<div>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Sales</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Sales</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                {{-- <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ $sale_id ? 'Edit Sale' : 'Create New Sale' }}</h3>
                        </div>
                        <div class="card-body">
                            <form wire:submit.prevent="store">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="customer_id">Customer (Optional)</label>
                                            <select wire:model="customer_id" id="customer_id" class="form-control">
                                                <option value="">Select Customer</option>
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('customer_id') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="payment_method">Payment Method</label>
                                            <select wire:model="payment_method" id="payment_method" class="form-control">
                                                <option value="cash">Cash</option>
                                                <option value="mobile_money">Mobile Money</option>
                                                <option value="card">Card</option>
                                                <option value="other">Other</option>
                                            </select>
                                            @error('payment_method') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="product_id">Product</label>
                                            <select wire:model="product_id" id="product_id" class="form-control">
                                                <option value="">Select Product</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}">{{ $product->name }} (Stock: {{ $product->quantity }})</option>
                                                @endforeach
                                            </select>
                                            @error('product_id') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="quantity">Quantity</label>
                                            <input type="number" wire:model="quantity" id="quantity" class="form-control">
                                            @error('quantity') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <button type="button" wire:click="addItem" class="btn btn-primary btn-block">Add Item</button>
                                        </div>
                                    </div>
                                </div>

                                @if (!empty($sale_items))
                                    <table class="table table-bordered mt-3">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Quantity</th>
                                                <th>Unit Price</th>
                                                <th>Total Price</th>
                                                <th>Profit</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($sale_items as $index => $item)
                                                <tr>
                                                    <td>{{ $item['product_name'] }}</td>
                                                    <td>{{ $item['quantity'] }}</td>
                                                    <td>{{ number_format($item['unit_price'], 2) }}</td>
                                                    <td>{{ number_format($item['total_price'], 2) }}</td>
                                                    <td>{{ number_format(($item['unit_price'] - $item['purchase_price']) * $item['quantity'], 2) }}</td>
                                                    <td>
                                                        <button type="button" wire:click="removeItem({{ $index }})" class="btn btn-danger btn-sm">Remove</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                                @error('sale_items') <span class="text-danger d-block mt-2">{{ $message }}</span> @enderror


                                <div class="row justify-content-end mt-3">
                                    <div class="col-md-4">
                                        <div class="alert alert-secondary">
                                            <h4>Total: {{ number_format($total_amount, 2) }}</h4>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="amount_paid">Amount Paid</label>
                                            <input type="number" step="0.01" wire:model.live="amount_paid" id="amount_paid" class="form-control">
                                            @error('amount_paid') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="change">Change</label>
                                            <input type="text" wire:model="change" id="change" class="form-control" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mt-3">
                                    <button type="submit" class="btn btn-success">{{ $sale_id ? 'Update Sale' : 'Complete Sale' }}</button>
                                    @if ($sale_id)
                                        <button type="button" wire:click="resetForm" class="btn btn-secondary">Cancel Edit</button>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div> --}}

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Sales History</h3>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <input type="date" wire:model.live="filter_date" class="form-control"
                                        placeholder="Filter by date">
                                </div>
                                <div class="col-md-4">
                                    <select wire:model.live="filter_customer" class="form-control">
                                        <option value="">All Customers</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select wire:model.live="filter_seller" class="form-control">
                                        <option value="">All Sellers</option>
                                        @foreach (\App\Models\User::all() as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Date</th>
                                        <th>Customer</th>
                                        <th>Total Amount</th>
                                        <th>Amount Paid</th>
                                        <th>Change</th>
                                        <th>Profit</th>
                                        <th>Sold By</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($sales as $sale)
                                        <tr>
                                            <td>{{ $sale->id }}</td>
                                            <td>{{ $sale->sale_date }}</td>
                                            <td>{{ $sale->customer->name ?? 'N/A' }}</td>
                                            <td>MWK{{ number_format($sale->total_amount) }}</td>
                                            <td>MWK{{ number_format($sale->amount_paid) }}</td>
                                            <td>MWK{{ number_format($sale->change) }}</td>
                                            <td class="text-success fs-2">
                                                @php
                                                    $profit = $sale->items->sum(
                                                        fn($item) => ($item->unit_price -
                                                            $item->product->purchase_price) *
                                                            $item->quantity,
                                                    );

                                                @endphp
                                                MWK{{ number_format($profit) }}
                                            </td>
                                            <td>{{ $sale->creator->name }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <button wire:click="viewSale({{ $sale->id }})"
                                                        class="btn btn-sm btn-info">View</button>
                                                    <button wire:click="editSale({{ $sale->id }})"
                                                        class="btn btn-sm btn-secondary">Edit</button>
                                                    @if (Auth::user()->is_admin)
                                                        <button wire:click="deleteSale({{ $sale->id }})"
                                                            class="btn btn-sm btn-danger">Delete</button>
                                                    @endif
                                                    <button wire:click="printReceipt({{ $sale->id }})"
                                                        class="btn btn-sm btn-primary">Print</button>
                                                </div>

                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">No sales found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            <div class="mt-3">
                                {{ $sales->links() }}
                            </div>
                        </div>
                        <div class="card-footer">
                            <h4>Daily Sales Summary: {{ number_format($daily_summary) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <x-modal title=" Sale Details - ID: {{ empty($selected_sale->id) ? '' : $selected_sale->id }}"
            :status="$view_modal">
            @if (!empty($selected_sale))
                <p><strong>Customer:</strong> {{ $selected_sale->customer->name ?? 'N/A' }}</p>
                <p><strong>Date:</strong> {{ empty($selected_sale->sale_date) ? 'N/A' : $selected_sale->sale_date }}</p>
                <p><strong>Total Amount:</strong>
                    {{ empty(number_format($selected_sale->total_amount)) ? 'N/A' : number_format($selected_sale->total_amount) }}
                </p>
                <p><strong>Amount Paid:</strong>
                    {{ empty(number_format($selected_sale->amount_paid)) ? 'N/A' : number_format($selected_sale->amount_paid) }}
                </p>
                <p><strong>Change:</strong>
                    {{ empty(number_format($selected_sale->change)) ? 'N/A' : number_format($selected_sale->change) }}</p>
                <p><strong>Payment Method:</strong>
                    {{ empty($selected_sale->payment_method) ? 'N/A' : $selected_sale->payment_method }}</p>
                <p><strong>Sold By:</strong>
                    {{ empty($selected_sale->creator->name) ? 'N/A' : $selected_sale->creator->name }}</p>
            @endif
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Total Price</th>
                        <th>Profit</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (empty($selected_sale->items) ? [] : $selected_sale->items as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->unit_price) }}</td>
                            <td>{{ number_format($item->total_price) }}</td>
                            <td>{{ number_format(($item->unit_price - $item->product->purchase_price) * $item->quantity) }}
                            </td>
                            <td>
                                <button wire:click="returnItem({{ $item->id }})"
                                    class="btn btn-sm btn-warning">Return</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if ($return_item_id)
                <div class="mt-4">
                    <h4>Return Product</h4>
                    <p><strong>Product:</strong> {{ $selected_sale->items->firstWhere('id', $return_item_id)->product->name }}</p>
                    <p><strong>Quantity:</strong> {{ $selected_sale->items->firstWhere('id', $return_item_id)->quantity }}</p>
                    <div class="form-group">
                        <label for="return_quantity">Quantity to Return</label>
                        <input type="number" wire:model="return_quantity" id="return_quantity" class="form-control"
                            max="{{ $selected_sale->items->firstWhere('id', $return_item_id)->quantity }}">
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
                    <button wire:click="confirmReturn" class="btn btn-success">Confirm Return</button>
                </div>
            @endif
        </x-modal>



</section>
</div>
