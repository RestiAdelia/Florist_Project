<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf; 


class ReportController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil input tanggal dari filter (default: bulan ini)
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->toDateString());

        // 2. Query data dengan filter
        $query = Order::with(['user', 'product']) // Eager loading agar tidak berat
            ->where('status_pembayaran', 'dibayar')
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);

        // 3. Ambil data untuk tabel
        $orders = $query->latest()->get();

        // 4. Hitung ringkasan statistik
        $totalPendapatan = $query->sum('total_harga');
        $totalPesanan = $query->count();
        $totalPelanggan = $query->distinct('user_id')->count('user_id');

        return view('admin.laporan.index', compact(
            'orders',
            'totalPendapatan',
            'totalPesanan',
            'totalPelanggan',
            'startDate',
            'endDate'
        ));
    }
   
    public function exportPdf(Request $request)
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $orders = Order::with(['user', 'product'])
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->where('status_pembayaran', 'dibayar')
            ->get();

        $totalPendapatan = $orders->sum('total_harga');

        // Load view khusus PDF
        $pdf = Pdf::loadView('admin.laporan.pdf', compact('orders', 'totalPendapatan', 'startDate', 'endDate'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('Laporan-Penjualan-Aurora.pdf');
    }
}
