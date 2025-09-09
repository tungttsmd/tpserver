<?php

namespace App\Http\Livewire\Features\Vendors;

use App\Models\Vendor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Http\Request;

class VendorIndexLivewire extends Component
{
    use WithPagination;

    public $dir = "desc", $sort = "updated_at";
    public $vendorId, $perPage = 20, $search;
    public $filter;
    public $columns;

    public function mount(Request $request)
    {
        $this->filter = $request->path();
        $this->columns = [
            'ID' => 'ID',
            'Ten' => 'Tên đối tác',
            'DienThoai' => 'Số điện thoại',
            'Email' => 'Email',
            'DiaChi' => 'Địa chỉ',
            'GhiChu' => 'Ghi chú',
            'NgayCapNhat' => 'Cập nhật',
            'NgayTao' => 'Ngày tạo',
        ];
    }
    public function render()
    {
        $query = $this->index();
        $sortColumn = $this->sort === 'NgayCapNhat' ? 'vendors.updated_at' : $this->sort;

        // Tìm kiếm realtime theo serial_number hoặc note cơ bản
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('phone', 'like', '%' . $this->search . '%');
            });
        }

        $list = $query
            ->select(
                'vendors.id as ID',
                'vendors.name as Ten',
                'vendors.phone as DienThoai',
                'vendors.email as Email',
                'vendors.address as DiaChi',
                'vendors.note as GhiChu',
                DB::raw('DATE_FORMAT(vendors.created_at, "%d/%m/%Y") as NgayTao'),
                DB::raw('DATE_FORMAT(vendors.updated_at, "%d/%m/%Y") as NgayCapNhat'),
            )->orderBy($sortColumn, $this->dir)
            ->paginate($this->perPage);

        // Render view
        return view('livewire.features.vendors.index', [
            'list' => $list,
            'sort' => $this->sort,
            'dir' => $this->dir,
            'columns' => $this->columns,
            'filter' => $this->filter,
        ]);
    }
    public function index()
    {
        $query = Vendor::query();

        // Tìm kiếm realtime theo serial_number hoặc note cơ bản
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('phone', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('address', 'like', '%' . $this->search . '%');
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
