<?php

namespace App\Http\Livewire\Features\Vendors;

use App\Models\Vendor;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;

class VendorCreateLivewire extends Component
{
    public $name, $phone, $email, $address, $note;
    protected $listeners = ['routeRefreshCall' => '$refresh', 'createSubmit' => 'createSubmit'];

    public function render()
    {
        return view('livewire.features.vendors.create');
    }
    public function createSubmit()
    {
        try {
            $this->validate([
                'name' => 'required|string|max:255|unique:vendors,name',
                'phone' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:255',
                'address' => 'nullable|string',
                'note' => 'nullable|string',
            ]);

            Vendor::create([
                'name' => $this->name,
                'phone' => $this->phone,
                'email' => $this->email,
                'address' => $this->address,
                'note' => $this->note,
            ]);

            session()->flash('success', 'Nhà cung cấp đã được tạo thành công.');
            $this->resetForm();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatchBrowserEvent('danger-alert', ['message' => 'Thông tin nhập liệu không hợp lệ!']);
        }
    }
    public function resetForm()
    {
        $this->reset();
    }
}
