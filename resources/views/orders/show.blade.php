@extends('layouts.app-user')

@section('content')
<div class="pt-20 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
    
    {{-- Alert Messages --}}
    @if(session('success'))
    <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
        {{ session('error') }}
    </div>
    @endif

    @if(request('payment') === 'success')
    <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
        <strong>Pembayaran Berhasil!</strong> Silakan klik "Check Status Pembayaran" untuk memperbarui status pesanan.
    </div>
    @endif

    @if(request('payment') === 'pending')
    <div class="mb-6 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded-lg">
        <strong>Pembayaran Pending!</strong> Silakan selesaikan pembayaran Anda.
    </div>
    @endif

    <div class="bg-white rounded-xl shadow-lg p-6 md:p-8">
        <div class="flex items-center justify-between mb-6 border-b pb-4">
            <h1 class="text-3xl font-bold text-gray-800">Detail Pesanan</h1>
            <span class="px-4 py-2 rounded-full text-sm font-semibold
                @if($order->status_pembayaran === 'menunggu_pembayaran') bg-yellow-100 text-yellow-800
                @elseif($order->status_pembayaran === 'dibayar') bg-green-100 text-green-800
                @elseif($order->status_pembayaran === 'diproses') bg-blue-100 text-blue-800
                @elseif($order->status_pembayaran === 'dikirim') bg-purple-100 text-purple-800
                @elseif($order->status_pembayaran === 'selesai') bg-teal-100 text-teal-800
                @else bg-red-100 text-red-800
                @endif">
                {{ $statuses[$order->status_pembayaran] ?? $order->status_pembayaran }}
            </span>
        </div>

        {{-- Order Info --}}
        <div class="mb-6">
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="text-gray-600">Pesanan:</span>
                    {{-- <span class="font-semibold ml-2">#{{ $order->id }}</span> --}}
                </div>
                <div>
                    <span class="text-gray-600">Tanggal Order:</span>
                    <span class="font-semibold ml-2">{{ $order->created_at->format('d M Y, H:i') }}</span>
                </div>
            </div>
        </div>

        {{-- Product Info --}}
        <div class="mb-6 bg-gray-50 rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Produk</h2>
            <div class="flex items-start space-x-4">
                <img src="{{ asset('storage/' . $order->product->gambar) }}" 
                     alt="{{ $order->product->nama }}"
                     class="w-24 h-24 object-cover rounded-lg flex-shrink-0">
                <div class="flex-grow">
                    <h3 class="font-bold text-lg text-gray-800">{{ $order->product->nama }}</h3>
                    <p class="text-teal-600 font-semibold text-lg mt-1">
                        Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Order Details --}}
        <div class="mb-6">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Detail Pesanan</h2>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-600">No. Telepon:</span>
                    <span class="font-semibold">{{ $order->no_telepon }}</span>
                </div>
                
                @if($order->jenis_ucapan)
                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-600">Jenis Ucapan:</span>
                    <span class="font-semibold">{{ $order->jenis_ucapan }}</span>
                </div>
                @endif

                @if($order->pesan_dari)
                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-600">Pesan Dari:</span>
                    <span class="font-semibold italic">{{ $order->pesan_dari }}</span>
                </div>
                @endif

                @if($order->pesan_untuk)
                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-600">Pesan Untuk:</span>
                    <span class="font-semibold italic">{{ $order->pesan_untuk }}</span>
                </div>
                @endif

                @if($order->text_ucapan)
                <div class="border-b pb-2">
                    <span class="text-gray-600">Teks Ucapan:</span>
                    <p class="font-semibold mt-1 p-3 bg-gray-100 rounded">{{ $order->text_ucapan }}</p>
                </div>
                @endif

                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-600">Tanggal Pengiriman:</span>
                    <span class="font-semibold">{{ $order->tanggal_pengiriman->format('d F Y') }}</span>
                </div>

                <div class="flex justify-between items-start border-b pb-2">
                    <span class="text-gray-600">Alamat Pengantaran:</span>
                    <span class="font-semibold text-right max-w-md">{{ $order->alamat }}</span>
                </div>

                @if($order->payment_type)
                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-600">Metode Pembayaran:</span>
                    <span class="font-semibold uppercase">{{ str_replace('_', ' ', $order->payment_type) }}</span>
                </div>
                @endif
            </div>
        </div>

        {{-- Total --}}
        <div class="border-t pt-4 mb-6">
            <div class="flex justify-between items-center">
                <span class="text-xl font-bold text-gray-800">Total Pembayaran:</span>
                <span class="text-2xl font-bold text-teal-600">
                    Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                </span>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('orders.index') }}" 
               class="inline-block bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-6 rounded-lg transition">
                ← Kembali
            </a>

            @if($order->status_pembayaran === 'menunggu_pembayaran')
                <a href="{{ route('orders.pay', $order->id) }}" 
                   class="inline-block bg-teal-600 hover:bg-teal-700 text-white font-semibold py-2 px-6 rounded-lg transition">
                    💳 Bayar Sekarang
                </a>
                
                <a href="{{ route('orders.check-status', $order->id) }}" 
                   class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition">
                    🔄 Check Status Pembayaran
                </a>
            @endif

            @if($order->status_pembayaran === 'dibayar' || $order->status_pembayaran === 'diproses')
                <a href="{{ route('orders.check-status', $order->id) }}" 
                   class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition">
                    🔄 Update Status
                </a>
            @endif
        </div>

        {{-- Info Box --}}
        @if($order->status_pembayaran === 'menunggu_pembayaran')
        <div class="mt-6 bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700">
                        <strong>Catatan:</strong> Setelah melakukan pembayaran, klik tombol <strong>"Check Status Pembayaran"</strong> untuk memperbarui status pesanan Anda.
                    </p>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection