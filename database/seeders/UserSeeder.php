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
        User::factory(1)->create(
            [
                'username' => 'admin',
                'password' => bcrypt('admin')
            ]
        )->each(function ($admin) {
            // Gán role cho admin
            $admin->assignRole('admin');
        });
        User::factory(1)->create(
            [
                'username' => 'manager',
                'password' => bcrypt('manager')
            ]
        )->each(function ($manager) {
            // Gán role cho admin
            $manager->assignRole('manager');
        });
        User::factory(1)->create(
            [
                'username' => 'storekeeper',
                'password' => bcrypt('storekeeper')
            ]
        )->each(function ($storekeeper) {
            // Gán role cho admin
            $storekeeper->assignRole('storekeeper');
        });
        User::factory(10)->create()->each(function ($user) {
            // Gán role cho user
            $user->assignRole('user');
        });
    }
}
