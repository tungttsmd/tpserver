<?php

namespace App\Exports;

use App\Models\Condition;
use Maatwebsite\Excel\Concerns\FromCollection;

class ConditionExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Condition::all();
    }
}
