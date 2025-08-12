<?php

namespace App\Http\Livewire\Features\Customers;

use App\Models\Customer;
use Filament\Notifications\Notification;
use Livewire\Component;

class CustomerCreateLivewire extends Component
{
    public $name, $phone, $email, $address, $logo_url, $note;
    public function render()
    {
        return view('livewire.features.customers.create');
    }
    public function createCustomer()
    {
        try {
            $this->validate([
                'name' => 'required|string|max:255|unique:customers,name',
                'phone' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:255',
                'address' => 'nullable|string',
                'logo_url' => 'nullable',
                'note' => 'nullable|string',
            ]);
            Customer::create([
                'name' => $this->name,
                'phone' => $this->phone,
                'email' => $this->email,
                'address' => $this->address,
                'avatar_url' => $this->logo_url,
                'note' => $this->note,
            ]);
            session()->flash('success', 'Khách hàng mới đã được tạo thành công');
            $this->reset();
        } catch (\Illuminate\Validation\ValidationException $e) {
            Notification::make()
                ->title('Lỗi xác thực')
                ->danger()
                ->body('Vui lòng kiểm tra lại thông tin nhập.')
                ->send();
            session()->flash('error', 'Thêm không thành công, vui lòng kiểm tra lại thông tin');

            throw $e; // Để Livewire hiển thị lỗi cụ thể bên input
        }
    }
}
