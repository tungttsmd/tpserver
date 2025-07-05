<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConditionSeeder extends Seeder
{
    public function run(): void
    {
        $conditions = [
            'Mới 100%',
            'Like New (99%)',
            'Đã qua sử dụng',
            'Cũ (trầy xước nhẹ)',
            'Hàng trưng bày',
            'Lỗi phần cứng',
            'Lỗi phần mềm',
            'Hư hỏng nặng',
            'Đã sửa chữa',
            'Chờ kiểm tra',
            'Không xác định',
        ];

        foreach ($conditions as $name) {
            DB::table('conditions')->updateOrInsert(['name' => $name]);
        }
    }
}
