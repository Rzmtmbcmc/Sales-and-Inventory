@extends('owner.olayouts.main')
@section('content')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Branch Management</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .product-price {
            font-weight: 600;
            color: #28a745;
            font-size: 1.1rem;
        }
        
        .quantity-badge {
            background-color: #17a2b8;
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 600;
        }
        
        .perishable-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .perishable-yes {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }
        
        .perishable-no {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .loading-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 9999;
        }
        
        .loading-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 2rem;
            border-radius: 0.5rem;
            text-align: center;
        }
        
        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.02);
        }
        
        .low-stock {
            color: #dc3545;
            font-weight: bold;
        }
        
        .out-of-stock {
            color: #6c757d;
            font-style: italic;
        }
    </style>
</head>
<<<<<<< HEAD
    <div class="wrapper">
        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Content Header -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">
                                <i class="fas fa-store mr-2"></i>
                                Brand Management
                            </h1>
                        </div>
                        <div class="col-sm-6">
                            <div class="float-sm-right">
                                <button class="btn btn-primary btn-lg" id="addBrandBtn">
                                    <i class="fas fa-plus mr-2"></i>Add Brand
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
=======
<body>
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-content">
            <div class="spinner-border text-primary mb-3" role="status">
                <span class="sr-only">Loading...</span>
