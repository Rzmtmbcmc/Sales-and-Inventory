@extends('manager.mlayouts.main')
@section('content')
<!-- The biggest battle is the war against ignorance. - Mustafa Kemal Atatürk-->
<header>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .card-analytics {
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
            border-radius: 12px;
            transition: box-shadow 0.2s;
        }
        .card-analytics:hover {
            box-shadow: 0 4px 16px rgba(0,0,0,0.12);
        }
        .analytics-icon {
            font-size: 2rem;
            color: #0d6efd;
        }
        .dashboard-header {
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 2rem;
        }
        
        /* Activity Status Styles */
        #activityStatus {
            padding: 8px 15px;
            border-radius: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        #activityStatus i {
            display: inline-block;
            margin-right: 5px;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
        }
        .alert-success #statusText { color: #155724; }
        .alert-warning #statusText { color: #856404; }
        .alert-danger #statusText { color: #721c24; }
    </style>
    <!-- CSRF Token for Heartbeat -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/heartbeat.js') }}"></script>
</header>

<!-- Activity Status Indicator -->
<div id="activityStatus" style="position: fixed; top: 10px; right: 10px; z-index: 1050; display: none;" class="alert" role="alert">
    <i class="fas fa-circle"></i> <span id="statusText">Online</span>
</div>
    
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


    <div class="container py-4">
        <div class="dashboard-header">Owner Dashboard</div>
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card card-analytics text-center p-3">
                    <div class="analytics-icon mb-2">
                        <i class="bi bi-bar-chart-line"></i>
                    </div>
                    <h5 class="card-title">Total Sales</h5>
                    <p class="display-6 fw-bold">$12,340</p>
                    <span class="text-success">+8% this month</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-analytics text-center p-3">
                    <div class="analytics-icon mb-2">
                        <i class="bi bi-people"></i>
                    </div>
                    <h5 class="card-title">Customers</h5>
                    <p class="display-6 fw-bold">1,245</p>
                    <span class="text-success">+5% growth</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-analytics text-center p-3">
                    <div class="analytics-icon mb-2">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <h5 class="card-title">Inventory</h5>
                    <p class="display-6 fw-bold">320</p>
                    <span class="text-danger">-2% this week</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-analytics text-center p-3">
                    <div class="analytics-icon mb-2">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                    <h5 class="card-title">Revenue</h5>
                    <p class="display-6 fw-bold">$8,900</p>
                    <span class="text-success">+12% this month</span>
                </div>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-8">
                <div class="card card-analytics p-4">
                    <h5 class="card-title mb-3">Sales Analytics</h5>
                    <canvas id="salesChart" height="120"></canvas>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-analytics p-4">
                    <h5 class="card-title mb-3">Top Products</h5>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Product A
                            <span class="badge bg-primary rounded-pill">120</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Product B
                            <span class="badge bg-primary rounded-pill">98</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Product C
                            <span class="badge bg-primary rounded-pill">85</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('salesChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Sales',
                    data: [1200, 1900, 3000, 2500, 3200, 4000],
                    borderColor: '#0d6efd',
                    backgroundColor: 'rgba(13,110,253,0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                }
            }
        });
    </script>
          </div>
          {{--Sample Page End--}}

          

      </div>
    </section>

  </div>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize the heartbeat system
        const heartbeat = new UserHeartbeat({
            heartbeatInterval: 30000, // 30 seconds
            inactivityTimeout: 300000, // 5 minutes
            onStatusUpdate: updateActivityStatus
        });

        // Function to update the status indicator
        function updateActivityStatus(status) {
            const statusIndicator = document.getElementById('activityStatus');
            const statusText = document.getElementById('statusText');
            const icon = statusIndicator.querySelector('i');

            if (status.is_active) {
                statusIndicator.className = 'alert alert-success';
                statusText.textContent = 'Online';
                icon.style.color = '#28a745';
            } else {
                statusIndicator.className = 'alert alert-warning';
                statusText.textContent = 'Inactive';
                icon.style.color = '#ffc107';
            }

            // Show the status indicator
            statusIndicator.style.display = 'block';

            // Hide after 3 seconds
            setTimeout(() => {
                statusIndicator.style.display = 'none';
            }, 3000);
        }

        // Start the heartbeat
        heartbeat.start().catch(error => {
            console.error('Failed to start heartbeat:', error);
            // Show error notification
            const statusIndicator = document.getElementById('activityStatus');
            statusIndicator.className = 'alert alert-danger';
            document.getElementById('statusText').textContent = 'Connection Error';
            statusIndicator.style.display = 'block';
        });

        // Add idle detection warning
        let idleWarningShown = false;
        document.addEventListener('mousemove', resetIdleWarning);
        document.addEventListener('keydown', resetIdleWarning);
        document.addEventListener('click', resetIdleWarning);

        function resetIdleWarning() {
            if (idleWarningShown) {
                const statusIndicator = document.getElementById('activityStatus');
                statusIndicator.style.display = 'none';
                idleWarningShown = false;
            }
        }

        // Check for inactivity
        setInterval(() => {
            const lastActivity = heartbeat.lastActivityTime;
            const inactiveTime = Date.now() - lastActivity;
            
            // Show warning when 4 minutes inactive (1 minute before being marked as inactive)
            if (inactiveTime > 240000 && !idleWarningShown) {
                const statusIndicator = document.getElementById('activityStatus');
                statusIndicator.className = 'alert alert-warning';
                document.getElementById('statusText').textContent = 'You will be marked as inactive soon';
                statusIndicator.style.display = 'block';
                idleWarningShown = true;
            }
        }, 30000); // Check every 30 seconds
})
.catch(error => {
    console.error('Authentication test error:', error);
});
    </script>
  @endsection
