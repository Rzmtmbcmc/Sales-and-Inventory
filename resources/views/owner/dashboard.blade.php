@extends('owner.olayouts.main')
@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="fas fa-chart-bar mr-2"></i>Dashboard Analytics</h1>
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
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-shopping-cart"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Orders (This Year)</span>
                            <span class="info-box-number" id="totalOrdersYear">0</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-dollar-sign"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Sales (This Year)</span>
                            <span class="info-box-number" id="totalSalesYear">₱0</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-shopping-cart"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Orders (This Month)</span>
                            <span class="info-box-number" id="totalOrdersMonth">0</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-dollar-sign"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Sales (This Month)</span>
                            <span class="info-box-number" id="totalSalesMonth">₱0</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Analytics Filters</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="yearFilter">Year</label>
                                <select id="yearFilter" class="form-control"></select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="brandFilter">Brand</label>
                                <select id="brandFilter" class="form-control"></select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="branchFilter">Branch</label>
                                <select id="branchFilter" class="form-control"></select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="productFilter">Product</label>
                                <select id="productFilter" class="form-control"></select>
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
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Sales Overview</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="salesChart" style="height: 300px;"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Top 10 Products</h3>
                        </div>
                        <div class="card-body">
                            <ul class="list-group" id="top10List">
                                <li class="list-group-item">No data available.</li>
                            </ul>
                        </div>
                    </div>
                    <div class="card card-danger">
                        <div class="card-header">
                            <h3 class="card-title">Bottom 10 Products</h3>
                        </div>
                        <div class="card-body">
                            <ul class="list-group" id="bottom10List">
                                <li class="list-group-item">No data available.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div class="col-lg-8">
                <div class="card card-info mt-4">
    <div class="card-header">
        <h3 class="card-title">Product Sales This Year</h3>
    </div>
    <div class="card-body">
        <canvas id="productSalesChart" style="height: 300px;"></canvas>
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
            $('#branchFilter').append(`<option value="${branch.id}">${branch.name}</option>`);
        });

        // Populate Product filter
        $('#productFilter').append('<option value="">All Products</option>');
        products.forEach(product => {
            $('#productFilter').append(`<option value="${product.id}">${product.name}</option>`);
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
                    updateRankingList('top10List', data.top_10_products, 'total_quantity_sold');
                    updateRankingList('bottom10List', data.bottom_10_products, 'total_quantity_sold');

                    // Update chart
                    updateSalesChart(response.graph_data);
                }
            } catch (error) {
                console.error("Error fetching dashboard data:", error);
            }
        }

        function updateRankingList(listId, items, valueKey) {
            const list = $(`#${listId}`);
            list.empty();
            if (items.length > 0) {
                items.forEach(item => {
                    list.append(`<li class="list-group-item d-flex justify-content-between align-items-center">
                        ${item.name}
                        <span class="badge badge-primary badge-pill">${item[valueKey]}</span>
                    </li>`);
                });
            } else {
                list.append('<li class="list-group-item">No data available.</li>');
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
                    grid: { display: false },
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
                legend: { display: false },
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