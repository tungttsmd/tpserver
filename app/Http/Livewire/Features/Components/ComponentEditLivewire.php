<?php

namespace App\Http\Livewire\Features\Components;

use App\Models\Category;
use App\Models\Component as ModelsComponent;
use App\Models\Condition;
use App\Models\Location;
use App\Models\Manufacturer;
use App\Models\Vendor;
use Livewire\Component;

class ComponentEditLivewire extends Component
{
    public $component = [];
    public $componentId = null;
    public function mount($componentId)
    {
        $this->componentId = $componentId;
        $componentModel = ModelsComponent::find($componentId)->all() ?? [];
        $this->component = $componentModel ? $componentModel->toArray() : [];
    }
    public function render()
    {
        $data = array_merge($this->getRelationData(), $this->component);
        return view('livewire.features.components.edit', $data);
    }

    public function getRelationData()
    {
        return [
            'categories' => Category::select('id', 'name')->get(),
            'conditions' => Condition::select('id', 'name')->get(),
            'locations' => Location::select('id', 'name')->get(),
            'vendors' => Vendor::select('id', 'name')->get(),
            'manufacturers' => Manufacturer::select('id', 'name')->get(),
        ];
    }
}

