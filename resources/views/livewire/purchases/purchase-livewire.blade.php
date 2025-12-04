<div>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Purchases</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Purchases</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Create New Purchase</h3>
                        </div>
                        <div class="card-body">
                            <form wire:submit.prevent="store">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="supplier_id">Supplier</label>
                                            <select wire:model="supplier_id" id="supplier_id" class="form-control">
                                                <option value="">Select Supplier</option>
                                                @foreach ($suppliers as $supplier)
                                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('supplier_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="purchase_date">Purchase Date</label>
                                            <input type="date" wire:model="purchase_date" id="purchase_date"
                                                class="form-control">
                                            @error('purchase_date')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="product_id">Product</label>
                                            <select wire:model="product_id" id="product_id" class="form-control">
                                                <option value="">Select Product</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('product_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="quantity">Quantity</label>
                                            <input type="number" wire:model="quantity" id="quantity"
                                                class="form-control">
                                            @error('quantity')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="cost">Cost</label>
                                            <input type="number" step="0.01" wire:model="cost" id="cost"
                                                class="form-control">
                                            @error('cost')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <button type="button" wire:click="addItem"
                                                class="btn btn-primary btn-block">Add Item</button>
                                        </div>
                                    </div>
                                </div>

                                @if (!empty($purchase_items))
                                    <table class="table table-bordered mt-3">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Quantity</th>
                                                <th>Cost</th>
                                                <th>Subtotal</th>

                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($purchase_items as $index => $item)
                                                <tr>
                                                    <td>{{ $item['product_name'] }}</td>
                                                    <td>{{ $item['quantity'] }}</td>
                                                    <td>{{ $item['cost'] }}</td>
                                                    <td>{{ $item['sub_total'] }}</td>
                                                    <td>
                                                        <button type="button"
                                                            wire:click="removeItem({{ $index }})"
                                                            class="btn btn-danger btn-sm">Remove</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                                @error('purchase_items')
                                    <span class="text-danger d-block mt-2">{{ $message }}</span>
                                @enderror


                                <div class="row justify-content-end mt-3">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="total_amount">Total Amount</label>
                                            <input type="text" wire:model="total_amount" id="total_amount"
                                                class="form-control" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mt-3">
                                    <button type="submit" class="btn btn-success">Save Purchase</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Purchase History</h3>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <input type="date" wire:model.live="filter_date" class="form-control"
                                        placeholder="Filter by date">
                                </div>
                                <div class="col-md-6">
                                    <select wire:model.live="filter_supplier" class="form-control">
                                        <option value="">All Suppliers</option>
                                        @foreach ($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Supplier</th>
                                        <th>Date</th>
                                        <th>Total Amount</th>
                                        <th>Created By</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($purchases as $purchase)
                                        <tr>
                                            <td>{{ $purchase->id }}</td>
                                            <td>{{ $purchase->supplier->name }}</td>
                                            <td>{{ $purchase->purchase_date }}</td>
                                            <td>{{ $purchase->total_amount }}</td>
                                            <td>{{ $purchase->creator->name }}</td>
                                            <td
                                                class="text-{{ $purchase->status == 'received' ? 'success' : ($purchase->status == 'pending' ? 'danger' : 'warning') }}">
                                                {{ $purchase->status }}</td>
                                            </td>
                                            <td>
                                                <button wire:click="viewPurchase({{ $purchase->id }})"
                                                    class="btn btn-sm btn-info">View Details</button>
                                                <button wire:click="delete({{ $purchase->id }})"
                                                    class="btn btn-sm btn-danger">Delete</button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No purchases found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            <div class="mt-3">
                                {{ $purchases->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <x-modal title=" Purchase Details - ID: {{ empty($selected_purchase->id ) ? '' : $selected_purchase->id}}" :status="$view_modal">
            <p><strong>Supplier:</strong> {{ empty($selected_purchase->supplier->name) ? 'N/A' : $selected_purchase->supplier->name}}</p>
            <p><strong>Date:</strong> {{ empty($selected_purchase->purchase_date) ? 'N/A' : $selected_purchase->purchase_date}}</p>
            <p><strong>Total Amount:</strong> {{ empty($selected_purchase->total_amount) ? 'N/A' : $selected_purchase->total_amount  }}</p>
            <p><strong>Created By:</strong> {{ empty($selected_purchase->creator->name) ? 'N/A' : $selected_purchase->creator->name }}</p>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Cost</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (empty($selected_purchase->items) ? [] : $selected_purchase->items as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->cost }}</td>
                            <td>{{ $item->quantity * $item->cost }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </x-modal>



    </section>
</div>
