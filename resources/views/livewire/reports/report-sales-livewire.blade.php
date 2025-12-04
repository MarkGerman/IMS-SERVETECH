<div>
    @section('title', 'Sales Report')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Sales Report</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Sales Report</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <!-- dev by Techlink360: Filter Card -->
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Start Date</label>
                                <input type="date" wire:model.live="startDate" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>End Date</label>
                                <input type="date" wire:model.live="endDate" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Customer</label>
                                <select wire:model.live="customer_id" class="form-control">
                                    <option value="">All Customers</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Sold By</label>
                                <select wire:model.live="user_id" class="form-control">
                                    <option value="">All Users</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- dev by Techlink360: Summary Info Boxes -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-dollar-sign"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Revenue</span>
                            <span class="info-box-number">{{ number_format($totalRevenue) }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-receipt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Number of Sales</span>
                            <span class="info-box-number">{{ $totalSalesCount }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-boxes"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Items Sold</span>
                            <span class="info-box-number">{{ $totalItemsSold }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-chart-pie"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Average Sale Amount</span>
                            <span class="info-box-number">{{ number_format($averageSaleAmount) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- dev by Techlink360: Sales Table -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Sales Details</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" onclick="window.print();"><i class="fas fa-print"></i> Print</button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Date</th>
                                    <th>Customer</th>
                                    <th>Total Amount</th>
                                    <th>Amount Paid</th>
                                    <th>Change</th>
                                    <th>Payment Method</th>
                                    <th>Sold By</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($sales as $sale)
                                    <tr>
                                        <td>{{ $sale->id }}</td>
                                        <td>{{ $sale->created_at->format('Y-m-d H:i') }}</td>
                                        <td>{{ $sale->customer->name ?? 'N/A' }}</td>
                                        <td>{{ number_format($sale->total_amount) }}</td>
                                        <td>{{ number_format($sale->amount_paid) }}</td>
                                        <td>{{ number_format($sale->change) }}</td>
                                        <td>{{ $sale->payment_method }}</td>
                                        <td>{{ $sale->creator->name ?? 'N/A' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No sales found for the selected criteria.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer clearfix">
                    {{ $sales->links() }}
                </div>
            </div>
        </div>
    </section>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            .content-wrapper, .content-wrapper * {
                visibility: visible;
            }
            .content-wrapper {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
            .main-header, .main-sidebar, .main-footer, .card-footer, .breadcrumb, .content-header .row.mb-2 .col-sm-6:last-child, .card-tools, .card:first-of-type {
                display: none !important;
            }
            .card {
                box-shadow: none !important;
                border: 1px solid #dee2e6 !important;
            }
            .table {
                width: 100% !important;
            }
            .table-responsive {
                overflow: hidden !important;
            }
        }
    </style>
</div>
