<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ComponentForm extends Component
{
    public $currentView = 'component-form-scan'; // view mặc định
    public $view_form_content = '';
    public function render()
    {
        return view('livewire.component-form');
    }
    public function mount($form)
    {
        switch ($form) {
            case 'component-form-create':
                $this->view_form_content = 'livewire.partials.component-form-create';
                break;
            default:
                $this->view_form_content = 'livewire.partials.component-form-scan';
                break;
        }
    }
}
