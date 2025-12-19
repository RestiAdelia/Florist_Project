<x-app-layout>
      <x-slot:title> Pesanan</x-slot:title>
    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b pb-4 mb-6">
            <h2 class="font-extrabold text-2xl text-gray-900 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 2a1 1 0 011 1v1h1a1 1 0 110 2h-1v1a1 1 0 11-2 0V6H9a1 1 0 110-2h1V3a1 1 0 011-1zM5 7a1 1 0 011-1h1a1 1 0 110 2H6a1 1 0 01-1-1zM4 11a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm4 4a1 1 0 011-1h1a1 1 0 110 2H9a1 1 0 01-1-1zm4 0a1 1 0 011-1h1a1 1 0 110 2h-1a1 1 0 01-1-1zm-4-4a1 1 0 011-1h1a1 1 0 110 2H9a1 1 0 01-1-1zm4 0a1 1 0 011-1h1a1 1 0 110 2h-1a1 1 0 01-1-1z"
                        clip-rule="evenodd" />
                </svg>
                Detail Pesanan 
            </h2>

            @php
                $status_label = ucfirst($order->status_pembayaran);
                $status_color = match($order->status) {
                    'pending' => 'text-yellow-800 bg-yellow-200',
                    'processing' => 'text-blue-800 bg-blue-200',
                    'shipped' => 'text-indigo-800 bg-indigo-200',
                    'delivered' => 'text-green-800 bg-green-200',
                    'cancelled' => 'text-red-800 bg-red-200',
                    default => 'text-gray-800 bg-gray-200',
                };
            @endphp

            <span class="px-4 py-1 text-sm font-bold rounded-full {{ $status_color }}">
                Status: {{ $status_label }}
            </span>
        </div>

        <!-- Scroll Wrapper untuk konten -->
        <div class="max-h-[75vh] overflow-y-auto space-y-6 pr-2">

            <!-- Informasi Pelanggan -->
            <div class="bg-white shadow-md rounded-xl p-5 border border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-3 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500 mr-2" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Informasi Pelanggan
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 text-gray-700 text-sm">
                    <p><strong>Nama Pemesan:</strong> {{ $order->user->name ?? 'Pengguna Tidak Terdaftar' }}</p>
                    <p><strong>No Telepon:</strong> {{ $order->no_telepon }}</p>
                    <p><strong>Alamat Kirim:</strong> {{ $order->alamat }}</p>
                    <p><strong>Tgl Pengiriman:</strong>
                        <span class="text-indigo-600 font-semibold">
                            {{ \Carbon\Carbon::parse($order->tanggal_pengiriman)->translatedFormat('d F Y') }}
                        </span>
                    </p>
                </div>
            </div>

            <!-- Rincian Produk (dengan gambar) -->
            <div class="bg-white shadow-md rounded-xl p-5 border border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-3 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500 mr-2" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19V6a2 2 0 00-2-2H5a2 2 0 00-2 2v13a2 2 0 002 2h4a2 2 0 002-2zm0 0l2.586-.586a2 2 0 001.314-1.314L20 9" />
                    </svg>
                    Rincian Produk
                </h3>

                <div class="flex flex-col sm:flex-row gap-5 items-start">
                    <!-- Gambar Produk -->
                    @if ($order->product && $order->product->gambar)
                        <img src="{{ asset('storage/' . $order->product->gambar) }}" 
                             alt="{{ $order->product->nama }}" 
                             class="w-full sm:w-48 h-48 object-cover rounded-lg border border-gray-200 shadow-sm">
                    @else
                        <div class="w-full sm:w-48 h-48 flex items-center justify-center bg-gray-100 text-gray-400 rounded-lg border border-dashed">
                            <span class="text-sm italic">Tidak ada gambar</span>
                        </div>
                    @endif

                    <!-- Detail Produk -->
                    <div class="flex-1 text-sm text-gray-700 space-y-2">
                        <p><strong>Nama Produk:</strong> {{ $order->product->nama ?? 'Produk Dihapus' }}</p>
                        <p><strong>Harga Satuan:</strong> Rp {{ number_format($order->product->harga ?? 0, 0, ',', '.') }}</p>
                        <p><strong>Jumlah:</strong> {{ $order->jumlah ?? 1 }}</p>
                        <p class="pt-2 border-t border-dashed mt-2">
                            <strong>Total Harga:</strong>
                            <span class="text-red-600 font-extrabold">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Detail Ucapan -->
            <div class="bg-white shadow-md rounded-xl p-5 border border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-3 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500 mr-2" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                    </svg>
                    Detail Ucapan
                </h3>
                <div class="text-sm text-gray-700 space-y-1">
                    <p><strong>Jenis Ucapan:</strong> {{ $order->jenis_ucapan }}</p>
                    <p><strong>Pesan Dari:</strong> {{ $order->pesan_dari }}</p>
                    <p><strong>Pesan Untuk:</strong> {{ $order->pesan_untuk }}</p>
                    <div class="mt-2">
                        <p class="font-medium text-gray-800 mb-1">Teks Ucapan:</p>
                        <div class="p-3 bg-indigo-50 border-l-4 border-indigo-500 italic rounded-md">
                            {{ $order->text_ucapan }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Pembayaran -->
            <div class="bg-white shadow-md rounded-xl p-5 border border-gray-100 mb-4">
                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-3 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm10 0v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2" />
                    </svg>
                    Detail Pembayaran
                </h3>
                <div class="text-sm text-gray-700 space-y-1">
                    <p><strong>Metode:</strong> {{ $order->metode_pembayaran ?? '-' }}</p>
                    <p><strong>Payment Type:</strong> {{ $order->payment_type ?? '-' }}</p>
                    <p><strong>Transaction ID:</strong> {{ $order->transaction_id ?? 'N/A' }}</p>
                    @php
                        $payment_color = match($order->status_pembayaran) {
                            'paid', 'settlement' => 'text-green-800 bg-green-200',
                            'pending' => 'text-yellow-800 bg-yellow-200',
                            'expire', 'failure' => 'text-red-800 bg-red-200',
                            default => 'text-gray-800 bg-gray-200',
                        };
                    @endphp
                    <p><strong>Status Pembayaran:</strong>
                        <span class="font-semibold px-3 py-1 text-sm rounded-full {{ $payment_color }}">
                            {{ ucfirst($order->status_pembayaran) }}
                        </span>
                    </p>
                </div>
                <div class="pt-6 flex justify-center sm:justify-end">
            <a href="{{ route('admin.orders.index') }}"
                class="inline-flex items-center px-5 py-2.5 text-sm font-medium rounded-full shadow-md text-white bg-gray-600 hover:bg-gray-700 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Daftar Pesanan
            </a>
        </div>
            </div>
        </div>

        <!-- Tombol Kembali -->
        
    </div>
</x-app-layout>
