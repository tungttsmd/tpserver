<?php

namespace App\Http\Livewire\Features\Customers;

use App\Models\Customer;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Http\Request;


class CustomerIndexLivewire extends Component
{
    use WithPagination;

    public $dir = "desc", $sort = "updated_at";
    public $customerId, $perPage = 20, $search;
    public $filter, $columns;
    public function mount(Request $request)
    {
        $this->filter = $request->path();
        $this->columns = [
            'ID' => 'ID',
            'Ten' => 'Khách hàng',
            'DienThoai' => 'Số điện thoại',
            'Email' => 'Email',
            'DiaChi' => 'Địa chỉ',
            'NgayNhap' => 'Ngày nhập',
            'NgayCapNhat' => 'Ngày cập nhật',
            'BHConLai' => 'BH còn lại (tháng)',
        ];
    }
    public function render()
    {


        $query = Customer::query();
        $sortColumn = $this->sort === 'NgayCapNhat' ? 'customers.updated_at' : $this->sort;

        $list = $query
            ->select(
                'customers.id as ID',
                'customers.name as Ten',
                'customers.phone as DienThoai',
                'customers.email as Email',
                'customers.address as DiaChi',
                'customers.note as GhiChu',
                'customers.created_at as NgayTao',
                'customers.updated_at as NgayCapNhat'
            )->orderBy($sortColumn, $this->dir)
            ->paginate($this->perPage);

        // Render view
        return view('livewire.features.customers.index', [
            'list' => $list,
            'columns' => $this->columns,
            'sort' => $this->sort,
            'dir' => $this->dir,
            'filter' => $this->filter,
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
