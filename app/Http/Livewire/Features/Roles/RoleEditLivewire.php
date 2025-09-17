<?php

namespace App\Http\Livewire\Features\Roles;

use App\Models\Role;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class RoleEditLivewire extends Component
{
    use WithPagination;

    public $userId, $roleId, $roleName;
    public $submitRoleId;
    public $recordId, $user;
    public $filter;
    protected $listeners = [
        'record' => 'record',
    ];

    public function mount($recordId)
    {
        $this->recordId = $recordId;
        if ($this->recordId) {
            $this->loadUser();
        }
    }
    public function render()
    {
        $options = Role::select([
            'id',
            'name',
            'display_name'
        ])->get();

        return view('livewire.features.roles.edit', [
            'options' => $options
        ]);
    }
    public function updateSubmit()
    {
        // Nhận roleId mới
        $refindRoleName = Role::find($this->roleId)->name;

        // Valid
        if ($refindRoleName === $this->roleName) {
            $this->dispatchBrowserEvent(
                'warning-alert',
                ['message' => 'Vai trò không thay đổi!']
            );
            return;
        }

        // Success
        // 🔹 Xóa tất cả role và permissions hiện tại
        $this->user->roles()->detach(); // xóa role cũ
        $this->user->permissions()->detach(); // xóa permission trực tiếp

        // 🔹 Gán role mới
        $this->user->assignRole($refindRoleName);
        $this->user->syncRoles($refindRoleName);
        $this->dispatchBrowserEvent(
            'success-alert',
            ['message' => 'Cập nhật vai trò thành công!']
        );

        // Làm mới form nếu cần
        $this->loadUser();

        // Làm mới bảng
        $this->emitSelf('$refresh');
    }
    public function record($recordId)
    {
        $this->recordId = $recordId;
        $this->loadUser();
    }
    private function loadUser()
    {
        $this->user = User::with('roles')->find($this->recordId);

        if ($this->user && $this->user->roles->first()) {
            $this->roleId = $this->user->roles->first()->id;
            $this->roleName = $this->user->roles->first()->name;
        } else {
            $this->roleId = null;
            $this->roleName = null;
        }
        $this->emitSelf('$refresh');
    }
}
