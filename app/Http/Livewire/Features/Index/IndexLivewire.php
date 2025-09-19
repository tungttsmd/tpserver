<?php

namespace App\Http\Livewire\Features\Index;

use Livewire\Component;

class IndexLivewire extends Component
{
    public $url = 'https://tung.info.vn/'; // Default URL, you can change this

    public function render()
    {
        return view('livewire.features.index.index');
    }
}
