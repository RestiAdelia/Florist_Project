@extends('layouts.app-user')

@section('content')
<main class="pt-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 min-h-screen">
    <div class="flex items-center justify-between mb-8 border-b-2 border-gray-100 pb-4">
        <div>
            <h2 class="text-3xl font-extrabold text-gray-800">Dashboard Pengguna</h2>
            <p class="text-sm text-gray-500 mt-1">Selamat datang kembali, {{ Auth::user()->name }}!</p>
        </div>
        <span class="text-xs font-medium bg-gray-100 text-gray-600 px-3 py-1 rounded-full">
            {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
        </span>
    </div>

    {{-- ======== Statistik Singkat ======== --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        
        <!-- Card 1: Pesanan Dalam Proses -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center space-x-4 border-l-4 border-teal-500 hover:shadow-md transition duration-300">
            <div class="p-3 bg-teal-50 rounded-full text-teal-600">
                <i class="fa-solid fa-truck-fast fa-xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-800">{{ $stats['orders_in_process'] }}</h2>
                <p class="text-gray-500 text-xs font-semibold uppercase tracking-wide">Sedang Diproses</p>
            </div>
        </div>

        <!-- Card 2: Total Pesanan (Diganti dari Wishlist agar sesuai Controller) -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center space-x-4 border-l-4 border-blue-500 hover:shadow-md transition duration-300">
            <div class="p-3 bg-blue-50 rounded-full text-blue-600">
                <i class="fa-solid fa-shopping-bag fa-xl"></i>
            </div>
            <div>
                {{-- Menggunakan 'orders_count' dari Controller --}}
                <h2 class="text-2xl font-bold text-gray-800">{{ $stats['orders_count'] ?? 0 }}</h2>
                <p class="text-gray-500 text-xs font-semibold uppercase tracking-wide">Total Semua Pesanan</p>
            </div>
        </div>

        <!-- Card 3: Pesanan Selesai -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center space-x-4 border-l-4 border-green-500 hover:shadow-md transition duration-300">
            <div class="p-3 bg-green-50 rounded-full text-green-600">
                <i class="fa-solid fa-circle-check fa-xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-800">{{ $stats['orders_completed'] }}</h2>
                <p class="text-gray-500 text-xs font-semibold uppercase tracking-wide">Pesanan Selesai</p>
            </div>
        </div>
    </div>

    {{-- ======== Riwayat Pesanan Terbaru ======== --}}
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4">
             <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                <i class="fa-regular fa-clock text-gray-400"></i> Riwayat Pesanan Terbaru
             </h3>
             <a href="{{ route('orders.index') }}" class="text-sm font-semibold text-teal-600 hover:text-teal-800 flex items-center gap-1 transition">
                Lihat Semua
                <i class="fa-solid fa-arrow-right text-xs"></i>
             </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Produk</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($recentOrders as $order)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            {{-- ID Pesanan --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                #{{ $order->id }}
                            </td>

                            {{-- Nama Produk (Tampilkan karena sudah di-load di controller) --}}
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 font-medium line-clamp-1 max-w-[200px]" title="{{ $order->product->nama ?? '' }}">
                                    {{ $order->product->nama ?? 'Produk dihapus' }}
                                </div>
                            </td>
                            
                            {{-- Tanggal --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $order->created_at->translatedFormat('d M Y') }}
                            </td>

                            {{-- Status Badge --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $status = strtolower($order->status_pembayaran ?? $order->status_pesanan);
                                    $badgeClass = match($status) {
                                        'menunggu_pembayaran', 'menunggu_konfirmasi' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                        'dibayar' => 'bg-blue-100 text-blue-800 border-blue-200',
                                        'diproses', 'dikirim' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
                                        'selesai', 'diterima' => 'bg-green-100 text-green-800 border-green-200',
                                        'dibatalkan' => 'bg-red-100 text-red-800 border-red-200',
                                        default => 'bg-gray-100 text-gray-800 border-gray-200'
                                    };
                                @endphp
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full border {{ $badgeClass }}">
                                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                                </span>
                            </td>

                            {{-- Total Harga --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-700">
                                Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                            </td>

                            {{-- Tombol Aksi --}}
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <a href="{{ route('orders.show', $order->id) }}" class="inline-flex items-center justify-center px-3 py-1.5 border border-teal-600 text-teal-600 rounded-lg hover:bg-teal-600 hover:text-white transition duration-200 text-xs font-bold">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-500">
                                    <i class="fa-solid fa-box-open fa-3x mb-3 text-gray-300"></i>
                                    <p class="text-sm font-medium">Belum ada riwayat pesanan.</p>
                                    <a href="{{ route('shop') }}" class="mt-2 text-teal-600 hover:underline text-xs">Mulai Belanja</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>
@endsection