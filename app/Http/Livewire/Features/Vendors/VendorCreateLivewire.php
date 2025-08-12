<?php

namespace App\Http\Livewire\Features\Vendors;

use App\Models\Vendor;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;

class VendorCreateLivewire extends Component
{
    public $name, $phone, $email, $address, $logo_url, $note;
    public function render()
    {
        return view('livewire.features.vendors.create');
    }
    public function createVendor()
    {
        // 'name' => $this->name,
        // 'phone' => $this->phone,
        // 'email' => $this->email,
        // 'address' => $this->address,
        // 'logo_url' => $this->logo_url,
        // 'note' => $this->note,

        $this->validate([
            'name' => 'required|string|max:255|unique:vendors,name',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'logo_url' => 'nullable',
            'note' => 'nullable|string',
        ]);

        Vendor::create([
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'address' => $this->address,
            'logo_url' => $this->logo_url,
            'note' => $this->note,
        ]);

        session()->flash('success', 'Nhà cung cấp đã được tạo thành công.');
        $this->reset(); // reset form
    }
}
