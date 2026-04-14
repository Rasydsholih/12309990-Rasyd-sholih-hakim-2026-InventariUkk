<?php

namespace App\Exports;

use App\Models\categories;
use Maatwebsite\Excel\Concerns\FromCollection;

class CategoriesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return categories::all();
    }


    public function headings(): array
    {
        return [
            'ID',
            'Nama Kategori',
            'Divisi',
            'Total Item',
            'Created At',
            'Updated At',
        ];
    }
}
