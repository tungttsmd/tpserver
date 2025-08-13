<?php

namespace App\Http\Livewire\Features\Vendors;

use App\Models\Vendor;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;
use Livewire\WithPagination;


class VendorIndexLivewire extends Component
{
    use WithPagination;

    public $dir ="desc", $sort="updated_at";
    public $vendorId, $perPage = 20, $search;
    public function render()
    {

        $columns = Schema::getColumnListing('vendors');
        $query = Vendor::query();

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
            'data' => [
                'vendors' => $query->paginate($this->perPage),
                'sort' => $this->sort,
                'dir' => $this->dir,
                'columns' => $columns,
                'relationships' => [],
            ],
            'filter' => session('route.filter')
        ];

        // Render view
        return view('livewire.features.vendors.index', $data);
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
    public function setVendorId($vendorId)
    {
        $this->vendorId = $vendorId;
    }
}
