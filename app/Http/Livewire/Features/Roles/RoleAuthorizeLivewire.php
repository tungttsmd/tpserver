<?php

namespace App\Http\Livewire\Features\Roles;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleAuthorizeLivewire extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedUserId;
    public $selectedRole = null;
    public $showRoleModal = false;
    public $filter;
    public $columns;
    public $sort = 'users.id';
    public $dir = 'asc';
    public $perPage = 20;
    protected $listeners = ['routeRefreshCall' => '$refresh']; // alias refresh nội bộ của livewire

    public function mount(Request $request)
    {
        $this->filter = $request->path();
        $this->columns = [
            'id' => 'ID',
            'username' => 'Username',
            'role' => 'Vai trò',
            'alias' => 'Tên hiển thị',
        ];
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updateSubmit()
    {
        $this->validate([
            'selectedRole' => 'required|exists:roles,name'
        ]);

        $user = User::findOrFail($this->selectedUserId);
        $user->syncRoles([$this->selectedRole]);

        $this->showRoleModal = false;
        $this->dispatchBrowserEvent('notify', [
            'type' => 'success',
            'message' => 'Cập nhật vai trò thành công!'
        ]);
    }

    public function render()
    {
        $query = $this->index();
        $list = $query
            ->select(['id', 'username', 'alias'])
            ->orderBy($this->sort, $this->dir)
            ->paginate($this->perPage);

        $list->getCollection()->transform(function ($user) {
            // Đã thêm thuộc tính 'role' ảo vào collection
            $user->role = $user->roles->pluck('name')->implode(', ');
            return $user;
        });

        return view('livewire.features.roles.authorize', [
            'list' => $list,
            'filter' => $this->search,
            'columns' => $this->columns,
            'sort' => $this->sort,
            'dir' => $this->dir,
            'roleList' => Role::all()
        ]);
    }
    public function index()
    {
        $query = User::with('roles');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('username', 'like', '%' . $this->search . '%')
                    ->orWhere('alias', 'like', '%' . $this->search . '%')
                    ->orWhereHas('roles', function ($qr) {
                        $qr->where('name', 'like', '%' . $this->search . '%');
                    });
            });
        }

        return $query;
    }
    public function resetFilters()
    {
        $this->reset(['search', 'perPage', 'sort', 'dir']);
        $this->resetPage(); // reset phân trang về trang 1
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
