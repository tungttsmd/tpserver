<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::with('permissions')->get();
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name',
        ]);

        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        return redirect()->route('roles.index')->with('success', 'Đã tạo vai trò: ' . $role->name);
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('admin.roles.edit-permissions', compact('role', 'permissions'));
    }
    public function update(Request $request, Role $role)
    {
        try {
            // Cập nhật permission cho role
            $role->syncPermissions($request->permissions ?? []);

            // Tìm tất cả người dùng đang có role này
            $users = \App\Models\User::role($role->name)->get();

            foreach ($users as $user) {
                // Xoá quyền gán trực tiếp nếu có từ bảng model_has_permissions
                $user->permissions()->detach();
            }

            // Xoá cache
            app(PermissionRegistrar::class)->forgetCachedPermissions();

            return redirect()->back()->with('success', 'Cập nhật quyền thành công và đồng bộ user.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi cập nhật quyền.');
        }
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
