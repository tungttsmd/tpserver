<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
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

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    public function editRoles(User $user)
    {
        $currentUser = auth()->user();

        if ($currentUser->hasRole('admin')) {
            $assignableRoles = Role::all();
        } elseif ($currentUser->hasRole('manager')) {
            $assignableRoles = Role::whereIn('name', ['user'])->get();
        } else {
            abort(403, 'Bạn không có quyền gán vai trò');
        }

        return view('admin.users.edit-roles', [
            'user' => $user,
            'roles' => $assignableRoles
        ]);
    }

    public function updateRoles(Request $request, User $user)
    {
        $currentUser = auth()->user();

        // Xác định danh sách role mà người hiện tại được phép gán
        if ($currentUser->hasRole('admin')) {
            $allowedRoles = Role::pluck('name')->toArray();
        } elseif ($currentUser->hasRole('manager')) {
            $allowedRoles = ['user']; // manager chỉ được gán role user
        } else {
            abort(403, 'Bạn không có quyền thực hiện thao tác này.');
        }

        // Gán lại 1 role duy nhất
        $role = $request->input('roles')[0] ?? null;

        if ($role && in_array($role, $allowedRoles)) {
            $user->syncRoles([$role]);
        }

        return redirect()->route('users.index')
            ->with('success', 'Cập nhật vai trò thành công!');
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
