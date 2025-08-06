<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class RouteController extends Component
{
    use WithPagination;

    protected $listeners = ['route' => 'handle'];
    public function handle($controller, $action = null, $filter = null, string $params = "{}")
    {
        // Lắng nghe Livewire.emit('route', controller, action, filter) để gọi hàm route

        // Mô hình MVC livewire SPA. Lưu ý cần 1 view tên là routes/index

        $params = json_decode(trim($params));

        // Lưu route hiện tại
        session(['route' => compact('controller', 'action', 'filter', 'params')]);

        // Refresh component con
        $this->emit('routeRefreshCall');
    }
    public function render()
    {
        return view('livewire.routes.index',  [
            'controller' => session('route.controller') ?? null,
            'action' => session('route.action') ?? null,
            'filter' => session('route.filter') ?? null,
            'params' => session('route.params') ?? null
        ]);
    }
}
