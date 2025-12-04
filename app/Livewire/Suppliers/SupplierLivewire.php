<?php

namespace App\Livewire\Suppliers;

use App\Models\Supplier;
use App\Models\AuditLog;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * SupplierLivewire component
 *
 * dev by Techlink360
 *
 * This component is responsible for managing suppliers, including CRUD operations,
 * searching, filtering, soft deletes, and blacklisting.
 */
class SupplierLivewire extends Component
{
    use LivewireAlert, WithPagination;

    public $modal = false;
    public $supplierId;
    public $name, $contact_person, $phone, $email, $address;
    public $search = '';
    public $show_trashed = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'contact_person' => 'nullable|string|max:255',
        'phone' => 'nullable|string|max:20',
        'email' => 'nullable|email|max:255|unique:suppliers,email,',
        'address' => 'nullable|string|max:500',
    ];

    /**
     * Show the create supplier modal.
     * dev by Techlink360
     */
    public function create()
    {
        $this->cancel();
        $this->modal = true;
    }

    /**
     * Show the edit supplier modal.
     * dev by Techlink360
     * @param int $id
     */
    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        $this->supplierId = $supplier->id;
        $this->name = $supplier->name;
        $this->contact_person = $supplier->contact_person;
        $this->phone = $supplier->phone;
        $this->email = $supplier->email;
        $this->address = $supplier->address;
        $this->modal = true;
    }

    /**
     * Soft delete a supplier.
     * dev by Techlink360
     * @param int $id
     */
    public function delete($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();
        $this->alert('success', 'Supplier deleted successfully.');

        AuditLog::create([
            'action' => 'delete',
            'table_name' => 'suppliers',
            'record_id' => $id,
            'user_id' => auth()->id(),
        ]);
    }

    /**
     * Restore a soft-deleted supplier.
     * dev by Techlink360
     * @param int $id
     */
    public function restore($id)
    {
        $supplier = Supplier::withTrashed()->findOrFail($id);
        $supplier->restore();
        $this->alert('success', 'Supplier restored successfully.');

        AuditLog::create([
            'action' => 'restore',
            'table_name' => 'suppliers',
            'record_id' => $id,
            'user_id' => auth()->id(),
        ]);
    }

    /**
     * Create or update a supplier.
     * dev by Techlink360
     */
    public function store()
    {
        $this->rules['email'] .= $this->supplierId;
        $this->validate();

        $supplier = Supplier::updateOrCreate(
            ['id' => $this->supplierId],
            [
                'name' => $this->name,
                'contact_person' => $this->contact_person,
                'phone' => $this->phone,
                'email' => $this->email,
                'address' => $this->address,
            ]
        );

        $this->alert('success', 'Supplier saved successfully.');
        $this->cancel();

        AuditLog::create([
            'action' => $this->supplierId ? 'update' : 'store',
            'table_name' => 'suppliers',
            'record_id' => $supplier->id,
            'user_id' => auth()->id(),
        ]);
    }

    /**
     * Toggle the blacklist status of a supplier.
     * dev by Techlink360
     * @param int $id
     */
    public function toggleBlacklist($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->is_blacklisted = !$supplier->is_blacklisted;
        $supplier->save();

        $message = $supplier->is_blacklisted ? 'Supplier blacklisted successfully.' : 'Supplier removed from blacklist.';
        $this->alert('success', $message);
    }

    /**
     * Reset component state and close modal.
     * dev by Techlink360
     */
    public function cancel()
    {
        $this->reset(['modal', 'supplierId', 'name', 'contact_person', 'phone', 'email', 'address']);
        $this->dispatch('modal-cancel');
    }

    /**
     * Render the component.
     * dev by Techlink360
     */
    public function render()
    {
        $query = Supplier::withCount('purchaseItems');

        if ($this->show_trashed) {
            $query->onlyTrashed();
        }

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                    ->orWhere('contact_person', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%")
                    ->orWhere('phone', 'like', "%{$this->search}%");
            });
        }

        return view('livewire.suppliers.supplier-livewire', [
            'suppliers' => $query->paginate(10),
        ]);
    }
}
