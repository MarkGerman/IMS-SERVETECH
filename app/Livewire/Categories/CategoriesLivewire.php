<?php

namespace App\Livewire\Categories;

use App\Models\Category;
use App\Models\AuditLog; // Import the AuditLog model
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB; // Add this import for database operations

class CategoriesLivewire extends Component
{
    use LivewireAlert, WithPagination;

    public $modal = false;

    public $name;
    public $description;
    public $search = '';
    public $categoryId;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string|max:500',
    ];

    public function mount()
    {

    }

    public function updatedSearch()
    {
        // Removed direct assignment of paginated data to $this->categories
    }

    public function create()
    {
        $this->reset(['name', 'description', 'categoryId']);
        $this->modal = true;

        AuditLog::create([
            'action' => 'create',
            'table_name' => 'categories',
            'user_id' => auth()->id(),
        ]);
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $this->categoryId = $category->id;
        $this->name = $category->name;
        $this->description = $category->description;
        $this->modal = true;

        AuditLog::create([
            'action' => 'edit',
            'table_name' => 'categories',
            'record_id' => $id,
            'user_id' => auth()->id(),
        ]);
    }

    public function delete($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        $this->alert('success', 'Category deleted successfully.');

        AuditLog::create([
            'action' => 'delete',
            'table_name' => 'categories',
            'record_id' => $id,
            'user_id' => auth()->id(),
        ]);
    }

    public function restore($id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        $category->restore();
        $this->alert('success', 'Category restored successfully.');

        AuditLog::create([
            'action' => 'restore',
            'table_name' => 'categories',
            'record_id' => $id,
            'user_id' => auth()->id(),
        ]);
    }

    public function store()
    {
        $this->validate();

        $category = Category::updateOrCreate(
            ['id' => $this->categoryId],
            ['name' => $this->name, 'description' => $this->description]
        );

        $this->alert('success', 'Category saved successfully.');
        $this->modal = false;

        AuditLog::create([
            'action' => $this->categoryId ? 'update' : 'store',
            'table_name' => 'categories',
            'record_id' => $category->id,
            'user_id' => auth()->id(),
        ]);

        $this->cancel();
    }

    public function cancel()
    {
        $this->reset(['modal', 'name', 'description', 'categoryId']);
        $this->dispatch('modal-cancel'); // Updated for Livewire v3
    }

    public function render()
    {
        $query = Category::withTrashed();

        if (!empty($this->search)) {
            $query->where('name', 'like', "%{$this->search}%");
        }

        return view('livewire.categories.categories-livewire', [
            'categories' => $query->paginate(10),
        ]);
    }
}
