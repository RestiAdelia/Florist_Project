<x-app-layout>
    <x-slot:title>Dashboard</x-slot:title>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-4">
            
            {{-- Header & Tanggal --}}
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-4 gap-4">
                <span class="text-xl font-bold text-gray-800 tracking-tight">Ringkasan Dashboard</span>
                <span class="text-sm text-gray-500 bg-white px-4 py-2 rounded-full shadow-sm border border-gray-100 font-medium">
                    {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                </span>
            </div>

            {{-- 1. STATISTIK CARDS (Tetap) --}}
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">
                {{-- Total Produk --}}
                <div class="bg-white overflow-hidden shadow-sm rounded-xl p-6 relative group hover:shadow-md transition duration-300">
                    <div class="absolute right-0 top-0 h-full w-1 bg-teal-500 rounded-r-xl"></div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Produk</p>
                        <p class="text-3xl font-extrabold text-teal-700 mt-2">{{ $totalProduk }}</p>
                    </div>
                </div>

                {{-- Pesanan Baru --}}
                <div class="bg-white overflow-hidden shadow-sm rounded-xl p-6 relative group hover:shadow-md transition duration-300">
                    <div class="absolute right-0 top-0 h-full w-1 bg-emerald-500 rounded-r-xl"></div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Belum Konfirmasi</p>
                        <p class="text-3xl font-extrabold text-emerald-700 mt-2">{{ $pesananBaru }}</p>
                    </div>
                </div>

                {{-- Total Order Selesai --}}
                <div class="bg-white overflow-hidden shadow-sm rounded-xl p-6 relative group hover:shadow-md transition duration-300">
                    <div class="absolute right-0 top-0 h-full w-1 bg-indigo-500 rounded-r-xl"></div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Order Selesai</p>
                        <p class="text-3xl font-extrabold text-indigo-700 mt-2">{{ $totalOrderSelesai }}</p>
                    </div>
                </div>

                {{-- Pendapatan Bulan Ini --}}
                <div class="bg-white overflow-hidden shadow-sm rounded-xl p-6 relative group hover:shadow-md transition duration-300">
                    <div class="absolute right-0 top-0 h-full w-1 bg-yellow-500 rounded-r-xl"></div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Pendapatan (Bln Ini)</p>
                        <p class="text-2xl font-extrabold text-yellow-600 mt-3 truncate">
                            Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- 2. URGENT ORDERS SECTION --}}
            @if (isset($urgentOrders) && $urgentOrders->count() > 0)
                <div class="mb-10">
                    
                    {{-- Header Section Warning --}}
                    <div class="flex items-center justify-between gap-2 mb-4 border-b pb-2 border-gray-200">
                        <div class="flex items-center gap-3">
                            <div class="bg-red-50 p-1.5 rounded-md animate-pulse border border-red-100">
                                <span class="text-lg">🚨</span>
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-gray-800 leading-tight">Perlu Dikirim Segera</h2>
                                <p class="text-xs text-gray-500">
                                    Deadline <span class="font-bold text-gray-700">7 hari ke depan</span>.
                                </p>
                            </div>
                        </div>
                        {{-- Info Pagination Kecil --}}
                        <div class="hidden sm:block text-xs text-gray-400">
                            Hal {{ $urgentOrders->currentPage() }} dari {{ $urgentOrders->lastPage() }}
                        </div>
                    </div>

                    {{-- 
                        GRID CONTAINER: 
                        grid-cols-1 (Mobile) -> 1 baris ke bawah
                        sm:grid-cols-2 (Tablet) -> 2 kolom
                        lg:grid-cols-4 (Desktop) -> 4 kolom (SATU BARIS KE SAMPING)
                    --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                        @foreach ($urgentOrders as $order)
                            @php
                                $isToday = $order->tanggal_pengiriman->format('Y-m-d') == date('Y-m-d');
                                $borderColor = $isToday ? 'border-t-rose-500' : 'border-t-teal-500'; // Ubah style border jadi di atas
                                $badgeColor = $isToday ? 'bg-rose-100 text-rose-700 animate-pulse' : 'bg-teal-50 text-teal-700';
                                $badgeText = $isToday ? 'HARI INI!' : \Carbon\Carbon::parse($order->tanggal_pengiriman)->translatedFormat('d M');
                            @endphp

                            {{-- CARD ITEM --}}
                            <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-all duration-300 border border-gray-200 border-t-4 {{ $borderColor }} flex flex-col h-full">
                                
                                {{-- Header Card --}}
                                <div class="p-3 border-b border-gray-50 flex justify-between items-center">
                                    
                                    <span class="px-2 py-0.5 text-[10px] font-bold rounded {{ $badgeColor }}">
                                        {{ $badgeText }}
                                    </span>
                                </div>

                                {{-- Body --}}
                                <div class="p-3 flex-1 flex flex-col gap-2">
                                    <div>
                                        <h4 class="text-sm font-semibold text-gray-800 line-clamp-1" title="{{ $order->product->nama ?? '-' }}">
                                            {{ $order->product->nama ?? 'Produk dihapus' }}
                                        </h4>
                                        <div class="flex items-center gap-1 mt-1">
                                            <span class="text-[10px] text-gray-400">Status:</span>
                                            <span class="text-[10px] px-1.5 py-0.5 rounded bg-gray-100 text-gray-600 font-medium">
                                                {{ ucfirst($order->status_pesanan) }}
                                            </span>
                                        </div>
                                    </div>

                                    {{-- Alamat Compact --}}
                                    <div class="bg-gray-50 rounded p-2 border border-gray-100 mt-auto">
                                        <div class="flex items-start gap-1.5">
                                            <svg class="w-3 h-3 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                            <p class="text-[11px] text-gray-600 line-clamp-2 leading-tight">
                                                {{ $order->alamat }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Footer Action --}}
                                <div class="p-2 border-t border-gray-100">
                                    <a href="{{ url('/admin/orders/' . $order->id) }}"
                                        class="block w-full text-center py-1.5 rounded bg-white border border-teal-200 text-xs font-semibold text-teal-700 hover:bg-teal-50 transition">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- PAGINATION LINKS --}}
                    <div class="mt-4 flex justify-end">
                        {{-- Ini akan memunculkan tombol Previous/Next angka --}}
                        {{ $urgentOrders->links() }}
                    </div>

                </div>
            @else
                <div class="mt-8 mb-8 bg-white border border-green-200 rounded-xl p-4 shadow-sm flex items-center gap-3">
                    <div class="bg-green-100 p-2 rounded-full text-green-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-800">Aman Terkendali</h3>
                        <p class="text-xs text-gray-500">Tidak ada pengiriman mendesak dalam 7 hari ke depan.</p>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>