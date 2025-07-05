<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Bo mạch chủ', 'note' => 'Mainboard dùng để kết nối các linh kiện như CPU, RAM, ổ cứng, v.v.'],
            ['name' => 'Bộ xử lý (CPU)', 'note' => 'Vi xử lý trung tâm thực hiện các lệnh và điều khiển hệ thống.'],
            ['name' => 'Bộ nhớ RAM', 'note' => 'Bộ nhớ truy cập ngẫu nhiên, lưu trữ dữ liệu tạm thời cho hệ thống.'],
            ['name' => 'Ổ cứng SSD', 'note' => 'Thiết bị lưu trữ dữ liệu tốc độ cao, loại solid-state drive.'],
            ['name' => 'Ổ cứng HDD', 'note' => 'Thiết bị lưu trữ dữ liệu cơ học, loại hard disk drive.'],
            ['name' => 'Nguồn (PSU)', 'note' => 'Bộ nguồn cung cấp điện cho toàn bộ hệ thống máy tính.'],
            ['name' => 'Card đồ họa (GPU)', 'note' => 'Thiết bị xử lý hình ảnh và video, dùng cho game và thiết kế.'],
            ['name' => 'Quạt tản nhiệt', 'note' => 'Tản nhiệt cho CPU, GPU hoặc case máy tính để tránh quá nhiệt.'],
            ['name' => 'Vỏ case', 'note' => 'Khung bao ngoài để lắp ráp linh kiện phần cứng máy tính.'],
            ['name' => 'Bo mạch mở rộng (PCIe)', 'note' => 'Các card mở rộng như sound card, network card, v.v. cắm qua khe PCIe.'],
        ];
        $faker = Faker::create();

        foreach ($categories as &$item) {
            $date_created = $faker->dateTimeBetween('-2 years', 'now');
            $date_updated = (clone $date_created)->modify('+' . rand(0, 60) . ' days');
            $item['date_created'] = $date_created;
            $item['date_updated'] = $date_updated;
        }

        DB::table('categories')->insert($categories);
    }
}
