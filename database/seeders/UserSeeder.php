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
            ['username' => 'admin', 'password' => bcrypt('123'), 'role' => 'admin', 'alias' => 'Trần Hưng Đạo'],
            ['username' => 'manager', 'password' => bcrypt('123'), 'role' => 'manager', 'alias' => 'Trần Quốc Tuấn'],
            ['username' => 'storekeeper', 'password' => bcrypt('123'), 'role' => 'storekeeper', 'alias' => 'Trưng Trắc'],
        ];

        foreach ($specialUsers as $user) {
            User::factory()->create([
                'alias' => $user['alias'],
                'username' => $user['username'],
                'password' => $user['password'],
            ])->each(function ($u) use ($user) {
                $u->assignRole($user['role']);
            });
        }

        User::factory(10)->create()->each(function ($user) {
            $user->assignRole('user');
        });
    }
}
