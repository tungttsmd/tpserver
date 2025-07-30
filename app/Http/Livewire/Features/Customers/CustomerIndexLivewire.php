<?php

namespace App\Http\Livewire\Features\Customers;

use App\Models\Customer;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;
use Livewire\WithPagination;


class CustomerIndexLivewire extends Component
{
    use WithPagination;

    public $dir, $sort;
    public function render()
    {
        $customers = Customer::paginate(20);
        $columns = Schema::getColumnListing('customers');
        $data = [
            'data' => [
                'customers' => $customers,
                'columns' => $columns,
                'relationships' => [],
            ]
        ];
        return view('livewire.features.customers.index', $data);
    }
    public function sortBy($sort_column)
    {
        if ($this->sort === $sort_column) {
            $this->dir = $this->dir === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sort = $sort_column;
            $this->dir = 'asc';
        }
    }
}
