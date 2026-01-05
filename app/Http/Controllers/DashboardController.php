<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung total produk
        $totalProduk = Product::count();

        // Hitung pesanan baru (status = menunggu_konfirmasi)
        $pesananBaru = Order::where('status_pesanan', 'menunggu_konfirmasi')->count();

        // Hitung total pelanggan (role = user)
        $totalPelanggan = User::where('role', 'user')->count();

        // Hitung pendapatan bulan ini (ambil yg status = selesai)
        $pendapatanBulanIni = Order::where('status_pembayaran', 'dibayar')
            ->where('status_pesanan', 'selesai')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total_harga');

        return view('admin.dashboard', compact(
            'totalProduk',
            'pesananBaru',
            'totalPelanggan',
            'pendapatanBulanIni'
            
        ));
    }
}
