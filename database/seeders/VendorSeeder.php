<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class VendorSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $date_created = $faker->dateTimeBetween('-2 years', 'now');
        $date_updated = (clone $date_created)->modify('+' . rand(0, 60) . ' days');
        $vendors = [];

        for ($i = 0; $i < 10; $i++) {
            $vendors[] = [
                'name' => $faker->unique()->company,
                'phone' => $faker->optional()->phoneNumber,
                'email' => $faker->unique()->companyEmail,
                'address' => $faker->address,
                'note' => $faker->sentence(6),
                'created_at' => $date_created,
                'updated_at' => $date_updated,
            ];
        }

        DB::table('vendors')->insert($vendors);
    }
}
