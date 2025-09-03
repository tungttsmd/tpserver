<?php

namespace App\Http\Livewire\Features\Components;

use App\Models\Category;
use App\Models\Component as HardwareComponent;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class ComponentIndexLivewire extends Component
{
    use WithPagination;

    public $categories, $statuses;
    public $category, $status;
    public $columns, $table, $relationships, $search,  $perPage = 20;
    public $dir = "desc", $sort = "NgayCapNhat";
    public $components;
    public $filter;
    protected $listeners = ['routeRefreshCall' => '$refresh']; // alias refresh nội bộ của livewire
    public function render()
    {
        $query = $this->index($this->filter);
        $sortColumn = $this->sort === 'NgayCapNhat' ? 'components.updated_at' : $this->sort;

        $list = $query
            ->join('categories', 'components.category_id', '=', 'categories.id')
            ->select(
                'components.id as ID',
                'components.serial_number as Serial',
                'components.name as Ten',
                'categories.name as PhanLoai',
                'components.stockin_source as NguonNhap',
                'components.stockin_at as NgayNhap',
                'components.updated_at as NgayCapNhat',
                DB::raw('TIMESTAMPDIFF(MONTH, CURDATE(), components.warranty_end) as BHConLai')
            )
            ->orderBy($sortColumn, $this->dir)
            ->paginate($this->perPage);

        return view('livewire.features.items.index', [
            'list' => $list,
            'columns' => $this->columns,
            'sort' => $this->sort,
            'dir' => $this->dir,
            'filter' => $this->filter,
        ]);
    }
    public function mount(Request $request)
    {
        $this->filter = $request->path();
        $this->columns = [
            'ID' => 'ID',
            'Serial' => 'Serial',
            'Ten' => 'Tên',
            'PhanLoai' => 'Phân loại',
            'NguonNhap' => 'Nguồn nhập',
            'NgayNhap' => 'Ngày nhập',
            'NgayCapNhat' => 'Ngày cập nhật',
            'BHConLai' => 'BH còn lại (tháng)',
        ];

        // Khởi tạo giá trị mặc định cho các biến lọc (rỗng = không lọc)
        $this->category = '';
        $this->status = '';

        // Lấy toàn bộ danh sách Category, Status từ database
        $this->categories = Category::all();
        $this->statuses = Status::all();
    }
    public function index($filter)
    {
        $query = HardwareComponent::with([
            'category',
            'status'
        ]);

        if ($filter === 'item/index') {
            $query->where('status_id', 1); // "Đang tồn kho"
        } elseif ($filter === 'item/stockout') {
            $query->where('status_id', 2); // "Đã xuất kho"
        }

        // Tìm kiếm realtime theo serial_number hoặc note cơ bản
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('serial_number', 'like', '%' . $this->search . '%')
                    ->orWhere('note', 'like', '%' . $this->search . '%');
            });
        }

        // Lọc theo status_id (từ dropdown chẳng hạn)
        if ($this->status) {
            $query->where('status_id', $this->status);
        }

        // Lọc theo category_id
        if ($this->category) {
            $query->where('category_id', $this->category);
        }

        // Giữ trạng thái sắp xếp khi lọc

        return $query;
    }

    public function resetFilters()
    {
        $this->reset(['search', 'category', 'status', 'perPage', 'sort', 'dir']);
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
