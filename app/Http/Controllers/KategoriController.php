<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    
    public function index(Request $request)
    {  $query = \App\Models\Category::query();
    if ($request->has('search') && $request->search != '') {
        $query->where('nama', 'like', '%' . $request->search . '%')
              ->orWhere('deskripsi', 'like', '%' . $request->search . '%');
    }
    $categories = $query->orderBy('created_at', 'desc')->paginate(5);
    $categories->appends(['search' => $request->search]);
    return view('kategori.index', compact('categories'));
    }


    public function create()
    {
        return view('kategori.create');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|unique:categories,nama|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        Category::create([
            'nama' => $validated['nama'],
            'deskripsi' => $validated['deskripsi'] ?? null,
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
    }
    public function show(Category $kategori)
    {
        return view('kategori.show', compact('kategori'));
    }

    public function edit(Category $kategori)
    {
        return view('kategori.edit', compact('kategori'));
    }
    public function update(Request $request, Category $kategori)
    {
        $validated = $request->validate([
            'nama' => 'required|max:255|unique:categories,nama,' . $kategori->id,
            'deskripsi' => 'nullable|string',
        ]);

        $kategori->update([
            'nama' => $validated['nama'],
            'deskripsi' => $validated['deskripsi'] ?? null,
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diupdate!');
    }
    public function destroy(Category $kategori)
    {
        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
