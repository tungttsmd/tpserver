<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class LogUserActionSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $actions = [
            0 => 'User login',
            1 => 'User logout',
            2 => 'User update password',
            3 => 'User update alias',
            4 => 'User update avatar',
            5 => 'User update cover',
            6 => 'User update permission of role',
            7 => 'User change role',
            8 => 'User create new role',
            9 => 'User download component log',
            10 => 'User download user log',
            11 => 'User delete user',
            12 => 'User view user',
            13 => 'User add new user',
        ];

        $data = [];

        for ($i = 0; $i < 50; $i++) { // tạo 50 bản ghi giả
            $actionId = $faker->numberBetween(0, 13);
            $userId = $faker->numberBetween(1, 1000); // giả sử có user_id từ 1 đến 1000
            $date_log = $faker->dateTimeBetween('-2 year', 'now');
            $data[] = [
                'user_id' => $userId,
                'action_id' => (string)$actionId, // cột string nên cast thành chuỗi
                'note' => $date_log->format('Y-m-d H:i:s') . ': Thao tác: [' . $actions[$actionId] . '] được thực hiện bởi user [#' . $userId . ']',
                'created_at' => $date_log
            ];
        }

        DB::table('log_user_actions')->insert($data);
    }
}
