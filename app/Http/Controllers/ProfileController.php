<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function editAvatar(User $user)
    {
        return view('profile.edit-avatar', compact('user'));
    }

    public function updateAvatar(Request $request, User $user)
    {
        // Nếu user không có quyền 'edit_users'
        if (!auth()->user()->can('edit_users')) {
            // Và cố gắng sửa alias user khác (không phải chính mình)
            if ($user->id !== auth()->id()) {
                abort(403, 'Bạn không được phép sửa alias của người khác.');
            }
            abort(403, 'Bạn không có quyền sửa alias.');
        }

        $request->validate([
            'avatar' => 'required|image|max:2048',
        ]);

        $filename = 'user_' . $user->id . '_' . $user->username . '.' . $request->file('avatar')->extension();
        $path = $request->file('avatar')->store('avatars', 'public', $filename);

        $user->avatar_url = '/storage/' . $path;
        $user->save();

        return back()->with('success', 'Đã cập nhật avatar thành công.');
    }

    public function editAlias(User $user)
    {
        return view('profile.edit-alias', compact('user'));
    }

    public function updateAlias(Request $request, User $user)
    {
        // Nếu user không có quyền 'edit_users'
        if (!auth()->user()->can('edit_users')) {
            // Và cố gắng sửa alias user khác (không phải chính mình)
            if ($user->id !== auth()->id()) {
                abort(403, 'Bạn không được phép sửa alias của người khác.');
            }
            abort(403, 'Bạn không có quyền sửa alias.');
        }

        // Validate dữ liệu
        $request->validate([
            'alias' => 'required|string|max:255',
        ]);

        // Cập nhật alias
        $user->alias = $request->alias;
        $user->save();

        // Redirect với thông báo thành công
        return redirect()->route('profile.edit-alias', $user->id)
            ->with('success', 'Đã cập nhật tên hiển thị thành công.');
    }

    public function editPassword(User $user)
    {
        return view('profile.edit-password', compact('user'));
    }

    public function updatePassword(Request $request, User $user)
    {
        // Nếu user không có quyền 'edit_users'
        if (!auth()->user()->can('edit_users_password')) {
            // Và cố gắng sửa alias user khác (không phải chính mình)
            if ($user->id !== auth()->id()) {
                abort(403, 'Bạn không được phép sửa alias của người khác.');
            }
            abort(403, 'Bạn không có quyền sửa alias.');
        }

        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:6', Password::defaults()],
        ]);

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Đã đổi mật khẩu thành công.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
