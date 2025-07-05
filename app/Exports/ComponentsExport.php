<?php

namespace App\Exports;

use App\Models\Component;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ComponentsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Component::all();
    }
    public function headings(): array
    {
        return Schema::getColumnListing('components');
    }
}
