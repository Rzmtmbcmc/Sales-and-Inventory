@ -0,0 +1,546 @@
@extends('owner.olayouts.main')
@section('content')

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

        <style>
            .content-wrapper {
                background-color: #f4f4f4;
            }

            .manager-card {
                transition: all 0.3s ease;
                border-left: 4px solid #007bff;
            }

            .manager-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            }

            .stats-box {
                border-radius: 8px;
                overflow: hidden;
            }

            .managers-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
                gap: 20px;
            }

            .search-section {
                background: white;
                border-radius: 8px;
                padding: 20px;
                margin-bottom: 20px;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            }

            .empty-state {
                text-align: center;
                padding: 60px 20px;
                background: white;
                border-radius: 8px;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            }

            .empty-icon {
                font-size: 4rem;
                color: #d1d5db;
                margin-bottom: 20px;
            }

            .notification {
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 9999;
                min-width: 300px;
            }

            .loading-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 9998;
            }

            .loading-spinner {
                width: 40px;
                height: 40px;
                border: 4px solid rgba(255, 255, 255, 0.3);
                border-top: 4px solid white;
                border-radius: 50%;
                animation: spin 1s linear infinite;
            }

            @keyframes spin {
                0% {
                    transform: rotate(0deg);
                }

                100% {
                    transform: rotate(360deg);
                }
            }
        </style>
    </head>

    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">
            <div class="content-wrapper">
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0">
                                    MANAGE ACCOUNTS
                                </h1>
                            </div>
                            <div class="col-sm-6">
                                <div class="float-sm-right">
                                    <button class="btn btn-primary btn-lg" id="addManagerBtn">
                                        <i class="fas fa-plus mr-2"></i>Add Manager
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-3 col-6">
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <h3 id="totalManagers">0</h3>
                                        <p>Total Managers</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-user-tie"></i>
                                    </div>
                                    <a href="#" class="small-box-footer">
                                        More info <i class="fas fa-arrow-circle-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="search-section">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-search"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" id="searchInput"
                                            placeholder="Search managers...">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="managers-grid" id="managersContainer">
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <div class="modal fade" id="managerFormModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h4 class="modal-title text-white" id="managerFormTitle">Add New Manager</h4>
                        <button type="button" class="close text-white" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <form id="managerForm">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="managerName">Full Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="managerName" name="name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="managerEmail">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="managerEmail" name="email" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="managerPhone">Phone</label>
                                        <input type="tel" class="form-control" id="managerPhone" name="phone">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="managerPassword">Password</label>
                                        <input type="password" class="form-control" id="managerPassword" name="password" autocomplete="new-password">
                                        <small id="passwordHelp" class="form-text text-muted" style="display: none;">Leave blank to keep current password.</small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="managerNotes">Notes</label>
                                        <textarea class="form-control" id="managerNotes" name="notes" rows="3" placeholder="Additional notes..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-2"></i>Save Manager
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            // 🔧 API Configuration
            const API_BASE_URL = '/api';

            // 📊 Application State
            let managers = [];
            let pagination = {};
            let editingManagerId = null;

            // 🌐 API Helper Functions
            async function apiRequest(endpoint, options = {}) {
                try {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

                    const fetchOptions = {
                        ...options,
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            ...(csrfToken && { 'X-CSRF-TOKEN': csrfToken }),
                            ...options.headers
                        },
                        credentials: 'same-origin',
                    };

                    if (!(options.body instanceof FormData)) {
                        fetchOptions.headers['Content-Type'] = 'application/json';
                        if (options.body && typeof options.body !== 'string') {
                            fetchOptions.body = JSON.stringify(options.body);
                        }
                    }

                    const response = await fetch(`${API_BASE_URL}${endpoint}`, fetchOptions);

                    if (!response.ok) {
                        const errorData = await response.json().catch(() => ({}));
                        let errorMessage = errorData.message || `HTTP ${response.status}: ${response.statusText}`;
                        if (response.status === 422 && errorData.errors) {
                            const errorMessages = Object.values(errorData.errors).flat();
                            errorMessage = errorMessages.join(' ');
                        }
                        throw new Error(errorMessage);
                    }

                    const responseText = await response.text();
                    return responseText ? JSON.parse(responseText) : {};
                } catch (error) {
                    console.error('API Error:', error);
                    showNotification(`${error.message}`, 'error');
                    throw error;
                }
            }

            // 🔔 Notification System
            function showNotification(message, type = 'success') {
                $('.notification').remove();

                const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
                const iconClass = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';

                const notification = $(`
                    <div class="alert ${alertClass} alert-dismissible notification">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <h6><i class="fas ${iconClass} mr-2"></i>${type === 'success' ? 'Success!' : 'Error!'}</h6>
                        ${message}
                    </div>
                `);

                $('body').append(notification);

                setTimeout(() => {
                    notification.fadeOut(() => notification.remove());
                }, 4000);
            }

            // 🔄 Loading State Management
            function showLoading(show = true) {
                if (show) {
                    if (!$('.loading-overlay').length) {
                        $('body').append(`
                            <div class="loading-overlay">
                                <div class="text-center">
                                    <div class="loading-spinner"></div>
                                    <div class="mt-3 text-white font-weight-bold">Loading...</div>
                                </div>
                            </div>
                        `);
                    }
                } else {
                    $('.loading-overlay').remove();
                }
            }

            // 🚀 Initialize Application
            $(document).ready(function() {
                setupEventListeners();
                loadInitialData();
            });

            function setupEventListeners() {
                $('#addManagerBtn').click(function(e) {
                    e.preventDefault();
                    openManagerForm();
                });
                
                $('#managerForm').submit(handleManagerSubmit);
                
                // Search and filters
                let searchTimeout;
                $('#searchInput').on('input', function() {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(handleSearch, 500);
                });
            }

            async function loadInitialData() {
                try {
                    showLoading(true);
                    await fetchManagers();
                    renderManagers();
                } catch (error) {
                    console.error('Failed to load manager data:', error);
                    showErrorState();
                } finally {
                    showLoading(false);
                }
            }

            async function fetchManagers(searchTerm = '') {
                const params = new URLSearchParams();
                if (searchTerm) params.append('search', searchTerm);

                const queryString = params.toString();
                const endpoint = `/managers${queryString ? '?' + queryString : ''}`;

                const response = await apiRequest(endpoint);
                managers = response.data;
                pagination = {
                    currentPage: response.current_page,
                    lastPage: response.last_page,
                    total: response.total,
                };
                return managers;
            }

            function updateStatistics() {
                const total = (pagination && pagination.total !== undefined) ? pagination.total : managers.length;
                $('#totalManagers').text(total);
            }

            function renderManagers(filteredManagers = managers) {
                const container = $('#managersContainer');
                container.empty();

                updateStatistics();

                const managerList = Array.isArray(filteredManagers) ? filteredManagers : (filteredManagers ? filteredManagers.data : []);

                if (!managerList || managerList.length === 0) {
                    container.html(`
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <h4 class="text-muted mb-3">No Managers Found</h4>
                            <p class="text-muted mb-4">Start by adding your first manager account.</p>
                            <button class="btn btn-primary btn-lg" onclick="openManagerForm()">
                                <i class="fas fa-plus mr-2"></i>Add Manager
                            </button>
                        </div>
                    `);
                    return;
                }

                managerList.forEach(manager => {
                    const managerCard = createManagerCard(manager);
                    container.append(managerCard);
                });
            }

            function createManagerCard(manager) {
                return $(`
                    <div class="card manager-card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-user-tie text-primary mr-2"></i>
                                        ${manager.name}
                                    </h5>
                                    <small class="text-muted">
                                        <i class="fas fa-envelope mr-1"></i>
                                        ${manager.email}
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-1"><i class="fas fa-phone mr-2"></i> ${manager.phone || 'N/A'}</p>
                                </div>
                                <div class="col-md-6 text-right">
                                    <p class="mb-1"><i class="fas fa-calendar mr-2"></i> Joined: ${new Date(manager.created_at).toLocaleDateString()}</p>
                                </div>
                            </div>
                            ${manager.notes ? `<div class="mt-3"><small class="text-muted"><i class="fas fa-sticky-note mr-1"></i>${manager.notes}</small></div>` : ''}
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-sm btn-info mr-2" onclick="openManagerForm(${manager.id})">
                                    <i class="fas fa-edit mr-1"></i>Edit
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="deleteManager(${manager.id})">
                                    <i class="fas fa-trash mr-1"></i>Delete
                                </button>
                            </div>
                        </div>
                    </div>
                `);
            }

            function openManagerForm(managerId = null) {
                editingManagerId = managerId;
                if (managerId) {
                    const manager = managers.find(m => m.id === managerId);
                    $('#managerFormTitle').text('Edit Manager');
                    populateManagerForm(manager);
                } else {
                    $('#managerFormTitle').text('Add New Manager');
                    resetManagerForm();
                }

                $('#managerFormModal').modal('show');
            }

            function populateManagerForm(manager) {
                $('#managerName').val(manager.name);
                $('#managerEmail').val(manager.email);
                $('#managerPhone').val(manager.phone);
                $('#managerNotes').val(manager.notes);
            }

            function resetManagerForm() {
                $('#managerForm')[0].reset();
            }

            async function handleManagerSubmit(e) {
                e.preventDefault();

                const form = document.getElementById('managerForm');
                const formData = new FormData(form);

                try {
                    showLoading(true);

                    let response;
                    if (editingManagerId) {
                        formData.append('_method', 'PUT');
                        response = await apiRequest(`/managers/${editingManagerId}`, {
                            method: 'POST',
                            body: formData,
                        });
                        showNotification('Manager updated successfully!');
                    } else {
                        response = await apiRequest('/managers', {
                            method: 'POST',
                            body: formData,
                        });
                        showNotification('Manager created successfully!');
                    }

                    await fetchManagers();
                    renderManagers();
                    $('#managerFormModal').modal('hide');

                } catch (error) {
                    console.error('Failed to save manager:', error);
                } finally {
                    showLoading(false);
                }
            }

            async function deleteManager(managerId) {
                if (confirm('Are you sure you want to delete this manager? This action cannot be undone.')) {
                    try {
                        showLoading(true);
                        await apiRequest(`/managers/${managerId}`, {
                            method: 'POST',
                            body: JSON.stringify({_method:'DELETE'})


                        });
                        showNotification('Manager deleted successfully!');
                        await fetchManagers();
                        renderManagers();
                    } catch (error) {
                        console.error('Failed to delete manager:', error);
                    } finally {
                        showLoading(false);
                    }
                }
            }

            async function handleSearch() {
                const searchTerm = $('#searchInput').val().trim();

                try {
                    await fetchManagers(searchTerm);
                    renderManagers();
                } catch (error) {
                    console.error('Search failed:', error);
                }
            }

            function showErrorState() {
                $('#managersContainer').html(`
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <h4 class="text-muted mb-3">Failed to Load Data</h4>
                        <p class="text-muted mb-4">Please check your connection and try again.</p>
                        <button onclick="loadInitialData()" class="btn btn-primary">
                            <i class="fas fa-refresh mr-2"></i>Retry
                        </button>
                    </div>
                `);
            }
        </script>
    @endsection