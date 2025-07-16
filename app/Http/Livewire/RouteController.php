<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class RouteController extends Component
{
    use WithPagination;
    // Lắng nghe Livewire.emit('route', controller, action, filter) để gọi hàm route
    protected $listeners = ['route' => 'routeController', 'modal' => 'modalController'];

    public function routeController($controller, $action = null, $filter = null)
    {
        // Mô hình MVC livewire SPA. Lưu ý cần 1 view tên là routes/index

        // Lưu route hiện tại
        session(['route' => compact('controller', 'action', 'filter')]);

        // Lấy lịch sử route cũ hoặc tạo mảng mới nếu chưa có
        $histories = session('routeHistories', []);

        // Thêm route mới vào cuối mảng lịch sử
        $histories[] = compact('controller', 'action', 'filter');

        // (Tùy chọn) Giới hạn số phần tử trong lịch sử, ví dụ giữ tối đa 10 bản ghi
        $histories = array_slice($histories, -10);

        // Lưu lại vào session
        session(['routeHistories' => $histories]);

        // Refresh component con
        $this->emit('routeRefreshCall');
    }
    public function modalController()
    {
        $this->dispatchBrowserEvent('show-popup');
    }
    public function render()
    {
        // Hành động gửi session('route') để ép toàn bộ livewire liên quan sẽ force reload trang
        // View cũng sẽ dùng dữ liệu extract từ session: $controller, $action, $filter để render
        return view('livewire.routes.index', session('route') ?? ['controller' => null, 'action' => null, 'filter' => null]);
    }
}


//     public $viewRender = 'livewire.layouts.layout-controller';
//     public $categories, $conditions, $statuses;
//     public $category, $condition, $status;
//     public $columns, $table, $relationships, $search, $sort, $dir = 'asc', $perPage = 20;
//     public $password_confirmation, $password, $current_password;
//     public $components;
//     public $avatar;
//     protected $rules = [
//         'current_password' => 'required',
//         'password' => 'required|min:8|confirmed',
//     ];

//     public function mount()
//     {
//         // Khởi tạo giá trị mặc định cho các biến lọc (rỗng = không lọc)
//         $this->category = '';
//         $this->condition = '';
//         $this->status = '';

//         // Lấy toàn bộ danh sách Category, Condition, Status từ database
//         $this->categories = \App\Models\Category::all();
//         $this->conditions = \App\Models\Condition::all();
//         $this->statuses = \App\Models\Status::all();
//     }
// }

// public function render()
// {
//     if ($this->viewRender === 'features.components.component-index-livewire') {
//         $data = $this->tableIndexRender();
//         return view('livewire.features.components.component-index-livewire', ['data' => $data]);
//     } elseif ($this->viewRender === 'livewire.profiles.index') {
//         $data = $this->indexProfileRender();
//     } elseif ($this->viewRender === 'livewire.profiles.index') {
//         $data = $this->editProfileRender();
//     } else {
//         $data = [];
//     }

//     return view($this->viewRender, [
//         'data' => $data,
//         'livewire' =>  get_class($this) // livewire dùng để debug xem blade đang được gọi bởi livewire nào
//     ]);
// }
// public function viewRender($viewRender)
// {
//     $this->viewRender = "livewire.$viewRender";
// }
// public function resetFilters()
// {
//     $this->reset(['search', 'category', 'condition', 'status', 'perPage', 'sort', 'dir']);
//     $this->resetPage();  // reset phân trang về trang 1
// }

// public function sortBy($sort_column)
// {
//     if ($this->sort === $sort_column) {
//         $this->dir = $this->dir === 'asc' ? 'desc' : 'asc';
//     } else {
//         $this->sort = $sort_column;
//         $this->dir = 'asc';
//     }
// }
// public function tableIndexRender()
// {
//     $query = HardwareComponent::with([
//         'category',
//         'vendor',
//         'condition',
//         'location',
//         'manufacturer',
//         'status'
//     ]);

//     // Lấy danh sách cột của bảng 'components'
//     $this->columns = Schema::getColumnListing('components');

//     // Lấy danh sách các quan hệ dựa trên cột có hậu tố "_id"
//     $relationships = [];
//     foreach ($this->columns as $column) {
//         if (str_ends_with($column, '_id')) {
//             $relationships[] = substr($column, 0, -3); // cắt bỏ '_id'
//         }
//     }
//     $this->relationships = $relationships;

//     // Tìm kiếm theo serial_number hoặc note
//     if ($this->search) {
//         $query->where(function ($q) {
//             $q->where('serial_number', 'like', '%' . $this->search . '%')
//                 ->orWhere('note', 'like', '%' . $this->search . '%');
//         });
//     }

//     if ($this->viewRender === 'components.table.stock') {
//         $query->where('status_id', 2); // "Sẵn kho"
//     } elseif ($this->viewRender === 'components.table.issue') {
//         $query->where('status_id', '!=', 2); // Đã xuất kho
//     }

//     // Lọc theo status_id (từ dropdown chẳng hạn)
//     if ($this->status) {
//         $query->where('status_id', $this->status);
//     }

//     // Lọc theo category_id
//     if ($this->category) {
//         $query->where('category_id', $this->category);
//     }

//     // Lọc theo condition_id
//     if ($this->condition) {
//         $query->where('condition_id', $this->condition);
//     }

//     if (in_array($this->sort, $this->columns)) {
//         $query->orderBy($this->sort, $this->dir);
//     }

//     return [
//         'components' => $query->paginate($this->perPage),
//         'columns' => $this->columns,
//         'relationships' => $this->relationships,
//     ];
// }
// public function indexProfileRender()
// {
//     $user = Auth::user();
//     return ['user' => $user, 'role' => $user->roles->first()];
// }
// public function editProfileRender()
// {
//     $user = Auth::user();
//     return ['user' => $user];
// }
// public function updatePassword()
// {
//     $this->validate();

//     if (!Hash::check($this->current_password, Auth::user()->password)) {
//         $this->addError('current_password', 'Mật khẩu hiện tại không đúng.');
//         return;
//     }

//     Auth::user()->update([
//         'password' => bcrypt($this->password),
//     ]);

//     $this->reset(['current_password', 'password', 'password_confirmation']);
//     session()->flash('success', 'Đổi mật khẩu thành công.');
// }
// public function updateAvatar()
// {
//     $this->validate([
//         'avatar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
//     ]);

//     $user = Auth::user();

//     // Xoá ảnh cũ nếu có
//     if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
//         Storage::disk('public')->delete($user->avatar);
//     }

//     $path = $this->avatar->store('avatars', 'public');
//     $user->update(['avatar' => $path]);

//     $this->reset('avatar');
//     session()->flash('success', 'Cập nhật ảnh đại diện thành công.');
