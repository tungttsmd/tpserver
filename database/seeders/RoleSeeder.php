<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $colorList = [
            '#dc2626', // đỏ
            '#2563eb', // xanh dương
            '#16a34a', // xanh lá
            '#f59e0b', // vàng cam
            '#d97706', // vàng đậm
            '#db2777', // hồng đậm
            '#0ea5e9', // xanh da trời
            '#a855f7', // tím
            '#ef4444', // đỏ sáng
            '#3b82f6', // xanh sáng
            '#22c55e', // xanh lá sáng
            '#eab308', // vàng sáng
            '#b45309', // vàng nâu
            '#be185d', // hồng tím
            '#0284c7', // xanh dương đậm
            '#7c3aed', // tím đậm
            '#f87171', // đỏ pastel
            '#60a5fa', // xanh pastel
            '#4ade80', // xanh lá pastel
            '#fde68a', // vàng pastel
            '#a16207', // nâu đậm
            '#db2777', // hồng tươi
            '#0284c7', // xanh dương đậm
            '#8b5cf6', // tím nhẹ
            '#fbbf24', // vàng sáng 2
            '#f43f5e', // đỏ hồng
            '#2563eb', // xanh dương 2
            '#84cc16', // xanh lá đậm
            '#f97316', // cam đậm
            '#d946ef', // tím hồng
            '#6366f1', // tím xanh
            '#ec4899', // hồng tím pastel
            '#22d3ee', // xanh nước biển nhạt
            '#fb7185', // đỏ nhạt
            '#f59e0b', // cam sáng
            '#ea580c', // cam đậm 2
            '#c084fc', // tím nhạt
            '#14b8a6', // xanh ngọc
        ];

        $roles = [
            ['name' => 'admin', 'display_name' => 'Quản trị'],
            ['name' => 'manager', 'display_name' => 'Quản lý'],
            ['name' => 'storekeeper', 'display_name' => 'Thủ kho'],
            ['name' => 'user', 'display_name' => 'Người dùng'],
        ];

        foreach ($roles as $role) {
            $randomColor = $colorList[array_rand($colorList)];

            Role::updateOrCreate(
                ['name' => $role['name'], 'guard_name' => 'web'],
                [
                    'display_name' => $role['display_name'],
                    'role_color' => $randomColor,
                ]
            );
        }
    }
}
