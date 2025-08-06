<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $list = [
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

        $faker = Faker::create();
        $locations = [];

        foreach ($list as $name) {
            $date_created = $faker->dateTimeBetween('-2 years', 'now');
            $date_updated = (clone $date_created)->modify('+' . rand(0, 60) . ' days');

            $locations[] = [
                'name' => $name,
                'created_at' => $date_created,
                'updated_at' => $date_updated,
            ];
        }

        // Chèn nhiều bản ghi cùng một lúc
        DB::table('locations')->insert($locations);
    }
}
