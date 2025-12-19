<x-app-layout>
     <x-slot:title>Dashboard</x-slot:title>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <h1 class="text-3xl font-bold text-gray-800 mb-6">Ringkasan Dashboard</h1>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">

                {{-- Total Produk --}}
                <div class="bg-white overflow-hidden shadow-lg rounded-lg p-6 flex items-center justify-between hover:shadow-xl hover:scale-[1.02] transition">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Produk</p>
                         <p class="text-4xl font-extrabold text-teal-600 mt-1">{{ $totalProduk }}</p>
                    </div>
                    <i class="bi bi-boxes text-4xl text-teal-400"></i>
                </div>

                {{-- Pesanan Baru --}}
                <div class="bg-white overflow-hidden shadow-lg rounded-lg p-6 flex items-center justify-between hover:shadow-xl hover:scale-[1.02] transition">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Belum Konfirmasi</p>
                        <p class="text-4xl font-extrabold text-emerald-600 mt-1">{{ $pesananBaru }}</p>
                    </div>
                    <i class="bi bi-cart-check-fill text-4xl text-emerald-400"></i>
                </div>

                {{-- Total Pelanggan --}}
                <div class="bg-white overflow-hidden shadow-lg rounded-lg p-6 flex items-center justify-between hover:shadow-xl hover:scale-[1.02] transition">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Order Selesai</p>
                        <p class="text-4xl font-extrabold text-indigo-600 mt-1">{{ $totalOrderSelesai }}</p>
                    </div>
                    <i class="bi bi-people-fill text-4xl text-indigo-400"></i>
                </div>

                {{-- Pendapatan Bulan Ini --}}
                <div class="bg-white overflow-hidden shadow-lg rounded-lg p-6 flex items-center justify-between hover:shadow-xl hover:scale-[1.02] transition">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Pendapatan (Bulan Ini)</p>
                        <p class="text-2xl font-extrabold text-yellow-600 mt-2">
                            Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}
                        </p>
                    </div>
                    <i class="bi bi-cash-stack text-4xl text-yellow-400"></i>
                </div>

            </div>

        </div>
    </div>

</x-app-layout>
