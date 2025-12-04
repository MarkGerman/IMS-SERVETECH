<div>
    <div>

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Dashboard</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h3 class="count">
                                    {{ $totalSalesToday ? number_format($totalSalesToday, 0, '.', ',') : '—' }}</h3>
                                <p>Total Sales (Today)</p>
                            </div>
                            <div class="icon"><i class="fas fa-coins"></i></div>
                            @if ($totalSalesToday && $totalSalesToday > 0)
                                <span class="small-box-footer">New <span
                                        class="badge badge-light ml-2">Today</span></span>
                            @endif
                        </div>
                    </div>
                    <!-- Small Box for Products in Stock -->
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3 class="count">{{ $productsInStock ? number_format($productsInStock, 0, '.', ',') : '—' }}</h3>
                                <p>Products in Stock</p>
                            </div>
                            <div class="icon"><i class="fas fa-boxes"></i></div>

                        </div>
                    </div>
                    <!-- Small Box for Profit Today -->
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3 class="count">{{ $profitToday ? 'MWK ' . number_format($profitToday, 0, '.', ',') : '—' }}</h3>
                                <p>Profit (Today)</p>
                            </div>
                            <div class="icon"><i class="fas fa-chart-line"></i></div>

                        </div>
                    </div>
                    <!-- Small Box for Low Stock Count -->
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3 class="count">{{ $lowStockCount ? number_format($lowStockCount, 0, '.', ',') : '—' }}</h3>
                                <p>Low Stock Items</p>
                            </div>
                            <div class="icon"><i class="fas fa-exclamation-triangle"></i></div>
                           
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <!-- Sales Chart - Today -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Sales (Today)</h3>
                            </div>
                            <div class="card-body">
                                <canvas id="salesChartToday" style="height:300px;"></canvas>
                            </div>
                        </div>

                        <!-- Sales Chart - This Week -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Sales (This Week)</h3>
                            </div>
                            <div class="card-body">
                                <canvas id="salesChartWeek" style="height:300px;"></canvas>
                            </div>
                        </div>

                        <!-- Sales Chart - This Month -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Sales (This Month)</h3>
                            </div>
                            <div class="card-body">
                                <canvas id="salesChartMonth" style="height:300px;"></canvas>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Best Selling Products</h3>
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Units Sold</th>
                                            <th>Total Revenue (MWK)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($bestSellingProducts as $p)
                                            <tr>
                                                <td>{{ $p->name }}</td>
                                                <td>{{ $p->units_sold }}</td>
                                                <td>{{ $p->revenue ? 'MWK ' . number_format($p->revenue, 0, '.', ',') : '—' }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3">—</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Expense Summary (Today)</h3>
                            </div>
                            <div class="card-body">
                                <div class="small-box bg-secondary">
                                    <div class="inner">
                                        <h4>{{ $expenseToday ? 'MWK ' . number_format($expenseToday, 0, '.', ',') : '—' }}
                                        </h4>
                                        <p>Expenses (Today)</p>
                                    </div>
                                    <div class="icon"><i class="fas fa-money-bill-wave"></i></div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Recent Transactions</h3>
                            </div>
                            <div class="card-body p-0 table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Customer</th>
                                            <th>Total (MWK)</th>
                                            <th>Seller</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recentTransactions as $t)
                                            <tr>
                                                <td>{{ $t->sale_date ? \Carbon\Carbon::parse($t->sale_date)->format('Y-m-d') : '—' }}
                                                </td>
                                                <td>{{ optional($t->customer)->name ?? '—' }}</td>
                                                <td>{{ $t->total_amount ? 'MWK ' . number_format($t->total_amount, 0, '.', ',') : '—' }}
                                                </td>
                                                <td>{{ optional($t->creator)->name ?? '—' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4">—</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Low Stock Items</h3>
                            </div>
                            <div class="card-body p-0">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Quantity</th>
                                            <th>Reorder Level</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($lowStockItems as $ls)
                                            <tr>
                                                <td>{{ $ls->name }}</td>
                                                <td>{{ $ls->quantity }}</td>
                                                <td>{{ $ls->reorder_level }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3">—</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @script
    <script>
        let salesChartToday, salesChartWeek, salesChartMonth;

        function renderChart(chartId, labels, data, chartInstance) {
            const ctx = document.getElementById(chartId).getContext('2d');
            if (chartInstance) {
                chartInstance.destroy();
            }
            return new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Sales (MWK)',
                        data: data,
                        borderColor: '#007bff',
                        backgroundColor: 'rgba(0,123,255,0.1)',
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        // Initial chart renders
        salesChartToday = renderChart('salesChartToday', @json($salesChartDataToday['labels']), @json($salesChartDataToday['data']), salesChartToday);
        salesChartWeek = renderChart('salesChartWeek', @json($salesChartDataWeek['labels']), @json($salesChartDataWeek['data']), salesChartWeek);
        salesChartMonth = renderChart('salesChartMonth', @json($salesChartDataMonth['labels']), @json($salesChartDataMonth['data']), salesChartMonth);
    </script>
    @endscript
</div>
