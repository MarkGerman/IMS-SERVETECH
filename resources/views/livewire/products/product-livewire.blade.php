<div>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Products</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Products</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="d-flex">
                            <div class="form-group mr-2">
                                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search products..." class="form-control">
                            </div>
                            <div class="form-group mr-2">
                                <select wire:model.live="category_filter" class="form-control">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="show_trashed" wire:model.live="show_trashed">
                                <label class="form-check-label" for="show_trashed">Show Deleted</label>
                            </div>
                        </div>
                        <div>
                            <button wire:click="create" class="btn btn-primary">Add Product</button>
                        </div>
                    </div>

                    <x-modal title="{{ $productId ? 'Edit Product' : 'Add Product' }}" :status="$modal">
                        <form wire:submit.prevent="store">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" id="name" wire:model="name" class="form-control">
                                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="category_id">Category</label>
                                        <select id="category_id" wire:model="category_id" class="form-control">
                                            <option value="">Select Category</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="brand">Brand</label>
                                        <input type="text" id="brand" wire:model="brand" class="form-control">
                                        @error('brand') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="barcode">Barcode</label>
                                        <input type="text" id="barcode" wire:model="barcode" class="form-control">
                                        @error('barcode') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="purchase_price">Purchase Price</label>
                                        <input type="number" step="0.01" id="purchase_price" wire:model="purchase_price" class="form-control">
                                        @error('purchase_price') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="selling_price">Selling Price</label>
                                        <input type="number" step="0.01" id="selling_price" wire:model="selling_price" class="form-control">
                                        @error('selling_price') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="quantity">Quantity</label>
                                        <input type="number" id="quantity" wire:model="quantity" class="form-control">
                                        @error('quantity') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="reorder_level">Reorder Level</label>
                                        <input type="number" id="reorder_level" wire:model="reorder_level" class="form-control">
                                        @error('reorder_level') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea id="description" wire:model="description" class="form-control"></textarea>
                                @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </x-modal>

                    <div class="card">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Category</th>
                                            <th>Brand</th>
                                            <th>Purchase Price</th>
                                            <th>Selling Price</th>
                                            <th>Quantity</th>
                                            <th>Profit Margin</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($products as $product)
                                            @php
                                                $isLowStock = $product->quantity <= $product->reorder_level;
                                            @endphp
                                            <tr class="{{ $product->trashed() ? 'table-danger' : ($isLowStock ? 'table-warning' : '') }}">
                                                <td>{{ $product->name }}</td>
                                                <td>{{ $product->category->name ?? 'N/A' }}</td>
                                                <td>{{ $product->brand }}</td>
                                                <td>{{ number_format($product->purchase_price, 2) }}</td>
                                                <td>{{ number_format($product->selling_price, 2) }}</td>
                                                <td>
                                                    {{ $product->quantity }}
                                                </td>
                                                <td>
                                                    @if($product->selling_price > 0)
                                                        {{ number_format((($product->selling_price - $product->purchase_price) / $product->selling_price) * 100, 2) }}%
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($product->trashed())
                                                        <span class="badge badge-danger">Deactivated</span>
                                                    @elseif($isLowStock)
                                                        <span class="badge badge-warning">Low Stock</span>
                                                    @else
                                                        <span class="badge badge-success">Active</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($product->trashed())
                                                        <button wire:click="restore({{ $product->id }})" class="btn btn-sm btn-outline-success">Restore</button>
                                                    @else
                                                        <button wire:click="edit({{ $product->id }})" class="btn btn-sm btn-outline-secondary">Edit</button>
                                                        <button wire:click="delete({{ $product->id }})" class="btn btn-sm btn-outline-danger">Delete</button>
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
                        <div class="card-footer">
                            {{ $products->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

