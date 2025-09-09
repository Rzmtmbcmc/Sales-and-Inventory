<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Past Order Details - Owner Dashboard</title>
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
                            <h1 class="m-0">Past Order Details</h1>
                        </div>
                        <div class="col-sm-6">
                            <div class="float-sm-right">
                                <a href="{{ route('owner.past-orders.index') }}" class="btn btn-secondary">
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
                                        <i class="fas fa-eye mr-2 text-primary"></i>Past Order Details
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="row mb-3">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0">Order ID:</h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary">
                                                    {{ $pastOrder->id }}
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0">Brand:</h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary">
                                                    {{ $pastOrder->brand->name ?? 'N/A' }}
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0">Branch:</h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary">
                                                    {{ $pastOrder->branch->name ?? 'N/A' }}
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0">Total Amount:</h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary">
                                                    ${{ number_format($pastOrder->total_amount, 2) }}
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0">Date:</h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary">
                                                    {{ $pastOrder->created_at->format('Y-m-d H:i:s') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5 class="card-title mb-0">
                                                        <i class="fas fa-list mr-2 text-primary"></i>Order Items
                                                    </h5>
                                                </div>
                                                <div class="card-body">
                                                    @if($pastOrder->items && $pastOrder->items->count() > 0)
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-striped">
                                                            <thead class="bg-light">
                                                                <tr>
                                                                    <th>Product</th>
                                                                    <th>Quantity</th>
                                                                    <th>Price</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($pastOrder->items as $item)
                                                                <tr>
                                                                    <td>{{ $item->product->name ?? 'N/A' }}</td>
                                                                    <td>{{ $item->quantity }}</td>
                                                                    <td>${{ number_format($item->price, 2) }}</td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    @else
                                                    <div class="empty-state">
                                                        <div class="empty-icon">
                                                            <i class="fas fa-box-open fa-3x" style="color: #d1d5db;"></i>
                                                        </div>
                                                        <h5 class="text-muted mb-3">No Items Found</h5>
                                                        <p class="text-muted">This past order has no associated items.</p>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <a href="{{ route('owner.past-orders.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-arrow-left mr-2"></i>Back to List
                                        </a>
                                        <button class="btn btn-warning float-right" onclick="printOrder({{ $pastOrder->id }})">
                                            <i class="fas fa-print mr-2"></i>Print Order
                                        </button>
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
                        <script>window.print();</script>
                    </body>
                </html>
            `);
            printWindow.document.close();
        }
    </script>
</body>
</html>