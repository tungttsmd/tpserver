<?php

namespace App\Http\Livewire;

use Illuminate\Http\Request;
use Livewire\Component;

class ModalController extends Component
{
    protected $listeners = ['modal' => 'handle'];
    public $segments = [];

    public $recordId = null,
        $modalType = null,
        $modalTitle = null,
        $modalIcon = null,
        $modalColor = null;

    public function handle($type, $id, $title, $color, $icon)
    {
        $this->recordId = $id;
        $this->modalType = $type;
        $this->modalTitle = $title;
        $this->modalIcon = $icon;
        $this->modalColor = $color;
        $this->dispatchBrowserEvent('modal-show');
    }

    public function mount(Request $request)
    {
        $this->segments = $request->segments();
    }

    public function render()
    {
        return view('livewire.modals.index', [
            'modalRoute' => $this->segments,
            'recordId' => $this->recordId,
            'modalType' => $this->modalType,
            'modalTitle' => $this->modalTitle,
            'modalIcon' => $this->modalIcon,
            'modalColor' => $this->modalColor,
        ]);
    }
}
