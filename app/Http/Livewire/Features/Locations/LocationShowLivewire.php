<?php

namespace App\Http\Livewire\Features\Locations;

use App\Models\Location;
use Livewire\Component;

class LocationShowLivewire extends Component
{
    protected $listeners = ['routeRefreshCall' => '$refresh', 'setLocationId' => 'setLocationId'];

    public $dir, $sort, $locationId;
    public function render()
    {
        $location = Location::find($this->locationId);
        $suggestions = $this->suggestions();
        $data = [
            'location' => $location,
            'suggestions' => $suggestions,
        ];
        return view('livewire.features.locations.show', $data);
    }
    public function suggestions()
    {
        return [];
    }
    public function setLocationId($locationId){
        $this->locationId = $locationId;
    }
}
