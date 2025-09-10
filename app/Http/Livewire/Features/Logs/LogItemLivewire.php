<?php

namespace App\Http\Livewire\Features\Logs;

use App\Models\LogComponent;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LogItemLivewire extends Component
{
    use WithPagination;
    public $sort = 'log_components.created_at';
    public $dir = 'desc';
    public $filter;
    public $columns;
    public $perPage = 20;
    public $logItemId;

    public $search;
    protected $listeners = ['record' => 'setLogItemId'];
    public function mount(Request $request)
    {
        $this->filter = $request->path();
        $this->columns = [
            'ID' => 'ID',
            'IDLinhKien' => 'ID linh kiện',
            'TenLinhKien' => 'Tên linh kiện',
            'ThaoTac' => 'Thao tác',
            'NguoiThucHien' => 'Người thực hiện',
            'NgayTao' => 'Ngày tạo',
           
        ];
    }
    public function render()
    {
        $componentLogs = LogComponent::query()
            ->join('components', 'log_components.component_id', '=', 'components.id')
            ->join('actions', 'log_components.action_id', '=', 'actions.id')
            ->join('users', 'log_components.user_id', '=', 'users.id')
            ->leftJoin('locations', 'log_components.location_id', '=', 'locations.id')
            ->leftJoin('vendors', 'log_components.vendor_id', '=', 'vendors.id')
            ->leftJoin('customers', 'log_components.customer_id', '=', 'customers.id')
            ->select([
                'log_components.id as ID',
                'components.id as IDLinhKien',
                'components.name as TenLinhKien',
                'actions.note as ThaoTac',
                'actions.id as ThaoTacId',
                'actions.target as ThaoTacTarget',
                'users.alias as NguoiThucHien',
                'locations.name as DiaChi',
                'vendors.name as NhaCungCap',
                'customers.name as KhachHang',
                DB::raw('DATE_FORMAT(log_components.created_at, "%d/%m/%Y") as NgayTao'),
            ])
            ->orderBy($this->sort, $this->dir)
            ->paginate($this->perPage);

        return view('livewire.features.logs.items', [
            'list' => $componentLogs,
            'sort' => $this->sort,
            'dir' => $this->dir,
            'columns' => $this->columns,
            'filter' => $this->filter,
            'perPage' => $this->perPage
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
    public function setLogItemId($id)
    {
        $this->logItemId = $id;
    }
}
