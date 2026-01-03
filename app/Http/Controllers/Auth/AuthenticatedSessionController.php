<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request)
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = $request->user();

        if ($user->email === 'admin@gmail.com') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('dashboard');
    }


    public function adminDashboard()
    {
        return view('dashboard', [
            'totalProduk' => Product::count(),
            'pesananBaru' => Order::where('status_pesanan', 'menunggu_konfirmasi')->count(),
            'totalOrderSelesai' => Order::where('status_pesanan', 'selesai')->count(),
            'pendapatanBulanIni' => Order::where('status_pembayaran', 'dibayar')
                ->where('status_pesanan', 'selesai')
                ->whereMonth('updated_at', now()->month)
                ->whereYear('updated_at', now()->year)
                ->sum('total_harga'),
        ]);
    }

    public function userDashboard()
    {
        $userId = Auth::id();

        $orders = Order::where('user_id', $userId)->get();

        return view('user.dashboard', [
            'stats' => [
                'orders_in_process' => $orders->whereIn('status_pembayaran', ['dibayar', 'diproses'])->count(),
                'orders_completed' => $orders->where('status_pembayaran', 'selesai')->count(),
                'wishlist_count' => 0,
            ],
            'recentOrders' => Order::where('user_id', $userId)->latest()->limit(5)->get(),
        ]);
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
