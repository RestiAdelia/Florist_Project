<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf; 


class ReportController extends Controller
{
    // public function index(Request $request)
    // {
        
    //     $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
    //     $endDate = $request->input('end_date', Carbon::now()->toDateString());

        
    //     $query = Order::with(['user', 'product']) 
    //         ->where('status_pembayaran', 'dibayar')
    //         ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);

       
    //     $orders = $query->latest()->get();

       
    //     $totalPendapatan = $query->sum('total_harga');
    //     $totalPesanan = $query->count();
    //     $totalPelanggan = $query->distinct('user_id')->count('user_id');
    //     $orders = $query->latest()->paginate(4)->withQueryString(); 

    //     return view('admin.laporan.index', compact(
    //         'orders',
    //         'totalPendapatan',
    //         'totalPesanan',
    //         'totalPelanggan',
    //         'startDate',
    //         'endDate'
    //     ));
    // }
     public function index(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->toDateString());

        // Query Dasar
        $query = Order::with(['user', 'product']) 
            ->where('status_pembayaran', 'dibayar')
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);

        // --- BAGIAN PENTING ---
        // Ganti ->get() menjadi ->paginate(4)
        // ->withQueryString() agar saat pindah halaman, filter tanggal tidak hilang
        $orders = $query->latest()->paginate(4)->withQueryString();

        // Hitung total untuk statistik (gunakan query terpisah agar tidak terpengaruh paginate)
        // Kita clone query agar tidak merusak variabel $query utama
        $statQuery = clone $query; 
        // Atau buat query baru jika clone bermasalah, tapi cara di bawah lebih aman:
        $totalPendapatan = Order::where('status_pembayaran', 'dibayar')
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->sum('total_harga');

        $totalPesanan = $orders->total(); // Mengambil total dari paginator
        // Untuk distinct user, kita buat query manual
        $totalPelanggan = Order::where('status_pembayaran', 'dibayar')
             ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
             ->distinct('user_id')
             ->count('user_id');

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
