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
    public $status = '';
    public $perPage = 20;
    public $sort = 'id';
    public $dir = 'desc';
    public $columns = [];
    public $view_table_action_buttons = '';
    public $table;

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
        $query = HardwareComponent::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('serial_number', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->table === 'component-stock') {
            // ép filter status là "Sẵn kho"
            $query->where('status', 'Sẵn kho');
        }

        if ($this->status) {
            $query->where('status', $this->status);
        }

        if ($this->category) {
            $query->where('category', $this->category);
        }
        if ($this->condition) {
            $query->where('condition', $this->condition);
        }


        $allowedSorts = ['serial_number', 'category', 'condition', 'location', 'updated_at', 'status', 'id'];
        if (in_array($this->sort, $allowedSorts)) {
            $query->orderBy($this->sort, $this->dir);
        }

        $components = $query->paginate($this->perPage);

        return view('livewire.component-table', ['components' => $components]);
    }
    public function resetFilters()
    {
        $this->reset(['search', 'category', 'condition', 'status', 'perPage', 'sort', 'dir']);
        $this->resetPage();  // reset phân trang về trang 1
    }
    public function mount($table)
    {
        $this->table = $table;
        $this->columns = Schema::getColumnListing('components');

        if ($table === 'component-index') {
            $this->view_table_action_buttons = 'livewire.partials.component-table-index-action';
        } elseif ($table === 'component-stock') {
            $this->view_table_action_buttons = 'livewire.partials.component-table-stock-action';
            $this->status = 'Sẵn kho';
        } elseif ($table === 'component-export') {
            $this->view_table_action_buttons = 'livewire.partials.component-table-export-action';
            $this->status = 'Xuất kho';
        }
    }
}
