<?php

namespace App\Http\Livewire\Features\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;

class UserCreateLivewire extends Component
{
    protected $listeners = ['routeRefreshCall' => '$refresh', 'createSubmit' => 'createSubmit'];

    public $username;
    public $password;
    public $password_confirmation;
    public $alias;
    public $avatar_url = '';
    public $selectedRoles = [];

    public function mount()
    {
        $this->avatar_url = asset('images/default-avatar.png'); // Set default avatar
    }

    public function render()
    {
        $roles = Role::all();
        return view('livewire.features.users.create', [
            'roles' => $roles
        ]);
    }

    public function createSubmit()
    {
        try {
            $this->validate();

            // Create user
            $user = User::create([
                'username' => $this->username,
                'password' => Hash::make($this->password),
                'alias' => $this->alias ? $this->alias : $this->username,
                'avatar_url' => $this->avatar_url,
            ]);

            // Log user creation
            Log::info('User created', [
                'user_id' => $user->id,
                'username' => $user->username,
                'created_by' => Auth::id(),
                'ip_address' => request()->ip()
            ]);

            $this->dispatchBrowserEvent('success-alert', [
                'message' => 'Tạo tài khoản thành công!',
            ]);

            $this->resetForm();
            $this->emit('userCreated');
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('danger-alert', [
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage(),
            ]);
        }
    }

    public function resetForm()
    {
        $this->reset([
            'username',
            'password',
            'password_confirmation',
            'alias',
        ]);
        $this->avatar_url = asset('images/default-avatar.png');
    }

    protected function rules()
    {
        return [
            'username' => 'required|string|max:50|unique:users,username',
            'password' => 'required|string|min:6|confirmed',
            'alias' => 'required|string|max:100',
        ];
    }

    protected function messages()
    {
        return [
            'username.required' => 'Vui lòng nhập tên đăng nhập',
            'username.unique' => 'Tên đăng nhập đã tồn tại',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp',
        ];
    }
}
