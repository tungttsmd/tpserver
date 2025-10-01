<?php

namespace App\Http\Livewire\Features\Customers;

use App\Models\Customer;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CustomerEditLivewire extends Component
{
    public $customer;
    public $customerId;
    public $name, $phone, $email, $address, $note;
    
    protected $listeners = [
        'routeRefreshCall' => '$refresh',
        'editSubmit' => 'editSubmit'
    ];

    protected function rules()
    {
        return Customer::rules($this->customerId);
    }
    
    protected function messages()
    {
        return Customer::messages();
    }

    public function mount($id = null)
    {
        if ($id) {
            $this->customerId = $id;
            $this->loadCustomer();
        }
    }

    public function loadCustomer()
    {
        $this->customer = Customer::findOrFail($this->customerId);
        $this->name = $this->customer->name;
        $this->phone = $this->customer->phone;
        $this->email = $this->customer->email;
        $this->address = $this->customer->address;
        $this->note = $this->customer->note;
    }

    public function render()
    {
        return view('livewire.features.customers.edit', [
            'customer' => $this->customer
        ]);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->rules(), $this->messages());
    }

    public function save()
    {
        $this->validate($this->rules(), $this->messages());
        
        try {
            // Check if customer exists
            if (!$this->customer) {
                throw new \Exception('Không tìm thấy thông tin khách hàng.');
            }

            // Update customer
            $this->customer->update([
                'name' => $this->name,
                'phone' => $this->phone,
                'email' => $this->email,
                'address' => $this->address,
                'note' => $this->note,
            ]);

            // Log the update
            Log::info('Customer updated', [
                'customer_id' => $this->customer->id,
                'updated_by' => Auth::id()
            ]);

            // Show success message
            session()->flash('message', 'Cập nhật thông tin khách hàng thành công!');
            
            // Redirect to show page
            return redirect()->route('customer.show', $this->customer->id);

        } catch (\Exception $e) {
            Log::error('Error updating customer: ' . $e->getMessage(), [
                'customer_id' => $this->customerId ?? null,
                'user_id' => Auth::id()
            ]);
            
            $this->addError('general', 'Có lỗi xảy ra: ' . $e->getMessage());
            
            session()->flash('error', 'Có lỗi xảy ra khi cập nhật khách hàng: ' . $e->getMessage());
        }
    }
}
