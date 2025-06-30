<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ComponentFactory extends Factory
{
    protected $model = \App\Models\Component::class;

    public function definition()
    {
        $categories = ['CPU', 'RAM', 'GPU', 'SSD', 'Motherboard', 'Power Supply'];
        $locations = ['Kho A', 'Kho B', 'Kho', 'In Transit'];
        $conditions = ['Mới', 'Like new', 'Đã sử dụng', 'Hỏng nặng'];
        $statuses = ['Sẵn kho', 'Xuất kho'];

        $exported = $this->faker->boolean(20); // 20% chance đã xuất kho
        $recalled = $this->faker->boolean(10); // 10% chance đã thu hồi

        return [
            'serial_number' => strtoupper($this->faker->bothify('SN-####-???')),
            'category' => $this->faker->randomElement($categories),
            'location' => $this->faker->randomElement($locations),
            'condition' => $this->faker->randomElement($conditions),
            'status' => $this->faker->randomElement($statuses),
            'description' => $this->faker->sentence(8),
            'exported_at' => $exported ? $this->faker->dateTimeBetween('-1 year', 'now') : null,
            'recalled_at' => $recalled ? $this->faker->dateTimeBetween('-6 months', 'now') : null,
        ];
    }
}
