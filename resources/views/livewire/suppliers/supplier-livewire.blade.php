<div>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Suppliers</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Suppliers</li>
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
                                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search suppliers..." class="form-control">
                            </div>
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="show_trashed" wire:model.live="show_trashed">
                                <label class="form-check-label" for="show_trashed">Show Deleted</label>
                            </div>
                        </div>
                        <div>
                            <button wire:click="create" class="btn btn-primary">Add Supplier</button>
                        </div>
                    </div>

                    <x-modal title="{{ $supplierId ? 'Edit Supplier' : 'Add Supplier' }}" :status="$modal">
                        <form wire:submit.prevent="store">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" id="name" wire:model="name" class="form-control">
                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label for="contact_person">Contact Person</label>
                                <input type="text" id="contact_person" wire:model="contact_person" class="form-control">
                                @error('contact_person') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" id="phone" wire:model="phone" class="form-control">
                                @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" wire:model="email" class="form-control">
                                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea id="address" wire:model="address" class="form-control" rows="3"></textarea>
                                @error('address') <span class="text-danger">{{ $message }}</span> @enderror
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
                                            <th>Contact</th>
                                            <th>Purchases</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($suppliers as $supplier)
                                            <tr class="{{ $supplier->trashed() ? 'table-danger' : ($supplier->is_blacklisted ? 'table-warning' : '') }}">
                                                <td>
                                                    {{ $supplier->name }}
                                                    <br>
                                                    <small>{{ $supplier->address }}</small>
                                                </td>
                                                <td>
                                                    {{ $supplier->contact_person }}
                                                    <br>
                                                    <small>{{ $supplier->email }} | {{ $supplier->phone }}</small>
                                                </td>
                                                <td>{{ $supplier->purchase_items_count }}</td>
                                                <td>
                                                    @if($supplier->trashed())
                                                        <span class="badge badge-danger">Deactivated</span>
                                                    @elseif($supplier->is_blacklisted)
                                                        <span class="badge badge-warning">Blacklisted</span>
                                                    @else
                                                        <span class="badge badge-success">Active</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($supplier->trashed())
                                                        <button wire:click="restore({{ $supplier->id }})" class="btn btn-sm btn-outline-success">Restore</button>
                                                    @else
                                                        <button wire:click="edit({{ $supplier->id }})" class="btn btn-sm btn-outline-secondary">Edit</button>
                                                        <button wire:click="delete({{ $supplier->id }})" class="btn btn-sm btn-outline-danger">Delete</button>
                                                        <button wire:click="toggleBlacklist({{ $supplier->id }})" class="btn btn-sm btn-outline-warning">
                                                            {{ $supplier->is_blacklisted ? 'Unlist' : 'Blacklist' }}
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No suppliers found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            {{ $suppliers->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

