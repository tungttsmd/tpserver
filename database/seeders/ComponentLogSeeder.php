<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ComponentLogSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $data = [];

        for ($i = 0; $i < 50; $i++) { // tạo 50 bản ghi mẫu
            $actionId = $faker->numberBetween(0, 15);
            $userId = $faker->numberBetween(1, 1000);
            $componentId = $faker->numberBetween(1, 500);

            // note là số ngẫu nhiên, ví dụ 1-1000
            $note = (string) $faker->numberBetween(1, 1000);

            $dateIssued = null;
            $dateRecalled = null;

            if ($actionId === 3) {
                $dateIssued = $faker->dateTimeBetween('-1 year', 'now');
            }
            if ($actionId === 4) {
                $dateRecalled = $faker->dateTimeBetween('-1 year', 'now');
            }

            $dateCreated = $faker->dateTimeBetween('-1 year', 'now');

            $data[] = [
                'user_id' => $userId,
                'component_id' => $componentId,
                'action_id' => $actionId,
                'note' => $note,
                'date_issued' => $dateIssued,
                'date_recalled' => $dateRecalled,
                'date_created' => $dateCreated,
                'date_updated' => $dateCreated,
            ];
        }

        DB::table('component_logs')->insert($data);
    }
}
