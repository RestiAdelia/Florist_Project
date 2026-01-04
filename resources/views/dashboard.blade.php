<x-app-layout>
    <x-slot:title>Dashboard</x-slot:title>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-4">
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-4 gap-4">
                <span class="text-xl font-bold text-gray-800 tracking-tight">Ringkasan Dashboard</span>
                <span
                    class="text-sm text-gray-500 bg-white px-4 py-2 rounded-full shadow-sm border border-gray-100 font-medium">
                    {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                </span>
            </div>
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-4">

                {{-- Total Produk --}}
                <div
                    class="bg-white overflow-hidden shadow-lg rounded-xl p-6 relative group hover:scale-[1.02] transition duration-300">
                    <div class="absolute right-0 top-0 h-full w-1.5 bg-teal-500 rounded-r-xl"></div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Produk</p>
                        <p class="text-4xl font-extrabold text-teal-700 mt-2">{{ $totalProduk }}</p>
                    </div>
                </div>

                {{-- Pesanan Baru --}}
                <div
                    class="bg-white overflow-hidden shadow-lg rounded-xl p-6 relative group hover:scale-[1.02] transition duration-300">
                    <div class="absolute right-0 top-0 h-full w-1.5 bg-emerald-500 rounded-r-xl"></div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Belum Konfirmasi</p>
                        <p class="text-4xl font-extrabold text-emerald-700 mt-2">{{ $pesananBaru }}</p>
                    </div>
                </div>

                {{-- Total Order Selesai --}}
                <div
                    class="bg-white overflow-hidden shadow-lg rounded-xl p-6 relative group hover:scale-[1.02] transition duration-300">
                    <div class="absolute right-0 top-0 h-full w-1.5 bg-indigo-500 rounded-r-xl"></div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Order Selesai</p>
                        <p class="text-4xl font-extrabold text-indigo-700 mt-2">{{ $totalOrderSelesai }}</p>
                    </div>
                </div>

                {{-- Pendapatan Bulan Ini --}}
                <div
                    class="bg-white overflow-hidden shadow-lg rounded-xl p-6 relative group hover:scale-[1.02] transition duration-300">
                    <div class="absolute right-0 top-0 h-full w-1.5 bg-yellow-500 rounded-r-xl"></div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Pendapatan (Bulan Ini)</p>
                        <p class="text-2xl font-extrabold text-yellow-600 mt-3 truncate"
                            title="Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}">
                            Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}
                        </p>
                    </div>
                </div>

            </div>



            @if (isset($urgentOrders) && $urgentOrders->count() > 0)
                {{-- Header Section Warning --}}
                <div class="flex items-center gap-2 mb-4 border-b pb-2 border-gray-200">
                    <!-- Icon lebih kecil & padding dikurangi -->
                    <div class="bg-red-100 p-1.5 rounded-md animate-pulse">
                        <span class="text-lg">🚨</span>
                    </div>

                    <div>
                        <!-- Judul turun ke text-lg -->
                        <h2 class="text-lg font-bold text-gray-800 leading-tight">Perlu Dikirim Segera</h2>
                        <!-- Deskripsi turun ke text-xs -->
                        <p class="text-xs text-gray-500">
                            Daftar pesanan dengan deadline pengiriman dalam <span class="font-bold text-gray-700">7 hari
                                ke depan</span>.
                        </p>
                    </div>
                </div>

                {{-- Grid Container --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
    @foreach ($urgentOrders as $order)
        @php
            $isToday = $order->tanggal_pengiriman->format('Y-m-d') == date('Y-m-d');

            // 1. Tentukan Warna Border & Badge
            // Hari Ini = Merah (Rose) agar mencolok
            // Minggu Ini = Teal (Tema Utama)
            $borderColor = $isToday ? 'border-l-rose-500' : 'border-l-teal-500';
            
            $badgeColor = $isToday
                ? 'bg-rose-100 text-rose-700 animate-pulse'
                : 'bg-teal-50 text-teal-700';
            
            $badgeText = $isToday
                ? 'HARI INI!'
                : \Carbon\Carbon::parse($order->tanggal_pengiriman)->translatedFormat('d M Y');
        @endphp

        {{-- START CARD --}}
        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden border-l-4 {{ $borderColor }} flex flex-col h-full border border-gray-100">

            {{-- A. Header Card: Order ID & Badge Tanggal --}}
            <div class="p-4 border-b border-gray-50 flex justify-between items-start bg-gray-50/30">
                <div>
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                        Pesanan ID
                    </span>
                    <p class="text-sm font-bold text-gray-700 mt-0.5">#{{ $order->id }}</p>
                </div>
                <span class="px-3 py-1 text-[11px] font-bold rounded-full {{ $badgeColor }} border border-opacity-10 border-black">
                    {{ $badgeText }}
                </span>
            </div>

            {{-- B. Body Card: Info Produk & Alamat --}}
            <div class="p-4 flex-1">
                {{-- Nama Produk --}}
                <div class="mb-4">
                    <h4 class="font-semibold text-gray-800 line-clamp-1" title="{{ $order->product->nama ?? '-' }}">
                        {{ $order->product->nama ?? 'Produk dihapus' }}
                    </h4>
                    <p class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                        Status:
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-teal-50 text-teal-700 border border-teal-100">
                            {{ ucfirst($order->status_pesanan) }}
                        </span>
                    </p>
                </div>

                {{-- Kotak Alamat (Tema Teal Muda) --}}
                <div class="bg-teal-50/50 rounded-lg p-3 border border-teal-100 relative group-hover:bg-teal-50 transition-colors">
                    {{-- Icon Pin Kecil --}}
                    <div class="absolute top-2 right-2 text-teal-300">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <p class="text-[10px] text-teal-800/60 font-bold uppercase mb-1">Tujuan Pengiriman:</p>
                    <p class="text-sm text-gray-700 line-clamp-2 leading-relaxed font-medium">
                        {{ $order->alamat }}
                    </p>
                </div>
            </div>

            {{-- C. Footer Card: Tombol Aksi --}}
            <div class="p-3 bg-white border-t border-gray-100">
                <a href="{{ url('/admin/orders/' . $order->id) }}"
                    class="flex items-center justify-center w-full py-2 px-4 rounded-lg bg-white border border-teal-200 text-sm font-semibold text-teal-700 hover:bg-teal-600 hover:text-white hover:border-teal-600 transition group">
                    Lihat Detail
                    <span class="ml-2 group-hover:translate-x-1 transition-transform">→</span>
                </a>
            </div>
        </div>
        {{-- END CARD --}}
    @endforeach
</div>
            @else
                {{-- State Aman / Kosong (Opsional: Jika ingin tetap menampilkan 'Semua Aman' di bawah statistik) --}}
                <div class="mt-8 bg-white border border-green-200 rounded-xl p-6 shadow-sm flex items-center gap-4">
                    <div class="bg-green-100 p-3 rounded-full text-green-600">
                        <span class="text-xl">✅</span>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Jadwal Pengiriman Aman</h3>
                        <p class="text-sm text-gray-500">Tidak ada pengiriman mendesak dalam 7 hari ke depan.</p>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
