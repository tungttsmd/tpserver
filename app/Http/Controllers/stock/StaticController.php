<?php

namespace App\Http\Controllers;

use App\Models\Component;
use Illuminate\Http\Request;

class StaticController extends Controller
{
    public function index(Request $request)
    {
        $query = Component::query();

        // Lọc theo phân loại
        if ($category = $request->input('category')) {
            $query->where('category', $category);
        }

        // Lọc theo thời gian cập nhật
        if ($request->filled('start_date')) {
            $query->whereDate('updated_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('updated_at', '<=', $request->end_date);
        }

        $components = $query->get();

        // Dữ liệu cho biểu đồ / thống kê
        $totalComponents = $components->count();
        $inStock = $components->where('status', 'Sẵn kho')->count();
        $exported = $components->where('status', 'Xuất kho')->count();
        $categoryStats = $components->groupBy('category')->map->count();

        return view('admin.static.index', compact('totalComponents', 'inStock', 'exported', 'categoryStats'));
    }
}
