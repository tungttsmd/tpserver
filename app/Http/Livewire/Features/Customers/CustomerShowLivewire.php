<?php

namespace App\Http\Livewire\Features\Customers;

use App\Models\Customer;
use Livewire\Component;


class CustomerShowLivewire extends Component
{

    public $dir, $sort;
    public function render()
    {
        $customer = Customer::find('1');
        $suggestions = $this->suggestions();
        $data = [
            'data' => [
                'customer' => $customer,
                'suggestions' => $suggestions,
            ]
        ];
        return view('livewire.features.customers.show', $data);
    }
    public function suggestions()
    {
        return [];
    }
}
