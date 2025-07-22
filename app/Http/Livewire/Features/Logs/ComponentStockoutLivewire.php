<?php

namespace App\Http\Livewire\Features\Logs;

use App\Models\ComponentLog;
use Livewire\Component;
use Livewire\WithPagination;

class ComponentStockoutLivewire extends Component
{
    use WithPagination;
    public $sort = 'id';
    public $dir = 'asc';

    public function render()
    {
        $components = ComponentLog::with(['component', 'action', 'user', 'vendor', 'customer'])->get();

        $componentLogs = ComponentLog::with(['component', 'action', 'user', 'vendor', 'customer'])
            ->orderBy($this->sort, $this->dir)
            ->paginate(10);

        $data = [
            'componentLogs' => $componentLogs,
            'columns' => [
                'component_id',
                'action_id',
                'user_id',
                'vendor_id',
                'customer_id',
                'note',
                'created_at',
            ],
            'components' => $components,
            'relationships' => [
                'component',
                'action',
                'user',
                'vendor',
                'customer',
            ],
        ];

        return view('livewire.features.logs.stockout', ['data' => $data, 'sort' => $this->sort, 'dir' => $this->dir]);
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
