<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Create Rejected Goods - Owner Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">   
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="{{ asset('js/heartbeat.js') }}"></script>
    <style>
        .content-wrapper {
            background-color: #f4f4f4;
        }
    </style>
    @push('styles')
    <style>
        .content-wrapper {
            margin-left: 260px !important;
            position: relative !important;
            z-index: 1 !important;
        }
        .main-sidebar {
            z-index: 1000 !important;
        }
    </style>
    @endpush
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('owner.olayouts.header')
        @include('owner.olayouts.sidebar')
        <div class="content-wrapper" style="margin-left: 260px; position: relative; z-index: 1;">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Create Rejected Goods</h1>
                        </div>
                        <div class="col-sm-6">
                            <div class="float-sm-right">
                                <a href="{{ route('owner.rejected-goods.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left mr-2"></i>Back to List
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-plus-circle mr-2 text-primary"></i>New Rejected Goods
                                    </h5>
                                </div>
                                <form method="POST" action="{{ route('owner.rejected-goods.store') }}" id="rejected-goods-form">
                                    @csrf
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="date">Date <span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" value="{{ old('date') }}" required>
                                                    @error('date')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="brand_id">Brand <span class="text-danger">*</span></label>
                                                    <select class="form-control @error('brand_id') is-invalid @enderror" id="brand_id" name="brand_id" required>
                                                        <option value="">Select Brand</option>
                                                        @foreach($brands as $brand)
                                                        <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('brand_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="branch_id">Branch <span class="text-danger">*</span></label>
                                                    <select class="form-control @error('branch_id') is-invalid @enderror" id="branch_id" name="branch_id" required>
                                                        <option value="">Select Branch</option>
                                                        @foreach($branches as $branch)
                                                        <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('branch_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="dr_no">DR No <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control @error('dr_no') is-invalid @enderror" id="dr_no" name="dr_no" value="{{ old('dr_no') }}" required>
                                                    @error('dr_no')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="amount">Amount <span class="text-danger">*</span></label>
                                                    <input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount" value="{{ old('amount') }}" required readonly>
                                                    @error('amount')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="reason">Reason <span class="text-danger">*</span></label>
                                                    <textarea class="form-control @error('reason') is-invalid @enderror" id="reason" name="reason" rows="3" required>{{ old('reason') }}</textarea>
                                                    @error('reason')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Product Items <span class="text-danger">*</span></label>
                                            <div id="items-container">
                                                <!-- Dynamic rows will be added here -->
                                            </div>
                                            <button type="button" class="btn btn-secondary mt-2" onclick="addItemRow()">
                                                <i class="fas fa-plus mr-2"></i>Add Item
                                            </button>
                                            @error('product_items')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save mr-2"></i>Create Rejected Goods
                                        </button>
                                        <a href="{{ route('owner.rejected-goods.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-arrow-left mr-2"></i>Back
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        @include('owner.olayouts.footer')
    </div>
    <script>
    let itemIndex = 0;
    let selectedProducts = new Set();

    // Function to create filtered product options HTML
    function createProductOptions() {
        let optionsHtml = '<option value="">Select Product</option>';
        @foreach($products as $product)
        if (!selectedProducts.has({{ $product->id }})) {
            optionsHtml += `<option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }}</option>`;
        }
        @endforeach
        return optionsHtml;
    }

    // Function to refresh all product selects with current filtered options
    function refreshProductSelects(currentSelect) {
        const rows = document.querySelectorAll('.form-row.mb-3');
        rows.forEach(function(row) {
            const productSelect = row.querySelector('select[name*="product_id"]');
            if (productSelect && productSelect !== currentSelect) {
                const currentValue = productSelect.value;
                productSelect.innerHTML = createProductOptions();
                if (currentValue && selectedProducts.has(parseInt(currentValue))) {
                    productSelect.value = currentValue;
                }
            }
        });
    }

    // Function to update selected products when a product is changed
    function updateSelectedProduct(select) {
        const productId = parseInt(select.value);
        const oldId = select.dataset.oldValue ? parseInt(select.dataset.oldValue) : null;
        if (oldId && oldId !== productId) {
            selectedProducts.delete(oldId);
        }
        if (productId && productId > 0) {
            selectedProducts.add(productId);
        }
        select.dataset.oldValue = productId || '';
        refreshProductSelects(select);
        calculateTotalAmount();
    }

    function addItemRow() {
        const container = document.getElementById('items-container');
        const row = document.createElement('div');
        row.className = 'form-row mb-3';
        row.id = 'item-row-' + itemIndex;
        row.innerHTML = `
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <label>Product <span class="text-danger">*</span></label>
                        <select class="form-control" name="product_items[${itemIndex}][product_id]" required>
                            ${createProductOptions()}
                        </select>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label>Quantity <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="product_items[${itemIndex}][quantity]" min="1" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <button type="button" class="btn btn-danger" onclick="removeItemRow(${itemIndex})">
                            <i class="fas fa-trash mr-1"></i>Remove
                        </button>
                    </div>
                </div>
            </div>
        `;
        container.appendChild(row);
        
        // Add event listeners for real-time calculation and product selection
        const newProductSelect = row.querySelector('select[name*="product_id"]');
        const newQuantityInput = row.querySelector('input[name*="quantity"]');
        if (newProductSelect) {
            newProductSelect.addEventListener('change', function() {
                updateSelectedProduct(this);
            });
            newProductSelect.addEventListener('change', calculateTotalAmount);
        }
        if (newQuantityInput) {
            newQuantityInput.addEventListener('input', calculateTotalAmount);
        }
        
        itemIndex++;
    }

    function removeItemRow(index) {
        const row = document.getElementById('item-row-' + index);
        if (row) {
            const productSelect = row.querySelector('select[name*="product_id"]');
            if (productSelect && productSelect.value) {
                selectedProducts.delete(parseInt(productSelect.value));
            }
            row.remove();
            refreshProductSelects();
            calculateTotalAmount();
        }
    }

    // Auto-calculate total amount from product items
    function calculateTotalAmount() {
        let total = 0;
        const rows = document.querySelectorAll('.form-row.mb-3');
        rows.forEach(function(row) {
            const productSelect = row.querySelector('select[name*="product_id"]');
            const quantityInput = row.querySelector('input[name*="quantity"]');
            if (productSelect && quantityInput && productSelect.value) {
                const selectedOption = productSelect.options[productSelect.selectedIndex];
                const price = parseFloat(selectedOption.dataset.price) || 0;
                const quantity = parseFloat(quantityInput.value) || 0;
                if (price > 0 && quantity > 0) {
                    total += price * quantity;
                }
            }
        });
        document.getElementById('amount').value = total.toFixed(2);
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        selectedProducts.clear();
        // Add event listeners to existing rows if any
        const existingRows = document.querySelectorAll('.form-row.mb-3');
        existingRows.forEach(function(row) {
            const productSelect = row.querySelector('select[name*="product_id"]');
            const quantityInput = row.querySelector('input[name*="quantity"]');
            if (productSelect) {
                productSelect.addEventListener('change', function() {
                    updateSelectedProduct(this);
                });
                productSelect.addEventListener('change', calculateTotalAmount);
                if (productSelect.value) {
                    selectedProducts.add(parseInt(productSelect.value));
                }
            }
            if (quantityInput) {
                quantityInput.addEventListener('input', calculateTotalAmount);
            }
        });
        refreshProductSelects();
    });
    </script>
    @stack('scripts')
</body>
</html>