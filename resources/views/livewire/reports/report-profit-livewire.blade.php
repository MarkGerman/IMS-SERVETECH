<div>
    @section('title', 'Profit & Loss Report')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Profit & Loss Report</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Profit & Loss Report</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <!-- dev by Techlink360: Date Filter Card -->
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="startDate">Start Date</label>
                                <input type="date" id="startDate" wire:model.live="startDate" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="endDate">End Date</label>
                                <input type="date" id="endDate" wire:model.live="endDate" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="button" class="btn btn-default" onclick="window.print();"><i class="fas fa-print"></i> Print</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- dev by Techlink360: Summary Info Boxes -->
            <div class="row">
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="info-box bg-success">
                        <span class="info-box-icon"><i class="fas fa-chart-line"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Revenue</span>
                            <span class="info-box-number">{{ number_format($totalRevenue) }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="info-box bg-warning">
                        <span class="info-box-icon"><i class="fas fa-shopping-cart"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Cost of Goods Sold (COGS)</span>
                            <span class="info-box-number">{{ number_format($totalCOGS) }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="info-box bg-info">
                        <span class="info-box-icon"><i class="fas fa-hand-holding-usd"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Gross Profit</span>
                            <span class="info-box-number">{{ number_format($grossProfit) }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="info-box bg-danger">
                        <span class="info-box-icon"><i class="fas fa-file-invoice-dollar"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Expenses</span>
                            <span class="info-box-number">{{ number_format($totalExpenses) }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="info-box bg-primary">
                        <span class="info-box-icon"><i class="fas fa-landmark"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Net Profit</span>
                            <span class="info-box-number">{{ number_format($netProfit) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- dev by Techlink360: Sales Details Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Sales Transactions</h3>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Sale ID</th>
                                            <th>Customer</th>
                                            <th>Revenue</th>
                                            <th>Cost</th>
                                            <th>Profit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($sales as $sale)
                                            @php
                                                $saleRevenue = $sale->items->sum(fn($item) => $item->unit_price * $item->quantity);
                                                $saleCost = $sale->items->sum(fn($item) => ($item->product->purchase_price ?? 0) * $item->quantity);
                                                $saleProfit = $saleRevenue - $saleCost;
                                            @endphp
                                            <tr>
                                                <td>{{ $sale->created_at->format('Y-m-d') }}</td>
                                                <td>{{ $sale->id }}</td>
                                                <td>{{ $sale->customer->name ?? 'N/A' }}</td>
                                                <td>{{ number_format($saleRevenue) }}</td>
                                                <td>{{ number_format($saleCost) }}</td>
                                                <td>
                                                    @php
                                                        $saleProfit = $sale->items->sum(fn($item) => ($item->unit_price - $item->product->purchase_price) * $item->quantity);
                                                        echo number_format($saleProfit);
                                                    @endphp
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No sales found for the selected period.</td>
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
            .main-header, .main-sidebar, .main-footer, .card-footer, .breadcrumb, .content-header .row.mb-2 .col-sm-6:last-child, .card .card-body .row .col-md-2 {
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
