<?php

namespace App\Http\Livewire\Features\Customers;

use App\Models\Customer;
use Livewire\Component;

class CustomerShowLivewire extends Component
{
    public $customer;
    public $customerId;

    public function mount($id = null)
    {
        if ($id) {
            $this->customerId = $id;
            $this->loadCustomer();
        }
    }

    public function loadCustomer()
    {
        $this->customer = Customer::with(['orders' => function($query) {
            $query->orderBy('order_date', 'desc')->take(5);
        }])->findOrFail($this->customerId);
    }

    public function render()
    {
        return view('livewire.features.customers.show', [
            'customer' => $this->customer,
        ]);
    }
}
