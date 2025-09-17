<?php

namespace App\Http\Livewire\Features\Roles;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Livewire\Component;
use Livewire\WithPagination;

class RoleShowLivewire extends Component
{
    use WithPagination;

    public $recordId;
    public $role;
    public $permissions = [];
    public $filter;
    public $roleId;
    public $user;

    protected $listeners = [
        'record' => 'record',
    ];

    public function mount($recordId)
    {
        $this->recordId = $recordId;
        if ($this->recordId) {
            $this->loadRole();
        }
    }

    public function render()
    {
        return view('livewire.features.roles.show');
    }

    public function record($recordId)
    {
        $this->recordId = $recordId;
        $this->loadRole();
        $this->emitSelf('$refresh');
    }

    private function loadRole()
    {
        // Lấy user
        $this->user = User::with('roles')->find($this->recordId);

        if (!$this->user || !$this->user->roles->first()) {
            $this->role = null;
            $this->roleId = null;
            $this->permissions = collect();
            return;
        }

        // Lấy role đầu tiên của user
        $this->roleId = $this->user->roles->first()->id;
        $this->role = Role::find($this->roleId);

        // Lấy permissions nếu role tồn tại
        $this->permissions = $this->role->permissions
            ->groupBy(function ($permission) {
                $parts = explode('.', $permission->name);
                return $parts[0] ?? 'other';
            })
            ->sortKeys();
    }
}
