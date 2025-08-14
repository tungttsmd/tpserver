<?php

namespace App\Http\Livewire\Features\Logs;

use App\Models\LogUserAction;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;
use Livewire\WithPagination;

class UserActionLivewire extends Component
{
    use WithPagination;
    public $sort = 'updated_at';
    public $dir = 'desc';

    public function render()
    {
        $logUserActions = LogUserAction::with(['action', 'user'])
            ->orderBy($this->sort, $this->dir)
            ->paginate(20);

        return view('livewire.features.logs.user-action', [
            'logUserActions' => $logUserActions,
            'columns' => Schema::getColumnListing('log_user_actions'),
            'filter'=>session('route.filter'),
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
