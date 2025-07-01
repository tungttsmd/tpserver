<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Lên các list permissions
        $permissions = [
            'view_components',
            'detail_components',
            'create_components',
            'edit_components',
            'delete_components',
            'export_components',
            'recall_components',
            'download_components',
            'view_users',
            'edit_users',
            'edit_users_password',
            'view_roles',
            'detail_roles',
            'edit_roles',
        ];

        // 2. Tạo permission vào bảng permissions
        foreach ($permissions as $permission) {
            \Spatie\Permission\Models\Permission::firstOrCreate([
                'name' => $permission,
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
                'detail_roles',
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
                'name'       => $roleName,
                'guard_name' => 'web',
            ]);

            // Gán dữ liệu vào bảng trung gian role_has_permissions
            $role->syncPermissions($perms);
        }

        // 5. Xóa cache permission để đảm bảo thay đổi có hiệu lực ngay
        app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
