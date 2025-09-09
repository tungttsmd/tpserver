<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $date_created = $faker->dateTimeBetween('-2 years', 'now');
        $date_updated = (clone $date_created)->modify('+' . rand(0, 60) . ' days');
        $customers = [];

        for ($i = 0; $i < 300; $i++) {
            $avatar_id = $faker->unique()->numberBetween(1, 10000);
            $customers[] = [
                'name' => $faker->unique()->name,
                'phone' => $faker->optional()->phoneNumber,
                'email' => $faker->unique()->safeEmail,
                'address' => $faker->address,
                'note' => $faker->sentence(6),
                'created_at' => $date_created,
                'updated_at' => $date_updated,
            ];
        }

        DB::table('customers')->insert($customers);
    }
}
