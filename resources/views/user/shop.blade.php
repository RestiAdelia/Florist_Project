{{-- resources/views/shop.blade.php --}}
@extends('layouts.app-user')

@section('content')
    <div class="pt-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <h1 class="text-3xl font-extrabold text-gray-800 mb-8 border-b-2 pb-2">Katalog Produk</h1>

        {{-- Filter kategori --}}
        <div class="mb-6 flex flex-wrap gap-2">
            <a href="{{ route('shop') }}"
                class="px-5 py-2 rounded-full border {{ empty($kategoriId) ? 'bg-teal-600 text-white' : 'bg-white text-gray-700' }} hover:bg-teal-500 hover:text-white transition">
                Semua
            </a>

            @foreach ($categories as $category)
                <a href="{{ route('shop', ['kategori' => $category->id]) }}"
                    class="px-5 py-2 rounded-full border {{ isset($kategoriId) && $kategoriId == $category->id ? 'bg-teal-600 text-white' : 'bg-white text-gray-700' }} hover:bg-teal-500 hover:text-white transition">
                    {{ $category->nama }}
                </a>
            @endforeach
        </div>

        {{-- Grid produk --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 sm:gap-6">
            @foreach ($products as $product)
                <div
                    class="group bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden flex flex-col transform hover:-translate-y-1">

                    {{-- Gambar produk --}}
                    <div class="relative overflow-hidden">
                        <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama }}"
                            class="w-full h-40 sm:h-52 object-cover transition-transform duration-500 group-hover:scale-105">

                        @if ($product->stok === 'tersedia')
                            <span
                                class="absolute top-2 left-2 bg-teal-600 text-white text-xs font-semibold px-2 py-0.5 rounded-full shadow-md">
                                Tersedia
                            </span>
                        @else
                            <span
                                class="absolute top-2 left-2 bg-red-600 text-white text-xs font-semibold px-2 py-0.5 rounded-full shadow-md">
                                Stok Habis
                            </span>
                        @endif

                        <button title="Tambah ke Wishlist"
                            class="absolute top-2 right-2 p-2 bg-white/80 rounded-full text-gray-600 hover:text-red-500 transition-opacity opacity-100 md:opacity-0 group-hover:opacity-100">
                            <i class="bi bi-heart text-lg"></i>
                        </button>
                    </div>

                    {{-- Informasi produk --}}
                    <div class="p-3 sm:p-4 flex flex-col flex-grow">
                        {{-- Nama Produk --}}
                        <h2 class="text-base sm:text-lg font-bold text-gray-800 mb-1 leading-tight line-clamp-2">
                            <a href="{{ '#' }}" class="hover:text-teal-600 transition">{{ $product->nama }}</a>
                        </h2>

                        {{-- Harga dan Tombol Pesan --}}
                        <div class="mt-auto flex items-center justify-between pt-3 border-t border-gray-100">
                            <span class="text-lg sm:text-xl font-semibold text-teal-700">
                                Rp {{ number_format($product->harga, 0, ',', '.') }}
                            </span>
                            {{-- {{ route('order.create', ['id' => $product->id]) }}" --}}
                            @if ($product->stok === 'tersedia')
                                <a href="{{ '#' }}"
                                    class="text-white font-semibold px-3 py-1.5 rounded-lg transition-colors duration-200 flex items-center space-x-2 bg-teal-600 hover:bg-teal-700"
                                    title="Pesan Produk Ini">
                                    <i class="bi bi-bag-check"></i>
                                    <span class="hidden sm:inline">Pesan</span>
                                </a>
                            @else
                                <button type="button"
                                    class="text-white font-semibold px-3 py-1.5 rounded-lg bg-gray-400 cursor-not-allowed flex items-center space-x-2"
                                    disabled>
                                    <i class="bi bi-bag-x"></i>
                                    <span class="hidden sm:inline">Habis</span>
                                </button>
                            @endif
                        </div>
                    </div>

                </div>
            @endforeach
        </div>

        {{-- Jika tidak ada produk --}}
        @if ($products->isEmpty())
            <p class="mt-10 text-center text-gray-500">Belum ada produk tersedia.</p>
        @endif

        {{-- Pagination (opsional) --}}
        {{-- 
        <div class="mt-10 mb-20 flex justify-center">
            {{ $products->links('vendor.pagination.tailwind') }}
        </div> 
        --}}
    </div>
@endsection
