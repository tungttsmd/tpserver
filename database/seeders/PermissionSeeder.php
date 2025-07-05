<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Danh sách permissions theo chuẩn module.action
        $permissions = [
            'dashboard.view' => 'Xem dashboard và thống kê',
            'log.view' => 'Xem logs hệ thống',
            'user.download_log' => 'Tải logs người dùng',
            'component.download_log' => 'Tải logs linh kiện',

            'role.view' => 'Xem danh sách vai trò',
            'role.create' => 'Tạo mới vai trò',
            'role.update' => 'Chỉnh sửa vai trò',

            'user.view' => 'Xem danh sách người dùng',
            'user.update' => 'Chỉnh sửa thông tin người dùng',
            'user.assign_role' => 'Gán vai trò cho người dùng',

            'component.view' => 'Xem danh sách linh kiện',
            'component.detail' => 'Xem chi tiết linh kiện',
            'component.create' => 'Tạo mới linh kiện',
            'component.update' => 'Chỉnh sửa linh kiện',
            'component.delete' => 'Xóa linh kiện',
            'component.issue' => 'Xuất kho linh kiện',
            'component.recall' => 'Thu hồi linh kiện',
            'component.scan_qr' => 'Quét QR linh kiện',
        ];

        // 2. Tạo permissions
        foreach ($permissions as $name => $displayName) {
            Permission::firstOrCreate([
                'name' => $name,
                'display_name' => $displayName,
                'guard_name' => 'web',
            ]);
        }

        // 3. Nhóm permission theo vai trò
        $rolesPermissions = [
            'admin' => array_keys($permissions), // full quyền

            'manager' => [
                'dashboard.view',
                'log.view',
                'user.download_log',
                'component.download_log',

                'role.view',
                'user.view',
                'user.update',
                'user.assign_role',

                'component.view',
                'component.detail',
                'component.create',
                'component.update',
                'component.delete',
                'component.issue',
                'component.recall',
                'component.scan_qr',
            ],

            'storekeeper' => [
                'component.view',
                'component.detail',
                'component.create',
                'component.update',
                'component.delete',
                'component.issue',
                'component.recall',
                'component.scan_qr',
                'component.download_log',
            ],

            'user' => [
                'component.view',
                'component.detail',
                'dashboard.view',
            ],
        ];

        // 4. Tạo role và gán permission
        foreach ($rolesPermissions as $roleName => $perms) {
            $role = Role::firstOrCreate([
                'name' => $roleName,
                'guard_name' => 'web',
            ]);
            $role->syncPermissions($perms);
        }

        // 5. Xóa cache permission
        app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
