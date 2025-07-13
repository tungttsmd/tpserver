<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition()
    {
        $id = $this->faker->unique()->numberBetween(1, 10000);
        $username = $this->faker->userName;
        $date_created = $this->faker->dateTimeBetween('-2 years', 'now');
        $date_updated = (clone $date_created)->modify('+' . rand(0, 60) . ' days');

        return [
            'alias' => $this->vietnameseName(),
            'username' => $username,
            'password' => bcrypt('123'),
            'avatar_url' => "https://i.pravatar.cc/150?u={$id}",
            'cover_url' => "https://picsum.photos/seed/{$username}/800/200",
            'created_at' => $date_created,
            'updated_at' => $date_updated,
            'remember_token' => Str::random(10),
        ];
    }
    protected function vietnameseName()
    {
        $ho = ['Nguyễn', 'Trần', 'Lê', 'Phạm', 'Hoàng', 'Phan', 'Vũ', 'Đặng', 'Bùi', 'Đỗ'];
        $tenLotPool = ['Văn', 'Thị', 'Hữu', 'Minh', 'Quang', 'Thành', 'Đức', 'Thanh', 'Xuân', 'Khánh'];
        $ten = ['An', 'Bảo', 'Cường', 'Dũng', 'Hà', 'Hạnh', 'Hùng', 'Linh', 'Mai', 'Nam', 'Oanh', 'Phương', 'Quang', 'Sơn', 'Trang', 'Tuấn', 'Vân', 'Vy', 'Yến'];

        $hoTenLot = $this->faker->randomElement($ho);

        // Lấy số từ 0 đến 3 chữ tên lót
        $soTenLot = $this->faker->numberBetween(0, 3);
        if ($soTenLot > 0) {
            $tenLotArr = $this->faker->randomElements($tenLotPool, $soTenLot);
            $hoTenLot .= ' ' . implode(' ', $tenLotArr);
        }

        $tenChinh = $this->faker->randomElement($ten);

        return $hoTenLot . ' ' . $tenChinh;
    }
}
