<?php

namespace App\Livewire\Admin\POS;

use App\Models\Customer;
use App\Models\Product; // dev by Techlink360: Import the Product model
use App\Models\Sale; // dev by Techlink360: Import the Sale model
use App\Models\SaleItem; // dev by Techlink360: Import the SaleItem model
use Illuminate\Support\Facades\Auth; // dev by Techlink360: Import Auth facade
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class POSLivewire extends Component
{
    use LivewireAlert;

    // dev by Techlink360: Properties for product search
    public $search = '';
    public $searchResults = [];

    // dev by Techlink360: Properties for cart management
    public $cartItems = [];
    public $totalPrice = 0;

    // dev by Techlink360: Properties for payment
    public $paymentMethod = 'cash'; // Default payment method
    public $customerId = null; // dev by Techlink360: Property to hold selected customer ID
    public $receipt = null; // To store receipt details after a sale
    public $amount_paid;
    public $change = 0;

    // dev by Techlink360: Properties for customer modal
    public $customerModal = false;
    public $name, $email, $phone, $address;


    // dev by Techlink360: Livewire lifecycle hook to update search results
    public function updatedSearch($value)
    {
        if (strlen($value) > 2) { // Only search if the term is long enough
            $this->searchResults = Product::where('name', 'like', '%' . $value . '%')
                                        ->orWhere('barcode', 'like', '%' . $value . '%')
                                        ->get();
        } else {
            $this->searchResults = [];
        }
    }

    // dev by Techlink360: Add item to cart
    public function addItemToCart($productId)
    {
        $product = Product::find($productId);

        if (!$product) {
            $this->alert('error', 'Product not found!');
            return;
        }

        // Check if product already in cart
        $found = false;
        foreach ($this->cartItems as $index => $item) {
            if ($item['product_id'] == $productId) {
                $newQuantity = $this->cartItems[$index]['quantity'] + 1;
                if ($newQuantity > $product->quantity) {
                    $this->alert('warning', 'Cannot add more than available stock!');
                    return;
                }
                $this->cartItems[$index]['quantity'] = $newQuantity;
                $found = true;
                break;
            }
        }

        if (!$found) {
            $this->cartItems[] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->selling_price,
                'quantity' => 1,
            ];
        }

        $this->search = ''; // Clear search after adding
        $this->searchResults = [];
        $this->calculateTotal(); // Recalculate total
        $this->alert('success', 'Product added to cart!');
    }

    // dev by Techlink360: Remove item from cart
    public function removeItemFromCart($index)
    {
        unset($this->cartItems[$index]);
        $this->cartItems = array_values($this->cartItems); // Re-index array
        $this->calculateTotal();
        $this->alert('info', 'Product removed from cart!');
    }

    // dev by Techlink360: Increment item quantity in cart
    public function incrementQuantity($index)
    {
        $productId = $this->cartItems[$index]['product_id'];
        $product = Product::find($productId);

        if (!$product) {
            $this->alert('error', 'Product not found!');
            return;
        }

        $newQuantity = $this->cartItems[$index]['quantity'] + 1;

        if ($newQuantity > $product->quantity) {
            $this->alert('warning', 'Cannot add more than available stock!');
            return;
        }

        $this->cartItems[$index]['quantity'] = $newQuantity;
        $this->calculateTotal();
    }

    // dev by Techlink360: Decrement item quantity in cart
    public function decrementQuantity($index)
    {
        if ($this->cartItems[$index]['quantity'] > 1) {
            $this->cartItems[$index]['quantity']--;
        } else {
            $this->removeItemFromCart($index); // Remove if quantity becomes 0
        }
        $this->calculateTotal();
    }

    // dev by Techlink360: Calculate total price of items in cart
    public function calculateTotal()
    {
        $this->totalPrice = array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $this->cartItems));
        $this->updatedAmountPaid($this->amount_paid);
    }

    // dev by Techlink360: Process the sale
    public function pay()
    {
        if (empty($this->cartItems)) {
            $this->alert('warning', 'Cart is empty!');
            return;
        }

        if ($this->amount_paid < $this->totalPrice) {
            $this->alert('error', 'Amount paid is less than the total price.');
            return;
        }

        try {
            // dev by Techlink360: Create a new Sale record
            $sale = Sale::create([
                'sale_date' => now(),
                'customer_id' => $this->customerId, // Use the customerId property
                'total_amount' => $this->totalPrice,
                'amount_paid' => $this->amount_paid, // dev by Techlink360: Save amount paid
                'change' => $this->change,           // dev by Techlink360: Save change
                'payment_method' => $this->paymentMethod,
                'created_by' => Auth::id(), // Get the authenticated user's ID
            ]);

            // dev by Techlink360: Loop through cart items to create SaleItems and update product stock
            foreach ($this->cartItems as $item) {
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                    'total_price' => $item['price'] * $item['quantity'],
                ]);

                // dev by Techlink360: Update product stock
                $product = Product::find($item['product_id']);
                if ($product) {
                    $product->quantity -= $item['quantity'];
                    $product->save();
                }
            }

            // dev by Techlink360: Update receipt details
            $this->receipt = [
                'sale_id' => $sale->id,
                'items' => $this->cartItems,
                'total' => $this->totalPrice,
                'payment_method' => $this->paymentMethod,
                'date' => $sale->sale_date->format('Y-m-d H:i:s'),
                'transaction_id' => $sale->id, // Using sale ID as transaction ID
                'amount_paid' => $this->amount_paid,
                'change' => $this->change,
            ];

            $this->alert('success', 'Sale completed successfully!');
            $this->clearSale(); // Clear cart after sale
            // dev by Techlink360: Dispatch event to show receipt or print
            $this->dispatch('show-receipt');

        } catch (\Exception $e) {
            // dev by Techlink360: Log the error and show an alert
            \Log::error('POS Sale Error: ' . $e->getMessage());
            $this->alert('error', 'An error occurred during the sale. Please try again.');
        }
    }

    // dev by Techlink360: Clear the current sale (cart and related data)
    public function clearSale()
    {
        $this->cartItems = [];
        $this->totalPrice = 0;
        $this->search = '';
        $this->searchResults = [];
        $this->paymentMethod = 'cash';
        $this->amount_paid = null;
        $this->change = 0;
        // Keep receipt for display until user closes it or new sale starts
    }

    // dev by Techlink360: Open the customer creation modal
    public function openCustomerModal()
    {
        $this->reset(['name', 'email', 'phone', 'address']);
        $this->customerModal = true;
    }

    // dev by Techlink360: Close the customer creation modal
    public function closeCustomerModal()
    {
        $this->customerModal = false;
    }

    // dev by Techlink360: Save a new customer
    public function saveCustomer()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:customers,email',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
        ]);

        $customer = Customer::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
        ]);

        $this->customerId = $customer->id;
        $this->alert('success', 'Customer added successfully');
        $this->closeCustomerModal();
    }

    public function updatedAmountPaid($value)
    {
        $this->amount_paid = $value;
        if (is_numeric($this->amount_paid) && is_numeric($this->totalPrice)) {
            $this->change = $this->amount_paid - $this->totalPrice;
        } else {
            $this->change = 0;
        }
    }


    public function render()
    {
        $customers = Customer::latest()->get();
        return view('livewire.admin.p-o-s.p-o-s-livewire', [
            'customers' => $customers
        ]);
    }
}
