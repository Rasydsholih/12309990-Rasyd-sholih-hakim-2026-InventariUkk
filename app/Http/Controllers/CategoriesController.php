<?php

namespace App\Http\Controllers;

use App\Models\categories;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
    * Display a listing of the resource.
    */
    public function index()
    {
        $categories = categories::all();
        return view('inventaris.admin.categories.categories', compact('categories'));
    }

    /**
    * Show the form for creating a new resource.
    */
    public function create()
    {
        return view('inventaris.admin.categories.add');
    }

    /**
    * Store a newly created resource in storage.
    */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'division' => 'required|in:Sarpas,Tata Usaha,Tefa',
        ], [
            'name.required' => 'The category name field is required.',
            'name.max' => 'The category name field is required.',
            'division.required' => 'The division Pj field is required.',
            'division.in' => 'The selected division Pj is invalid.',
        ]);
        categories::create([
            'name' => $validated['name'],
            'division' => $validated['division'],
            'total_items' => 0,
        ]);
        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    /**
    * Display the specified resource.
    */
    public function show(categories $category)
    {
        return view('categories.show', compact('category'));
    }

    /**
    * Show the form for editing the specified resource.
    */
    public function edit(categories $category)
    {
        return view('inventaris.admin.categories.update', compact('category'));
    }

    /**
    * Update the specified resource in storage.
    */
    public function update(Request $request, categories $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'division' => 'required|in:Sarpas,Tata Usaha,Tefa',
        ], [
            'name.required' => 'Nama kategori harus diisi.',
            'name.max' => 'Nama kategori maksimal 100 karakter.',
            'division.required' => 'Pilih divisi terlebih dahulu.',
            'division.in' => 'Divisi yang dipilih tidak valid.',
        ]);

        $category->update([
            'name' => $validated['name'],
            'division' => $validated['division'],
            'total_items' => $category->total_items,
        ]);
        
        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    /**
    * Remove the specified resource from storage.
    */
    public function destroy(categories $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}