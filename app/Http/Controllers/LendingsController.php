<?php

namespace App\Http\Controllers;

use App\Models\lendings;
use Illuminate\Http\Request;
use App\Models\Item;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LendingExport;

class LendingsController extends Controller
{
    public function index()
    {
        $lendings = lendings::with('item:id,name')->get();
        return view('inventaris.staff.lendings.lendings', compact('lendings'));
    }

    public function create()
    {
        $items = Item::select('id', 'name', 'total')->where('total', '>', 0)->get();
        return view('inventaris.staff.lendings.add', compact('items'));
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'name'         => 'required|string|max:100',
            'item_id'      => 'required|array', 
            'item_id.*'    => 'required|exists:items,id', 
            'total'        => 'required|array', 
            'total.*'      => [
                'required',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) use ($request) {
                    $index = explode('.', $attribute)[1]; 
                    $itemId = $request->item_id[$index] ?? null;

                    if ($itemId) {
                        $item = \App\Models\Item::find($itemId);
                        if ($item && $value > $item->total) {
                            $fail("Gagal! Jumlah pinjam untuk barang {$item->name} melebihi stok yang tersedia ({$item->total}).");
                        }
                    }
                },
            ], 
            'keterangan'   => 'nullable|string|max:255',
        ], [
            'name.required'      => 'Nama peminjam harus diisi.',
            'name.max'           => 'Nama peminjam maksimal 100 karakter.',
            'item_id.*.required' => 'Pilih item terlebih dahulu pada semua form.',
            'item_id.*.exists'   => 'Item yang dipilih tidak valid.',
            'total.*.required'   => 'Jumlah barang harus diisi pada semua form.',
            'total.*.integer'    => 'Jumlah barang harus berupa angka.',
            'total.*.min'        => 'Jumlah barang minimal 1.',
        ]);

        $date = now();
        $edited_by = auth()->user()->name;

        foreach ($request->item_id as $key => $itemId) {
            lendings::create([
                'name'       => $request->name,
                'item_id'    => $itemId,
                'total'      => $request->total[$key],
                'keterangan' => $request->keterangan,
                'date'       => $date,
                'edited_by'  => $edited_by,
            ]);

        }

        return redirect()->route('lendings.index')->with('success', 'Data peminjaman berhasil disimpan.');
    }   


    public function markAsReturned($id)
    {
        $lending = lendings::findOrFail($id);
        
        $lending->update([
            'returned' => true,
            'returned_date' => now(), 
            // Kita biarkan 'edited_by' utuh seperti aslinya
            'penerima' => auth()->user()->name 
        ]);

        return redirect()->back()->with('success', 'Barang telah berhasil dikembalikan dan diterima oleh ' . auth()->user()->name);
    }

    public function show($lendings)
    {
        $item = \App\Models\Item::with('lendings')->findOrFail($lendings);
        return view('inventaris.staff.lendings.show', compact('item'));
    }



    public function destroy($lendings)
    {
        
        $lending = lendings::findOrFail($lendings);
        
        $lending->delete();
        
        return redirect()->route('lendings.index')->with('success', 'Data peminjaman berhasil dihapus.');
    }

    public function exportExcel()
    {
        return Excel::download(new LendingExport, 'Data_Peminjaman_'.date('Y-m-d').'.xlsx');
    }
}