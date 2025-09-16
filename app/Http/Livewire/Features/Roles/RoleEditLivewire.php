<?php

namespace App\Http\Livewire\Features\Roles;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\WithPagination;

class RoleEditLivewire extends Component
{
    use WithPagination;

    public $userId;
    public $selectedRoleId;
    public $display_name = '';
    public $roles = [];
    public $filter;
    public $user;

    protected $listeners = ['record' => 'record'];
    
    public function mount(Request $request)
    {
        $this->filter = $request->path();
        $this->roles = Role::orderBy('name')->get();
    }

    public function updateSubmit()
    {
        

    }

    public function render()
    {
        return view('livewire.features.roles.edit');
    }
    public function record($id)
    {
        $this->userId = $id;
        $this->formRebinding();
    }
    public function formRebinding()
    {
        $this->user = User::with(['roles'])->findOrFail($this->userId);
        $this->selectedRoleId = $this->user->roles->first()->id;
    }
}
