<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ModalController extends Component
{
    protected $listeners = ['modal' => 'handle'];
    public $recordId = null, $modalType = null,  $modalTitle = null, $modalIcon = null, $modalColor = null;

    public function handle($type, $id, $title, $color, $icon)
    {
        $this->recordId = $id;
        $this->modalType = $type;
        $this->modalTitle = $title;
        $this->modalIcon = $icon;
        $this->modalColor = $color;
        $this->dispatchBrowserEvent('modal-show');
    }
    public function render()
    {
        return view('livewire.modals.index', [
            'controller' => session('route.controller') ?? null,
            'action' => session('route.action') ?? null,
            'filter' => session('route.filter') ?? null,
            'params' => session('route.params') ?? null
        ]);
    }
}
