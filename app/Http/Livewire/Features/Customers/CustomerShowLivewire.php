<?php

namespace App\Http\Livewire\Features\Customers;

use App\Models\Customer;
use Livewire\Component;

class CustomerShowLivewire extends Component
{
    protected $listeners = ['record'=>'record','routeRefreshCall' => '$refresh', 'setCustomerId' => 'setCustomerId'];

    public $dir, $sort, $customerId;
    public function render()
    {
        $customer = Customer::find($this->customerId);
        $suggestions = $this->suggestions();
        $data = [
            'customer' => $customer,
            'suggestions' => $suggestions,
        ];
        return view('livewire.features.customers.show', $data);
    }
    public function suggestions()
    {
        return [];
    }
    public function record($customerId){
        $this->customerId = $customerId;
    }
}
