<?php

namespace App\Livewire\Sales;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * SaleLivewire component
 *
 * dev by Techlink360
 *
 * This component is responsible for managing sales, including CRUD operations,
 * stock management, filtering, and printing receipts.
 */
class SaleLivewire extends Component
{
    use LivewireAlert, WithPagination;

    public $customers, $products;
    public $sale_id, $customer_id, $payment_method = 'cash', $total_amount = 0, $amount_paid = 0, $change = 0;
    public $sale_items = [];
    public $product_id, $quantity = 1;

    public $filter_date, $filter_customer, $filter_seller;
    public $view_modal = false;
    public $selected_sale;

    public $return_item_id, $return_quantity, $admin_email, $admin_password, $return_reason;

    protected $rules = [
        'customer_id' => 'nullable|exists:customers,id',
        'payment_method' => 'required|string',
        'sale_items' => 'required|array|min:1',
        'amount_paid' => 'required|numeric|min:0',
    ];

    /**
     * Initialize component with default values.
     * dev by Techlink360
     */
    public function mount()
    {
        $this->customers = Customer::all();
        $this->products = Product::where('quantity', '>', 0)->get();
    }

    /**
     * Add an item to the current sale.
     * dev by Techlink360
     */
    public function addItem()
    {
        $this->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::find($this->product_id);

        if ($product->quantity < $this->quantity) {
            $this->alert('error', 'Not enough stock for ' . $product->name);
            return;
        }

        // Check if product is already in the cart
        $existing_item_key = null;
        foreach ($this->sale_items as $key => $item) {
            if ($item['product_id'] == $this->product_id) {
                $existing_item_key = $key;
                break;
            }
        }

        if ($existing_item_key !== null) {
            $this->sale_items[$existing_item_key]['quantity'] += $this->quantity;
            $this->sale_items[$existing_item_key]['total_price'] = $this->sale_items[$existing_item_key]['quantity'] * $this->sale_items[$existing_item_key]['unit_price'];
        } else {
            $this->sale_items[] = [
                'product_id' => $this->product_id,
                'product_name' => $product->name,
                'quantity' => $this->quantity,
                'unit_price' => $product->selling_price,
                'purchase_price' => $product->purchase_price, // dev by Techlink360: Add purchase price for profit calculation
                'total_price' => $this->quantity * $product->selling_price,
            ];
        }

        $this->calculateTotal();
        $this->reset('product_id', 'quantity');
    }

    /**
     * Remove an item from the current sale.
     * dev by Techlink360
     * @param int $index
     */
    public function removeItem($index)
    {
        unset($this->sale_items[$index]);
        $this->sale_items = array_values($this->sale_items);
        $this->calculateTotal();
    }

    /**
     * Calculate the total amount of the current sale.
     * dev by Techlink360
     */
    public function calculateTotal()
    {
        $this->total_amount = collect($this->sale_items)->sum('total_price');
        $this->calculateChange();
    }

    /**
     * Calculate the change to be given to the customer.
     * dev by Techlink360
     */
    public function updatedAmountPaid()
    {
        $this->calculateChange();
    }

    public function calculateChange()
    {
        $this->change = (float)$this->amount_paid - (float)$this->total_amount;
    }

    /**
     * Store a new sale or update an existing one.
     * dev by Techlink360
     */
    public function store()
    {
        $this->validate();

        if ($this->sale_id) {
            $sale = Sale::find($this->sale_id);
            // Revert stock for old items before updating
            foreach ($sale->items as $item) {
                $product = Product::find($item->product_id);
                $product->quantity += $item->quantity;
                $product->save();
            }
            $sale->items()->delete(); // Delete old items
        }

        $sale = Sale::updateOrCreate(
            ['id' => $this->sale_id],
            [
                'customer_id' => $this->customer_id,
                'payment_method' => $this->payment_method,
                'total_amount' => $this->total_amount,
                'amount_paid' => $this->amount_paid,
                'change' => $this->change,
                'created_by' => Auth::id(),
                'sale_date' => now(),
            ]
        );

        foreach ($this->sale_items as $item) {
            SaleItem::create([
                'sale_id' => $sale->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'total_price' => $item['total_price'],
            ]);

            // Deduct product stock
            $product = Product::find($item['product_id']);
            $product->quantity -= $item['quantity'];
            $product->save();
        }

        $this->alert('success', 'Sale saved successfully.');
        $this->resetForm();
        $this->mount();
    }

    /**
     * Load an existing sale for editing.
     * dev by Techlink360
     * @param int $id
     */
    public function editSale($id)
    {
        $sale = Sale::with('items.product')->findOrFail($id);
        $this->sale_id = $sale->id;
        $this->customer_id = $sale->customer_id;
        $this->payment_method = $sale->payment_method;
        $this->total_amount = $sale->total_amount;
        $this->amount_paid = $sale->amount_paid;
        $this->change = $sale->change;

        $this->sale_items = [];
        foreach ($sale->items as $item) {
            $this->sale_items[] = [
                'product_id' => $item->product_id,
                'product_name' => $item->product->name,
                'quantity' => $item->quantity,
                'unit_price' => $item->unit_price,
                'purchase_price' => $item->product->purchase_price, // dev by Techlink360: Add purchase price for profit calculation
                'total_price' => $item->total_price,
            ];
        }
    }

