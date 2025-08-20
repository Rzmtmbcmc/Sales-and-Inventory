@extends('owner.olayouts.main')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">DASHBOARD</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
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
                                <h3 id="totalOrdersYear">0</h3>
                                <p>Total Orders per Annum</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-basket"></i>
                            </div>
                            <a href="{{ route('owner.orders') }}" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3 id="totalSalesYear">₱0</h3>
                                <p>Total Sales per Annum</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                            <a href="#" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3 id="totalOrdersMonth">0</h3>
                                <p>Total Orders per Month</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-basket"></i>
                            </div>
                            <a href="{{ route('owner.orders') }}" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3 id="totalSalesMonth">₱0</h3>
                                <p>Total Sales per Month</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                            <a href="#" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-filter mr-2"></i>Analytics Filters</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="yearFilter">Year</label>
                                    <select id="yearFilter" class="form-control select2bs4"></select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="brandFilter">Brand</label>
                                    <select id="brandFilter" class="form-control select2bs4"></select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="branchFilter">Branch</label>
                                    <select id="branchFilter" class="form-control select2bs4"></select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="productFilter">Product</label>
                                    <select id="productFilter" class="form-control select2bs4"></select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-right">
                                <button class="btn btn-primary" id="applyFiltersBtn">
                                    <i class="fas fa-filter mr-1"></i> Apply Filters
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-8">
                        <div class="card card-info card-outline">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-chart-line mr-2"></i>Sales Overview</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                        <i class="fas fa-expand"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart">
                                    <canvas id="salesChart" style="height: 300px; width: 100%;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-star mr-2"></i>Top 10 Products</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th class="text-right">Quantity Sold</th>
                                            </tr>
                                        </thead>
                                        <tbody id="top10List">
                                            <tr>
                                                <td colspan="2" class="text-center">No data available.</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card card-danger card-outline">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-arrow-down mr-2"></i>Bottom 10 Products</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th class="text-right">Quantity Sold</th>
                                            </tr>
                                        </thead>
                                        <tbody id="bottom10List">
                                            <tr>
                                                <td colspan="2" class="text-center">No data available.</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card card-info card-outline">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-boxes mr-2"></i>Product Sales This Year</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                        <i class="fas fa-expand"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart">
                                    <canvas id="productSalesChart" style="height: 300px; width: 100%;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(document).ready(function() {
            let salesChart;
            let productSalesChart;

            // Fetch brands, branches, and products for filters
            async function fetchFilters() {
                try {
                    const [brands, branches, products] = await Promise.all([
                        $.get('/api/brands'),
                        $.get('/api/branches'),
                        $.get('/api/products?all=true')
                    ]);

                    // Populate Year filter (keep this as it was)
                    const currentYear = new Date().getFullYear();
                    for (let i = currentYear; i >= currentYear - 5; i--) {
                        $('#yearFilter').append(`<option value="${i}">${i}</option>`);
                    }

                    // Populate Brand filter
                    $('#brandFilter').append('<option value="">All Brands</option>');
                    brands.forEach(brand => {
                        $('#brandFilter').append(`<option value="${brand.id}">${brand.name}</option>`);
                    });

                    // Populate Branch filter
                    $('#branchFilter').append('<option value="">All Branches</option>');
                    branches.forEach(branch => {
                        $('#branchFilter').append(
                            `<option value="${branch.id}">${branch.name}</option>`);
                    });

                    // Populate Product filter
                    $('#productFilter').append('<option value="">All Products</option>');
                    products.forEach(product => {
                        $('#productFilter').append(
                            `<option value="${product.id}">${product.name}</option>`);
                    });

                    // Initialize Select2 for better dropdown styling
                    $('.select2bs4').select2({
                        theme: 'bootstrap4'
                    });

                } catch (error) {
                    console.error("Error fetching filters:", error);
                }
            }

            // Fetch and display dashboard data
            async function fetchDashboardData() {
                const selectedYear = $('#yearFilter').val();
                const selectedBrand = $('#brandFilter').val();
                const selectedBranch = $('#branchFilter').val();
                const selectedProduct = $('#productFilter').val();

                try {
                    const response = await $.get('/api/analytics', {
                        year: selectedYear,
                        brand_id: selectedBrand,
                        branch_id: selectedBranch,
                        product_id: selectedProduct
                    });

                    if (response.success) {
                        const data = response.rankings;
                        initProductSalesChart(response.product_sales);
                        $('#totalOrdersYear').text(data.total_orders_this_year);
                        $('#totalSalesYear').text(`₱${data.total_sales_this_year.toLocaleString()}`);
                        $('#totalOrdersMonth').text(data.most_orders_this_month);
                        $('#totalSalesMonth').text(`₱${data.total_sales_this_month.toLocaleString()}`);
                        // Update rankings
                        updateRankingTable('top10List', data.top_10_products, 'total_quantity_sold');
                        updateRankingTable('bottom10List', data.bottom_10_products, 'total_quantity_sold');

                        // Update chart
                        updateSalesChart(response.graph_data);
                    }
                } catch (error) {
                    console.error("Error fetching dashboard data:", error);
                }
            }

            function updateRankingTable(tableId, items, valueKey) {
                const table = $(`#${tableId}`);
                table.empty();
                if (items.length > 0) {
                    items.forEach(item => {
                        table.append(`<tr>
                        <td>${item.name}</td>
                        <td class="text-right"><span class="badge bg-primary">${item[valueKey]}</span></td>
                    </tr>`);
                    });
                } else {
                    table.append('<tr><td colspan="2" class="text-center">No data available.</td></tr>');
                }
            }

            function updateSalesChart(data) {
                const labels = Object.keys(data);
                const salesData = Object.values(data);

                const chartData = {
                    labels: labels,
                    datasets: [{
                        label: 'Total Sales',
                        backgroundColor: 'rgba(60,141,188,0.9)',
                        borderColor: 'rgba(60,141,188,0.8)',
                        pointRadius: false,
                        pointColor: '#3b8bba',
                        pointStrokeColor: 'rgba(60,141,188,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data: salesData
                    }]
                };

                const chartOptions = {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return '₱' + value;
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                };

                const ctx = document.getElementById('salesChart').getContext('2d');
                if (salesChart) {
                    salesChart.destroy();
                }
                salesChart = new Chart(ctx, {
                    type: 'bar',
                    data: chartData,
                    options: chartOptions
                });
            }

            // Initialize year filter with current year and some past years
            const currentYear = new Date().getFullYear();
            for (let i = currentYear; i >= currentYear - 5; i--) {
                $('#yearFilter').append(`<option value="${i}">${i}</option>`);
            }

            // Event listener for filter button
            $('#applyFiltersBtn').on('click', fetchDashboardData);

            // Initial data load
            fetchFilters();
            fetchDashboardData();
        });
        let productSalesChart;

        function initProductSalesChart(data) {
            const ctx = document.getElementById('productSalesChart').getContext('2d');

            // Destroy existing chart
            if (productSalesChart) {
                productSalesChart.destroy();
            }

            productSalesChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: Object.keys(data),
                    datasets: [{
                        label: 'Sales per Product',
                        data: Object.values(data),
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        borderWidth: 0 // Add this to prevent border rendering issues
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                callback: function(value) {
                                    return '₱' + value;
                                }
                            }
                        },
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            enabled: true,
                            position: 'nearest'
                        }
                    }
                }
            });
        }
    </script>
@endsection
