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
        User::factory(1)->create()->each(function ($admin) {
            // Gán role cho admin
            $admin->assignRole('admin');
        });
        User::factory(10)->create()->each(function ($user) {
            // Gán role cho user
            $user->assignRole('user');
        });
    }
}
