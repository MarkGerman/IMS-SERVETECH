<div>
    {{-- dev by Techlink360: Page Header --}}
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Returns Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Returns</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    {{-- dev by Techlink360: Main Content --}}
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Return History</h3>
                            <div class="card-tools">
                                <button wire:click="openNewReturnModal" class="btn btn-primary">Record New
                                    Return</button>
                            </div>
                        </div>
                        <div class="card-body">
                            {{-- dev by Techlink360: Search and Filter --}}
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <input type="text" wire:model.live="searchReturns" class="form-control"
                                        placeholder="Search by Sale ID, Customer, Reason...">
                                </div>
                                <div class="col-md-3">
                                    <input type="date" wire:model.live="filterByDate" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <select wire:model.live="filterByCustomer" class="form-control">
                                        <option value="">Filter by Customer</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select wire:model.live="filterByStatus" class="form-control">
                                        <option value="">Filter by Status</option>
                                        <option value="pending">Pending</option>
                                        <option value="approved">Approved</option>
                                        <option value="rejected">Rejected</option>
                                    </select>
                                </div>
                            </div>

                            {{-- dev by Techlink360: Returns Table --}}
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Return ID</th>
                                            <th>Sale ID</th>
                                            <th>Customer</th>
                                            <th>Return Date</th>
                                            <th>Refund Amount</th>
                                            <th>Status</th>
                                            <th>Created By</th>
                                            <th>Approved By</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($returns as $return)
                                            <tr>
                                                <td>{{ $return->id }}</td>
                                                <td>{{ $return->sale_id }}</td>
                                                <td>{{ $return->customer->name ?? 'N/A' }}</td>
                                                <td>{{ $return->return_date->format('Y-m-d') }}</td>
                                                <td>MWK{{ number_format($return->total_refund_amount, 2) }}</td>
                                                <td><span
                                                        class="badge badge-{{ $return->status == 'approved' ? 'success' : ($return->status == 'rejected' ? 'danger' : 'warning') }}">{{ ucfirst($return->status) }}</span>
                                                </td>
                                                <td>{{ $return->creator->name ?? 'N/A' }}</td>
                                                <td>{{ $return->approver->name ?? 'N/A' }}</td>
                                                <td>
                                                    <button wire:click="viewReturn({{ $return->id }})"
                                                        class="btn btn-info btn-sm" title="View"><i
                                                            class="fas fa-eye"></i></button>
                                                    @if ($return->status == 'pending')
                                                        <button wire:click="approveReturn({{ $return->id }})"
                                                            class="btn btn-success btn-sm" title="Approve"><i
                                                                class="fas fa-check"></i></button>
                                                        <button wire:click="rejectReturn({{ $return->id }})"
                                                            class="btn btn-danger btn-sm" title="Reject"><i
                                                                class="fas fa-times"></i></button>
                                                    @endif
                                                    {{-- Add view details button later if needed --}}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center">No returns found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            {{-- dev by Techlink360: Pagination --}}
                            <div class="mt-3">
                                {{ $returns->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <x-modal title="Return Details - ID: {{ empty($selected_return->id) ? '' : $selected_return->id }}"
            :status="$view_modal">
            @if (!empty($selected_return))
                <p><strong>Sale ID:</strong> {{ $selected_return->sale_id }}</p>
                <p><strong>Customer:</strong> {{ $selected_return->customer->name ?? 'N/A' }}</p>
                <p><strong>Return Date:</strong> {{ $selected_return->return_date->format('Y-m-d') }}</p>
                <p><strong>Total Refund Amount:</strong>
                    MWK{{ number_format($selected_return->total_refund_amount, 2) }}
                </p>
                <p><strong>Status:</strong> <span
                        class="badge badge-{{ $selected_return->status == 'approved' ? 'success' : ($selected_return->status == 'rejected' ? 'danger' : 'warning') }}">{{ ucfirst($selected_return->status) }}</span>
                </p>
                <p><strong>Reason:</strong> {{ $selected_return->reason }}</p>
                <p><strong>Created By:</strong> {{ $selected_return->creator->name ?? 'N/A' }}</p>
                <p><strong>Approved By:</strong> {{ $selected_return->approver->name ?? 'N/A' }}</p>

                <button wire:click="printReturn({{ $selected_return->id }})" class="btn btn-primary">Print</button>
                <h5 class="mt-4">Returned Items</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (empty($selected_return->returnItems) ? [] : $selected_return->returnItems as $item)
                            <tr>
                                <td>{{ $item->saleItem->product->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>MWK{{ number_format($item->saleItem->unit_price, 2) }}</td>
                                <td>MWK{{ number_format($item->quantity * $item->saleItem->unit_price, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </x-modal>

        {{-- Removed: Record New Return Modal --}}


        <x-modal title="Record New Return" :status="$new_return_modal">
            <form wire:submit.prevent="storeReturn">
                <div class="form-group">
                    <label for="sale_id">Select Sale</label>
                    <select wire:model.live="selected_sale_id" id="sale_id" class="form-control">
                        <option value="">Select Sale</option>
                        @foreach ($sales as $sale)
                            <option value="{{ $sale->id }}">ID: {{ $sale->id }} -
                                {{ $sale->customer->name ?? 'N/A' }} - {{ $sale->sale_date }}</option>
                        @endforeach
                    </select>
                    @error('selected_sale_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                @if ($selected_sale_id)
                    <div class="form-group">
                        <label for="product_id">Select Product</label>
                        <select wire:model="selected_product_id" id="product_id" class="form-control">
                            <option value="">Select Product</option>
                            @foreach ($products as $product)
                                <option value="{{ $product['id'] }}">
                                    {{ $product['name'] }} (Sold: {{ $product['quantity'] }})
                                </option>
                            @endforeach
                        </select>
                        @error('selected_product_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="return_quantity">Quantity to Return</label>
                        <input type="number" wire:model="return_quantity" id="return_quantity" class="form-control"
                            max="{{ $max_return_quantity }}">
                        @error('return_quantity')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="return_reason">Reason for Return</label>
                        <textarea wire:model="return_reason" id="return_reason" class="form-control"></textarea>
                        @error('return_reason')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="admin_email">Admin Email</label>
                        <input type="email" wire:model="admin_email" id="admin_email" class="form-control">
                        @error('admin_email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="admin_password">Admin Password</label>
                        <input type="password" wire:model="admin_password" id="admin_password" class="form-control">
                        @error('admin_password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                @endif

                <button type="submit" class="btn btn-primary">Submit Return</button>
            </form>
        </x-modal>




    </section>


    @script
        <script>
            window.addEventListener('print-return', event => {
                const returnId = event.detail[0];
                const url = `/returns/print/${returnId}`;
                const printWindow = window.open(url, '_blank');
                printWindow.addEventListener('load', () => {
                    printWindow.print();
                });
            });
        </script>
    @endscript




</div>
