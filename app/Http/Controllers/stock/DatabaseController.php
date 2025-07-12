<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DatabaseController extends Controller
{
    public function checkDatabaseConnection()
    {
        try {
            // Kiểm tra kết nối cơ sở dữ liệu
            DB::connection()->getPdo();
            return "Kết nối cơ sở dữ liệu thành công!";
        } catch (\Exception $e) {
            return "Không thể kết nối tới cơ sở dữ liệu. Lỗi: " . $e->getMessage();
        }
    }
}
