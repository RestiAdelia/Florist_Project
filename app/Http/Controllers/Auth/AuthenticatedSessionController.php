<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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


    // $pendapatanBulanIni = Order::where('status_pembayaran', 'dibayar')
    //     ->where('status_pesanan', 'selesai')
    //     ->whereMonth('created_at', now()->month)
    //     ->whereYear('created_at', now()->year)
    //     ->sum('total_harga');

    return view('dashboard', compact(
        'totalProduk',
        'pesananBaru',
        // 'totalPelanggan',
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

        // 1. Ambil Statistik Pesanan
        $orders = Order::where('user_id', $userId)->get();

        $stats = [
            'orders_in_process' => $orders->whereIn('status_pembayaran', ['dibayar', 'diproses'])->count(),
            'orders_completed' => $orders->where('status_pembayaran', 'selesai')->count(),
            'wishlist_count' => 12, // Placeholder
        ];

        // 2. Ambil Riwayat Pesanan Terbaru
        $recentOrders = Order::where('user_id', $userId)
                              ->latest()
                              ->limit(5)
                              ->get();
        
        // --- FOKUS PERBAIKAN: PASTIKAN $stats DAN $recentOrders ADA DI SINI ---
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