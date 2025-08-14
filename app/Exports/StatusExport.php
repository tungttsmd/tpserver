<?php

namespace App\Exports;

use App\Models\Status;
use Maatwebsite\Excel\Concerns\FromCollection;

class StatusExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Status::all();
    }
}
