<?php

namespace App\Exports;

use App\Models\Component;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ComponentExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Component::with(['category', 'status'])->select(
            'id',
            'serial_number',
            'name',
            'category_id',
            'status_id',
            'stockin_source',
            'stockin_at',
            'warranty_start',
            'warranty_end',
            'note',
            'updated_at',
            'created_at'
        )->get();
    }
    public function headings(): array
    {
        return ['Id', 'Serial number', 'Tên linh kiện', 'Phân loại', 'Trạng thái', 'Nội dung', 'Nguồn nhập', 'Ngày nhập', 'Bắt đầu bảo hành', 'Kết thúc bảo hành', 'Cập nhật', 'Ngày tạo'];
    }
    public function map($row): array
    {
        return [
            $row->id,
            $row->serial_number,
            $row->name ?? '--',
            $row->category->name ?? '--',
            $row->status->name ?? '--',
            $row->note,
            $row->stockin_source,
            $row->stockin_at ? $row->stockin_at->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i:s') : '',
            $row->warranty_start ? $row->warranty_start->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i:s') : '',
            $row->warranty_end ? $row->warranty_end->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i:s') : '',
            $row->updated_at ? $row->updated_at->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i:s') : '',
            $row->created_at ? $row->created_at->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i:s') : '',
        ];
    }
}
