<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $specialUsers = [
            ['username' => 'admin',   'password' => bcrypt('123'), 'alias' => 'Admin thử nghiệm',   'role' => 'admin'],
            ['username' => 'manager', 'password' => bcrypt('123'), 'alias' => 'Quản lý thử nghiệm', 'role' => 'manager'],
            ['username' => 'staff',   'password' => bcrypt('123'), 'alias' => 'Nhân viên thử nghiệm', 'role' => 'staff'],
        ];

        foreach ($specialUsers as $item) {
            $user = User::firstOrCreate(
                [
                    'username' => $item['username'],
                    'alias'    => $item['alias'],
                    'password' => $item['password'],
                ]
            );

            // Gán role tương ứng (Spatie Permission)
            $user->assignRole($item['role']);
        }
    }
}
