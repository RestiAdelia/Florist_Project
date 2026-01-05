<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderAdminController extends Controller
{
   
    public function index(Request $request)
    {
        // 1. Ambil kata kunci pencarian
        $search = $request->input('search');

        // 2. Query Dasar (Filter Wajib Anda)
        $query = Order::with(['product', 'user'])
            ->where('status_pesanan', '!=', 'menunggu_konfirmasi')
            ->where('status_pembayaran', 'dibayar');

        // 3. Logika Pencarian (Jika ada input search)
        $query->when($search, function ($q) use ($search) {
            $q->where(function ($subQuery) use ($search) {
                // Cari berdasarkan Nama User
                $subQuery->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%");
                })
                // ATAU Cari berdasarkan Nama Produk
                ->orWhereHas('product', function ($prodQuery) use ($search) {
                    $prodQuery->where('nama', 'like', "%{$search}%");
                })
                // ATAU Cari berdasarkan Jenis Ucapan / No Telepon
                ->orWhere('jenis_ucapan', 'like', "%{$search}%")
                ->orWhere('no_telepon', 'like', "%{$search}%");
            });
        });

        // 4. Urutkan dan Paginate
        $orders = $query->orderBy('tanggal_pengiriman', 'asc')
            ->paginate(5)     
            ->withQueryString(); 

        return view('admin.orders.index', compact('orders'));
    }   

    public function indexKonfirmasi()
    {
       
        $orders = Order::where('status_pesanan', '!=', 'selesai')
            ->latest()
            ->get();

        return view('admin.confirmasi.index', compact('orders'));
    }

    /**
     * Update status pesanan (konfirmasi admin)
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status_pesanan' => 'required',
        ]);

        $order->update([
            'status_pesanan' => $request->status_pesanan
        ]);

        return back()->with('success', 'Status pesanan berhasil diperbarui!');
    }

    public function show($id)
    {
        $order = Order::with(['product', 'user'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }
}
