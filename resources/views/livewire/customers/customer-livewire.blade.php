<div>
    {{-- dev by Techlink360 --}}
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Customers</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Customers</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    {{-- dev by Techlink360: Search and Add button --}}
                    <div class="d-flex justify-content-end mb-3">
                        <div class="form-group mr-2">
                            <input type="text" wire:model.live="search" class="form-control" placeholder="Search customers...">
                        </div>
                        <div class="form-group">
                            <button wire:click="create()" @click="$wire.dispatch('modal-open');" class="btn-primary btn-sm">
                                Add <x-spinner for="create" />
                            </button>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                {{-- dev by Techlink360: Customers table --}}
                                <table class="table table-striped table-inverse">
                                    <thead class="thead-inverse">
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Address</th>
                                            <th>Total Sales</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($customers as $customer)
                                            <tr>
                                                <td>{{ $customer->name }}</td>
                                                <td>{{ $customer->email }}</td>
                                                <td>{{ $customer->phone }}</td>
                                                <td>{{ $customer->address }}</td>
                                                <td>{{ $customer->sales_count }}</td>
                                                <td>
                                                    <button wire:click="create({{ $customer->id }})" @click="$wire.dispatch('modal-open');" class="btn btn-sm btn-primary">Edit</button>
                                                    <button wire:click="delete({{ $customer->id }})" class="btn btn-sm btn-danger">Delete</button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No customers found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            {{-- dev by Techlink360: Pagination links --}}
                            {{ $customers->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- dev by Techlink360: Add/Edit Customer Modal --}}
        <x-modal title="{{ $id ? 'Edit Customer' : 'Add Customer' }}" :status="$modal">
            <form wire:submit.prevent='store'>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" wire:model="name" id="name" class="form-control">
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" wire:model="email" id="email" class="form-control">
                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" wire:model="phone" id="phone" class="form-control">
                    @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea wire:model="address" id="address" class="form-control"></textarea>
                    @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-dark">Save <x-spinner for="store" /></button>
                </div>
            </form>
        </x-modal>
    </section>
</div>
