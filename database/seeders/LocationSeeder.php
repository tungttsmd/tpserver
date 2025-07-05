<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            'Kho chính',
            'Kho kỹ thuật',
            'Kho linh kiện cũ',
            'Phòng bảo hành',
            'Phòng kỹ thuật 1',
            'Phòng kỹ thuật 2',
            'Tầng 1 - Tủ A1',
            'Tầng 2 - Tủ B3',
            'Khu vực đóng gói',
            'Kệ linh kiện nhanh',
        ];

        foreach ($locations as $name) {
            DB::table('locations')->updateOrInsert(['name' => $name]);
        }
    }
}
