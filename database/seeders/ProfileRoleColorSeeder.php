<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProfileRoleColorSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $data = [];

        for ($i = 1; $i <= 30; $i++) {
            $data[] = [
                'role_id' => $i,
                'hexcode' => $faker->unique()->hexColor,
            ];
        }

        DB::table('profile_role_colors')->insert($data);
    }
}
