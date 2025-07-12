<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Component as HardwareComponent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class LayoutController extends Component
{
    use WithPagination, WithFileUploads;
    protected $listeners = ['viewRender'];
    public $viewRender = 'livewire.layouts.layout-controller';
    public $categories, $conditions, $statuses;
    public $category, $condition, $status;
    public $columns, $table, $relationships, $search, $sort, $dir = 'asc', $perPage = 20;
    public $password_confirmation, $password, $current_password;
    public $components;
    public $avatar;
    protected $rules = [
        'current_password' => 'required',
        'password' => 'required|min:8|confirmed',
    ];

    public function mount()
    {
        // Khởi tạo giá trị mặc định cho các biến lọc (rỗng = không lọc)
        $this->category = '';
        $this->condition = '';
        $this->status = '';

        // Lấy toàn bộ danh sách Category, Condition, Status từ database
        $this->categories = \App\Models\Category::all();
        $this->conditions = \App\Models\Condition::all();
        $this->statuses = \App\Models\Status::all();
    }
    public function render()
    {
        if ($this->viewRender === 'livewire.components.table.index') {
            $data = $this->tableIndexRender();
            return view($this->viewRender, ['data' => $data]);
        } elseif ($this->viewRender === 'livewire.profiles.index') {
            $data = $this->indexProfileRender();
        } elseif ($this->viewRender === 'livewire.profiles.index') {
            $data = $this->editProfileRender();
        } else {
            $data = [];
        }

        return view($this->viewRender, [
            'data' => $data,
            'livewire' =>  get_class($this) // livewire dùng để debug xem blade đang được gọi bởi livewire nào
        ]);
    }
    public function viewRender($viewRender)
    {
        $this->viewRender = "livewire.$viewRender";
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
    public function tableIndexRender()
    {
        $query = HardwareComponent::with([
            'category',
            'vendor',
            'condition',
            'location',
            'manufacturer',
            'status'
        ]);

        // Lấy danh sách cột của bảng 'components'
        $this->columns = Schema::getColumnListing('components');

        // Lấy danh sách các quan hệ dựa trên cột có hậu tố "_id"
        $relationships = [];
        foreach ($this->columns as $column) {
            if (str_ends_with($column, '_id')) {
                $relationships[] = substr($column, 0, -3); // cắt bỏ '_id'
            }
        }
        $this->relationships = $relationships;

        // Tìm kiếm theo serial_number hoặc note
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('serial_number', 'like', '%' . $this->search . '%')
                    ->orWhere('note', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->viewRender === 'components.table.stock') {
            $query->where('status_id', 2); // "Sẵn kho"
        } elseif ($this->viewRender === 'components.table.issue') {
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

        if (in_array($this->sort, $this->columns)) {
            $query->orderBy($this->sort, $this->dir);
        }

        return [
            'components' => $query->paginate($this->perPage),
            'columns' => $this->columns,
            'relationships' => $this->relationships,
        ];
    }
    public function indexProfileRender()
    {
        $user = Auth::user();
        return ['user' => $user, 'role' => $user->roles->first()];
    }
    public function editProfileRender()
    {
        $user = Auth::user();
        return ['user' => $user];
    }
    public function updatePassword()
    {
        $this->validate();

        if (!Hash::check($this->current_password, Auth::user()->password)) {
            $this->addError('current_password', 'Mật khẩu hiện tại không đúng.');
            return;
        }

        Auth::user()->update([
            'password' => bcrypt($this->password),
        ]);

        $this->reset(['current_password', 'password', 'password_confirmation']);
        session()->flash('success', 'Đổi mật khẩu thành công.');
    }
    public function updateAvatar()
    {
        $this->validate([
            'avatar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = Auth::user();

        // Xoá ảnh cũ nếu có
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $path = $this->avatar->store('avatars', 'public');
        $user->update(['avatar' => $path]);

        $this->reset('avatar');
        session()->flash('success', 'Cập nhật ảnh đại diện thành công.');
    }
}
