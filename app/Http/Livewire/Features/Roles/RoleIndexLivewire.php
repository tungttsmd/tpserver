<?php

namespace App\Http\Livewire\Features\Roles;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class RoleIndexLivewire extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 20;
    public $sort = 'id';
    public $dir = 'asc';
    public $columns;
    public $filter;


    protected $listeners = [
        'refreshRoles' => '$refresh',
        'resetFilters' => 'resetFilters',
    ];

    public function mount(Request $request)
    {
        $this->filter = $request->path();
        $this->columns = [
            'ID' => 'ID',
            'TenVaiTro' => 'Tên vai trò',
            'TenHienThi' => 'Tên hiển thị',
            'NgayTao' => 'Ngày tạo',
            'NgayCapNhat' => 'Cập nhật',
        ];
    }
    public function render()
    {
        $query = $this->index();
        $sortColumn = $this->sort === 'NgayCapNhat' ? 'updated_at' : $this->sort;

        // Apply sorting
        $list = $query->select([
            'id as ID',
            'name as TenVaiTro',
            'display_name as TenHienThi',
            DB::raw("DATE_FORMAT(created_at, '%d/%m/%Y') as NgayTao"),
            DB::raw("DATE_FORMAT(updated_at, '%d/%m/%Y') as NgayCapNhat"),
        ])->orderBy($sortColumn, $this->dir)
            ->paginate($this->perPage);

        return view('livewire.features.roles.index', [
            'list' => $list,
            'columns' => $this->columns,
            'filter' => $this->filter,
            'sort' => $this->sort,
            'dir' => $this->dir,
        ]);
    }

    public function index()
    {
        $query = Role::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('display_name', 'like', '%' . $this->search . '%');
            });
        }

        return $query;
    }

    public function sortBy($column)
    {
        if ($this->sort === $column) {
            $this->dir = $this->dir === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sort = $column;
            $this->dir = 'asc';
        }
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['search', 'perPage', 'sort', 'dir']);
        $this->resetPage();
    }
}
