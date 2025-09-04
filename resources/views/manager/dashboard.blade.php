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
    </style>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/user-heartbeat.js') }}"></script>
</header>
    
    
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
            const heartbeat = new UserHeartbeat();
            heartbeat.start();
            fetch('/api/user', {
    headers: {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    credentials: 'include'
})
.then(response => {
    if (!response.ok) {
        console.error('Authentication test failed:', response.status);
        // Redirect to login if needed
        if (response.status === 401) {
            window.location.href = '/login';
        }
    }
    return response.json();
})
.then(user => {
    console.log('Authenticated as:', user);
})
.catch(error => {
    console.error('Authentication test error:', error);
});
        });
    </script>
  @endsection
