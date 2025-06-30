<?php

namespace App\Exports;

use App\Models\Component;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ComponentsExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Component::select('id', 'serial_number', 'category', 'condition', 'status', 'location', 'description', 'updated_at', 'created_at')->get();
    }
    public function headings(): array
    {
        return ['Id', 'Serial', 'Phân loại', 'Tình trạng', 'Trạng thái', 'Vị trí', 'Mô tả', 'Cập nhật', 'Ngày tạo'];
    }
}
