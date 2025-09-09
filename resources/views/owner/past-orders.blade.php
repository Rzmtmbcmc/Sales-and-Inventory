<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Past Orders - Owner Dashboard</title>
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
                            <h1 class="m-0">Past Orders</h1>
                        </div>
                        <div class="col-sm-6">
                            <div class="float-sm-right">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-list mr-2 text-primary"></i>Past Orders List
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <!-- Filter Form -->
                                    <form class="mb-4" id="filterForm">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="start_date">Start Date</label>
                                                    <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="end_date">End Date</label>
                                                    <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="sort_direction">Sort By Date</label>
                                                    <select class="form-control" id="sort_direction" name="sort_direction">
                                                        <option value="desc" {{ request('sort_direction', 'desc') == 'desc' ? 'selected' : '' }}>Newest First</option>
                                                        <option value="asc" {{ request('sort_direction') == 'asc' ? 'selected' : '' }}>Oldest First</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="brand_search">Brand Search</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="brand_search" name="brand_search" placeholder="Search brands..." value="{{ request('brand_search', '') }}">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-outline-secondary" type="button" onclick="clearSearch('brand_search')">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="branch_search">Branch Search</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="branch_search" name="branch_search" placeholder="Search branches..." value="{{ request('branch_search', '') }}">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-outline-secondary" type="button" onclick="clearSearch('branch_search')">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 d-flex align-items-end">
                                                <button type="button" class="btn btn-secondary" onclick="clearAllFilters()">
                                                    <i class="fas fa-times mr-1"></i>Clear All Filters
                                                </button>
                                            </div>
                                        </div>
                                    </form>

                                    <div id="filtersApplied" class="alert alert-info alert-dismissible fade show d-none" role="alert">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        <span id="filtersText">Filters applied: </span>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th>Order ID</th>
                                                    <th>Brand</th>
                                                    <th>Branch</th>
                                                    <th>Total Amount</th>
                                                    <th>Date</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($pastOrders as $pastOrder)
                                                <tr data-date="{{ $pastOrder->created_at->format('Y-m-d') }}">
                                                    <td>{{ $pastOrder->id }}</td>
                                                    <td>{{ $pastOrder->brand->name ?? 'N/A' }}</td>
                                                    <td>{{ $pastOrder->branch->name ?? 'N/A' }}</td>
                                                    <td>${{ number_format($pastOrder->total_amount, 2) }}</td>
                                                    <td>{{ $pastOrder->created_at->format('Y-m-d') }}</td>
                                                    <td>
                                                        <a href="{{ route('owner.past-orders.show', $pastOrder) }}" class="btn btn-info btn-sm">
                                                            <i class="fas fa-eye mr-1"></i>View
                                                        </a>
                                                        <button class="btn btn-warning btn-sm" onclick="printOrder({{ $pastOrder->id }})">
                                                            <i class="fas fa-print mr-1"></i>Print
                                                        </button>
                                                        <form method="POST" action="{{ route('owner.past-orders.destroy', $pastOrder) }}" style="display: inline;" onsubmit="return confirm('Are you sure?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm">
                                                                <i class="fas fa-trash mr-1"></i>Delete
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="6" class="text-center text-muted py-5">
                                                        <div class="empty-state">
                                                            <i class="fas fa-inbox fa-3x mb-3" style="color: #d1d5db;"></i>
                                                            <h5>No Past Orders Found</h5>
                                                            <p class="mb-0">No past orders available at the moment.</p>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="float-right">
                                        {{ $pastOrders->appends(request()->query())->links('pagination::bootstrap-4') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        @include('owner.olayouts.footer')
    </div>
    @stack('scripts')
    <script>
        function printOrder(orderId) {
            // Open new window with printable order details
            const printWindow = window.open('', '_blank');
            printWindow.document.write(`
                <html>
                    <head>
                        <title>Order #${orderId}</title>
                        <style>
                            body { font-family: Arial, sans-serif; margin: 20px; }
                            table { width: 100%; border-collapse: collapse; }
                            th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                            th { background-color: #f2f2f2; }
                        </style>
                    </head>
                    <body>
                        <h2>Order Details #${orderId}</h2>
                        <p>Please implement server-side printing or fetch details via AJAX.</p>
                        <script>window.print();
                    </body>
                </html>
            `);
            printWindow.document.close();
        }

        // Client-side filtering for brand, branch, and date
        document.addEventListener('DOMContentLoaded', function() {
            const brandInput = document.getElementById('brand_search');
            const branchInput = document.getElementById('branch_search');
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');
            const tableRows = document.querySelectorAll('tbody tr[data-date]:not(.empty-state-row)');
            const filtersApplied = document.getElementById('filtersApplied');
            const filtersText = document.getElementById('filtersText');

            function updateFiltersDisplay() {
                let filterText = 'Filters applied: ';
                let hasFilters = false;

                if (startDateInput.value) {
                    filterText += `Start Date: ${startDateInput.value} `;
                    hasFilters = true;
                }
                if (endDateInput.value) {
                    filterText += `${startDateInput.value ? '- ' : ''}End Date: ${endDateInput.value} `;
                    hasFilters = true;
                }
                if (brandInput.value.trim()) {
                    filterText += `${(startDateInput.value || endDateInput.value) ? ', ' : ''}Brand: ${brandInput.value.trim()} `;
                    hasFilters = true;
                }
                if (branchInput.value.trim()) {
                    filterText += `${(startDateInput.value || endDateInput.value || brandInput.value.trim()) ? ', ' : ''}Branch: ${branchInput.value.trim()} `;
                    hasFilters = true;
                }

                if (hasFilters) {
                    filtersText.textContent = filterText;
                    filtersApplied.classList.remove('d-none');
                } else {
                    filtersApplied.classList.add('d-none');
                }
            }

            function filterTable() {
                const brandTerm = brandInput.value.toLowerCase().trim();
                const branchTerm = branchInput.value.toLowerCase().trim();
                const startDate = startDateInput.value ? new Date(startDateInput.value) : null;
                const endDate = endDateInput.value ? new Date(endDateInput.value) : null;
                if (endDate) {
                    endDate.setHours(23, 59, 59, 999);
                }

                let visibleCount = 0;

                tableRows.forEach(row => {
                    const brandCell = row.cells[1];
                    const branchCell = row.cells[2];
                    const dateStr = row.getAttribute('data-date');
                    const orderDate = new Date(dateStr);

                    const brandText = brandCell.textContent.toLowerCase();
                    const branchText = branchCell.textContent.toLowerCase();

                    const matchesBrand = brandTerm === '' || brandText.includes(brandTerm);
                    const matchesBranch = branchTerm === '' || branchText.includes(branchTerm);
                    let matchesDate = true;

                    if (startDate && endDate) {
                        matchesDate = orderDate >= startDate && orderDate <= endDate;
                    } else if (startDate) {
                        matchesDate = orderDate >= startDate;
                    } else if (endDate) {
                        matchesDate = orderDate <= endDate;
                    }

                    if (matchesBrand && matchesBranch && matchesDate) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                // Show/hide empty state
                const emptyRow = document.querySelector('tr td[colspan="6"]');
                if (emptyRow) {
                    if (visibleCount === 0 && tableRows.length > 0) {
                        emptyRow.parentElement.style.display = '';
                    } else {
                        emptyRow.parentElement.style.display = 'none';
                    }
                }

                updateFiltersDisplay();
            }

            // Event listeners
            if (brandInput) {
                brandInput.addEventListener('keyup', filterTable);
            }
            if (branchInput) {
                branchInput.addEventListener('keyup', filterTable);
            }
            if (startDateInput) {
                startDateInput.addEventListener('change', filterTable);
                startDateInput.addEventListener('input', filterTable);
            }
            if (endDateInput) {
                endDateInput.addEventListener('change', filterTable);
                endDateInput.addEventListener('input', filterTable);
            }

            // Initial filter on page load
            filterTable();

            // Make filterTable global for other functions
            window.filterTable = filterTable;
        });

        function clearSearch(inputId) {
            document.getElementById(inputId).value = '';
            window.filterTable(); // Trigger filter update
        }
    </script>

    <script>
        function clearAllFilters() {
            document.getElementById('start_date').value = '';
            document.getElementById('end_date').value = '';
            document.getElementById('brand_search').value = '';
            document.getElementById('branch_search').value = '';
            window.filterTable();
        }
    </script>
</body>
</html>