<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    // Menampilkan semua kategori
    public function index()
    {
        $categories = Category::latest()->paginate(5); // tampilkan 10 per halaman
        return view('kategori.index', compact('categories'));
    }

    // Menampilkan form tambah kategori
    public function create()
    {
        return view('kategori.create');
    }

    // Menyimpan kategori baru
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

    // Menampilkan detail kategori
    public function show(Category $kategori)
    {
        return view('kategori.show', compact('kategori'));
    }

    // Menampilkan form edit kategori
    public function edit(Category $kategori)
    {
        return view('kategori.edit', compact('kategori'));
    }

    // Mengupdate data kategori
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

    // Menghapus kategori
    public function destroy(Category $kategori)
    {
        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
