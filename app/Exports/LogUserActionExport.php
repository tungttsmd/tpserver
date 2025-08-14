<?php

namespace App\Exports;

use App\Models\LogUserAction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LogUserActionExport implements FromCollection, WithMapping, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return LogUserAction::with(['user', 'action'])->select('id', 'user_id', 'action_id', 'note', 'updated_at', 'created_at')->get();
    }
    public function headings(): array
    {
        return ['Id', 'Tài khoản', 'Tên người thực hiện', 'Hành động', 'Ghi chú', 'Cập nhật', 'Ngày tạo'];
    }
    public function map($row): array
    {
        return [
            $row->id,
            $row->user->alias ?? '--',
            $row->user->username ?? '--',
            $row->action->name ?? '--',
            $row->note,
            $row->created_at ? $row->created_at->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i:s') : '',
            $row->updated_at ? $row->updated_at->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i:s') : '',
        ];
    }
}
