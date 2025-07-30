<?php

namespace App\Http\Livewire\Features\Vendors;

use App\Models\Vendor;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;
use Livewire\WithPagination;

class VendorIndexLivewire extends Component
{
    use WithPagination;
    public $dir, $sort;
    public function render()
    {
        $vendors = Vendor::paginate(20);
        $columns = Schema::getColumnListing('vendors');
        $data = [
            'data' => [
                'vendors' => $vendors,
                'columns' => $columns,
                'relationships' => [],
            ]
        ];
        return view('livewire.features.vendors.index', $data);
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
