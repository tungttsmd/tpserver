<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class LogComponentSeeder extends Seeder
{
    public function run()
    {
        $notes = [
            'Thiết bị bị hỏng và cần thay thế',
            'Kiểm tra tồn kho thất bại',
            'Xuất kho cho khách hàng A',
            'Nhập lại vì lỗi giao hàng',
            'Thêm ghi chú nội bộ',
            'Thiết bị bị lỗi sau khi kiểm tra',
            'Thiết bị không đạt tiêu chuẩn vận hành',
            'Thiết bị đã hết hạn sử dụng',
            'Hàng hóa bị móp trong quá trình vận chuyển',
            'Xuất kho theo đơn hàng số #1023',
            'Xuất kho cho khách hàng B',
            'Xuất kho theo yêu cầu bộ phận kỹ thuật',
            'Xuất linh kiện cho phòng R&D',
            'Giao hàng sai mã sản phẩm, cần nhập lại',
            'Nhập kho do trả hàng từ khách',
            'Nhập lại sau khi bảo trì xong',
            'Kiểm kê kho định kỳ - ghi nhận sai lệch',
            'Xuất sai số lượng, cần kiểm tra lại',
            'Nhập tồn sau kiểm kê cuối tháng',
            'Thiết bị bị thiếu linh kiện',
            'Ghi nhận thiếu hàng trong đợt giao',
            'Tăng tồn kho thủ công sau điều chỉnh',
            'Giao thiếu cho khách hàng, cần bổ sung',
            'Hủy đơn hàng – trả thiết bị về kho',
            'Hủy giao dịch và thu hồi thiết bị',
            'Đổi thiết bị do lỗi sản xuất',
            'Điều chuyển nội bộ giữa kho A và B',
            'Tăng kho do trả hàng nhà cung cấp',
            'Xuất theo phiếu điều phối ngày 20/07',
            'Điều chỉnh tồn kho do nhập sai',
            'Ghi nhận hao hụt trong sản xuất',
            'Hàng không đạt yêu cầu, trả lại kho',
            'Thiết bị cần kiểm định lại',
            'Nhập do khách trả vì không sử dụng',
            'Thiết bị gãy chân cắm, cần thay mới',
            'Đã hết hạn bảo hành, đưa vào kho lỗi',
            'Xuất nhầm hàng, cần hoàn trả',
            'Nhập hàng mẫu để thử nghiệm',
            'Thiết bị không dùng được, cần thu hồi',
            'Nhập do thay đổi kế hoạch sản xuất',
            'Nhập do đổi model sản phẩm',
            'Xuất hàng thử nghiệm cho khách',
            'Kiểm tra hàng lỗi trước khi trả NCC',
            'Xuất theo phiếu xuất ngày 21/07/2025',
            'Điều chỉnh đơn giá và nhập lại',
            'Bổ sung hàng do sai sót ban đầu',
            'Ghi nhận hàng hư hỏng không sử dụng',
            'Thiết bị lỗi phần mềm, chờ xử lý',
            'Lỗi kỹ thuật trong quá trình test',
            'Nhập do yêu cầu của phòng QA',
            'Thiết bị không khởi động được',
            'Xuất theo yêu cầu bảo trì',
            'Nhập kho lại do giao nhầm khách',
            'Xuất theo dự án ABC',
            'Giao sai mã, đổi lại đúng hàng',
            'Hàng cần phân loại lại trước khi dùng',
            'Xuất cho công trình tại Bình Dương',
            'Nhập kho vì dự án bị hoãn',
            'Giao thiết bị mới thay thế cái cũ',
            'Thêm ghi chú cho đợt kiểm tra tháng 7',
            'Xuất cho phòng thử nghiệm sản phẩm',
            'Ghi chú bổ sung khi kiểm tra hàng',
            'Nhập hàng từ nhà cung cấp X',
            'Xuất tạm thiết bị cho demo khách hàng',
            'Thiết bị gặp sự cố điện tử',
            'Bảo trì định kỳ – xuất thiết bị',
            'Nhập do khách hàng không nhận hàng',
            'Tồn kho ảo – cần xác minh',
            'Xuất hàng gấp cho sự kiện',
            'Hủy phiếu xuất cũ và thay thế mới',
            'Nhập hàng không đủ số lượng',
            'Xuất thử nghiệm tính năng mới',
            'Hàng không đạt tiêu chuẩn kỹ thuật',
            'Thiết bị bị rò rỉ nguồn điện',
            'Trả lại do phát hiện lỗi ngoại quan',
            'Nhập lại do sai mã kho',
            'Thiết bị hỏng trong quá trình sử dụng',
            'Xuất phục vụ hội nghị khách hàng',
            'Nhập kho do hoàn đơn hàng',
            'Thiết bị không còn phù hợp tiêu chuẩn',
            'Giao hàng cho phòng sản xuất',
            'Giao hàng lỗi – yêu cầu đổi mới',
            'Ghi nhận điều chỉnh kho cuối quý',
            'Nhập hàng để kiểm tra thêm',
            'Nhập sau kiểm tra chất lượng bổ sung',
            'Xuất theo hợp đồng #56789',
            'Nhập hàng bảo hành từ khách',
            'Trả hàng không đạt chuẩn kỹ thuật',
            'Xuất do khách hàng yêu cầu test',
            'Thiết bị lỗi cảm biến',
            'Thiết bị thiếu phụ kiện',
            'Ghi chú về trạng thái thiết bị sau test',
            'Nhập hàng từ nguồn tạm thời',
            'Xuất hàng cho bộ phận đào tạo',
            'Thiết bị không tương thích phần mềm',
            'Thiết bị gặp lỗi cơ học',
            'Nhập kho do hoàn trả từ đại lý',
            'Điều chỉnh tồn kho do kiểm kê đột xuất',
            'Nhập vì lỗi đơn hàng trước',
            'Xuất để hủy do lỗi sản xuất',
        ];

        $faker = Faker::create();

        $data = [];

        for ($i = 0; $i < 50; $i++) { // tạo 50 bản ghi mẫu
            $actionId = $faker->numberBetween(0, 15);
            $userId = $faker->numberBetween(1, 13);
            $componentId = $faker->numberBetween(1, int2: 1000);
            $customerId = $faker->numberBetween(1, 300);
            $vendorId = $faker->numberBetween(1, 10);
            $locationId = $faker->numberBetween(1, 11);

            // note là số ngẫu nhiên, ví dụ 1-1000
            $note = $faker->randomElement($notes);

            $dateStockOut = null;

            if ($actionId === 4) {
                $dateStockOut = $faker->dateTimeBetween('-1 year', 'now');
            }

            $dateCreated = $faker->dateTimeBetween('-1 year', 'now');

            $data[] = [
                'user_id' => $userId,
                'customer_id' => $customerId,
                'component_id' => $componentId,
                'vendor_id' => $vendorId,
                'location_id' => $locationId,
                'action_id' => $actionId,
                'note' => $note,
                'stockout_at' => $dateStockOut,
                'created_at' => $dateCreated,
                'updated_at' => $dateCreated,
            ];
        }

        DB::table('log_components')->insert($data);
    }
}
