<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ComponentController extends Component
{
    public $component = null;
    public function render()
    {
        if ($this->component) {
            return view("livewire.elements.$this->component");
        }
        return view('livewire.component-controller');
    }
    public function logout()
    {
        Auth::logout();               // Đăng xuất user hiện tại
        session()->invalidate();      // Hủy session hiện tại (tăng bảo mật)
        session()->regenerateToken(); // Tạo lại CSRF token mới
        return redirect('/');    // Chuyển hướng về trang login
    }
}
