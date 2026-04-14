<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\categories;
use Illuminate\Http\Request;
use App\Exports\ItemsExport;
use Maatwebsite\Excel\Facades\Excel;

class ItemsController extends Controller
{
    
    public function index()
    {
        $user = auth()->user();

        $items = \App\Models\Item::with([
            'category',
        ])

        ->get();

        if ($user->role == 'admin') {
            return view('inventaris.admin.items.items', compact('items'));
        } else {
            return view('inventaris.staff.items.items', compact('items'));
        }
    }

    
    public function create()
    {
        $categories = categories::select('id', 'name')->get();
        return view('inventaris.admin.items.add', compact('categories'));
    }

    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:100',
            'total' => 'required|integer|min:0',
        ], [
            'category_id.required' => 'Pilih kategori terlebih dahulu.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'name.required' => 'Nama item harus diisi.',
            'name.max' => 'Nama item maksimal 100 karakter.',
            'total.required' => 'Jumlah total harus diisi.',
            'total.integer' => 'Jumlah total harus berupa angka.',
            'total.min' => 'Jumlah total minimal 0.',
        ]);

        Item::create($validated);
        categories::findOrFail($validated['category_id'])->increment('total_items');

        return redirect()->route('items.index')->with('success', 'Item created successfully.');
    }

    
    public function show(Item $item)
    {
        $item->load(['category:id,name']);
        return view('inventaris.admin.items.show', compact('item'));
    }


    public function edit(Item $item)
    {
        $categories = categories::select('id', 'name')->get();
        return view('inventaris.admin.items.update', compact('item', 'categories'));
    }

    

    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:100',
            'total' => 'required|integer|min:0',
            'repair' => 'required|integer|min:0|lte:total',
        ], [
            'category_id.required' => 'Pilih kategori terlebih dahulu.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'name.required' => 'Nama item harus diisi.',
            'name.max' => 'Nama item maksimal 100 karakter.',
            'total.required' => 'Jumlah total harus diisi.',
            'total.integer' => 'Jumlah total harus berupa angka.',
            'total.min' => 'Jumlah total minimal 0.',
            'repair.lte' => 'Jumlah repair tidak boleh lebih dari total items.',
        ]);

        if ($item->category_id !== $validated['category_id']) {
            categories::find($item->category_id)?->decrement('total_items');
            categories::findOrFail($validated['category_id'])->increment('total_items');
        }

        $item->update($validated);

        return redirect()->route('items.index')->with('success', 'Item updated successfully.');
    }

    

    public function destroy(Item $item)
    {
        categories::find($item->category_id)?->decrement('total_items');
        $item->delete();

        return redirect()->route('items.index')->with('success', 'Item deleted successfully.');
    }

    public function exportExcel()
    {
        return Excel::download(new ItemsExport, 'Data_Items_'.date('Y-m-d').'.xlsx');
    }

    
}