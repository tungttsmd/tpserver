<?php

namespace App\Exports;

use App\Models\UserLog;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserLogsExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return UserLog::select('id', 'user', 'action', 'note', 'updated_at', 'created_at')->get();
    }
    public function headings(): array
    {
        return ['Id', 'Tài khoản', 'Hành động', 'Nội dung', 'Cập nhật', 'Ngày tạo'];
    }
}
