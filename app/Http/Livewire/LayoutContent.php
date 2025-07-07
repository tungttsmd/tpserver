<?php
namespace App\Http\Livewire;

use Livewire\Component;

class LayoutContent extends Component
{
    public $currentView = 'component-form-scan'; // view mặc định

    protected $listeners = ['changeView'];

    public function changeView($viewName)
    {
        $this->currentView = $viewName;
    }

    public function render()
    {
        return view('livewire.layout-content');
    }
}
