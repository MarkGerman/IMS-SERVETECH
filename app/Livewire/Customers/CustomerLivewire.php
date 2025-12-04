<?php

namespace App\Livewire\Customers;

use App\Models\Customer;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class CustomerLivewire extends Component
{
    use LivewireAlert;
    use WithPagination;

    public $modal = false;
    public $id;
    public $search;
    public $name, $email, $phone, $address;

    protected $listeners = ['refresh' => '$refresh'];

    /**
     * dev by Techlink360
     * Opens the modal to create or edit a customer.
     *
     * @param int|null $id
     * @return void
     */
    public function create($id = null)
    {
        $this->id = $id;
        if ($id) {
            $customer = Customer::find($id);
            $this->name = $customer->name;
            $this->email = $customer->email;
            $this->phone = $customer->phone;
            $this->address = $customer->address;
        }
        $this->modal = true;
    }

    /**
     * dev by Techlink360
     * Deletes a customer from the database.
     *
     * @param int $id
     * @return void
     */
    public function delete($id)
    {
        $customer = Customer::find($id);
        if ($customer) {
            $customer->delete();
            $this->alert('success', 'Customer deleted successfully');
            $this->dispatch('refresh');
        }
    }

    /**
     * dev by Techlink360
     * Stores or updates a customer in the database.
     *
     * @return void
     */
    public function store()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:customers,email,' . $this->id,
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
        ]);

        Customer::updateOrCreate(['id' => $this->id], [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
        ]);

        $this->alert('success', 'Customer saved successfully');
        $this->cancel();
    }

    /**
     * dev by Techlink360
     * Resets the component's properties and closes the modal.
     *
     * @return void
     */
    public function cancel()
    {
        $this->reset(["modal", "id", "name", "email", "phone", "address"]);
        $this->dispatch('modal-cancel');
    }

    /**
     * dev by Techlink360
     * Renders the component.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        $customers = Customer::withCount('sales')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('phone', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.customers.customer-livewire', [
            'customers' => $customers
        ]);
    }
}
