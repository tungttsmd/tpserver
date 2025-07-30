<?php

namespace App\Http\Livewire\Features\Users;

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Livewire\WithPagination;
use Livewire\Component;

class UserIndexLivewire extends Component
{
    use WithPagination;
    public $dir, $sort;
    public function render()
    {
        $users = User::paginate(20);
        $columns = Schema::getColumnListing('users');
        $data = [
            'data' => [
                'users' => $users,
                'columns' => $columns,
                'relationships' => [],
            ]
        ];
        return view('livewire.features.users.index', $data);
    }
    public function sortBy($sort_column)
    {
        if ($this->sort === $sort_column) {
            $this->dir = $this->dir === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sort = $sort_column;
            $this->dir = 'asc';
        }
    }
}
