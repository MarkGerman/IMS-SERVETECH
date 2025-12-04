<div>
    @section('title', 'Stock Report')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Stock Report</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Stock Report</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-box"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Products</span>
                            <span class="info-box-number">{{ $totalProducts }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-boxes"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Quantity</span>
                            <span class="info-box-number">{{ $totalQuantity }}</span>
                        </div>
                    </div>
                </div>
                <div class="clearfix hidden-md-up"></div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-dollar-sign"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Purchase Value</span>
                            <span class="info-box-number">{{ number_format($totalPurchaseValue, 2) }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i
                                class="fas fa-exclamation-triangle"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Low Stock Products</span>
                            <span class="info-box-number">{{ $lowStockProducts }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Products Stock List</h3>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 250px;">
                                    <input type="text" wire:model.live.debounce.300ms="search"
                                        class="form-control float-right"
                                        placeholder="Search by name, brand, barcode...">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-default" wire:click.prevent="printPage"><i
                                                class="fas fa-print"></i> Print</button>
                                        <button type="button" class="btn btn-default" onclick="customPrint()"><i
                                                class="fas fa-print"></i> Print 2</button>
                                        <div class="dropdown open">
                                            <a class="btn btn-secondary dropdown-toggle" type="button" id="triggerId"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Print 3
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="triggerId">
                                                @use(Native\Desktop\Facades\System)
                                                @foreach (System::printers() as $printer)
                                                    <a class="dropdown-item"
                                                        href="#">{{ $printer->displayName }}</a>
                                                @endforeach



                                            </div>  
                                        </div>
                                    </div>
                                    <x-modal title="pdf" status="{{ $modal }}" >
                                        @if($modal)
                                        <iframe src="{{ asset('pdf/My Awesome File.pdf') }}" type="application/pdf" width="100%" height="100%"  >

                                        </iframe>
                                        @endif 
                                    </x-modal>
                                </div>
                            </div>
                        </div>

                        <script>
                            function customPrint() {
                                // window.print();
                                window.NativePHP.printer.printPage();
                            }
                        </script>

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th wire:click="sortBy('name')" style="cursor: pointer;">Name <i
                                                    class="fas fa-sort"></i></th>
                                            <th wire:click="sortBy('category_id')" style="cursor: pointer;">Category <i
                                                    class="fas fa-sort"></i></th>
                                            <th wire:click="sortBy('brand')" style="cursor: pointer;">Brand <i
                                                    class="fas fa-sort"></i></th>
                                            <th>Purchase Price</th>
                                            <th>Selling Price</th>
                                            <th wire:click="sortBy('quantity')" style="cursor: pointer;">Quantity <i
                                                    class="fas fa-sort"></i></th>
                                            <th>Re-order Level</th>
                                            <th>Stock Value (Purchase)</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($products as $product)
                                            <tr>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ $product->category->name ?? 'N/A' }}</td>
                                                <td>{{ $product->brand }}</td>
                                                <td>{{ number_format($product->purchase_price, 2) }}</td>
                                                <td>{{ number_format($product->selling_price, 2) }}</td>
                                                <td>{{ $product->quantity }}</td>
                                                <td>{{ $product->reorder_level }}</td>
                                                <td>{{ number_format($product->purchase_price * $product->quantity, 2) }}
                                                </td>
                                                <td>
                                                    @if ($product->quantity == 0)
                                                        <span class="badge badge-danger">Out of Stock</span>
                                                    @elseif ($product->quantity <= $product->reorder_level)
                                                        <span class="badge badge-warning">Low Stock</span>
                                                    @else
                                                        <span class="badge badge-success">In Stock</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center">No products found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer clearfix">
                            {{ $products->links() }}
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

            .content-wrapper,
            .content-wrapper * {
                visibility: visible;
            }

            .content-wrapper {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            .card-header .card-tools,
            .breadcrumb,
            .content-header .row.mb-2 .col-sm-6:last-child,
            .main-footer,
            .card-footer {
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
