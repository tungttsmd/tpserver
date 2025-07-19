<?php

namespace App\Http\Livewire\Features\Components;

use App\Models\Component as ModelsComponent;
use Livewire\Component;

class ComponentStockoutLivewire extends Component
{
    public $componentId, $note, $component;
    public $qrcode;
    public function render()
    {
        return view('livewire.features.components.stockout');
    }
    public function mount()
    {
        $this->note = $this->componentId;
        $this->component = ModelsComponent::with([
            'category',
            'vendor',
            'condition',
            'location',
            'manufacturer',
            'status'
        ])->where('id', $this->componentId)->first();

        $this->qrcode = "https://api.qrserver.com/v1/create-qr-code/?data={$this->component->serial_number}&size=240x240";
    }
}
