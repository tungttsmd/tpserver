<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class RouteController extends Component
{
    use WithPagination;

    public $modalType = null, $recordId = null, $modalTitle = null, $modalIcon = null, $modalColor = null;
    protected $listeners = ['route' => 'routeController', 'modal' => 'modalController'];

    public function routeController($controller, $action = null, $filter = null)
    {
        // Lắng nghe Livewire.emit('route', controller, action, filter) để gọi hàm route

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
    public function modalController($modalType, $id, $title, $color, $icon)
    {
        $this->modalType = $modalType;
        $this->recordId = $id;
        $this->modalTitle = $title;
        $this->modalIcon = $icon;
        $this->modalColor = $color;
        $this->dispatchBrowserEvent('show-popup', ['modalType' => $modalType, 'recordId' => $id]);
    }
    public function render()
    {
        // Hành động gửi session('route') để ép toàn bộ livewire liên quan sẽ force reload trang
        // View cũng sẽ dùng dữ liệu extract từ session: $controller, $action, $filter để render
        return view('livewire.routes.index',  [
            'controller' => session('route.controller'),
            'action' => session('route.action'),
            'filter' => session('route.filter')
        ]);
    }
}