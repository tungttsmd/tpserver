<?php

namespace App\Http\Livewire\Features\Stats;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class StatIndexLivewire extends Component
{
    public function render()
    {
        $components = $this->components(); // Hàm bạn vừa viết ở trên
        $categories = DB::table('categories')->pluck('name', 'id'); // Lấy tên category
        return view('livewire.features.stats.index', [
            'components' => $components,
            'categories' => $categories,
        ]);
    }
    public function components()
    {
        $today = now()->toDateString();

        return DB::table('components')
            ->select(
                'category_id',
                DB::raw("YEAR(stockin_at) as year"),
                DB::raw("MONTH(stockin_at) as month"),
                DB::raw("COUNT(*) as total"),
                DB::raw("SUM(CASE WHEN status_id = 1 THEN 1 ELSE 0 END) as ton_kho"),
                DB::raw("SUM(CASE WHEN status_id = 2 THEN 1 ELSE 0 END) as da_xuat_kho"),
                DB::raw("SUM(CASE WHEN warranty_end >= '{$today}' THEN 1 ELSE 0 END) as con_bao_hanh"),
                DB::raw("SUM(CASE WHEN warranty_end < '{$today}' OR warranty_end IS NULL THEN 1 ELSE 0 END) as het_bao_hanh")
            )
            ->groupBy('category_id', 'year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'category_id'    => $item->category_id,
                    'year'           => $item->year,
                    'month'          => $item->month,
                    'date'           => sprintf('%d-%02d-01', $item->year, $item->month),
                    'total'          => $item->total,
                    'ton_kho'        => $item->ton_kho,
                    'da_xuat_kho'    => $item->da_xuat_kho,
                    'con_bao_hanh'   => $item->con_bao_hanh,
                    'het_bao_hanh'   => $item->het_bao_hanh,
                ];
            });
    }
}
