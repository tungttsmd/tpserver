<?php

namespace App\Http\Livewire\Features\Users;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Livewire\WithPagination;
use Livewire\Component;

class UserIndexLivewire extends Component
{
    use WithPagination;
    public $dir = 'desc';
    public $filter;
    public $sort = 'updated_at';
    public $search;
    public $userId;
    public $perPage = 20;
    public $columns;
    protected $listeners = ['resetFilter' => 'resetFilters', 'record' => 'setUserId'];

    public function mount(Request $request)
    {
        $this->filter = $request->path();
        $this->columns = [
            'ID' => 'ID',
            'TenNguoiDung' => 'Alias',
            'TaiKhoan' => 'Username',
            'NgayTao' => 'Ngày tạo',
            'NgayCapNhat' => 'Ngày cập nhật',
        ];
    }
    public function render()
    {
        $query = $this->index();
        $list = $query->select([
            'id as ID',
            'alias as TenNguoiDung',
            'username as TaiKhoan',
            DB::raw("DATE_FORMAT(updated_at, '%d/%m/%Y') as NgayCapNhat"),
            DB::raw("DATE_FORMAT(created_at, '%d/%m/%Y') as NgayTao"),
        ])->orderBy($this->sort, $this->dir)->paginate($this->perPage);

        return view('livewire.features.users.index', [
            'list' => $list,
            'columns' => $this->columns,
            'filter' => $this->filter,
            'sort' => $this->sort,
            'dir' => $this->dir
        ]);
    }
    public function index()
    {
        $query = User::query();
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('users.username', 'like', '%' . $this->search . '%')
                    ->orWhere('users.alias', 'like', '%' . $this->search . '%');
            });
        }
        return $query;
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
    public function reserFilters()
    {
        $this->reset(['sort', 'dir', 'search', 'perPage']);
        $this->resetPage(); // reset phân trang về trang 1

    }
    public function setUserId($id)
    {
        $this->userId = $id;
    }
}
