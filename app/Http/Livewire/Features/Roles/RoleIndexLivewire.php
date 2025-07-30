<?php

namespace App\Http\Livewire\Features\Roles;

use Illuminate\Support\Facades\Schema;
use Livewire\WithPagination;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Livewire\Component;

class RoleIndexLivewire extends Component
{
    use WithPagination;
    public $dir, $sort;
    public function render()
    {
        $roles = Role::paginate(20);
        $columns = Schema::getColumnListing('roles');
        $data = [
            'data' => [
                'roles' => $roles,
                'columns' => $columns,
                'relationships' => [],
            ]
        ];
        return view('livewire.features.roles.index', $data);
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
