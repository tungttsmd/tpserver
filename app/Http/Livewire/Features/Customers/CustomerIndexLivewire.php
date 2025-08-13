<?php

namespace App\Http\Livewire\Features\Customers;

use App\Models\Customer;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;
use Livewire\WithPagination;


class CustomerIndexLivewire extends Component
{
    use WithPagination;

    public $dir = "desc", $sort = "updated_at";
    public $customerId, $perPage = 20, $search;
    public function render()
    {

        $columns = Schema::getColumnListing('customers');
        $query = Customer::query();

        // Tìm kiếm realtime theo serial_number hoặc note cơ bản
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('phone', 'like', '%' . $this->search . '%');
            });
        }

        // Thực hiện sắp xếp nếu có cột và hướng sắp xếp
        if ($this->sort && $this->dir) {
            $query->orderBy($this->sort, $this->dir);
        }

        // Đóng gói dữ liệu
        $data = [
            'customers' => $query->paginate($this->perPage),
            'sort' => $this->sort,
            'dir' => $this->dir,
            'columns' => $columns,
            'relationships' => [],
        ];

        // Render view
        return view('livewire.features.customers.index', [
            'data' => $data,
            'filter' => session('route.filter') ?? null
        ]);
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
    public function resetFilters()
    {
        $this->reset(['search', 'perPage', 'sort', 'dir']);
        $this->resetPage();  // reset phân trang về trang 1
    }
    public function fetch($id)
    {
        $this->customerId = $id;
    }
}
