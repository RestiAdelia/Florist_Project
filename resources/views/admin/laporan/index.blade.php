<x-app-layout>
    <x-slot:title>Dashboard</x-slot:title>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <h1 class="text-3xl font-bold text-gray-800 mb-6">Ringkasan Dashboard</h1>

            @if(isset($urgentOrders) && $urgentOrders->count() > 0)
                <div class="mb-8 bg-yellow-50 border-l-4 border-yellow-500 p-5 rounded-md shadow-sm">
                    <div class="w-full">
                        <h3 class="text-lg font-bold text-yellow-800">
                            ⚠️ Perhatian: {{ $urgentOrders->count() }} Pesanan Perlu Dikirim Minggu Ini!
                        </h3>
                        <p class="text-sm text-yellow-700 mb-3">
                            Berikut adalah daftar pesanan aktif dengan jadwal pengiriman dalam 7 hari ke depan.
                        </p>

                        <div class="bg-white rounded-lg border border-yellow-200 overflow-hidden shadow-sm">
                            <ul class="divide-y divide-yellow-100">
                                @foreach($urgentOrders as $order)
                                    <li class="p-4 hover:bg-yellow-50 transition flex flex-col sm:flex-row justify-between sm:items-center gap-4">
                                        
                                        {{-- Kolom Kiri: Info Pesanan --}}
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <span class="font-bold text-gray-800 text-lg">Order #{{ $order->id }}</span>
                                                
                                                {{-- Badge Kedip jika Hari Ini --}}
                                                @if($order->tanggal_pengiriman == date('Y-m-d'))
                                                    <span class="px-2 py-0.5 text-xs font-bold bg-red-100 text-red-700 rounded-full animate-pulse">
                                                        HARI INI!
                                                    </span>
                                                @endif
                                            </div>
                                            
                                            <p class="text-sm text-gray-600 font-medium">
                                                {{ $order->product->nama ?? 'Produk dihapus' }}
                                            </p>
                                            
                                            {{-- Alamat (Tanpa Icon) --}}
                                            <p class="text-xs text-gray-500 mt-1">
                                                <span class="font-semibold text-gray-600">Tujuan:</span> 
                                                {{ Str::limit($order->alamat, 60) }}
                                            </p>
                                        </div>

                                        {{-- Kolom Kanan: Tanggal & Tombol --}}
                                        <div class="text-left sm:text-right">
                                            <p class="text-sm text-gray-500 mb-1">Jadwal Kirim:</p>
                                            
                                            {{-- Warna Badge: Merah (Hari ini), Biru (Besok/Lusa) --}}
                                            <span class="inline-block px-3 py-1 text-sm font-bold rounded-lg 
                                                {{ $order->tanggal_pengiriman == date('Y-m-d') ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                                                {{ \Carbon\Carbon::parse($order->tanggal_pengiriman)->translatedFormat('d M Y') }}
                                            </span>
                                            
                                            <div class="mt-2">
                                                <a href="{{ url('/admin/orders/' . $order->id) }}" class="text-sm font-semibold text-teal-600 hover:text-teal-800 underline">
                                                    Lihat Detail
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
            {{-- ========================================================== --}}


            {{-- Grid Kartu Statistik --}}
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">

                {{-- Total Produk --}}
                <div class="bg-white overflow-hidden shadow-lg rounded-lg p-6 flex items-center justify-between hover:shadow-xl hover:scale-[1.02] transition">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Produk</p>
                         <p class="text-4xl font-extrabold text-teal-600 mt-1">{{ $totalProduk }}</p>
                    </div>
                    {{-- Icon dihapus sesuai permintaan 'tanpa icon' di area notif, tapi ini area statistik (opsional dihapus) --}}
                    {{-- <i class="bi bi-boxes text-4xl text-teal-400"></i> --}}
                </div>

                {{-- Pesanan Baru --}}
                <div class="bg-white overflow-hidden shadow-lg rounded-lg p-6 flex items-center justify-between hover:shadow-xl hover:scale-[1.02] transition">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Belum Konfirmasi</p>
                        <p class="text-4xl font-extrabold text-emerald-600 mt-1">{{ $pesananBaru }}</p>
                    </div>
                    {{-- <i class="bi bi-cart-check-fill text-4xl text-emerald-400"></i> --}}
                </div>

                {{-- Total Order Selesai --}}
                <div class="bg-white overflow-hidden shadow-lg rounded-lg p-6 flex items-center justify-between hover:shadow-xl hover:scale-[1.02] transition">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Order Selesai</p>
                        <p class="text-4xl font-extrabold text-indigo-600 mt-1">{{ $totalOrderSelesai }}</p>
                    </div>
                    {{-- <i class="bi bi-people-fill text-4xl text-indigo-400"></i> --}}
                </div>

                {{-- Pendapatan Bulan Ini --}}
                <div class="bg-white overflow-hidden shadow-lg rounded-lg p-6 flex items-center justify-between hover:shadow-xl hover:scale-[1.02] transition">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Pendapatan (Bulan Ini)</p>
                        <p class="text-2xl font-extrabold text-yellow-600 mt-2">
                            Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}
                        </p>
                    </div>
                    {{-- <i class="bi bi-cash-stack text-4xl text-yellow-400"></i> --}}
                </div>

            </div>

        </div>
    </div>
</x-app-layout>