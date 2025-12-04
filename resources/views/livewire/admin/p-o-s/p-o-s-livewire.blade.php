<div>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Point of Sale (POS)</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">POS</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Product Search and Cart Section -->
                <div class="col-md-8">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Products & Cart</h3>
                        </div>
                        <div class="card-body">
                            <!-- Product Search -->
                            <div class="form-group position-relative">
                                <input type="text" wire:model.live="search" class="form-control" placeholder="Search Product by Name or Barcode">
                                @if (!empty($search) && !empty($searchResults))
                                    <ul class="list-group position-absolute w-100" style="z-index: 1000;">
                                        @foreach ($searchResults as $product)
                                            <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"  wire:click="addItemToCart({{ $product->id }})">
                                                <div>{{ $product->name }}  </div> <span class="badge badge-primary badge-pill" >MWK{{ number_format($product->selling_price, 2) }}</span>  <span class="badge badge-{{ $product->quantity > 0 ? 'success' : 'danger' }} badge-pill" >{{ $product->quantity }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>

                            <!-- Cart Items -->
                            <h4 class="mt-4">Cart Items</h4>
                            <div class="table-responsive">
                                <table class="table table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Qty</th>
                                            <th>Subtotal</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($cartItems as $index => $item)
                                            <tr>
                                                <td>{{ $item['name'] }}</td>
                                                <td>MWK{{ number_format($item['price'], 2) }}</td>
                                                <td>
                                                    <div class="input-group input-group-sm" style="width: 120px;">
                                                        <div class="input-group-prepend">
                                                            <button class="btn btn-outline-secondary" type="button" wire:click="decrementQuantity({{ $index }})">-</button>
                                                        </div>
                                                        <input type="text" class="form-control text-center" value="{{ $item['quantity'] }}" readonly>
                                                        <div class="input-group-append">
                                                            <button class="btn btn-outline-secondary" type="button" wire:click="incrementQuantity({{ $index }})">+</button>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>MWK{{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                                                <td>
                                                    <button class="btn btn-danger btn-sm" wire:click="removeItemFromCart({{ $index }})">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No items in cart.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment and Receipt Section -->
                <div class="col-md-4">
                    <div class="card card-success card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Payment</h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4>Total:</h4>
                                <h3>MWK{{ number_format($totalPrice, 2) }}</h3>
                            </div>

                            {{-- dev by Techlink360: Customer Selection --}}
                            <div class="form-group">
                                <label for="customer">Customer (Optional)</label>
                                <div class="input-group">
                                    <select wire:model="customerId" id="customer" class="form-control">
                                        <option value="">Walk-in Customer</option>
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-append">
                                        <button wire:click="openCustomerModal" @click="$wire.dispatch('customer-modal-open')" class="btn btn-primary">Add</button>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="paymentMethod">Payment Method:</label>
                                <select wire:model="paymentMethod" id="paymentMethod" class="form-control">
                                    <option value="cash">Cash</option>
                                    <option value="card">Card</option>
                                    <option value="momo">Mobile Money</option>
                                </select>
                            </div>

                            {{-- dev by Techlink360: Amount Paid --}}
                            <div class="form-group">
                                <label for="amount_paid">Amount Paid</label>
                                <input type="number" wire:model.live="amount_paid" id="amount_paid" class="form-control" placeholder="Enter amount paid">
                            </div>

                            {{-- dev by Techlink360: Change Display --}}
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5>Change:</h5>
                                <h5>MWK{{ number_format($change, 2) }}</h5>
                            </div>

                            <button class="btn btn-success btn-lg btn-block mt-3" wire:click="pay" wire:loading.attr="disabled" @if($amount_paid < $totalPrice) disabled @endif>
                                <i class="fas fa-money-bill-wave"></i> Pay
                            </button>
                            <button class="btn btn-secondary btn-block mt-2" wire:click="clearSale" wire:loading.attr="disabled">
                                <i class="fas fa-redo"></i> Clear Sale
                            </button>

                            <!-- Receipt Display -->
                            @if ($receipt)
                                <div class="mt-4 p-3 border rounded bg-light">
                                    <h5>Receipt</h5>
                                    <p><strong>Transaction ID:</strong> {{ $receipt['transaction_id'] }}</p>
                                    <p><strong>Date:</strong> {{ $receipt['date'] }}</p>
                                    <p><strong>Payment Method:</strong> {{ ucfirst($receipt['payment_method']) }}</p>
                                    <hr>
                                    <h6>Items:</h6>
                                    <ul>
                                        @foreach ($receipt['items'] as $item)
                                            <li>{{ $item['name'] }} ({{ $item['quantity'] }} x MWK{{ number_format($item['price'], 2) }}) = MWK{{ number_format($item['price'] * $item['quantity'], 2) }}</li>
                                        @endforeach
                                    </ul>
                                    <hr>
                                    <h5 class="text-right">Total: MWK{{ number_format($receipt['total'], 2) }}</h5>
                                    <h5 class="text-right">Amount Paid: MWK{{ number_format($receipt['amount_paid'], 2) }}</h5>
                                    <h5 class="text-right">Change: MWK{{ number_format($receipt['change'], 2) }}</h5>
                                    <button class="btn btn-info btn-block mt-3" onclick="window.print()">
                                        <i class="fas fa-print"></i> Print Receipt
                                    </button>
                                    <button class="btn btn-primary btn-block mt-2" wire:click="$set('receipt', null)">
                                        <i class="fas fa-plus"></i> New Sale
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- dev by Techlink360: Add Customer Modal --}}
    <div class="modal fade" id="customerModal" tabindex="-1" role="dialog" aria-labelledby="customerModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="customerModalLabel">Add New Customer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="closeCustomerModal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent="saveCustomer">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" wire:model="name" id="name" class="form-control">
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email (Optional)</label>
                            <input type="email" wire:model="email" id="email" class="form-control">
                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" wire:model="phone" id="phone" class="form-control">
                            @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="address">Address (Optional)</label>
                            <textarea wire:model="address" id="address" class="form-control"></textarea>
                            @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="closeCustomerModal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Customer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('livewire:init', () => {
                Livewire.on('customer-modal-open', () => {
                    $('#customerModal').modal('show');
                });
                Livewire.on('customer-modal-close', () => {
                    $('#customerModal').modal('hide');
                });
            });
        </script>
    @endpush
</div>
