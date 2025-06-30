<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect()->intended('index'); // nếu đã login (do remember token) thì chuyển tiếp
        }

        return view('auth.login');
    }
    // Đăng nhập người dùng
    public function loginpost(Request $request)
    {
        $credentials = $request->only('username', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            Log::create([
                'action' => 'Đăng nhập',
                'user' => Auth::user()->username ?? 'unknown',
                'note' => 'Người dùng [' . Auth::user()->role . '] ' . Auth::user()->username . ' đã đăng nhập.'
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
        Log::create([
            'action' => 'Đăng xuất',
            'user' => Auth::user()->username ?? 'unknown',
            'note' => 'Người dùng [' . Auth::user()->role . '] ' . Auth::user()->username . ' đã đăng xuất.'
        ]);
        Auth::logout();
        return redirect('/');
    }
}
