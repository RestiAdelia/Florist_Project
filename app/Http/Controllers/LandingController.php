<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $products = Product::with('category')->latest()->paginate(6);

        return view('landing', compact('categories', 'products'));
    }
public function filterProduk(Request $request)
{
    $categoryId = $request->get('category_id');

    $query = Product::with('category');

    if ($categoryId) {
        $query->where('category_id', $categoryId);
    }

    $products = $query->paginate(8); // atau sesuai jumlah per page

    // kalau request dari AJAX, kirim partial view saja
    if ($request->ajax()) {
        return view('profile.partials.product-list', compact('products'))->render();
    }

    // kalau bukan AJAX, tampilkan halaman utama (landing)
    $categories = Category::all();
    return view('landing', compact('products', 'categories'));
}



}
