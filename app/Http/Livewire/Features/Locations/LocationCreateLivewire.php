<?php

namespace App\Http\Livewire\Features\Locations;

use App\Models\Location;
use Livewire\Component;

class LocationCreateLivewire extends Component
{
    public $name, $note;
    public function render()
    {
        return view('livewire.features.locations.create');
    }
    public function createLocation()
    {
        // 'name' => $this->name,
        // 'phone' => $this->phone,
        // 'email' => $this->email,
        // 'address' => $this->address,
        // 'logo_url' => $this->logo_url,
        // 'note' => $this->note,

        $this->validate([
            'name' => 'required|string|max:255|unique:locations,name',
            'note' => 'nullable|string',
        ]);

        Location::create([
            'name' => $this->name,
            'note' => $this->note,
        ]);

        session()->flash('success', 'Vị trí mới đã được tạo thành công.');
        $this->reset(); // reset form
    }
}
