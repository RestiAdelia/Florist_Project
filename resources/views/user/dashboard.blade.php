{{-- resources/views/user/dashboard.blade.php --}}
@extends('layouts.app-user')

@section('content')
<main class="pt-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-bold mb-6">Dashboard</h1>

    {{-- ======== Statistik Singkat ======== --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Card Pesanan -->
        <div class="bg-white rounded-lg shadow p-6 flex items-center space-x-4">
            <i class="fa-solid fa-truck fa-2xl text-teal-600"></i>
            <div>
                <h2 class="text-lg font-semibold">Pesanan</h2>
                <p class="text-gray-500">5 pesanan dalam proses</p>
            </div>
        </div>

        <!-- Card Wishlist -->
        <div class="bg-white rounded-lg shadow p-6 flex items-center space-x-4">
            <i class="fa-solid fa-heart fa-2xl text-pink-500"></i>
            <div>
                <h2 class="text-lg font-semibold">Wishlist</h2>
                <p class="text-gray-500">12 produk favorit</p>
            </div>
        </div>

        <!-- Card Keranjang -->
        <div class="bg-white rounded-lg shadow p-6 flex items-center space-x-4">
            <i class="fa-solid fa-cart-shopping fa-2xl text-yellow-500"></i>
            <div>
                <h2 class="text-lg font-semibold">Keranjang</h2>
                <p class="text-gray-500">3 item siap checkout</p>
            </div>
        </div>
    </div>

    <div class="mt-10 bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold mb-4">Riwayat Pesanan</h2>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">1</td>
                        <td class="px-6 py-4 whitespace-nowrap">Buket Mawar Merah</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-green-600 font-semibold">Selesai</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">2025-10-25</td>
                        <td class="px-6 py-4 whitespace-nowrap">Rp 150.000</td>
                    </tr>

                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">2</td>
                        <td class="px-6 py-4 whitespace-nowrap">Buket Lily Putih</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-yellow-600 font-semibold">Proses</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">2025-10-24</td>
                        <td class="px-6 py-4 whitespace-nowrap">Rp 200.000</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</main>
@endsection
