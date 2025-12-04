<?php

namespace App\Livewire\Returns;

use App\Models\Returns; // dev by Techlink360: Import the Returns model
use App\Models\Customer; // dev by Techlink360: Import the Customer model
use Illuminate\Support\Facades\Auth; // dev by Techlink360: Import Auth facade
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class ReturnLivewire extends Component
{
    use LivewireAlert;
    use WithPagination;

    // dev by Techlink360: Properties for return history
    public $searchReturns = '';
    public $filterByDate = '';
    public $filterByCustomer = '';
    public $filterByStatus = '';

    public $view_modal = false;
    public $selected_return;

    public $new_return_modal = false;
    public $sales = [];
    public $selected_sale_id;
    public $products = [];
    public $selected_product_id;
    public $return_quantity;
    public $return_reason;
    public $max_return_quantity;
    public $admin_email;
    public $admin_password;

    protected $listeners = ['refresh' => '$refresh'];

    /**
     * dev by Techlink360
     * Lifecycle hook to reset pagination when search or filters change.
     */
    public function updated($propertyName)
    {
        if (in_array($propertyName, ['searchReturns', 'filterByDate', 'filterByCustomer', 'filterByStatus'])) {
            $this->resetPage();
        }
    }

    /**
     * dev by Techlink360
     * Approves a pending return (owner only).
     *
     * @param int $returnId
     * @return void
     */
    public function approveReturn($returnId)
    {
        // dev by Techlink360: Implement owner check here if roles are defined
        // For now, anyone can approve. Add proper authorization later.
        $return = Returns::find($returnId);
        if ($return && $return->status == 'pending') {
            $return->status = 'approved';
            $return->approved_by = Auth::id();
            $return->save();
            $this->alert('success', 'Return approved successfully!');
            $this->dispatch('refresh');
        } else {
            $this->alert('error', 'Return not found or already processed.');
        }
    }

    /**
     * dev by Techlink360
     * Rejects a pending return (owner only).
     *
     * @param int $returnId
     * @return void
     */
    public function rejectReturn($returnId)
    {
        // dev by Techlink360: Implement owner check here if roles are defined
        // For now, anyone can reject. Add proper authorization later.
        $return = Returns::find($returnId);
        if ($return && $return->status == 'pending') {
            $return->status = 'rejected';
            $return->approved_by = Auth::id(); // Record who rejected
            $return->save();
            $this->alert('success', 'Return rejected successfully!');
            $this->dispatch('refresh');
        } else {
            $this->alert('error', 'Return not found or already processed.');
        }
    }

    /**
     * dev by Techlink360
     * View details of a specific return.
     * @param int $id
     */
    public function viewReturn($id)
    {
        $this->selected_return = Returns::with('sale.customer', 'creator', 'approver', 'returnItems.saleItem.product')->find($id);
        $this->view_modal = true;
    }

    public function openNewReturnModal()
    {
        $this->sales = \App\Models\Sale::with('customer')->latest()->get();
        $this->new_return_modal = true;
    }

    public function updatedSelectedSaleId($saleId)
    {
        $sale = \App\Models\Sale::with('items.product')->find($saleId);
        $this->products = $sale->items->map(function ($item) {
            return [
                'id' => $item->product->id,
                'name' => $item->product->name,
                'quantity' => $item->quantity,
                'sale_item_id' => $item->id,
            ];
        });
    }

    public function storeReturn()
    {
        $this->validate([
            'selected_sale_id' => 'required',
            'selected_product_id' => 'required',
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

        if (!$admin->is_admin) {
            $this->alert('error', 'Only administrators can approve returns.');
            return;
        }

        $sale_item = \App\Models\SaleItem::where('sale_id', $this->selected_sale_id)
            ->where('product_id', $this->selected_product_id)
            ->first();

        if ($this->return_quantity > $sale_item->quantity) {
            $this->alert('error', 'Cannot return more than the purchased quantity.');
            return;
        }

        $refund_amount = $this->return_quantity * $sale_item->unit_price;

        $return = \App\Models\Returns::create([
            'sale_id' => $this->selected_sale_id,
            'customer_id' => $sale_item->sale->customer_id,
            'return_date' => now(),
            'reason' => $this->return_reason,
            'total_refund_amount' => $refund_amount,
            'status' => 'approved',
            'approved_by' => $admin->id,
            'created_by' => Auth::id(),
        ]);

        \App\Models\ReturnItem::create([
            'return_id' => $return->id,
            'sale_item_id' => $sale_item->id,
            'quantity' => $this->return_quantity,
            'approved_by' => $admin->id,
            'return_date' => now(),
        ]);

        $product = \App\Models\Product::find($this->selected_product_id);
        $product->quantity += $this->return_quantity;
        $product->save();

        $sale_item->quantity -= $this->return_quantity;
        $sale_item->total_price = $sale_item->quantity * $sale_item->unit_price;
        $sale_item->save();

        $sale = \App\Models\Sale::find($this->selected_sale_id);
        $sale->total_amount -= $refund_amount;
        $sale->save();

        $this->alert('success', 'Product returned successfully.');
        $this->new_return_modal = false;
        $this->reset('selected_sale_id', 'selected_product_id', 'return_quantity', 'return_reason', 'admin_email', 'admin_password');
    }


    public function cancel(){
        $this->reset(['searchReturns', 'filterByDate', 'filterByCustomer', 'filterByStatus', 'view_modal', 'selected_return', 'new_return_modal', 'selected_sale_id', 'selected_product_id', 'return_quantity', 'return_reason', 'admin_email', 'admin_password', 'sales', 'products',  'return_quantity', 'admin_email', 'admin_password', 'return_reason','new_return_modal']);
    }
    /**
     * dev by Techlink360
     * Dispatch an event to print the details of a specific return.
     * @param int $id
     */
    public function printReturn($id)
    {
        $this->dispatch('print-return', $id);
    }



    /**
     * dev by Techlink360
     * Renders the component view with paginated and filtered return history.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        $returns = Returns::with(['sale.customer', 'creator', 'approver'])
            ->when($this->searchReturns, function ($query) {
                $query->where('id', 'like', '%' . $this->searchReturns . '%')
                    ->orWhere('reason', 'like', '%' . $this->searchReturns . '%')
                    ->orWhereHas('sale', function ($q) {
                        $q->where('id', 'like', '%' . $this->searchReturns . '%');
                    })
                    ->orWhereHas('customer', function ($q) {
                        $q->where('name', 'like', '%' . $this->searchReturns . '%');
                    });
            })
            ->when($this->filterByDate, function ($query) {
                $query->whereDate('return_date', $this->filterByDate);
            })
            ->when($this->filterByCustomer, function ($query) {
                $query->where('customer_id', $this->filterByCustomer);
            })
            ->when($this->filterByStatus, function ($query) {
                $query->where('status', $this->filterByStatus);
            })
            ->latest()
            ->paginate(10);

        $customers = Customer::orderBy('name')->get(); // For customer filter dropdown

        return view('livewire.returns.return-livewire', [
            'returns' => $returns,
            'customers' => $customers,
        ]);
    }
}
