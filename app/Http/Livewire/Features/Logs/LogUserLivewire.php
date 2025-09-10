<?php

namespace App\Http\Livewire\Features\Logs;

use App\Models\LogUserAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;
use Livewire\WithPagination;

class LogUserLivewire extends Component
{
    use WithPagination;
    public $sort = 'updated_at';
    public $dir = 'desc';
    public $perPage = 20;
    public $filter;
    public $columns;
    public $search;
    public $logUserId;
    protected $listeners = ['record' => 'setLogUserId', 'resetFilter' => 'resetFilters'];
    public function mount(Request $request)
    {
        $this->filter = $request->path();
        $this->columns = [
            'ID' => 'ID',
            'IDNguoiDung' => 'ID người dùng',
            'IDThaoTac' => 'ID thao tác',
            'GhiChu' => 'Ghi chú',
            'NgayTao' => 'Ngày tạo',
            'NgayCapNhat' => 'Ngày cập nhật',
        ];
    }

    public function render()
    {
        $query = $this->index();
        $sortColumn = $this->sort === 'NgayCapNhat' ? 'log_user_actions.updated_at' : $this->sort;
        $sortDirection = $this->dir === 'ASC' ? 'ASC' : 'DESC';

        $list = $query->select([
            'log_user_actions.id as ID',
            'log_user_actions.user_id as IDNguoiDung',
            'log_user_actions.action_id as IDThaoTac',
            'log_user_actions.note as GhiChu',
            'log_user_actions.created_at as NgayTao',
            'log_user_actions.updated_at as NgayCapNhat',
        ])->orderBy($sortColumn, $sortDirection)->paginate($this->perPage);

        return view('livewire.features.logs.users', [
            'list' => $list,
            'columns' => $this->columns,
            'filter' => $this->filter,
            'sort' => $this->sort,
            'dir' => $this->dir
        ]);
    }
    public function index()
    {
        $query = LogUserAction::with(['action', 'user']);
        if ($this->search) {
            $query->where(function ($q) {
                $q->whereHas('user', function ($q2) {
                    $q2->where('alias', 'like', '%' . $this->search . '%');
                })
                    ->orWhereHas('action', function ($q3) {
                        $q3->where('note', 'like', '%' . $this->search . '%');
                    })
                    ->orWhere('note', 'like', '%' . $this->search . '%');
            });
        }
        return $query;
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
    public function setLogUserId($id)
    {
        $this->logUserId = $id;
    }
    public function resetFilters()
    {
        $this->reset(['search', 'perPage', 'sort', 'dir']);
        $this->resetPage(); // reset phân trang về trang 1
    }
}
