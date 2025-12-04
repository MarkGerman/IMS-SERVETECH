<?php

namespace App\Livewire\Setup;

use Livewire\Component;
use App\Models\Setting;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithFileUploads;

class SetupLivewire extends Component
{
    use WithFileUploads;
    use LivewireAlert;

    public $system_organization_name;
    public $system_phone_1;
    public $system_phone_2;
    public $system_phone_3;

    public $logo; // for upload or stored path

    public $shop_name;
    public $shop_email;
    public $shop_phone;
    public $shop_address;

    public $markup_percentage;
    public $tax_percentage;

    public $pos_enabled = true;
    public $allow_negative_stock = false;

    public $existing_logo; // to display the current logo

    public function mount()
    {
        $s = Setting::first() ?? new Setting();

        $this->system_organization_name = $s->system_organization_name;
        $this->system_phone_1 = $s->system_phone_1;
        $this->system_phone_2 = $s->system_phone_2;
        $this->system_phone_3 = $s->system_phone_3;

        $this->existing_logo = $s->logo;

        $this->shop_name = $s->shop_name;
        $this->shop_email = $s->shop_email;
        $this->shop_phone = $s->shop_phone;
        $this->shop_address = $s->shop_address;

        $this->markup_percentage = $s->markup_percentage;
        $this->tax_percentage = $s->tax_percentage;

        $this->pos_enabled = $s->pos_enabled;
        $this->allow_negative_stock = $s->allow_negative_stock;
    }

    public function save()
    {
        $this->validate([
            'system_organization_name' => 'nullable|string|max:255',
            'system_phone_1' => 'nullable|string|max:50',
            'system_phone_2' => 'nullable|string|max:50',
            'system_phone_3' => 'nullable|string|max:50',

            'logo' => 'nullable|image|max:2048', // 2MB max

            'shop_name' => 'nullable|string|max:255',
            'shop_email' => 'nullable|email|max:255',
            'shop_phone' => 'nullable|string|max:50',
            'shop_address' => 'nullable|string|max:500',

            'markup_percentage' => 'numeric|min:0|max:100',
            'tax_percentage' => 'numeric|min:0|max:100',

            'pos_enabled' => 'boolean',
            'allow_negative_stock' => 'boolean',
        ]);

        // Handle logo upload
        $logoPath = null ;

        $logoPath = $this->logo->store('logos', 'custom');


        Setting::updateOrCreate(
            ['id' => 1],
            [
                'system_organization_name' => $this->system_organization_name,
                'system_phone_1' => $this->system_phone_1,
                'system_phone_2' => $this->system_phone_2,
                'system_phone_3' => $this->system_phone_3,

                'logo' => $logoPath,

                'shop_name' => $this->shop_name,
                'shop_email' => $this->shop_email,
                'shop_phone' => $this->shop_phone,
                'shop_address' => $this->shop_address,

                'markup_percentage' => $this->markup_percentage,
                'tax_percentage' => $this->tax_percentage,

                'pos_enabled' => $this->pos_enabled ? 1 : 0,
                'allow_negative_stock' => $this->allow_negative_stock ? 1 : 0,
            ]
        );

        $this->alert('success', 'Settings updated successfully');
    }

    public function render()
    {
        return view('livewire.setup.setup-livewire')->layout('layouts.blank');

    }
}
