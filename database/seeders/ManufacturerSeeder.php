<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ManufacturerSeeder extends Seeder
{
    public function run(): void
    {
        $manufacturers = [
            'Intel',
            'AMD',
            'NVIDIA',
            'Samsung',
            'HP',
            'Sony',
            'ASUS',
            'MSI',
            'Gigabyte',
            'Dell',
        ];

        foreach ($manufacturers as $name) {
            DB::table('manufacturers')->updateOrInsert(['name' => $name], [
                'date_created' => now(),
                'date_updated' => now(),
            ]);
        }
    }
}