    /**
     * Delete a sale (admin only).
     * dev by Techlink360
     * @param int $id
     */
    public function deleteSale($id)
    {
        // Assuming a simple admin check for now
        if (!Auth::user()->is_admin) { // You need to implement is_admin on your User model
            $this->alert('error', 'Only administrators can delete sales.');
            return;
        }

        $sale = Sale::with('items')->findOrFail($id);

        foreach ($sale->items as $item) {
            $product = Product::find($item->product_id);
            $product->quantity += $item->quantity; // Revert stock
            $product->save();
        }

        $sale->delete();
        $this->alert('success', 'Sale deleted successfully.');
    }

    /**
     * View details of a specific sale.
     * dev by Techlink360
     * @param int $id
     */
    public function viewSale($id)
    {
        $this->selected_sale = Sale::with('customer', 'creator', 'items.product')->find($id);
        $this->view_modal = true;
    }

    /**
     * Dispatch an event to print the receipt for a sale.
     * dev by Techlink360
     * @param int $id
     */
    public function printReceipt($id)
    {
        $this->dispatch('print-receipt', $id);
    }

    /**
     * Reset the form fields and re-initialize component.
     * dev by Techlink360
     */
    public function resetForm()
    {
        $this->reset('sale_id', 'customer_id', 'payment_method', 'total_amount', 'sale_items', 'product_id', 'quantity', 'amount_paid', 'change');
        $this->mount(); // Re-initialize customers and products
    }

    /**
     * Set the item to be returned.
     * dev by Techlink360
     * @param int $itemId
     */
    public function returnItem($itemId)
    {
        $this->return_item_id = $itemId;
        $item = $this->selected_sale->items->firstWhere('id', $itemId);
        $this->return_quantity = $item->quantity;
    }

    /**
     * Confirm and process the return of a product.
     * dev by Techlink360
     */
    public function confirmReturn()
    {
        $this->validate([
            'return_quantity' => 'required|integer|min:1',
            'return_reason' => 'required|string|min:10',
            'admin_email' => 'required|email',
            'admin_password' => 'required|string',
        ]);

        if (!Auth::guard('web')->validate(['email' => $this->admin_email, 'password' => $this->admin_password])) {
            $this->alert('error', 'Invalid admin credentials.');
            return;
        }

        $admin = Auth::guard('web')->getLastAttempted();
        // dd($admin);

        if (!$admin->role == "systems" || !$admin->role == "admin"  ) {
            $this->alert('error', 'Only administrators can approve returns.');
            return;
        }

        $item = SaleItem::find($this->return_item_id);
        if ($this->return_quantity > $item->quantity) {
            $this->alert('error', 'Cannot return more than the purchased quantity.');
            return;
        }

        $refund_amount = $this->return_quantity * $item->unit_price;

        $return = \App\Models\Returns::create([
            'sale_id' => $item->sale_id,
            'customer_id' => $item->sale->customer_id,
            'return_date' => now(),
            'reason' => $this->return_reason,
            'total_refund_amount' => $refund_amount,
            'status' => 'approved',
            'approved_by' => $admin->id,
            'created_by' => Auth::id(),
        ]);

        // Create a return record
        \App\Models\ReturnItem::create([
            'return_id' => $return->id,
            'sale_item_id' => $item->id,
            'quantity' => $this->return_quantity,
            'approved_by' => $admin->id,
            'return_date' => now(),
        ]);

        // Update product stock
        $product = Product::find($item->product_id);
        $product->quantity += $this->return_quantity;
        $product->save();

        // Update sale item quantity
        $item->quantity -= $this->return_quantity;
        $item->total_price = $item->quantity * $item->unit_price;
        $item->save();

        // Update sale total amount
        $sale = Sale::find($item->sale_id);
        $sale->total_amount -= $refund_amount;
        $sale->save();

        $this->alert('success', 'Product returned successfully.');
        $this->reset('return_item_id', 'return_quantity', 'admin_email', 'admin_password', 'return_reason');
        $this->viewSale($sale->id);
    }

    public function cancel(){
        $this->reset([
            'sale_id', 'customer_id', 'payment_method', 'total_amount', 'sale_items', 'product_id', 'quantity', 'amount_paid', 'change','return_item_id', 'return_quantity', 'admin_email', 'admin_password', 'return_reason','view_modal']);
    }



    /**
     * Render the component.
     * dev by Techlink360
     */
    public function render()
    {
        $query = Sale::with('customer', 'creator', 'items.product')->latest();

        if ($this->filter_date) {
            $query->whereDate('sale_date', $this->filter_date);
        }

        if ($this->filter_customer) {
            $query->where('customer_id', $this->filter_customer);
        }

        if ($this->filter_seller) {
            $query->where('created_by', $this->filter_seller);
        }

        $sales = $query->paginate(10);

        $daily_summary = Sale::whereDate('sale_date', today())->sum('total_amount');

        return view('livewire.sales.sale-livewire', [
            'sales' => $sales,
            'daily_summary' => $daily_summary,
        ]);
    }
}

