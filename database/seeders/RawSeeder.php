<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RawSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Chạy app db tối thiểu
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            ActionSeeder::class,
            ProfileRoleColorSeeder::class,
            StatusSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
        ]);
    }
}
