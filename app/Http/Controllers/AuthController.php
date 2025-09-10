<?php

namespace App\Http\Controllers;

use App\Models\LogUserAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect()->intended('index'); // nếu đã login (do remember token) thì chuyển tiếp
        }

        return view('login');
    }
    // Đăng nhập người dùng
    public function loginpost(Request $request)
    {
        $credentials = $request->only('username', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            LogUserAction::create([
                'action_id' => 1,
                'user_id' => Auth::user()->id,
                'note' => 'Người dùng ' . Auth::user()->alias . '(' . Auth::user()->username . ') đã đăng nhập.'

            ]);
            $request->session()->regenerate();
            return redirect()->intended('index');
        }

        return back()->withErrors([
            'username' => 'Username hoặc password không đúng! Vui lòng nhập lại.',
        ]);
    }

    // Đăng xuất người dùng
    public function logout()
    {
        return redirect('/');
    }
    public function logoutpost()
    {
        LogUserAction::create([
            'action' => 'Đăng xuất',
            'user' => Auth::user()->username ?? 'unknown',
            'note' => 'Người dùng ' . Auth::user()->username . ' đã đăng xuất.'
        ]);
        Auth::logout();
        return redirect('/');
    }
}
