<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderAdminController extends Controller
{
    /**
     * Tampilkan semua pesanan (tanpa filter) dengan pagination
     */
    public function index()
    {
        $orders = Order::with(['product', 'user'])

            ->where('status_pesanan', '!=', 'menunggu_konfirmasi',)
            ->where('status_pembayaran', 'dibayar')     // hanya pesanan yang sudah dibayar
            ->orderBy('tanggal_pengiriman', 'asc')
            ->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    public function indexKonfirmasi()
    {
        // // Ambil semua data pesanan + relasi user & product
        // $orders = Order::with(['product', 'user'])
        //     ->orderByDesc('created_at')
        //     ->paginate(10); // tampilkan 10 data per halaman

        // return view('admin.orders.index', compact('orders'));
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
