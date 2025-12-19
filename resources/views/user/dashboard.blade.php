@extends('layouts.app-user')

@section('content')
<main class="pt-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h2 class="text-3xl font-extrabold text-gray-800 mb-8 border-b-2 pb-2">Dashboard Pengguna </h2>

    {{-- ======== Statistik Singkat ======== --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- Card Pesanan Dalam Proses -->
        <div class="bg-white rounded-xl shadow-lg p-6 flex items-center space-x-4 border-l-4 border-teal-600 hover:shadow-xl transition duration-300">
            <i class="fa-solid fa-truck fa-2xl text-teal-600"></i>
            <div>
                <h2 class="text-xl font-bold text-gray-800">{{ $stats['orders_in_process'] }}</h2>
                <p class="text-gray-500 text-sm">Pesanan Dalam Proses</p>
            </div>
        </div>

        <!-- Card Wishlist -->
        <div class="bg-white rounded-xl shadow-lg p-6 flex items-center space-x-4 border-l-4 border-pink-500 hover:shadow-xl transition duration-300">
            <i class="fa-solid fa-heart fa-2xl text-pink-500"></i>
            <div>
                <h2 class="text-xl font-bold text-gray-800">{{ $stats['wishlist_count'] }}</h2>
                <p class="text-gray-500 text-sm">Produk di Wishlist</p>
            </div>
            {{-- <a href="{{ route('wishlist.index') }}" class="text-xs text-pink-500 ml-auto hover:underline">Lihat Semua</a> --}}
        </div>

        <!-- Card Pesanan Selesai -->
        <div class="bg-white rounded-xl shadow-lg p-6 flex items-center space-x-4 border-l-4 border-green-500 hover:shadow-xl transition duration-300">
            <i class="fa-solid fa-square-check fa-2xl text-green-600"></i>
            <div>
                <h2 class="text-xl font-bold text-gray-800">{{ $stats['orders_completed'] }}</h2>
                <p class="text-gray-500 text-sm">Pesanan Selesai</p>
            </div>
          
        </div>
    </div>

    {{-- ======== Riwayat Pesanan Terbaru ======== --}}
    <div class="mt-10 bg-white rounded-xl shadow-lg p-6">
        <div class="flex justify-between items-center mb-4">
             <h3 class="text-2xl font-semibold text-gray-800">Riwayat Pesanan Terbaru</h3>
             <a href="{{ route('orders.index') }}" class="text-sm font-medium text-teal-600 hover:text-teal-800">Lihat Semua Riwayat</a>
        </div>

        <div class="overflow-x-auto border border-gray-100 rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                       <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($recentOrders as $index => $order)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $index + 1 }}</td>
                            
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusClass = [
                                        'menunggu_pembayaran' => 'bg-yellow-100 text-yellow-800',
                                        'dibayar' => 'bg-blue-100 text-blue-800',
                                        'diproses' => 'bg-indigo-100 text-indigo-800',
                                        'selesai' => 'bg-green-100 text-green-800',
                                        'dibatalkan' => 'bg-red-100 text-red-800',
                                    ][$order->status_pembayaran] ?? 'bg-gray-100 text-gray-800';
                                    
                                    $statusLabel = [
                                        'menunggu_pembayaran' => 'Belum Bayar', 
                                        'dibayar' => 'Sudah Bayar',
                                        'diproses' => 'Diproses',
                                        'selesai' => 'Selesai', 
                                        'dibatalkan' => 'Dibatalkan', 
                                    ][$order->status_pembayaran] ?? 'Tidak Dikenal';
                                @endphp
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                    {{ $statusLabel }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $order->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-teal-600">
                                Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('orders.show', $order->id) }}" class="text-teal-600 hover:text-teal-900 font-semibold">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500 italic">
                                Belum ada riwayat pesanan terbaru.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>
@endsection