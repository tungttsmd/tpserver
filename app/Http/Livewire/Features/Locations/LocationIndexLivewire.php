<?php

namespace App\Http\Livewire\Features\Locations;

use App\Models\Location;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocationIndexLivewire extends Component
{
    use WithPagination;

    public $dir = "desc", $sort = "updated_at";
    public $locationId, $perPage = 20, $search;
    public $columns;
    public $filter;
    public function mount(Request $request)
    {
        $this->filter = $request->path();
        $this->columns = [
            'ID' => 'ID',
            'Ten' => 'Tên vị trí',
            'GhiChu' => 'Ghi chú',
            'NgayCapNhat' => 'Cập nhật',
            'NgayTao' => 'Ngày tạo',
        ];
    }
    public function render()
    {
        $query = $this->index();
        $sortColumn = $this->sort === 'NgayCapNhat' ? 'locations.updated_at' : $this->sort;

        $list = $query->select([
            'locations.id as ID',
            'locations.name as Ten',
            'locations.note as GhiChu',
            DB::raw('DATE_FORMAT(locations.created_at, "%d/%m/%Y") as NgayTao'),
            DB::raw('DATE_FORMAT(locations.updated_at, "%d/%m/%Y") as NgayCapNhat'),
        ])->orderBy($sortColumn, $this->dir)
            ->paginate($this->perPage);

        // Render view
        return view('livewire.features.locations.index', [
            'list' => $list,
            'sort' => $this->sort,
            'dir' => $this->dir,
            'columns' => $this->columns,
            'filter' => $this->filter
        ]);
    }

    public function index()
    {
        $query = Location::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('note', 'like', '%' . $this->search . '%');
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
    public function setLocationId($locationId)
    {
        $this->locationId = $locationId;
    }
}
