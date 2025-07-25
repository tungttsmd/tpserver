<?php

namespace App\Http\Livewire\Features\Logs;

use App\Models\ComponentLog;
use Livewire\Component;
use Livewire\WithPagination;

class ComponentStockoutLivewire extends Component
{
    use WithPagination;
    public $sort = 'updated_at';
    public $dir = 'desc';

    public function render()
    {
        $componentLogs = ComponentLog::with(['component', 'action', 'user', 'vendor', 'customer', 'location'])
            ->orderBy($this->sort, $this->dir)
            ->paginate(20);

        return view('livewire.features.logs.stockout', [
            'componentLogs' => $componentLogs,
            'sort' => $this->sort,
            'dir' => $this->dir
        ]);
    }

    public function sortBy($field)
    {
        if ($this->sort === $field) {
            $this->dir = $this->dir === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sort = $field;
            $this->dir = 'asc';
        }
    }
}
