<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

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
            ActionSeeder::class,
            LogComponentSeeder::class,
            CategorySeeder::class,
            LogUserActionSeeder::class,
            VendorSeeder::class,
            ProfileRoleColorSeeder::class,
            CustomerSeeder::class,
            OrdersTableSeeder::class,
            StatusSeeder::class,
            LocationSeeder::class,
            RoleSeeder::class,
        ]);
    }
}