>>>>>>> cf5bf9bef95838ee0c0f6c8715826fc3d911c9a5
            </div>
            <div>Loading products...</div>
        </div>
    </div>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Content Header -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Inventory Management</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Products</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Info boxes -->
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-box"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Products</span>
                                <span class="info-box-number" id="totalProducts">0</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-cubes"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Quantity</span>
                                <span class="info-box-number" id="totalQuantity">0</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-clock"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Perishable Items</span>
                                <span class="info-box-number" id="perishableProducts">0</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-exclamation-triangle"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Low Stock</span>
                                <span class="info-box-number" id="lowStockProducts">0</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Search and Filter Section -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-search mr-1"></i>
                            Search & Filter
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Search Products</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-search"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" id="searchInput" 
                                               placeholder="Search by product name...">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Filter by Status</label>
                                    <select class="form-control" id="perishableFilter">
                                        <option value="">All Products</option>
                                        <option value="yes">Perishable Only</option>
                                        <option value="no">Non-Perishable Only</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Stock Level</label>
                                    <select class="form-control" id="stockFilter">
                                        <option value="">All Stock</option>
                                        <option value="low">Low Stock (≤10)</option>
                                        <option value="out">Out of Stock</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button type="button" class="btn btn-primary btn-block" id="addProductBtn">
                                        <i class="fas fa-plus mr-1"></i> Add Product
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Products Table -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-list mr-1"></i>
                            Products List
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" onclick="loadProducts()" title="Refresh">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Perishable</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                <!-- Table rows will be populated by JavaScript -->
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer clearfix">
                        <div class="float-left">
                            <span class="text-muted">
                                Showing <span id="showingStart">0</span> to <span id="showingEnd">0</span> 
                                of <span id="totalEntries">0</span> entries
                            </span>
                        </div>
                        <ul class="pagination pagination-sm m-0 float-right" id="pagination">
                            <!-- Pagination will be populated by JavaScript -->
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Add/Edit Product Modal -->
    <div class="modal fade" id="productModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalTitle">Add New Products</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="productForm">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="productName">Product Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="productName" required>
                            <div class="invalid-feedback">Please provide a valid product name.</div>
                        </div>
                        <div class="form-group">
                            <label for="productPrice">Product Price <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">₱</span>
                                </div>
                                <input type="number" class="form-control" id="productPrice" 
                                       step="0.01" min="0" required>
                                <div class="invalid-feedback">Please provide a valid price.</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="productQuantity">Quantity <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="productQuantity" 
                                   min="0" required>
                            <div class="invalid-feedback">Please provide a valid quantity.</div>
                        </div>
                        <div class="form-group">
                            <label for="productPerishable">Perishable Status <span class="text-danger">*</span></label>
                            <select class="form-control" id="productPerishable" required>
                                <option value="">Select Status</option>
                                <option value="yes">Yes - Perishable</option>
                                <option value="no">No - Non-Perishable</option>
                            </select>
                            <div class="invalid-feedback">Please select perishable status.</div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" onclick="closeModal('productModal')">Cancel</button>
                        <button type="button" class="btn btn-primary" onclick="saveProduct()">
                            <i class="fas fa-save mr-1"></i> Save Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h4 class="modal-title text-white">
                        <i class="fas fa-exclamation-triangle mr-2"></i>Confirm Delete
                    </h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this product? This action cannot be undone.</p>
                    <div class="alert alert-warning">
                        <strong id="deleteProductInfo"></strong>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                        <i class="fas fa-trash mr-1"></i> Delete Product
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Laravel API Configuration
        const API_CONFIG = {
            baseURL: '/api',
            endpoints: {
                products: '/products',
                product: '/products'
            },
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
            }
        };

        // Sample data for fallback
        let sampleProducts = [
            {id: 1, name: "Fresh Apples", price: 3.99, quantity: 50, perishable: "yes"},
            {id: 2, name: "Canned Beans", price: 1.49, quantity: 25, perishable: "no"},
            {id: 3, name: "Organic Milk", price: 4.29, quantity: 8, perishable: "yes"},
            {id: 4, name: "Pasta", price: 2.99, quantity: 100, perishable: "no"},
            {id: 5, name: "Fresh Bread", price: 2.49, quantity: 15, perishable: "yes"},
            {id: 6, name: "Rice", price: 5.99, quantity: 75, perishable: "no"},
            {id: 7, name: "Yogurt", price: 3.79, quantity: 5, perishable: "yes"},
            {id: 8, name: "Cereal", price: 4.99, quantity: 30, perishable: "no"},
            {id: 9, name: "Bananas", price: 1.99, quantity: 0, perishable: "yes"},
            {id: 10, name: "Peanut Butter", price: 6.49, quantity: 20, perishable: "no"}
        ];

        // Global variables
        let products = [];
        let filteredProducts = [];
        let currentPage = 1;
        let productsPerPage = 10;
        let totalPages = 1;
        let editingId = null;
        let deleteId = null;
        let searchTimeout = null;

        // API Helper Functions
        async function apiRequest(endpoint, options = {}) {
            showLoading(true);
            try {
                const url = API_CONFIG.baseURL + endpoint;
                const config = {
                    headers: API_CONFIG.headers,
                    ...options
                };

                const response = await fetch(url, config);
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const data = await response.json();
                return data;
            } catch (error) {
                console.error('API Error:', error);
                showToast('API connection failed. Using sample data.', 'warning');
                return null;
            } finally {
                showLoading(false);
            }
        }

        // Load products from Laravel API
        async function loadProducts(page = 1, search = '', perishable = '', stock = '') {
            const params = new URLSearchParams({
                page: page,
                per_page: productsPerPage,
                search: search,
                perishable: perishable,
                stock: stock
            });

            const response = await apiRequest(`${API_CONFIG.endpoints.products}?${params}`);
            
            if (response && response.data) {
                products = response.data;
                currentPage = response.current_page;
                totalPages = response.last_page;
                
                filteredProducts = products;
                renderTable();
                renderPagination();
                updateStats();
                updatePaginationInfo(response.from, response.to, response.total);
            } else {
                useSampleData(search, perishable, stock);
            }
        }

        // Fallback to sample data
        function useSampleData(search = '', perishable = '', stock = '') {
            products = [...sampleProducts];
            
            filteredProducts = products.filter(product => {
                const matchesSearch = !search || product.name.toLowerCase().includes(search.toLowerCase());
                const matchesPerishable = !perishable || product.perishable === perishable;
                
                let matchesStock = true;
                if (stock === 'low') {
                    matchesStock = product.quantity > 0 && product.quantity <= 10;
                } else if (stock === 'out') {
                    matchesStock = product.quantity === 0;
                }
                
                return matchesSearch && matchesPerishable && matchesStock;
            });
            
            totalPages = Math.ceil(filteredProducts.length / productsPerPage);
            const start = (currentPage - 1) * productsPerPage;
            const end = start + productsPerPage;
            const pageProducts = filteredProducts.slice(start, end);
            
            renderTable(pageProducts);
            renderPagination();
            updateStats();
            updatePaginationInfo(start + 1, Math.min(end, filteredProducts.length), filteredProducts.length);
        }

        // Create product
        async function createProduct(productData) {
            const response = await apiRequest(API_CONFIG.endpoints.products, {
                method: 'POST',
                body: JSON.stringify(productData)
            });

            if (response) {
                showToast('Product created successfully!', 'success');
                loadProducts(currentPage, getCurrentSearch(), getCurrentPerishableFilter(), getCurrentStockFilter());
                return true;
            } else {
                const newId = Math.max(...sampleProducts.map(p => p.id)) + 1;
                sampleProducts.push({ id: newId, ...productData });
                useSampleData(getCurrentSearch(), getCurrentPerishableFilter(), getCurrentStockFilter());
                showToast('Product added to sample data!', 'success');
                return true;
            }
        }

        // Update product
        async function updateProduct(id, productData) {
            const response = await apiRequest(`${API_CONFIG.endpoints.product}/${id}`, {
                method: 'PUT',
                body: JSON.stringify(productData)
            });

            if (response) {
                showToast('Product updated successfully!', 'success');
                loadProducts(currentPage, getCurrentSearch(), getCurrentPerishableFilter(), getCurrentStockFilter());
                return true;
            } else {
                const index = sampleProducts.findIndex(p => p.id === id);
                if (index !== -1) {
                    sampleProducts[index] = { ...sampleProducts[index], ...productData };
                    useSampleData(getCurrentSearch(), getCurrentPerishableFilter(), getCurrentStockFilter());
                    showToast('Product updated in sample data!', 'success');
                    return true;
                }
            }
            return false;
        }

        // Delete product
        async function deleteProductAPI(id) {
            const response = await apiRequest(`${API_CONFIG.endpoints.product}/${id}`, {
                method: 'DELETE'
            });

            if (response) {
                showToast('Product deleted successfully!', 'success');
                loadProducts(currentPage, getCurrentSearch(), getCurrentPerishableFilter(), getCurrentStockFilter());
                return true;
            } else {
                sampleProducts = sampleProducts.filter(p => p.id !== id);
                useSampleData(getCurrentSearch(), getCurrentPerishableFilter(), getCurrentStockFilter());
                showToast('Product removed from sample data!', 'success');
                return true;
            }
        }

        // Render table
        function renderTable(pageProducts = null) {
            const tbody = document.getElementById('tableBody');
            const productsToRender = pageProducts || filteredProducts;

            if (productsToRender.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                            <br>
                            <span class="text-muted">No products found</span>
                        </td>
                    </tr>
                `;
                return;
            }

            tbody.innerHTML = productsToRender.map(product => {
                const quantityClass = product.quantity === 0 ? 'out-of-stock' : 
                                    product.quantity <= 10 ? 'low-stock' : '';
                
                return `
                    <tr>
                        <td><strong>#${product.id}</strong></td>
                        <td>${product.name}</td>
                        <td><span class="product-price">₱${parseFloat(product.price).toFixed(2)}</span></td>
                        <td>
                            <span class="quantity-badge ${quantityClass}">
                                ${product.quantity} ${product.quantity === 1 ? 'unit' : 'units'}
                            </span>
                        </td>
                        <td>
                            <span class="badge perishable-badge perishable-${product.perishable}">
                                ${product.perishable === 'yes' ? 'Yes' : 'No'}
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-info btn-sm mr-1" onclick="editProduct(${product.id})" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="deleteProduct(${product.id})" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
            }).join('');
        }

        // Search setup
        function setupSearch() {
            const searchInput = document.getElementById('searchInput');
            const perishableFilter = document.getElementById('perishableFilter');
            const stockFilter = document.getElementById('stockFilter');

            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    currentPage = 1;
                    loadProducts(currentPage, this.value, perishableFilter.value, stockFilter.value);
                }, 500);
            });

            perishableFilter.addEventListener('change', function() {
                currentPage = 1;
                loadProducts(currentPage, searchInput.value, this.value, stockFilter.value);
            });

            stockFilter.addEventListener('change', function() {
                currentPage = 1;
                loadProducts(currentPage, searchInput.value, perishableFilter.value, this.value);
            });
        }

        // Get current values
        function getCurrentSearch() {
            return document.getElementById('searchInput').value;
        }

        function getCurrentPerishableFilter() {
            return document.getElementById('perishableFilter').value;
        }

        function getCurrentStockFilter() {
            return document.getElementById('stockFilter').value;
        }

        // Update statistics
        function updateStats() {
            const total = filteredProducts.length;
            const totalQty = filteredProducts.reduce((sum, p) => sum + parseInt(p.quantity), 0);
            const perishable = filteredProducts.filter(p => p.perishable === 'yes').length;
            const lowStock = filteredProducts.filter(p => p.quantity > 0 && p.quantity <= 10).length;

            document.getElementById('totalProducts').textContent = total;
            document.getElementById('totalQuantity').textContent = totalQty;
            document.getElementById('perishableProducts').textContent = perishable;
            document.getElementById('lowStockProducts').textContent = lowStock;
        }

        // Pagination
        function renderPagination() {
            const pagination = document.getElementById('pagination');
            
            if (totalPages <= 1) {
                pagination.innerHTML = '';
                return;
            }
            
            let paginationHTML = '';
            
            // Previous button
            paginationHTML += `
                <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                    <a class="page-link" href="#" onclick="changePage(${currentPage - 1})">«</a>
                </li>
            `;
            
            // Page numbers
            for (let i = 1; i <= totalPages; i++) {
                if (i === 1 || i === totalPages || (i >= currentPage - 1 && i <= currentPage + 1)) {
                    paginationHTML += `
                        <li class="page-item ${i === currentPage ? 'active' : ''}">
                            <a class="page-link" href="#" onclick="changePage(${i})">${i}</a>
                        </li>
                    `;
                } else if (i === currentPage - 2 || i === currentPage + 2) {
                    paginationHTML += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                }
            }
            
            // Next button
            paginationHTML += `
                <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                    <a class="page-link" href="#" onclick="changePage(${currentPage + 1})">»</a>
                </li>
            `;
            
            pagination.innerHTML = paginationHTML;
        }

        // Change page
        function changePage(page) {
            if (page >= 1 && page <= totalPages && page !== currentPage) {
                currentPage = page;
                loadProducts(currentPage, getCurrentSearch(), getCurrentPerishableFilter(), getCurrentStockFilter());
            }
        }

        // Update pagination info
        function updatePaginationInfo(start, end, total) {
            document.getElementById('showingStart').textContent = start || 0;
            document.getElementById('showingEnd').textContent = end || 0;
            document.getElementById('totalEntries').textContent = total || 0;
        }

        // Modal functions
        function openAddModal() {
            editingId = null;
            document.getElementById('modalTitle').textContent = 'Add New Product';
            document.getElementById('productForm').reset();
            document.getElementById('productForm').classList.remove('was-validated');
            
            // Clear any previous validation states
            const inputs = document.querySelectorAll('#productModal input, #productModal select');
            inputs.forEach(input => {
                input.classList.remove('is-invalid', 'is-valid');
            });
            
            // Show modal using Bootstrap 4 method or fallback
            if (typeof $ !== 'undefined' && $.fn.modal) {
                $('#productModal').modal('show');
            } else {
                // Fallback for vanilla JS
                const modal = document.getElementById('productModal');
                modal.style.display = 'block';
                modal.classList.add('show');
                document.body.classList.add('modal-open');
                
                // Create backdrop
                const backdrop = document.createElement('div');
                backdrop.className = 'modal-backdrop fade show';
                backdrop.id = 'modalBackdrop';
                document.body.appendChild(backdrop);
            }
        }

        function closeModal(modalId) {
            if (typeof $ !== 'undefined' && $.fn.modal) {
                $(`#${modalId}`).modal('hide');
            } else {
                // Fallback for vanilla JS
                const modal = document.getElementById(modalId);
                modal.style.display = 'none';
                modal.classList.remove('show');
                document.body.classList.remove('modal-open');
                
                // Remove backdrop
                const backdrop = document.getElementById('modalBackdrop');
                if (backdrop) {
                    backdrop.remove();
                }
            }
        }

        function editProduct(id) {
            editingId = id;
            const product = filteredProducts.find(p => p.id === id) || sampleProducts.find(p => p.id === id);
            
            if (product) {
                document.getElementById('modalTitle').textContent = 'Edit Product';
                document.getElementById('productName').value = product.name;
                document.getElementById('productPrice').value = product.price;
                document.getElementById('productQuantity').value = product.quantity;
                document.getElementById('productPerishable').value = product.perishable;
                document.getElementById('productForm').classList.remove('was-validated');
                
                // Clear any previous validation states
                const inputs = document.querySelectorAll('#productModal input, #productModal select');
                inputs.forEach(input => {
                    input.classList.remove('is-invalid', 'is-valid');
                });
                
                if (typeof $ !== 'undefined' && $.fn.modal) {
                    $('#productModal').modal('show');
                } else {
                    // Fallback for vanilla JS
                    const modal = document.getElementById('productModal');
                    modal.style.display = 'block';
                    modal.classList.add('show');
                    document.body.classList.add('modal-open');
                    
                    // Create backdrop
                    const backdrop = document.createElement('div');
                    backdrop.className = 'modal-backdrop fade show';
                    backdrop.id = 'modalBackdrop';
                    document.body.appendChild(backdrop);
                }
            }
        }

        async function saveProduct() {
            const form = document.getElementById('productForm');
            
            if (!form.checkValidity()) {
                form.classList.add('was-validated');
                return;
            }

            const productData = {
                name: document.getElementById('productName').value.trim(),
                price: parseFloat(document.getElementById('productPrice').value),
                quantity: parseInt(document.getElementById('productQuantity').value),
                perishable: document.getElementById('productPerishable').value
            };

            let success = false;
            if (editingId) {
                success = await updateProduct(editingId, productData);
            } else {
                success = await createProduct(productData);
            }

            if (success) {
                closeModal('productModal');
            }
        }

        function deleteProduct(id) {
            deleteId = id;
            const product = filteredProducts.find(p => p.id === id) || sampleProducts.find(p => p.id === id);
            
            if (product) {
                document.getElementById('deleteProductInfo').textContent = 
                    `${product.name} - ₱${parseFloat(product.price).toFixed(2)} (Qty: ${product.quantity})`;
                $('#deleteModal').modal('show');
            }
        }

        async function confirmDelete() {
            if (deleteId) {
                await deleteProductAPI(deleteId);
                $('#deleteModal').modal('hide');
                deleteId = null;
            }
        }

        // Utility functions
        function showLoading(show) {
            const overlay = document.getElementById('loadingOverlay');
            overlay.style.display = show ? 'block' : 'none';
        }

        function showToast(message, type = 'info') {
            if (typeof toastr !== 'undefined') {
                toastr[type](message);
            } else {
                const alertClass = type === 'success' ? 'alert-success' : 
                                 type === 'warning' ? 'alert-warning' : 
                                 type === 'error' ? 'alert-danger' : 'alert-info';
                
                const notification = document.createElement('div');
                notification.className = `alert ${alertClass} alert-dismissible fade show position-fixed`;
                notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
                notification.innerHTML = `
                    ${message}
                    <button type="button" class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                `;
                document.body.appendChild(notification);
                
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.parentNode.removeChild(notification);
                    }
                }, 5000);
            }
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            setupSearch();
            loadProducts();
            
            // Add event listener for add product button
            document.getElementById('addProductBtn').addEventListener('click', openAddModal);
        });
    </script>
<script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'967b0fa696bbb9ff',t:'MTc1Mzk0MzU3My4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script>

@endsection