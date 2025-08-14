<?php

namespace App\Exports;

use App\Models\Vendor;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class VendorExport implements FromCollection, WithMapping, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Vendor::select('id', 'name', 'phone', 'email', 'address', 'logo_url', 'note', 'updated_at', 'created_at')->get();
    }
    public function headings(): array
    {
        return ['Id', 'Tên đối tác', 'Số điện thoại', 'Email', 'Địa chỉ', 'Logo url', 'Ghi chú', 'Cập nhật', 'Ngày tạo'];
    }
    public function map($row): array
    {
        return [
            $row->id,
            $row->name ?? '',
            $row->phone ?? '',
            $row->email ?? '',
            $row->address ?? '',
            $row->logo_url ?? '',
            $row->note,
            $row->updated_at ? $row->updated_at->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i:s') : '',
            $row->created_at ? $row->created_at->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i:s') : '',
        ];
    }
}
