<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ComponentFactory extends Factory
{
    protected $model = \App\Models\Component::class;

    public function definition()
    {
        $warranty_options = [
            '+6 months',
            '+1 year',
            '+2 years',
            '+3 years',
            '+5 years',
            '+7 years',
        ];

        $warranty_modifier = $this->faker->randomElement($warranty_options);
        $date_created = $this->faker->dateTimeBetween('-2 years', 'now');
        $warranty_start = $date_created;
        $warranty_end = (clone $warranty_start)->modify($warranty_modifier);
        $date_updated = (clone $date_created)->modify('+' . rand(0, 60) . ' days');

        return [
            'serial_number'    => strtoupper($this->faker->unique()->bothify('TPSC-####-???')),
            'name'             => $this->faker->unique()->words(2, true),
            'category_id'      => $this->faker->numberBetween(1, 10),
            'status_id'        =>  1, // So 2 se bi loi neu khong duoc them thu cong, boi phai di kem action_id = 39 nua
            'note'             => $this->faker->sentence,

            // Tại sao không để trường này trong component log? Bởi nó luôn luôn bắt buộc khi thêm một component
            // Không cho phép sửa đổi trường này nếu không đủ thẩm quyền, đảm bảo tính toàn vẹn của dữ liệu
            'stockin_source' => $this->faker->unique()->words(2, true),
            'stockin_at'       => $date_created,

            'warranty_start'   => $warranty_start,
            'warranty_end'     => $warranty_end,
            'created_at'     => $date_created,
            'updated_at'     => $date_updated,
        ];
    }
}
