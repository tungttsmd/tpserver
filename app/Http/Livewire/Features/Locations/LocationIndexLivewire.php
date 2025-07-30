<?php

namespace App\Http\Livewire\Features\Locations;

use App\Models\Location;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;
use Livewire\WithPagination;

class LocationIndexLivewire extends Component
{
    use WithPagination;
    public $dir, $sort;
    public function render()
    {
        $locations = Location::paginate(20);
        $columns = Schema::getColumnListing('locations');
        $data = [
            'data' => [
                'locations' => $locations,
                'columns' => $columns,
                'relationships' => [],
            ]
        ];
        return view('livewire.features.locations.index', $data);
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
