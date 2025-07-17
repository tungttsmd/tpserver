<?php

namespace App\Http\Livewire\Features\Components;

use App\Models\Category;
use App\Models\Component as ModelsComponent;
use App\Models\Condition;
use App\Models\Location;
use App\Models\Manufacturer;
use App\Models\Vendor;
use Carbon\Carbon;
use Livewire\Component;

class ComponentEditLivewire extends Component
{
    public $component;
    public $componentId = null;
    public $name;
    public $warranty_start, $warranty_end, $note, $manufacturer_id, $vendor_id, $stockin_at, $category_id, $condition_id, $location_id;
    public $toggleWarranty = false;
    public function mount($componentId)
    {
        $this->componentId = $componentId;
        $component = ModelsComponent::findOrFail($componentId);

        // Gán vào từng property để bind với form
        $this->component = $component ?? null;
        $this->name = $component->name ?? null;
        $this->category_id = $component->category_id ?? null;
        $this->condition_id = $component->condition_id ?? null;
        $this->location_id = $component->location_id ?? null;
        $this->vendor_id = $component->vendor_id ?? null;
        $this->manufacturer_id = $component->manufacturer_id ?? null;
        $this->note = $component->note ?? null;

        // format date của laravel không hỗ trợ cho string datetime, phải dùng Carbon (date phải đúng định dạng string trong input form)
        $this->stockin_at = $component->stockin_at ? Carbon::parse($component->stockin_at)->format('Y-m-d') : null;
        $this->warranty_start = $component->warranty_start ? Carbon::parse($component->warranty_start)->format('Y-m-d') : null;
        $this->warranty_end = $component->warranty_end ? Carbon::parse($component->warranty_end)->format('Y-m-d') : null;

        $this->toggleWarranty = !is_null($component->warranty_start);
    }
    public function render()
    {
        $data = array_merge($this->getRelationData(), ['component' => $this->component]);
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
    public function update()
    {
        $component = ModelsComponent::findOrFail($this->componentId);
        $component->update([
            'name' => $this->name,
            'category_id' => $this->category_id,
            'condition_id' => $this->condition_id,
            'location_id' => $this->location_id,
            'vendor_id' => $this->vendor_id,
            'manufacturer_id' => $this->manufacturer_id,
            'note' => $this->note,
            'stockin_at' => Carbon::parse($this->stockin_at),
            'warranty_start' => $this->toggleWarranty ? Carbon::parse($this->warranty_start) : null,
            'warranty_end' => $this->toggleWarranty ? Carbon::parse($this->warranty_end) : null,
        ]);

        session()->flash('success', 'Cập nhật thành công!');
    }

}

