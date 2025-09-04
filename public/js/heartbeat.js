class UserHeartbeat {
    constructor(options = {}) {
        this.options = {
            heartbeatInterval: options.heartbeatInterval || 30000, // 30 seconds
            onlineCheckInterval: options.onlineCheckInterval || 60000, // 1 minute
            heartbeatEndpoint: options.heartbeatEndpoint || '/api/heartbeat',
            onlineUsersEndpoint: options.onlineUsersEndpoint || '/api/online-users',
            userEndpoint: options.userEndpoint || '/api/user',
            onStatusUpdate: options.onStatusUpdate || null // Callback for status updates
        };

        this.heartbeatIntervalId = null;
        this.onlineCheckIntervalId = null;
        this.currentUser = null;
    }

    async validateSession() {
        try {
            const response = await this.makeAuthenticatedRequest(this.options.userEndpoint);
            if (response.status === 419) { // CSRF token mismatch
                // Refresh the page to get a new CSRF token
                window.location.reload();
                return false;
            }
            if (!response.ok) {
                if (response.status === 401) {
                    // Redirect to login if unauthorized
                    window.location.href = '/login';
                }
                throw new Error('Session invalid');
            }
            this.currentUser = await response.json();
            return true;
        } catch (error) {
            console.error('Session validation error:', error);
            if (error.message === 'Session invalid') {
                // Redirect to login
                window.location.href = '/login';
            }
            return false;
        }
    }

    makeAuthenticatedRequest(url, options = {}) {
        const headers = {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        };

        return fetch(url, {
            ...options,
            headers: { ...headers, ...options.headers },
            credentials: 'same-origin'
        });
    }

    async sendHeartbeat() {
        try {
            // Validate CSRF token before sending heartbeat
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (!csrfToken || !csrfToken.getAttribute('content')) {
                // If no CSRF token, refresh the page
                window.location.reload();
                return;
            }

            const response = await this.makeAuthenticatedRequest(this.options.heartbeatEndpoint, {
                method: 'POST'
            });

            if (!response.ok) {
                throw new Error(`Heartbeat failed: ${response.status}`);
            }
        } catch (error) {
            console.error('Heartbeat error:', error);
        }
    }

    async checkOnlineUsers() {
        try {
            const response = await this.makeAuthenticatedRequest(this.options.onlineUsersEndpoint);

            if (!response.ok) {
                throw new Error(`Failed to fetch online users: ${response.status}`);
            }

            const data = await response.json();

            // Call the callback function if provided
            if (this.options.onStatusUpdate && typeof this.options.onStatusUpdate === 'function') {
                this.options.onStatusUpdate(data);
            }

            return data;
        } catch (error) {
            console.error('Online status check error:', error);
            return [];
        }
    }

    async start() {
        // Validate session first
        const isValid = await this.validateSession();
        if (!isValid) {
            console.error('Failed to validate session');
            return false;
        }

        // Send initial heartbeat
        await this.sendHeartbeat();

        // Set up regular heartbeat
        this.heartbeatIntervalId = setInterval(() => {
            this.validateSession();
        }, this.options.heartbeatInterval);

        // Set up regular online status check if callback is provided
        if (this.options.onStatusUpdate) {
            this.onlineCheckIntervalId = setInterval(() => {
                this.checkOnlineUsers();
            }, this.options.onlineCheckInterval);
        }

        // Handle page visibility changes
        document.addEventListener('visibilitychange', () => {
            if (document.visibilityState === 'visible') {
                this.validateSession(); // Send heartbeat immediately when page becomes visible
            }
        });

        // Handle before unload
        window.addEventListener('beforeunload', () => {
            this.stop();
        });
    }

    stop() {
        if (this.heartbeatIntervalId) {
            clearInterval(this.heartbeatIntervalId);
            this.heartbeatIntervalId = null;
        }
        if (this.onlineCheckIntervalId) {
            clearInterval(this.onlineCheckIntervalId);
            this.onlineCheckIntervalId = null;
        }
    }
}
