<?php

namespace App\Http\Livewire\Features\Exports;

use App\Exports\ComponentsExport;
use App\Exports\UserLogsExport;
use App\Exports\VendorsExport;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class ExportLivewire extends Component
{
    public function render()
    {
        return view('livewire.features.exports.index');
    }
    public function export($type)
    {
        switch ($type) {
            case 'vendors':
                return Excel::download(new VendorsExport, 'vendors.xlsx');
            case 'products':
                return Excel::download(new ComponentsExport, 'products.xlsx');
            case 'orders':
                return Excel::download(new UserLogsExport, 'orders.xlsx');
            default:
                abort(404); // hoặc return thông báo lỗi
        }
    }
}
