<?php

namespace App\Http\Livewire\Features\Stats;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class StatStockVariationLivewire extends Component
{
    protected $listeners = ['routeRefreshCall' => '$refresh']; // alias refresh nội bộ của livewire
    public function render()
    {
        return view('livewire.features.stats.stock-variation', [
            'componentLogs' => $this->componentLogs()
        ]);
    }
    public function componentLogs()
    {
        return DB::table('component_logs')
            ->select(
                DB::raw("YEAR(created_at) as year"),
                DB::raw("MONTH(created_at) as month"),
                DB::raw("COUNT(*) as total"),
                DB::raw("SUM(CASE WHEN action_id = '15' THEN 1 ELSE 0 END) as nhap_kho"),
                DB::raw("SUM(CASE WHEN action_id = '39' THEN 1 ELSE 0 END) as thu_hoi"),
                DB::raw("SUM(CASE WHEN action_id BETWEEN 31 AND 38 THEN 1 ELSE 0 END) as xuat_kho"),
            )
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get()
            ->map(function ($item) {
                $ton_kho = $item->nhap_kho - $item->xuat_kho + $item->thu_hoi;  // Tính tồn kho

                return [
                    'year' => $item->year,
                    'month' => $item->month,
                    'date' => sprintf('%d-%02d-01', $item->year, $item->month),
                    'total' => $item->total,     // Tổng số thao tác (dùng để định dạng biểu đồ)
                    'ton_kho' => $ton_kho,     // Thêm tồn kho tính được
                    'xuat_kho' => $item->xuat_kho,
                    'nhap_kho' => $item->nhap_kho,
                    'thu_hoi' => $item->thu_hoi,
                ];
            });
    }
}
