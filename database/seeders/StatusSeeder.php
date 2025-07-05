<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    public function run(): void
    {
        // Xóa dữ liệu cũ để tránh duplicate khi chạy lại seeder
        DB::table('statuses')->truncate();

        // Danh sách trạng thái
        $statuses = [
            ['name' => 'Đã xuất kho'],
            ['name' => 'Tồn kho'],
            ['name' => 'Đã bán'],
            ['name' => 'Lắp máy'],
            ['name' => 'Kỹ thuật'],
            ['name' => 'Khác'],
        ];

        foreach ($statuses as $status) {
            DB::table('statuses')->insert([
                'name' => $status['name'],
                'date_created' => now(),
                'date_updated' => now(),
            ]);
        }
    }
}
