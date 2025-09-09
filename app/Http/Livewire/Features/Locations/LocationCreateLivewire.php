<?php

namespace App\Http\Livewire\Features\Locations;

use App\Models\Location;
use Livewire\Component;

class LocationCreateLivewire extends Component
{
    public $name, $note;
    protected $listeners = ['routeRefreshCall' => '$refresh', 'createSubmit' => 'createSubmit'];
    public function render()
    {
        return view('livewire.features.locations.create');
    }
    public function createSubmit()
    {
        try {
            $this->validate([
                'name' => 'required|string|max:255|unique:locations,name',
                'note' => 'nullable|string',
            ]);

            $insert = [
                'name' => $this->name,
                'note' => $this->note,
            ];

            Location::create($insert);

            $this->dispatchBrowserEvent('success-alert', ['message' => 'Vị trí mới đã được tạo thành công!']);
            $this->resetForm();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatchBrowserEvent('danger-alert', ['message' => 'Thông tin nhập liệu không hợp lệ!']);
        }
    }
    public function resetForm()
    {
        $this->reset();
    }
}
