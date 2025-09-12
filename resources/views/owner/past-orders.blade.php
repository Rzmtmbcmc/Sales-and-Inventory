@extends('owner.olayouts.main')
@section('content')
    <style>
        .order-amount {
            font-weight: 600;
            color: #28a745;
            font-size: 1.1rem;
        }
        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.02);
        }
        @media (max-width: 767.98px) {
            .info-box, .small-box, .card {
                margin-bottom: 1rem;
            }
            .table-responsive {
                overflow-x: auto;
            }
            .card-header .card-title {
                font-size: 1rem;
            }
            .input-group-text, .form-control {
                font-size: 0.95rem;
            }
            .btn {
                font-size: 0.95rem;
                padding: 0.4rem 0.7rem;
            }
        }
    </style>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">PAST ORDERS</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Past Orders</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <!-- Info boxes -->
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $stats['total_orders'] ?? 0 }}</h3>
                                <p>Total Orders</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-list"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>₱{{ number_format($stats['total_amount'] ?? 0, 2) }}</h3>
                                <p>Total Amount</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $stats['orders_today'] ?? 0 }}</h3>
                                <p>Orders Today</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-calendar-day"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h3>{{ $stats['orders_this_month'] ?? 0 }}</h3>
                                <p>Orders This Month</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Search and Filter Section -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-search mr-1"></i> Search & Filter</h3>
                    </div>
                    <div class="card-body">
                        <form class="row g-2" method="GET" action="{{ route('owner.past-orders.index') }}">
                            <div class="col-12 col-md-4 mb-2">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    <input type="text" name="search" class="form-control" placeholder="Search by brand, branch, or order ID..." value="{{ request('search', '') }}">
                                </div>
                            </div>
                            <div class="col-6 col-md-2 mb-2">
                                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                            </div>
                            <div class="col-6 col-md-2 mb-2">
                                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                            </div>
                            <div class="col-6 col-md-2 mb-2">
                                <select name="sort_direction" class="form-control">
                                    <option value="desc" {{ request('sort_direction', 'desc') == 'desc' ? 'selected' : '' }}>Newest First</option>
                                    <option value="asc" {{ request('sort_direction') == 'asc' ? 'selected' : '' }}>Oldest First</option>
                                </select>
                            </div>
                            <div class="col-6 col-md-2 mb-2">
                                <input type="text" name="branch_search" class="form-control" placeholder="Branch..." value="{{ request('branch_search', '') }}">
                            </div>
                            <div class="col-6 col-md-2 mb-2">
                                <input type="text" name="brand_search" class="form-control" placeholder="Brand..." value="{{ request('brand_search', '') }}">
                            </div>
                            <div class="col-12 col-md-2 mb-2">
                                <button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter mr-1"></i>Filter</button>
                            </div>
                            <div class="col-12 col-md-2 mb-2">
                                <a href="{{ route('owner.past-orders.index') }}" class="btn btn-secondary w-100"><i class="fas fa-times mr-1"></i>Clear</a>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Orders Table -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-list mr-1"></i> Past Orders List</h3>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
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
                                <tr>
                                    <td>{{ $pastOrder->id }}</td>
                                    <td>{{ $pastOrder->brand->name ?? 'N/A' }}</td>
                                    <td>{{ $pastOrder->branch->name ?? 'N/A' }}</td>
                                    <td class="order-amount">₱{{ number_format($pastOrder->total_amount, 2) }}</td>
                                    <td>{{ $pastOrder->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <a href="{{ route('owner.past-orders.show', $pastOrder) }}" class="btn btn-info btn-sm"><i class="fas fa-eye mr-1"></i>View</a>
                                        <button class="btn btn-warning btn-sm" onclick="printOrder({{ $pastOrder->id }})"><i class="fas fa-print mr-1"></i>Print</button>
                                        <form method="POST" action="{{ route('owner.past-orders.destroy', $pastOrder) }}" style="display: inline;" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash mr-1"></i>Delete</button>
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
                    <div class="card-footer clearfix">
                        <div class="float-left">
                            <span class="text-muted">
                                Showing <span id="showingStart">{{ $showingStart ?? 0 }}</span> to <span id="showingEnd">{{ $showingEnd ?? 0 }}</span>
                                of <span id="totalEntries">{{ $totalEntries ?? 0 }}</span> entries
                            </span>
                        </div>
                        <div class="float-right">
                            {{ $pastOrders->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
