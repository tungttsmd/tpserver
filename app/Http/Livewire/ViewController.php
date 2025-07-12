<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ViewController extends Component
{
    public function render()
    {
        return view('livewire.view-controller',[
            'livewire' =>  get_class($this)
        ]);
    }
}
