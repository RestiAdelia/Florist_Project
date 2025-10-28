<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');
        if ($request->has('search') && $request->search != '') {
            $query->where('nama', 'like', '%' . $request->search . '%')
                ->orWhere('deskripsi', 'like', '%' . $request->search . '%');
        }
        $products = $query->orderBy('created_at', 'desc')->paginate(10);
        $products->appends(['search' => $request->search]);

        return view('produk.index', compact('products'));
    }
    public function create()
    {
        $categories = Category::all();
        $stokOptions = ['tersedia', 'habis'];
        return view('produk.create', compact('categories', 'stokOptions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|in:tersedia,habis',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('produk', 'public');
        }
        Product::create([
            'category_id' => $request->category_id,
            'nama' => $request->nama,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'deskripsi' => $request->deskripsi,
            'gambar' => $gambarPath,
        ]);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Product $produk)
    {
        $categories = Category::all();
        $stokOptions = ['tersedia', 'habis'];
        return view('produk.edit', compact('produk', 'categories', 'stokOptions'));
    }
    public function update(Request $request, Product $produk)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|in:tersedia,habis',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        if ($request->hasFile('gambar')) {
            if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
                Storage::disk('public')->delete($produk->gambar);
            }
            $produk->gambar = $request->file('gambar')->store('produk', 'public');
        }

        $produk->update([
            'category_id' => $request->category_id,
            'nama' => $request->nama,
            'harga' => $request->harga,
            'jenis' => $request->jenis,
            'stok' => $request->stok,
            'deskripsi' => $request->deskripsi,
            'gambar' => $produk->gambar,
        ]);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui!');
    }
    public function show($id)
    {
        // Ambil data produk beserta relasi kategori
        $produk = Product::with('category')->findOrFail($id);

        // Jika ingin halaman khusus untuk detail produk:
        return view('produk.show', compact('produk'));
    }
    public function katalog(Request $request)
    {
        $kategoriId = $request->query('kategori'); // ambil dari query string ?kategori=1

        $categories = Category::all();

        $products = Product::when($kategoriId, function ($query, $kategoriId) {
            return $query->where('category_id', $kategoriId);
        })->get();

        return view('user.shop', compact('products', 'categories', 'kategoriId'));
    }


    public function destroy(Product $produk)
    {
        if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
            Storage::disk('public')->delete($produk->gambar);
        }

        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus!');
    }
}
