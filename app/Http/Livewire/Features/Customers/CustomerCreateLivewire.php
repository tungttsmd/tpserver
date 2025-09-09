<?php

namespace App\Http\Livewire\Features\Customers;

use App\Models\Customer;
use Filament\Notifications\Notification;
use Livewire\Component;

class CustomerCreateLivewire extends Component
{
    public $name, $phone, $email, $address, $note;
    protected $listeners = ['routeRefreshCall' => '$refresh', 'createSubmit' => 'createSubmit'];
    public function render()
    {
        return view('livewire.features.customers.create');
    }
    public function createSubmit()
    {
        try {
            $this->validate([
                'name' => 'required|string|max:255|unique:customers,name',
                'phone' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:255',
                'address' => 'nullable|string',
                'note' => 'nullable|string',
            ]);

            $insert = [
                'name' => $this->name,
                'phone' => $this->phone,
                'email' => $this->email,
                'address' => $this->address,
                'note' => $this->note,
            ];
            Customer::create($insert);

            $this->dispatchBrowserEvent('success-alert', ['message' => 'Khách hàng mới đã được tạo thành công!']);
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
