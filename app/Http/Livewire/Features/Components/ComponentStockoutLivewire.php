<?php

namespace App\Http\Livewire\Features\Components;

use Livewire\Component;

class ComponentStockoutLivewire extends Component
{
    public $componentId, $note;
    public function render()
    {
        return view('livewire.features.components.stockout');
    }
    public function mount() {
        $this->note = $this->componentId;
    }
}
