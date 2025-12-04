<?php

namespace App\Livewire\Purchases;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class PurchaseLivewire extends Component
{
    use LivewireAlert, WithPagination;

    public $suppliers, $products;
    public $supplier_id, $purchase_date, $total_amount = 0;
    public $purchase_items = [];
    public $product_id, $quantity = 1, $cost;

    public $filter_date, $filter_supplier;
    public $view_modal = false;
    public $selected_purchase;

    protected $rules = [
        'supplier_id' => 'required|exists:suppliers,id',
        'purchase_date' => 'required|date',
        'purchase_items' => 'required|array|min:1',
    ];

    public function mount()
    {
        $this->suppliers = Supplier::all();
        $this->products = Product::all();
        $this->purchase_date = now()->format('Y-m-d');
    }

    public function addItem()
    {
        $this->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'cost' => 'required|numeric|min:0',
        ]);

        $product = Product::find($this->product_id);

        $this->purchase_items[] = [
            'product_id' => $this->product_id,
            'product_name' => $product->name,
            'quantity' => $this->quantity,
            'cost' => $this->cost,
            'sub_total' => $this->quantity * $this->cost,
        ];

        $this->calculateTotal();
        $this->reset('product_id', 'quantity', 'cost');
    }

    public function removeItem($index)
    {
        unset($this->purchase_items[$index]);
        $this->purchase_items = array_values($this->purchase_items);
        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $this->total_amount = collect($this->purchase_items)->sum('sub_total');
    }

    public function store()
    {
        $this->validate();

        $purchase = Purchase::create([
            'supplier_id' => $this->supplier_id,
            'purchase_date' => $this->purchase_date,
            'total_amount' => $this->total_amount,
            'created_by' => Auth::id(),
        ]);

        foreach ($this->purchase_items as $item) {
            PurchaseItem::create([
                'purchase_id' => $purchase->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'cost' => $item['cost'],
            ]);

            // Update product stock
            $product = Product::find($item['product_id']);
            $product->quantity += $item['quantity'];
            $product->save();
        }

        $this->alert('success', 'Purchase created successfully.');
        $this->reset();
        $this->mount();
    }

    public $purchase_id;

    public function edit($id)
    {
        $purchase = Purchase::with('items')->findOrFail($id);
        $this->purchase_id = $id;
        $this->supplier_id = $purchase->supplier_id;
        $this->purchase_date = $purchase->purchase_date;
        $this->total_amount = $purchase->total_amount;

        $this->purchase_items = [];
        foreach ($purchase->items as $item) {
            $product = Product::find($item->product_id);
            $this->purchase_items[] = [
                'product_id' => $item->product_id,
                'product_name' => $product->name,
                'quantity' => $item->quantity,
                'cost' => $item->cost,
                'sub_total' => $item->quantity * $item->cost,
            ];
        }
    }

    public function delete($id)
    {
        $purchase = Purchase::with('items.product.saleItems')->find($id);

        foreach ($purchase->items as $item) {
            if ($item->product->saleItems->count() > 0) {
                $this->alert('error', 'Cannot delete purchase because some items have been sold.');
                return;
            }
        }

        foreach ($purchase->items as $item) {
            $product = Product::find($item->product_id);
            $product->quantity -= $item->quantity;
            $product->save();
        }

        $purchase->delete();
        $this->alert('success', 'Purchase deleted successfully.');
    }

    /**
     * dev by Techlink360
     * Displays the details of a specific purchase in a modal.
     *
     * @param int $id The ID of the purchase to view.
     * @return void
     */
    public function viewPurchase($id)
    {
        $this->selected_purchase = Purchase::with('supplier', 'creator', 'items.product')->findOrFail($id);
        $this->view_modal = true;
    }

    /**
     * dev by Techlink360
     * Closes the purchase details modal and resets the selected purchase.
     *
     * @return void
     */
    public function cancel()
    {
        $this->reset(['view_modal', 'selected_purchase']);
        
    }

    public function render()
    {
        $query = Purchase::with('supplier', 'creator')->latest();

        if ($this->filter_date) {
            $query->whereDate('purchase_date', $this->filter_date);
        }

        if ($this->filter_supplier) {
            $query->where('supplier_id', $this->filter_supplier);
        }

        $purchases = $query->paginate(10);

        return view('livewire.purchases.purchase-livewire', [
            'purchases' => $purchases,
        ]);
    }
}
