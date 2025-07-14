<?php

namespace App\Http\Livewire\Features\Components;

use App\Http\Livewire\RouteController;
use App\Models\Category;
use App\Models\Component as HardwareComponent;
use App\Models\Condition;
use App\Models\Location;
use App\Models\Manufacturer;
use App\Models\Status;
use App\Models\Vendor;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;
use Livewire\WithPagination;

class ComponentIndexLivewire extends Component
{
    use WithPagination;

    public $categories, $conditions, $statuses, $locations, $vendors, $manufacturers;
    public $category, $condition, $status, $location, $vendor, $manufacturer;
    public $columns, $table, $relationships, $search, $sort, $dir = 'asc', $perPage = 20;
    public $components;
    protected $listeners = ['routeRefreshCall' => '$refresh']; // alias refresh nội bộ của livewire
    public function render()
    {
        $data = $this->index(session('route.filter') ?? null);
        return view('livewire.features.components.index', ['data' => $data]);
    }
    public function mount()
    {
        // Khởi tạo giá trị mặc định cho các biến lọc (rỗng = không lọc)
        $this->category = '';
        $this->condition = '';
        $this->status = '';
        $this->location = '';
        $this->vendor = '';
        $this->manufacturer = '';

        // Lấy toàn bộ danh sách Category, Condition, Status từ database
        $this->categories = Category::all();
        $this->conditions = Condition::all();
        $this->statuses = Status::all();
        $this->locations = Location::all();
        $this->vendors = Vendor::all();
        $this->manufacturers = Manufacturer::all();
    }
    public function index($filter)
    {
        $query = HardwareComponent::with([
            'category',
            'vendor',
            'condition',
            'location',
            'manufacturer',
            'status'
        ]);

        if ($filter === 'current-stock') {
            $query->where('status_id', 1); // "Đang tồn kho"
        } elseif ($filter === 'stockout') {
            $query->where('status_id', 2); // "Đã xuất kho"
        }

        // Lấy danh sách cột của bảng 'components'
        $this->columns = Schema::getColumnListing('components');

        // Lấy danh sách tên cột quan hệ dựa trên cột có hậu tố "_id"
        $relationships = [];
        foreach ($this->columns as $column) {
            if (str_ends_with($column, '_id')) {
                $relationships[] = substr($column, 0, -3); // cắt bỏ '_id'
            }
        }
        $this->relationships = $relationships;

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

        // Lọc theo condition_id
        if ($this->location) {
            $query->where('location_id', $this->location);
        }

        // Lọc theo condition_id
        if ($this->condition) {
            $query->where('condition_id', $this->condition);
        }

        // Lọc theo vendor_id
        if ($this->vendor) {
            $query->where('vendor_id', $this->vendor);
        }

        // Lọc theo manufacturer_id
        if ($this->manufacturer) {
            $query->where('manufacturer_id', $this->manufacturer);
        }

        // Giữ trạng thái sắp xếp khi lọc
        if (in_array($this->sort, $this->columns)) {
            $query->orderBy($this->sort, $this->dir);
        }

        return [
            'components' => $query->paginate($this->perPage),
            'columns' => $this->columns,
            'relationships' => $this->relationships,
        ];
    }
    public function resetFilters()
    {
        $this->reset(['search', 'category', 'condition', 'status', 'perPage', 'sort', 'dir']);
        $this->resetPage();  // reset phân trang về trang 1
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
