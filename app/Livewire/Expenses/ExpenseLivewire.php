<?php

namespace App\Livewire\Expenses;

use App\Models\Expense;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

/**
 * ExpenseLivewire component
 *
 * dev by Techlink360
 *
 * This component is responsible for managing expenses, including CRUD operations,
 * filtering by date, and calculating totals.
 */
class ExpenseLivewire extends Component
{
    use LivewireAlert, WithPagination;

    public $expense_id, $description, $amount, $expense_date;
    public $filter = 'all';
    public $modal = false;

    protected $rules = [
        'description' => 'required|string|max:255',
        'amount' => 'required|numeric|min:0',
        'expense_date' => 'required|date',
    ];

    /**
     * Initialize component with default values.
     * dev by Techlink360
     */
    public function mount()
    {
        $this->expense_date = now()->format('Y-m-d');
    }

    /**
     * Show the create expense modal.
     * dev by Techlink360
     */
    public function create()
    {
        $this->resetForm();
        $this->modal = true;
    }

    /**
     * Show the edit expense modal.
     * dev by Techlink360
     * @param int $id
     */
    public function edit($id)
    {
        $expense = Expense::findOrFail($id);
        $this->expense_id = $id;
        $this->description = $expense->description;
        $this->amount = $expense->amount;
        $this->expense_date = $expense->expense_date;
        $this->modal = true;
    }

    /**
     * Create or update an expense.
     * dev by Techlink360
     */
    public function store()
    {
        $this->validate();

        Expense::updateOrCreate(
            ['id' => $this->expense_id],
            [
                'description' => $this->description,
                'amount' => $this->amount,
                'expense_date' => $this->expense_date,
                'created_by' => Auth::id(),
            ]
        );

        $this->alert('success', 'Expense saved successfully.');
        $this->resetForm();
        $this->modal = false;
    }

    /**
     * Delete an expense.
     * dev by Techlink360
     * @param int $id
     */
    public function delete($id)
    {
        Expense::destroy($id);
        $this->alert('success', 'Expense deleted successfully.');
    }

    /**
     * Reset the form fields.
     * dev by Techlink360
     */
    public function resetForm()
    {
        $this->reset('expense_id', 'description', 'amount');
        $this->expense_date = now()->format('Y-m-d');
    }

    /**
     * Close the modal and reset the form.
     * dev by Techlink360
     */
    public function cancel()
    {
        $this->resetForm();
        $this->modal = false;
    }

    /**
     * Render the component.
     * dev by Techlink360
     */
    public function render()
    {
        $query = Expense::with('creator')->latest();

        switch ($this->filter) {
            case 'today':
                $query->whereDate('expense_date', Carbon::today());
                break;
            case 'week':
                $query->whereBetween('expense_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                break;
            case 'month':
                $query->whereMonth('expense_date', Carbon::now()->month);
                break;
        }

        $expenses = $query->paginate(10);
        $total_expenses = $query->sum('amount');

        return view('livewire.expenses.expense-livewire', [
            'expenses' => $expenses,
            'total_expenses' => $total_expenses,
        ]);
    }
}
