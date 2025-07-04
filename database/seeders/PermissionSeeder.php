<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Lên các list permissions
        $permissions = [
            'view_components' => 'Xem danh sách linh kiện',
            'detail_components' => 'Xem chi tiết linh kiện',
            'create_components' => 'Tạo mới linh kiện',
            'edit_components' => 'Chỉnh sửa linh kiện',
            'delete_components' => 'Xóa linh kiện',
            'export_components' => 'Xuất kho linh kiện',
            'recall_components' => 'Thu hồi linh kiện',
            'download_components' => 'Tải xuống danh sách linh kiện',
            'view_users' => 'Xem danh sách người dùng',
            'edit_users' => 'Thay đổi thông tin người dùng',
            'edit_users_password' => 'Thay đổi mật khẩu người dùng',
            'view_roles' => 'Xem danh sách vai trò',
            'create_roles' => 'Tạo mới vai trò',
            'edit_roles' => 'Chỉnh sửa quyền hạn vai trò',
        ];

        // 2. Tạo permission vào bảng permissions
        foreach ($permissions as $permission => $display_name) {
            Permission::firstOrCreate([
                'name' => $permission,
                'display_name' => $display_name,
                'guard_name' => 'web',
            ]);
        }
        // 3. Lên list các role và permissions đi theo
        $permissionGroups = [
            'view_components' => [
                'view_components',
                'detail_components',
            ],
            'control_components' => [
                'view_components',
                'detail_components',
                'create_components',
                'edit_components',
                'delete_components',
                'export_components',
                'recall_components',
                'download_components',
            ],
            'control_users' => [
                'view_users',
                'edit_users',
                'edit_users_password',
            ],
            'control_roles' => [
                'view_roles',
                'create_roles',
                'edit_roles'
            ]
        ];

        $rolesHasPermissions = [
            'admin' => array_merge(
                $permissionGroups['control_components'],
                $permissionGroups['control_users'],
                $permissionGroups['control_roles'],
            ),
            'manager' => array_merge(
                $permissionGroups['control_components'],
                $permissionGroups['control_users'],
            ),
            'storekeeper' => array_merge(
                $permissionGroups['control_components'],
            ),
            'user' => array_merge(
                $permissionGroups['view_components'],
            ),
            // thêm role khác nếu cần
        ];

        // 4. Thêm role vào bảng roles & tiến hành sync permission
        foreach ($rolesHasPermissions as $roleName => $perms) {
            // Gán dữ liệu vào bảng role
            $role = Role::firstOrCreate([
                'name' => $roleName,
                'guard_name' => 'web',
            ]);

            // Gán dữ liệu vào bảng trung gian role_has_permissions
            $role->syncPermissions($perms);
        }

        // 5. Xóa cache permission để đảm bảo thay đổi có hiệu lực ngay
        app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
