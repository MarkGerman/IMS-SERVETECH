<div>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Expenses</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Expenses</li>
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
                        <div>
                            <button wire:click="create" class="btn btn-primary">Add Expense</button>
                        </div>
                        <div class="btn-group">
                            <button wire:click="$set('filter', 'all')" class="btn btn-secondary {{ $filter === 'all' ? 'active' : '' }}">All</button>
                            <button wire:click="$set('filter', 'today')" class="btn btn-secondary {{ $filter === 'today' ? 'active' : '' }}">Today</button>
                            <button wire:click="$set('filter', 'week')" class="btn btn-secondary {{ $filter === 'week' ? 'active' : '' }}">This Week</button>
                            <button wire:click="$set('filter', 'month')" class="btn btn-secondary {{ $filter === 'month' ? 'active' : '' }}">This Month</button>
                        </div>
                    </div>

                    <x-modal title="{{ $expense_id ? 'Edit Expense' : 'Add Expense' }}" :status="$modal">
                        <form wire:submit.prevent="store">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <input type="text" id="description" wire:model="description" class="form-control">
                                @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input type="number" step="0.01" id="amount" wire:model="amount" class="form-control">
                                @error('amount') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label for="expense_date">Expense Date</label>
                                <input type="date" id="expense_date" wire:model="expense_date" class="form-control">
                                @error('expense_date') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <button type="button" wire:click="cancel" class="btn btn-secondary">Cancel</button>
                            </div>
                        </form>
                    </x-modal>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Total Expenses ({{ ucfirst($filter) }}): {{ $total_expenses }}</h3>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Description</th>
                                            <th>Amount</th>
                                            <th>Date</th>
                                            <th>Created By</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($expenses as $expense)
                                            <tr>
                                                <td>{{ $expense->description }}</td>
                                                <td>{{ $expense->amount }}</td>
                                                <td>{{ $expense->expense_date }}</td>
                                                <td>{{ $expense->creator->name }}</td>
                                                <td>
                                                    <button wire:click="edit({{ $expense->id }})" class="btn btn-sm btn-outline-secondary">Edit</button>
                                                    <button wire:click="delete({{ $expense->id }})" class="btn btn-sm btn-outline-danger">Delete</button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No expenses found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            {{ $expenses->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
