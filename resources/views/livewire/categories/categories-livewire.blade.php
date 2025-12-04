<div>

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Categories</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Categories</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <!-- Default box -->
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-end mb-3">
                        <div class="form-group mr-2">
                            <input wire:model.debounce.300ms="search" type="text" placeholder="Search categories"
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <button @click="$wire.create(); $wire.dispatch('modal-open');"
                                class="btn btn-primary btn-sm">Add</button>
                        </div>
                        <x-modal title="Manage Category" :status="$modal">
                            <form wire:submit='store'>
                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input type="text" wire:model="name" class="form-control">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                </div>

                                <div class="form-group">
                                    <label for="">Description</label>
                                    <textarea wire:model="description" class="form-control" rows="3"></textarea>
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-dark">save<x-spinner
                                            for="store" /></button>
                                </div>
                            </form>
                        </x-modal>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">All Categories</h3>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($categories as $index => $category)
                                            <tr class="{{ $category->trashed() ? 'table-danger' : '' }}">
                                                <td>{{ $loop->iteration }}</td> <!-- Updated for Livewire v3 -->
                                                <td>{{ $category->name }}</td>
                                                <td>{{ $category->description ?? '—' }}</td>
                                                <td>
                                                    @if($category->trashed())
                                                        <button wire:click.prevent="restore({{ $category->id }})"
                                                            class="btn btn-sm btn-outline-success">Restore</button>
                                                    @else
                                                        <button wire:click.prevent="edit({{ $category->id }})"
                                                            class="btn btn-sm btn-outline-secondary">Edit</button>
                                                        <button wire:click.prevent="delete({{ $category->id }})"
                                                            class="btn btn-sm btn-outline-danger">Delete</button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4">No categories found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            {{ $categories->links() }} <!-- Pagination links remain compatible -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

</div>

