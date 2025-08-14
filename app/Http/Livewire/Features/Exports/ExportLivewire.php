<?php

namespace App\Http\Livewire\Features\Exports;

use App\Exports\ActionExport;
use App\Exports\CategoryExport;
use App\Exports\ComponentExport;
use App\Exports\ConditionExport;
use App\Exports\CustomerExport;
use App\Exports\LocationExport;
use App\Exports\LogComponentExport;
use App\Exports\LogUserActionExport;
use App\Exports\ManufacturerExport;
use App\Exports\RoleExport;
use App\Exports\StatusExport;
use App\Exports\UserExport;
use App\Exports\VendorExport;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class ExportLivewire extends Component
{
    public $fileType;
    public function render()
    {
        return view('livewire.features.exports.index');
    }
    public function export()
    {
        if ($this->fileType) {
            switch ($this->fileType) {

                case 'components':
                    return Excel::download(new ComponentExport, 'components.xlsx');
                case 'log_user_actions':
                    return Excel::download(new LogUserActionExport, 'log_user_actions.xlsx');
                case 'log_components':
                    return Excel::download(new LogComponentExport, 'log_components.xlsx');
                case 'vendors':
                    return Excel::download(new VendorExport, 'vendors.xlsx');
                case 'customers':
                    return Excel::download(new CustomerExport, 'customers.xlsx');
                case 'locations':
                    return Excel::download(new LocationExport, 'locations.xlsx');

                case 'categories':
                    return Excel::download(new CategoryExport, 'categories.xlsx');
                case 'manufacturers':
                    return Excel::download(new ManufacturerExport, 'manufacturers.xlsx');
                case 'statuses':
                    return Excel::download(new StatusExport, 'statuses.xlsx');
                case 'conditions':
                    return Excel::download(new ConditionExport, 'conditions.xlsx');
                case 'actions':
                    return Excel::download(new ActionExport, 'actions.xlsx');

                case 'users':
                    return Excel::download(new UserExport, 'users.xlsx');
                case 'roles':
                    return Excel::download(new RoleExport, 'roles.xlsx');

                default:
                    abort(404); // hoặc return thông báo lỗi
            }
        }
    }
}
