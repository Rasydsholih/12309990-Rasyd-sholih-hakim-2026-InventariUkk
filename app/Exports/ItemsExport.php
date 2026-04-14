<?php

namespace App\Exports;

use App\Models\Item;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ItemsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Item::with(['category:id,name'])->get();
    }

    public function headings(): array
    {
        return [
            'Kategori',
            'Nama Item',
            'Total Item',
            'Total Repair',
            'Last Update',
        ];
    }


    public function map($item): array
    {
        return [
            $item->category ? $item->category->name : 'N/A',
            $item->name,
            $item->total,
            $item->repair,                                  
            $item->updated_at ? $item->updated_at->format('Y-m-d H:i:s') : 'N/A',
        ];
    }
}