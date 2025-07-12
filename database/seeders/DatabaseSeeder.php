<?php

namespace Database\Seeders;

use App\Models\Manufacturer;
use Illuminate\Database\Seeder;
use PhpOffice\PhpSpreadsheet\Calculation\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PermissionSeeder::class,
            UserSeeder::class,
            ComponentSeeder::class,
            ActionLogSeeder::class,
            ComponentLogSeeder::class,
            CategorySeeder::class,
            UserLogSeeder::class,
            VendorSeeder::class,
            ProfileRoleColorSeeder::class,
            CustomerSeeder::class,
            StatusSeeder::class,
            LocationSeeder::class,
            ConditionSeeder::class,
            ManufacturerSeeder::class,
            RoleSeeder::class,
        ]);
    }
}
