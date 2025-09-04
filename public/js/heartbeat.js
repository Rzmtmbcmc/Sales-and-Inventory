class UserHeartbeat {
    constructor(options = {}) {
        this.options = {
            heartbeatInterval: options.heartbeatInterval || 30000, // 30 seconds
            onlineCheckInterval: options.onlineCheckInterval || 60000, // 1 minute
            heartbeatEndpoint: options.heartbeatEndpoint || '/api/heartbeat',
            onlineUsersEndpoint: options.onlineUsersEndpoint || '/api/online-users',
            onStatusUpdate: options.onStatusUpdate || null // Callback for status updates
        };

        this.heartbeatIntervalId = null;
        this.onlineCheckIntervalId = null;
    }

    async sendHeartbeat() {
        try {
            const response = await fetch(this.options.heartbeatEndpoint, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
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
            const response = await fetch(this.options.onlineUsersEndpoint, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            });

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

    start() {
        // Send initial heartbeat
        this.sendHeartbeat();

        // Set up regular heartbeat
        this.heartbeatIntervalId = setInterval(() => {
            this.sendHeartbeat();
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
                this.sendHeartbeat(); // Send heartbeat immediately when page becomes visible
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
