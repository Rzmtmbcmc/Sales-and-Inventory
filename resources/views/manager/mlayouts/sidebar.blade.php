<div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="" alt="AdminLTELogo" height="60" width="60" style="border-radius: 50%">
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>

      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        {{-- <li class="nav-item">
          <a class="nav-link" data-widget="navbar-search" href="#" role="button">
            <i class="fas fa-search"></i>
          </a>
          <div class="navbar-search-block">
            <form class="form-inline">
              <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                  <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                  </button>
                  <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </li> --}}

        <!-- Messages Dropdown Menu -->


        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="fa fa-user"></i> Hello!, <!-- {{ Auth::user()->email }}  Name of usser who login-->
          </a>
        </li>


        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="fa fa-power-off"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <div class="dropdown-divider"></div>
            <a href="" class="dropdown-item mt-2">
              <i class="fa fa-lock"></i> Change Password
            </a>
            <form method="POST" action="">
              @csrf

              <a class="dropdown-item p-3 text-dark"  href=""
                      onclick="event.preventDefault();
                                 this.closest('form').submit();">
                  <i class="fa fa-arrow-right"></i>  {{ __('Log Out') }}
              </a>
          </form>

        </li>


      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="" class="brand-link">

        <img src="" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">STI Panel</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->

        <!-- SidebarSearch Form -->


        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
            <li class="nav-item menu-open">
              <a href="" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Dashboard

                </p>
              </a>
            </li>



            <li class="nav-item">
              <a href="" class="nav-link">
                  <i class="nav-icon fa fa-box"></i>
                <p>
                  for edit
                </p>
              </a>
            </li>



            <li class="nav-item">
              <a href="" class="nav-link">
                <i class="nav-icon fa fa-users"></i>
                <p>
                   for edit
                </p>
              </a>
            </li>


            <li class="nav-header">Maintenance</li>


            <li class="nav-item">
              <a href="" class="nav-link">
                <i class="nav-icon fa fa-list"></i>
                <p>
                  for edit
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="" class="nav-link">
                <i class="nav-icon fa fa-scroll"></i>
                <p>
                   for edit
                </p>
              </a>
            </li>
            <li class="nav-item">
                <a href="" class="nav-link">
                    <i class="nav-icon fa fa-users-cog"></i>
                  <p>
                     for edit
                  </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="" class="nav-link">
                    <i class="nav-icon fa fa-desktop"></i>
                  <p>
                     for edit
                  </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="" class="nav-link">
                    <i class="nav-icon fa fa-cogs"></i>
                  <p>
                     for edit
                  </p>
                </a>
            </li>



          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>
