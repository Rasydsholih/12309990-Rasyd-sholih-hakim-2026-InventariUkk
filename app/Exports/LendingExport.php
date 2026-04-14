<?php

namespace App\Exports;

// 1. PASTIKAN BARIS INI ADA UNTUK MEMANGGIL MODEL YANG BENAR
use App\Models\lendings; 
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class LendingExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // 2. PASTIKAN DI SINI MENGGUNAKAN 'lendings' (huruf kecil & pakai 's')
        return lendings::with('item')->get();
    }

    /**
     * Menentukan header / baris pertama pada Excel
     */
    public function headings(): array
    {
        return [
            'Item',
            'Total',
            'Name',
            'Ket.',
            'Date',
            'Return Date',
            'Edited By'
        ];
    }

    /**
     * Melakukan mapping data ke masing-masing kolom
     */
    public function map($lending): array
    {
        return [
            
            $lending->item ? $lending->item->name : '-', 
            
            $lending->total,
            $lending->name,
            $lending->keterangan,
            
            
            $lending->date ? Carbon::parse($lending->date)->format('M d, Y') : '-',
            
            
            $lending->returned && $lending->returned_date 
                ? Carbon::parse($lending->returned_date)->format('M d, Y') 
                : '-',
                
            $lending->edited_by,
        ];
    }
}