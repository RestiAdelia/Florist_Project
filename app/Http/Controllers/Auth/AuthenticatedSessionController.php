<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user(); // pakai Facade

        if ($user->role === 'admin') {
            return redirect()->route('dashboard');
        }
        return redirect()->route('user.dashboard');
    }
    public function adminDashboard()
    {
        $totalProduk = Product::count();

        $pesananBaru = Order::where('status_pesanan', 'menunggu_konfirmasi')->count();

        // Sesuaikan role pelanggan jika berbeda
        // $totalPelanggan = User::where('role', 'user')->count();
        $totalOrderSelesai = Order::where('status_pesanan', 'selesai')->count();

        $pendapatanBulanIni = Order::where('status_pembayaran', 'dibayar')
            ->where('status_pesanan', 'selesai')
            ->whereMonth('updated_at', now()->month)
            ->whereYear('updated_at', now()->year)
            ->sum('total_harga');

        $startDate = Carbon::today();
        $endDate   = Carbon::today()->addDays(7);

        // $urgentOrders = Order::with('product')
        //     ->whereBetween('tanggal_pengiriman', [$startDate, $endDate])
        //     ->whereNotIn('status_pesanan', ['selesai', 'dibatalkan'])
        //     ->orderBy('tanggal_pengiriman', 'asc')
        //     ->get();
        $urgentOrders = Order::with('product')
            ->whereBetween('tanggal_pengiriman', [$startDate, $endDate])
            ->whereNotIn('status_pesanan', ['selesai', 'dibatalkan'])
            ->orderBy('tanggal_pengiriman', 'asc')
            ->paginate(4, ['*'], 'urgent_page');


        return view('dashboard', compact(
            'totalProduk',
            'pesananBaru',
            'urgentOrders',
            'pendapatanBulanIni',
            'totalOrderSelesai'
        ));
    }

    /**
     * User dashboard
     */
   
   
    public function userDashboard()
    {
        $userId = Auth::id();

        // 1. Ambil Semua Pesanan User (sebagai Collection)
        // Kita ambil semua dulu agar bisa dihitung statusnya tanpa query berulang ke DB
        $orders = Order::where('user_id', $userId)->get();

        $stats = [
            // Menghitung dari collection yang sudah diambil di atas
            'orders_in_process' => $orders->whereIn('status_pembayaran', ['dibayar', 'diproses', 'dikirim'])->count(),

            // Pastikan value 'selesai' ini ada di kolom status_pembayaran atau status_pesanan di database Anda
            'orders_completed'  => $orders->where('status_pembayaran', 'selesai')->count(),

            // PERBAIKAN: Hapus koma ganda (,,) menjadi satu koma (,)
            'orders_count'      => $orders->count(),
        ];

        // 2. Ambil Riwayat Pesanan Terbaru
        // Tambahkan with('product') agar query lebih ringan saat meload nama produk di view
        $recentOrders = Order::with('product')
            ->where('user_id', $userId)
            ->latest()
            ->limit(5)
            ->get();

        return view('user.dashboard', compact('stats', 'recentOrders'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
