<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActionLogSeeder extends Seeder
{
    public function run()
    {
        $userActions = [
            0 => ['name' => 'userLogin',             'note' => 'Người dùng đăng nhập hệ thống.'],
            1 => ['name' => 'userLogout',            'note' => 'Người dùng đăng xuất khỏi hệ thống.'],
            2 => ['name' => 'userUpdatePassword',   'note' => 'Người dùng cập nhật mật khẩu.'],
            3 => ['name' => 'userUpdateAlias',      'note' => 'Người dùng cập nhật bí danh (alias).'],
            4 => ['name' => 'userUpdateAvatar',     'note' => 'Người dùng cập nhật ảnh đại diện.'],
            5 => ['name' => 'userUpdateCover',      'note' => 'Người dùng cập nhật ảnh bìa.'],
            6 => ['name' => 'userUpdateRolePermission', 'note' => 'Người dùng cập nhật quyền hạn của vai trò.'],
            7 => ['name' => 'userChangeRole',       'note' => 'Người dùng thay đổi vai trò.'],
            8 => ['name' => 'userCreateNewRole',    'note' => 'Người dùng tạo vai trò mới.'],
            9 => ['name' => 'userDownloadComponentLog', 'note' => 'Người dùng tải về nhật ký linh kiện.'],
            10 => ['name' => 'userDownloadUserLog', 'note' => 'Người dùng tải về nhật ký người dùng.'],
            11 => ['name' => 'userDeleteUser',       'note' => 'Người dùng xóa một người dùng khác.'],
            12 => ['name' => 'userViewUser',         'note' => 'Người dùng xem thông tin người dùng khác.'],
            13 => ['name' => 'userAddNewUser',       'note' => 'Người dùng thêm mới một người dùng.'],
        ];

        $componentActions = [
            0 => ['name' => 'componentAddOrReceive',    'note' => 'Thêm mới hoặc nhập kho linh kiện.'],
            1 => ['name' => 'componentUpdateSerial',    'note' => 'Cập nhật số serial của linh kiện.'],
            2 => ['name' => 'componentDelete',          'note' => 'Xóa linh kiện do lỗi dữ liệu.'],
            3 => ['name' => 'componentIssue',           'note' => 'Xuất kho linh kiện.'],
            4 => ['name' => 'componentRecall',          'note' => 'Thu hồi linh kiện.'],
            5 => ['name' => 'componentView',            'note' => 'Xem thông tin linh kiện.'],
            6 => ['name' => 'componentScanQrView',      'note' => 'Quét mã QR để xem linh kiện.'],
            7 => ['name' => 'componentScanQrNotFound',  'note' => 'Quét mã QR không tìm thấy linh kiện.'],
            8 => ['name' => 'componentChangeName',      'note' => 'Thay đổi tên linh kiện.'],
            9 => ['name' => 'componentChangeLocation',  'note' => 'Thay đổi vị trí linh kiện.'],
            10 => ['name' => 'componentChangeCategory', 'note' => 'Thay đổi phân loại linh kiện.'],
            11 => ['name' => 'componentChangeCondition', 'note' => 'Thay đổi tình trạng linh kiện.'],
            12 => ['name' => 'componentChangeManufacturer', 'note' => 'Thay đổi nhà sản xuất linh kiện.'],
            13 => ['name' => 'componentChangeStatus',   'note' => 'Thay đổi trạng thái linh kiện.'],
            14 => ['name' => 'componentChangeWarrantyStart', 'note' => 'Thay đổi ngày bắt đầu bảo hành.'],
            15 => ['name' => 'componentChangeWarrantyEnd',   'note' => 'Thay đổi ngày hết hạn bảo hành.'],
        ];

        $data = [];

        foreach ($userActions as $id => $info) {
            $data[] = [
                'action_id' => $id,
                'target' => 'user',
                'name' => $info['name'],
                'note' => $info['note'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        foreach ($componentActions as $id => $info) {
            $data[] = [
                'action_id' => $id,
                'target' => 'component',
                'name' => $info['name'],
                'note' => $info['note'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        DB::table(table: 'action_logs')->insert($data);
    }
}
