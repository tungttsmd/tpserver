<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return User::select('id', 'alias', 'username', 'avatar_url', 'cover_url', 'updated_at', 'created_at')->get();
    }
    public function headings(): array
    {
        return ['Id', 'Tên tài khoản', 'Username', 'Avatar url', 'Cover url', 'Cập nhật', 'Ngày tạo'];
    }
}
