@extends('owner.olayouts.main')
@section('content')
<!-- The biggest battle is the war against ignorance. - Mustafa Kemal Atatürk-->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .row{
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .dashboard-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: none;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border-radius: 16px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
        }
        
        .metric-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 16px;
            padding: 1.5rem;
            text-align: center;
            transition: transform 0.3s ease;
        }
        
        .metric-card:hover {
            transform: scale(1.05);
        }
        
        .metric-value {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }
        
        .metric-label {
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        .chart-container {
            position: relative;
            height: 300px;
            margin: 1rem 0;
        }
        
        .filter-btn {
            border-radius: 25px;
            padding: 0.5rem 1.5rem;
            margin: 0.25rem;
            border: 2px solid #667eea;
            background: transparent;
            color: #667eea;
            transition: all 0.3s ease;
        }
        
        .filter-btn.active,
        .filter-btn:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
        }
        
        .navbar-custom {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
        }
        
        .table-custom {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        
        .progress-custom {
            height: 8px;
            border-radius: 10px;
            background: #e9ecef;
        }
        
        .progress-bar-custom {
            border-radius: 10px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }
    </style>
</head>
    
    
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div id="loader"></div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              {{--<li class="breadcrumb-item"><a href="{{ route('admin.dashboard')}}">Home</a></li>
              <li class="breadcrumb-item"><a href="">Home</a></li>--}}
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <section class="content">
      <div class="container-fluid">
{{--Sample page--}}
          <div class="row">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <i class="fas fa-chart-line me-2"></i>Analytics Pro
            </a>
            <div class="d-flex align-items-center">
                <span class="badge bg-success me-3">Live Data</span>
                <button class="btn btn-outline-primary btn-sm" onclick="refreshData()">
                    <i class="fas fa-sync-alt me-1"></i>Refresh
                </button>
            </div>
        </div>
    </nav>

    <div class="container mt-5 pt-4">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="text-white mb-3">Dashboard Overview</h1>
                <div class="d-flex flex-wrap">
                    <button class="filter-btn active" onclick="setTimeFilter('today')">Today</button>
                    <button class="filter-btn" onclick="setTimeFilter('week')">This Week</button>
                    <button class="filter-btn" onclick="setTimeFilter('month')">This Month</button>
                    <button class="filter-btn" onclick="setTimeFilter('year')">This Year</button>
                </div>
            </div>
        </div>

        <!-- Metrics Cards -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="metric-card">
                    <div class="metric-value" id="totalUsers">24,567</div>
                    <div class="metric-label">Total Users</div>
                    <small class="d-block mt-2">
                        <i class="fas fa-arrow-up text-success"></i> +12.5% from last period
                    </small>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="metric-card">
                    <div class="metric-value" id="revenue">$89,432</div>
                    <div class="metric-label">Revenue</div>
                    <small class="d-block mt-2">
                        <i class="fas fa-arrow-up text-success"></i> +8.3% from last period
                    </small>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="metric-card">
                    <div class="metric-value" id="conversions">3.2%</div>
                    <div class="metric-label">Conversion Rate</div>
                    <small class="d-block mt-2">
                        <i class="fas fa-arrow-down text-warning"></i> -2.1% from last period
                    </small>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="metric-card">
                    <div class="metric-value" id="avgSession">4:32</div>
                    <div class="metric-label">Avg. Session</div>
                    <small class="d-block mt-2">
                        <i class="fas fa-arrow-up text-success"></i> +15.7% from last period
                    </small>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row mb-4">
            <div class="col-lg-8 mb-3">
                <div class="card dashboard-card">
                    <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Revenue Trends</h5>
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-outline-primary active" onclick="updateChart('revenue')">Revenue</button>
                            <button class="btn btn-outline-primary" onclick="updateChart('users')">Users</button>
                            <button class="btn btn-outline-primary" onclick="updateChart('sessions')">Sessions</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="mainChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-3">
                <div class="card dashboard-card">
                    <div class="card-header bg-transparent border-0">
                        <h5 class="mb-0">Traffic Sources</h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="pieChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Performance Metrics -->
        <div class="row mb-4">
            <div class="col-lg-6 mb-3">
                <div class="card dashboard-card">
                    <div class="card-header bg-transparent border-0">
                        <h5 class="mb-0">Performance Metrics</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Page Load Speed</span>
                                <span class="fw-bold">2.3s</span>
                            </div>
                            <div class="progress progress-custom">
                                <div class="progress-bar progress-bar-custom" style="width: 85%"></div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span>User Engagement</span>
                                <span class="fw-bold">78%</span>
                            </div>
                            <div class="progress progress-custom">
                                <div class="progress-bar progress-bar-custom" style="width: 78%"></div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Mobile Optimization</span>
                                <span class="fw-bold">92%</span>
                            </div>
                            <div class="progress progress-custom">
                                <div class="progress-bar progress-bar-custom" style="width: 92%"></div>
                            </div>
                        </div>
                        <div class="mb-0">
                            <div class="d-flex justify-content-between mb-2">
                                <span>SEO Score</span>
                                <span class="fw-bold">88%</span>
                            </div>
                            <div class="progress progress-custom">
                                <div class="progress-bar progress-bar-custom" style="width: 88%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-3">
                <div class="card dashboard-card">
                    <div class="card-header bg-transparent border-0">
                        <h5 class="mb-0">Top Pages</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Page</th>
                                        <th>Views</th>
                                        <th>Bounce Rate</th>
                                    </tr>
                                </thead>
                                <tbody id="topPagesTable">
                                    <tr>
                                        <td>/home</td>
                                        <td><span class="badge bg-primary">12,543</span></td>
                                        <td>23.4%</td>
                                    </tr>
                                    <tr>
                                        <td>/products</td>
                                        <td><span class="badge bg-primary">8,921</span></td>
                                        <td>31.2%</td>
                                    </tr>
                                    <tr>
                                        <td>/about</td>
                                        <td><span class="badge bg-primary">5,432</span></td>
                                        <td>18.7%</td>
                                    </tr>
                                    <tr>
                                        <td>/contact</td>
                                        <td><span class="badge bg-primary">3,210</span></td>
                                        <td>45.1%</td>
                                    </tr>
                                    <tr>
                                        <td>/blog</td>
                                        <td><span class="badge bg-primary">2,876</span></td>
                                        <td>28.9%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Chart configurations
        let mainChart, pieChart;
        let currentTimeFilter = 'today';
        let currentChartType = 'revenue';

        // Sample data for different time periods
        const sampleData = {
            today: {
                revenue: [1200, 1900, 3000, 5000, 2000, 3000, 4500],
                users: [120, 190, 300, 500, 200, 300, 450],
                sessions: [800, 1200, 1800, 3200, 1400, 2100, 2800]
            },
            week: {
                revenue: [8500, 12000, 15000, 18000, 22000, 19000, 25000],
                users: [850, 1200, 1500, 1800, 2200, 1900, 2500],
                sessions: [5600, 8000, 10000, 12000, 14500, 12500, 16500]
            },
            month: {
                revenue: [45000, 52000, 48000, 61000, 55000, 67000, 72000, 68000, 75000, 82000, 78000, 89000],
                users: [4500, 5200, 4800, 6100, 5500, 6700, 7200, 6800, 7500, 8200, 7800, 8900],
                sessions: [30000, 34500, 32000, 40500, 36500, 44500, 48000, 45000, 50000, 54500, 52000, 59000]
            },
            year: {
                revenue: [520000, 580000, 640000, 720000, 680000, 750000, 820000, 780000, 850000, 920000, 880000, 950000],
                users: [52000, 58000, 64000, 72000, 68000, 75000, 82000, 78000, 85000, 92000, 88000, 95000],
                sessions: [350000, 390000, 430000, 480000, 450000, 500000, 550000, 520000, 570000, 620000, 590000, 640000]
            }
        };

        // Initialize charts
        function initCharts() {
            // Main Chart
            const mainCtx = document.getElementById('mainChart').getContext('2d');
            mainChart = new Chart(mainCtx, {
                type: 'line',
                data: {
                    labels: getLabels(currentTimeFilter),
                    datasets: [{
                        label: 'Revenue ($)',
                        data: sampleData[currentTimeFilter].revenue,
                        borderColor: '#667eea',
                        backgroundColor: 'rgba(102, 126, 234, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0,0,0,0.1)'
                            }
                        },
                        x: {
                            grid: {
                                color: 'rgba(0,0,0,0.1)'
                            }
                        }
                    }
                }
            });

            // Pie Chart
            const pieCtx = document.getElementById('pieChart').getContext('2d');
            pieChart = new Chart(pieCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Organic Search', 'Direct', 'Social Media', 'Referral', 'Email'],
                    datasets: [{
                        data: [45, 25, 15, 10, 5],
                        backgroundColor: [
                            '#667eea',
                            '#764ba2',
                            '#f093fb',
                            '#f5576c',
                            '#4facfe'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true
                            }
                        }
                    }
                }
            });
        }

        // Get labels based on time filter
        function getLabels(timeFilter) {
            switch(timeFilter) {
                case 'today':
                    return ['6 AM', '9 AM', '12 PM', '3 PM', '6 PM', '9 PM', '12 AM'];
                case 'week':
                    return ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
                case 'month':
                    return ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5', 'Week 6', 'Week 7', 'Week 8', 'Week 9', 'Week 10', 'Week 11', 'Week 12'];
                case 'year':
                    return ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                default:
                    return [];
            }
        }

        // Set time filter
        function setTimeFilter(filter) {
            currentTimeFilter = filter;
            
            // Update active button
            document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            
            // Update chart
            mainChart.data.labels = getLabels(filter);
            mainChart.data.datasets[0].data = sampleData[filter][currentChartType];
            mainChart.update();
            
            // Update metrics based on time filter
            updateMetrics(filter);
        }

        // Update chart type
        function updateChart(type) {
            currentChartType = type;
            
            // Update active button
            document.querySelectorAll('.btn-group .btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            
            // Update chart data and label
            let label = '';
            switch(type) {
                case 'revenue':
                    label = 'Revenue ($)';
                    break;
                case 'users':
                    label = 'Users';
                    break;
                case 'sessions':
                    label = 'Sessions';
                    break;
            }
            
            mainChart.data.datasets[0].label = label;
            mainChart.data.datasets[0].data = sampleData[currentTimeFilter][type];
            mainChart.update();
        }

        // Update metrics based on time filter
        function updateMetrics(filter) {
            const metrics = {
                today: {
                    users: '24,567',
                    revenue: '$89,432',
                    conversions: '3.2%',
                    avgSession: '4:32'
                },
                week: {
                    users: '156,789',
                    revenue: '$542,100',
                    conversions: '3.8%',
                    avgSession: '5:12'
                },
                month: {
                    users: '678,901',
                    revenue: '$2,340,000',
                    conversions: '4.1%',
                    avgSession: '4:58'
                },
                year: {
                    users: '8,234,567',
                    revenue: '$28,900,000',
                    conversions: '3.9%',
                    avgSession: '5:23'
                }
            };
            
            document.getElementById('totalUsers').textContent = metrics[filter].users;
            document.getElementById('revenue').textContent = metrics[filter].revenue;
            document.getElementById('conversions').textContent = metrics[filter].conversions;
            document.getElementById('avgSession').textContent = metrics[filter].avgSession;
        }

        // Refresh data function
        function refreshData() {
            // Simulate data refresh with loading state
            const refreshBtn = document.querySelector('[onclick="refreshData()"]');
            const originalText = refreshBtn.innerHTML;
            refreshBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Refreshing...';
            refreshBtn.disabled = true;
            
            setTimeout(() => {
                // Generate some random variations in the data
                Object.keys(sampleData).forEach(period => {
                    Object.keys(sampleData[period]).forEach(metric => {
                        sampleData[period][metric] = sampleData[period][metric].map(value => {
                            const variation = (Math.random() - 0.5) * 0.2; // ±10% variation
                            return Math.round(value * (1 + variation));
                        });
                    });
                });
                
                // Update current chart
                mainChart.data.datasets[0].data = sampleData[currentTimeFilter][currentChartType];
                mainChart.update();
                
                // Update metrics
                updateMetrics(currentTimeFilter);
                
                // Reset button
                refreshBtn.innerHTML = originalText;
                refreshBtn.disabled = false;
                
                // Show success message
                const badge = document.querySelector('.badge.bg-success');
                badge.textContent = 'Data Updated';
                setTimeout(() => {
                    badge.textContent = 'Live Data';
                }, 2000);
            }, 1500);
        }

        // Initialize everything when page loads
        document.addEventListener('DOMContentLoaded', function() {
            initCharts();
        });
    </script>
<script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'967a4addc441bc40',t:'MTc1MzkzNTUxMy4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script>

          {{--Sample Page End--}}

          

      </div>
    </section>

  </div>
  @endsection
