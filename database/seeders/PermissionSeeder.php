<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Danh sách permissions theo chuẩn module.action
        $permissions = [
            // Item (Linh kiện) permissions
            'item.create' => 'Tạo mới linh kiện',
            'item.scan' => 'Quét QR linh kiện',
            'item.index' => 'Xem danh sách linh kiện',
            'item.stockout' => 'Xem linh kiện đã xuất kho',

            // Customer (Khách hàng) permissions
            'customer.create' => 'Tạo mới khách hàng',
            'customer.index' => 'Xem danh sách khách hàng',

            // Vendor (Nhà cung cấp) permissions
            'vendor.create' => 'Tạo mới nhà cung cấp',
            'vendor.index' => 'Xem danh sách nhà cung cấp',

            // Location (Vị trí kho) permissions
            'location.create' => 'Tạo mới vị trí kho',
            'location.index' => 'Xem danh sách vị trí kho',

            // Export (Xuất file) permissions
            'export.index' => 'Tải xuống dữ liệu',

            // Log (Nhật ký) permissions
            'log.users' => 'Xem nhật ký người dùng',
            'log.items' => 'Xem nhật ký linh kiện',

            // User (Người dùng) permissions
            'user.index' => 'Xem danh sách người dùng',
            'user.create' => 'Tạo mới người dùng',

            // Role (Vai trò) permissions
            'role.index' => 'Xem danh sách vai trò',
            'role.create' => 'Tạo mới vai trò',
            'role.authorize' => 'Phân quyền người dùng',
        ];

        // 2. Tạo permissions
        foreach ($permissions as $name => $displayName) {
            Permission::firstOrCreate([
                'name' => $name,
                'display_name' => $displayName,
                'guard_name' => 'web',
            ]);
        }

        // 3. Gom nhóm quyền
        $item     = ['item.create', 'item.scan', 'item.index', 'item.stockout'];
        $customer = ['customer.create', 'customer.index'];
        $vendor   = ['vendor.create', 'vendor.index'];
        $location = ['location.create', 'location.index'];
        $export   = ['export.index'];
        $log      = ['log.users', 'log.items'];
        $user     = ['user.index', 'user.create'];
        $role     = ['role.index', 'role.create', 'role.authorize'];

        // Làm phẳng mảng quyền
        $staffPermissions   = array_merge($item, $customer, $vendor, $location);
        $managerPermissions = array_merge($staffPermissions, $export, $log);
        $adminPermissions   = array_merge($managerPermissions, $user, $role);

        // 4. Tạo role và gán permission
        $haystack = [
            'staff' => $staffPermissions,
            'manager' => $managerPermissions,
            'admin' => $adminPermissions,
        ];

        foreach ($haystack as $role => $permissions) {
            $role = Role::firstOrCreate([
                'name' => $role,
                'guard_name' => 'web',
            ]);
            $role->syncPermissions($permissions);
        }

        // 5. Xoá cache để có hiệu lực
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
