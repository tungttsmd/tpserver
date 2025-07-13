<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    public function run(): void
    {
        // Danh sách trạng thái
        $statuses = [
            ['name' => 'Đang tồn kho'],
            ['name' => 'Đã xuất kho'],
        ];

        foreach ($statuses as $status) {
            DB::table('statuses')->insert([
                'name' => $status['name'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
