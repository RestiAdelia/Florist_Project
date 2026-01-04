@extends('layouts.app-user')

@section('content')
    <div class="pt-20 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold text-gray-800 mb-6 border-b-2 pb-2">
            Daftar Pesanan Anda
        </h1>

        @php
            $statusSettings = [
                'menunggu_pembayaran' => ['label' => 'Belum Bayar', 'class' => 'bg-yellow-100 text-yellow-800'],
                'dibayar'             => ['label' => 'Menunggu Konfirmasi', 'class' => 'bg-orange-100 text-orange-700'],
                'diproses'            => ['label' => 'Diproses', 'class' => 'bg-indigo-100 text-indigo-800'],
                'selesai'             => ['label' => 'Selesai', 'class' => 'bg-green-100 text-green-800'],
                'dibatalkan'          => ['label' => 'Dibatalkan', 'class' => 'bg-red-100 text-red-800'],
            ];
            
            // Ambil dari variabel controller yang baru dikirim, atau fallback ke request
            $activeStatus = $currentStatus ?? request('status', 'All');
        @endphp

        {{-- NAVIGASI TAB --}}
        <div class="bg-white rounded-lg shadow-sm mb-6 overflow-x-auto border border-gray-100">
            <nav class="flex justify-between min-w-max">
                @php 
                    $navStatuses = ['All' => 'Semua'] + array_combine(array_keys($statusSettings), array_column($statusSettings, 'label'));
                @endphp

                @foreach ($navStatuses as $key => $label)
                    @php
                        $isActive = $key === $activeStatus;
                        $count = $statusCounts[$key] ?? 0;
                        $linkClasses = $isActive
                            ? 'border-b-2 border-teal-600 text-teal-600 font-bold bg-teal-50/50'
                            : 'border-b-2 border-transparent text-gray-700 hover:text-teal-600 hover:bg-gray-50';
                    @endphp

                    {{-- Perhatikan: Parameter sekarang bernama 'status', bukan 'status_pembayaran' --}}
                    <a href="{{ route('orders.index', ['status' => $key]) }}"
                        class="tab-button flex-1 text-center py-3 text-sm whitespace-nowrap transition duration-200 {{ $linkClasses }}">
                        {{ $label }}
                        @if ($count > 0)
                            <span class="ml-1 px-2 py-0.5 text-xs font-bold rounded-full 
                                {{ $isActive ? 'bg-teal-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                                {{ $count }}
                            </span>
                        @endif
                    </a>
                @endforeach
            </nav>
        </div>

        @if ($orders->isEmpty())
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg shadow-sm">
                <p class="text-yellow-700 font-medium">Data pesanan belum ada untuk kategori ini.</p>
            </div>
        @else
            <div class="space-y-6">
                @foreach ($orders as $order)
                    @php
                        // LOGIKA PRIORITAS STATUS (Penting!)
                        // Urutan if-else ini menentukan warna apa yang muncul
                        
                        $st = 'menunggu_pembayaran'; // Default

                        if ($order->status_pesanan === 'dibatalkan') {
                            $st = 'dibatalkan';
                        } elseif ($order->status_pesanan === 'selesai') {
                            $st = 'selesai';
                        } elseif ($order->status_pesanan === 'diproses' || $order->status_pesanan === 'dikirim') {
                            $st = 'diproses';
                        } elseif ($order->status_pesanan === 'menunggu_konfirmasi') {
                            $st = 'dibayar';
                        } elseif ($order->status_pembayaran === 'menunggu_pembayaran') {
                            $st = 'menunggu_pembayaran';
                        }

                        $currentStatus = $statusSettings[$st] ?? ['label' => $st, 'class' => 'bg-gray-100 text-gray-800'];
                    @endphp

                    <div class="bg-white shadow-lg rounded-xl p-6 border border-gray-200">
                        <div class="flex justify-between items-center border-b pb-2 mb-4">
                            <h2 class="font-bold text-gray-800 text-base">Pesanan 
                                
                            </h2>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $currentStatus['class'] }}">
                                {{ $currentStatus['label'] }}
                            </span>
                        </div>

                        {{-- Detail Produk --}}
                        @if ($order->product)
                            <div class="flex items-center space-x-4">
                                <img src="{{ asset('storage/' . $order->product->gambar) }}"
                                    alt="{{ $order->product->nama }}"
                                    class="w-16 h-16 object-cover rounded-md border flex-shrink-0">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-800">{{ $order->product->nama }}</h3>
                                    <p class="text-sm text-gray-500">
                                        Rp {{ number_format($order->product->harga, 0, ',', '.') }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-gray-500">Total</p>
                                    <p class="font-bold text-teal-600 text-lg">
                                        Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        @else
                            <p class="text-red-500 italic mb-4">Produk tidak tersedia.</p>
                        @endif

                        <div class="mt-4 flex justify-end space-x-3 border-t pt-4">
                            
                            {{-- LOGIKA TOMBOL BAYAR DIPERBAIKI --}}
                            {{-- Hanya muncul jika status pembayaran menunggu DAN pesanan TIDAK dibatalkan --}}
                            @if ($order->status_pembayaran === 'menunggu_pembayaran' && $order->status_pesanan !== 'dibatalkan')
                                <a href="{{ route('orders.pay', $order->id) }}"
                                    class="bg-teal-600 hover:bg-teal-700 text-white py-2 px-4 rounded-lg text-sm font-semibold transition">
                                    Lanjut Bayar
                                </a>
                            @endif

                            @if ($order->status_pesanan === 'menunggu_konfirmasi')
                                <span class="text-sm text-gray-500 py-2 px-4 self-center">Menunggu validasi admin.</span>
                            @endif

                            <a href="{{ route('orders.show', $order->id) }}"
                                class="bg-gray-200 hover:bg-gray-300 text-gray-800 py-2 px-4 rounded-lg text-sm font-semibold transition">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
@endsection