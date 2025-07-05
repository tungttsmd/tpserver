<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Component as HardwareComponent;
use Illuminate\Support\Facades\Schema;

class ComponentTable extends Component
{
    use WithPagination;

    public $search = '';
    public $category = '';
    public $condition = '';
    public $status = 0;
    public $categories = [];
    public $conditions = [];
    public $statuses = [];
    public $perPage = 20;
    public $sort = 'id';
    public $dir = 'desc';
    public $columns = [];
    public $view_table_action_buttons = '';
    public $table;
    public $relationships;

    public function updating($field)
    {
        $this->resetPage();
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

    public function render()
    {
        $query = HardwareComponent::with([
            'category',
            'vendor',
            'condition',
            'location',
            'manufacturer',
            'status'
        ]);

        // Tìm kiếm theo serial_number hoặc note
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('serial_number', 'like', '%' . $this->search . '%')
                    ->orWhere('note', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->table === 'component-stock') {
            $query->where('status_id', 2); // "Sẵn kho"
        } elseif ($this->table === 'component-export') {
            $query->where('status_id', '!=', 2); // Đã xuất kho
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
        if ($this->condition) {
            $query->where('condition_id', $this->condition);
        }

        // Sắp xếp
        $allowedSorts = ['serial_number', 'category_id', 'condition_id', 'vendor_id', 'location_id', 'date_updated', 'status_id', 'id'];
        if (in_array($this->sort, $allowedSorts)) {
            $query->orderBy($this->sort, $this->dir);
        }

        // Phân trang
        $components = $query->paginate($this->perPage);

        return view('livewire.component-table', [
            'components' => $components,
        ]);
    }

    public function resetFilters()
    {
        $this->reset(['search', 'category', 'condition', 'status', 'perPage', 'sort', 'dir']);
        $this->resetPage();  // reset phân trang về trang 1
    }
    public function mount($table)
    {
        // Lấy toàn bộ danh sách Category, Condition, Status từ database
        $this->categories = \App\Models\Category::all();
        $this->conditions = \App\Models\Condition::all();
        $this->statuses = \App\Models\Status::all();

        // Khởi tạo giá trị mặc định cho các biến lọc (rỗng = không lọc)
        $this->category = '';
        $this->condition = '';
        $this->status = '';

        // Gán biến table
        $this->table = $table;

        // Lấy danh sách cột của bảng 'components'
        $this->columns = Schema::getColumnListing('components');

        // Tìm các quan hệ dựa trên cột có hậu tố "_id"
        $relationships = [];
        foreach ($this->columns as $column) {
            if (str_ends_with($column, '_id')) {
                $relationships[] = substr($column, 0, -3); // cắt bỏ '_id'
            }
        }
        $this->relationships = $relationships;

        // Gán view partial cho nút hành động dựa theo giá trị $table
        switch ($table) {
            case 'component-index':
                $this->view_table_action_buttons = 'livewire.partials.component-table-index-action';
                break;
            case 'component-stock':
                $this->view_table_action_buttons = 'livewire.partials.component-table-stock-action';
                break;
            case 'component-export':
                $this->view_table_action_buttons = 'livewire.partials.component-table-export-action';
                break;
            default:
                $this->view_table_action_buttons = '';
                break;
        }
    }
}
