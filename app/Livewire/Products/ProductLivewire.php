<?php

namespace App\Livewire\Products;

use App\Models\Product;
use App\Models\AuditLog;
use App\Models\Category;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * ProductLivewire component
 *
 * dev by Techlink360
 *
 * This component is responsible for managing products, including CRUD operations,
 * searching, filtering, and soft deletes.
 */
class ProductLivewire extends Component
{
    use LivewireAlert, WithPagination;

    public $modal = false;
    public $productId;
    public $name, $category_id, $brand, $purchase_price, $selling_price, $quantity, $reorder_level, $barcode, $description;
    public $search = '';
    public $category_filter = '';
    public $show_trashed = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'brand' => 'nullable|string|max:255',
        'purchase_price' => 'required|numeric|min:0',
        'selling_price' => 'required|numeric|gt:purchase_price',
        'quantity' => 'required|integer|min:0',
        'reorder_level' => 'nullable|integer|min:0',
        'barcode' => 'nullable|string|max:255|unique:products,barcode,',
        'description' => 'nullable|string|max:500',
    ];

    /**
     * Reset component state and close modal.
     * dev by Techlink360
     */
    public function cancel()
    {
        $this->reset(['modal', 'productId', 'name', 'category_id', 'brand', 'purchase_price', 'selling_price', 'quantity', 'reorder_level', 'barcode', 'description']);
        $this->dispatch('modal-cancel');
    }

    /**
     * Show the create product modal.
     * dev by Techlink360
     */
    public function create()
    {
        $this->cancel();
        $this->modal = true;
        $this->dispatch('modal-open');
    }

    /**
     * Show the edit product modal.
     * dev by Techlink360
     * @param int $id
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $this->productId = $product->id;
        $this->name = $product->name;
        $this->category_id = $product->category_id;
        $this->brand = $product->brand;
        $this->purchase_price = $product->purchase_price;
        $this->selling_price = $product->selling_price;
        $this->quantity = $product->quantity;
        $this->reorder_level = $product->reorder_level;
        $this->barcode = $product->barcode;
        $this->description = $product->description;
        $this->modal = true;
        $this->dispatch('modal-open');
    }

    /**
     * Soft delete a product.
     * dev by Techlink360
     * @param int $id
     */
    public function delete($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        $this->alert('success', 'Product deleted successfully.');

        AuditLog::create([
            'action' => 'delete',
            'table_name' => 'products',
            'record_id' => $id,
            'user_id' => auth()->id(),
        ]);
    }

    /**
     * Restore a soft-deleted product.
     * dev by Techlink360
     * @param int $id
     */
    public function restore($id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        $product->restore();
        $this->alert('success', 'Product restored successfully.');

        AuditLog::create([
            'action' => 'restore',
            'table_name' => 'products',
            'record_id' => $id,
            'user_id' => auth()->id(),
        ]);
    }

    /**
     * Create or update a product.
     * dev by Techlink360
     */
    public function store()
    {
        $this->rules['barcode'] .= $this->productId;
        $this->validate();

        $product = Product::updateOrCreate(
            ['id' => $this->productId],
            [
                'name' => $this->name,
                'category_id' => $this->category_id,
                'brand' => $this->brand,
                'purchase_price' => $this->purchase_price,
                'selling_price' => $this->selling_price,
                'quantity' => $this->quantity,
                'reorder_level' => $this->reorder_level,
                'barcode' => $this->barcode,
                'description' => $this->description,
            ]
        );

        $this->alert('success', 'Product saved successfully.');
        $this->cancel();

        AuditLog::create([
            'action' => $this->productId ? 'update' : 'store',
            'table_name' => 'products',
            'record_id' => $product->id,
            'user_id' => auth()->id(),
        ]);
        $this->dispatch('modal-cancel');
    }

    /**
     * Render the component.
     * dev by Techlink360
     */
    public function render()
    {
        $query = Product::with('category');

        if ($this->show_trashed) {
            $query->onlyTrashed();
        } else {
            $query->whereNull('deleted_at');
        }

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                    ->orWhere('brand', 'like', "%{$this->search}%")
                    ->orWhere('barcode', 'like', "%{$this->search}%")
                    ->orWhereHas('category', function ($subq) {
                        $subq->where('name', 'like', "%{$this->search}%");
                    });
            });
        }

        if (!empty($this->category_filter)) {
            $query->where('category_id', $this->category_filter);
        }

        return view('livewire.products.product-livewire', [
            'products' => $query->paginate(10),
            'categories' => Category::all(),
        ]);
    }
}
