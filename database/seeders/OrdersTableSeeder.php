<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Order::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Get all customer IDs
        $customerIds = Customer::pluck('id')->toArray();

        if (empty($customerIds)) {
            $this->command->info('No customers found. Please seed customers first.');
            return;
        }

        $statuses = ['pending', 'processing', 'completed', 'cancelled'];
        $orders = [];
        $now = now();

        // Create 50 sample orders
        for ($i = 0; $i < 50; $i++) {
            $orderDate = now()->subDays(rand(1, 90));
            $status = $statuses[array_rand($statuses)];
            
            $orders[] = [
                'customer_id' => $customerIds[array_rand($customerIds)],
                'order_number' => 'ORD' . str_pad($i + 1, 5, '0', STR_PAD_LEFT),
                'order_date' => $orderDate,
                'status' => $status,
                'total_amount' => rand(100000, 10000000) / 100, // Random amount between 1,000.00 and 100,000.00
                'notes' => $this->getRandomNotes($status),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // Insert orders in chunks
        foreach (array_chunk($orders, 50) as $chunk) {
            Order::insert($chunk);
        }
    }

    /**
     * Get random notes based on order status
     */
    private function getRandomNotes(string $status): ?string
    {
        $notes = [
            'pending' => [
                'Chờ xác nhận',
                'Đơn hàng mới, chưa xử lý',
                'Đang chờ kiểm tra kho',
            ],
            'processing' => [
                'Đang đóng gói',
                'Đang giao cho đơn vị vận chuyển',
                'Đang xử lý thanh toán',
            ],
            'completed' => [
                'Đã giao hàng thành công',
                'Khách đã nhận hàng',
                'Hoàn tất đơn hàng',
            ],
            'cancelled' => [
                'Khách hủy đơn',
                'Hết hàng',
                'Không liên lạc được với khách',
            ],
        ];

        return $notes[$status][array_rand($notes[$status])] ?? null;
    }
}
