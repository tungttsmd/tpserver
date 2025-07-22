<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            'Không xác định',
            'Nhà điều hành',
            100,
            110,
            120,
            200,
            210,
            220,
            300,
            310,
            320,
        ];

        foreach ($locations as $name) {
            DB::table('locations')->updateOrInsert(['name' => $name]);
        }
    }
}
