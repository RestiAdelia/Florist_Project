@extends('layouts.florist')

@section('content')
<!-- Hero Section -->
<section class="px-6 py-20">
    <div class="container mx-auto grid grid-cols-1 md:grid-cols-2 gap-12 items-center">

        <!-- Gambar di kiri -->
        <div class="flex justify-center md:justify-start">
            <img src="{{ asset('images/florist.png') }}" alt="Florist"
                class="w-64 md:w-80 lg:w-[420px] drop-shadow-xl mt-8 md:mt-12 lg:mt-16">
        </div>

        <!-- Teks di kanan -->
        <div class="max-w-xl text-center md:text-left">
            <h1 class="text-5xl md:text-6xl font-extrabold text-pink-600 leading-tight tracking-wide drop-shadow-md">
                Aurora Adv <br> & Florist
            </h1>
            <p class="mt-6 text-lg md:text-xl text-gray-800 leading-relaxed drop-shadow-sm">
                Kami menyediakan berbagai <span class="font-semibold text-pink-600">karangan bunga</span>
                untuk acara <span class="italic">pernikahan</span>, wisuda, ulang tahun,
                dan momen spesial Anda.
            </p>
            <div class="mt-8 flex flex-col md:flex-row gap-4 md:gap-6 justify-center md:justify-start">
                <a href="#produk"
                    class="px-8 py-4 bg-pink-600 text-white rounded-xl shadow-lg text-lg font-semibold hover:bg-pink-700 transition">
                    Pesan Sekarang
                </a>
                <a href="#about"
                    class="px-8 py-4 border-2 border-pink-600 text-pink-600 rounded-xl text-lg font-semibold hover:bg-pink-600 hover:text-white transition">
                    Pelajari Lebih Lanjut
                </a>
            </div>
        </div>

    </div>
</section>

<!-- About Section -->
<section id="about" class="relative bg-pink-50 overflow-hidden py-40">
    <div class="container mx-auto flex flex-col items-start gap-6 px-6 relative z-10 max-w-3xl">
        <h2 class="text-4xl md:text-5xl font-extrabold text-pink-600 mb-4">
            Tentang Aurora Adv & Florist
        </h2>
        <p class="text-gray-700 text-base md:text-lg leading-relaxed mb-3">
            Aurora Adv & Florist hadir untuk membantu Anda merayakan setiap momen spesial dengan <span
                class="font-semibold text-pink-600">karangan bunga</span> yang cantik dan berkualitas. Kami
            menyediakan layanan untuk pernikahan, ulang tahun, wisuda, dan acara penting lainnya.
        </p>
        <p class="text-gray-700 text-base md:text-lg leading-relaxed mb-4">
            Tim kami berdedikasi untuk menciptakan desain bunga yang unik dan sesuai dengan selera Anda, menjadikan
            setiap momen lebih berkesan.
        </p>
        <a href="{{ url('/cara-pemesanan') }}"
            class="inline-block px-6 py-3 bg-pink-600 text-white rounded-xl shadow-lg text-base font-semibold hover:bg-pink-700 transition">
            Read More
        </a>
    </div>

    <!-- Gambar kanan -->
    <div class="absolute top-0 right-0 h-full">
        <img src="{{ asset('images/about.png') }}" alt="About Aurora Florist"
            class="h-full max-h-[500px] w-auto object-cover drop-shadow-xl rounded-l-lg">
    </div>
</section>

<!-- Produk Section -->
<section id="produk" class="px-6 py-20 bg-gray-50">
    <div class="container mx-auto">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800">Our Featured Products</h2>
            <p class="text-gray-500 mt-2">Kami menyediakan berbagai karangan bunga berkualitas</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
            @foreach(range(1,6) as $item)
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition flex flex-col">
                <img src="{{ asset('images/produk'.$item.'.jpg') }}" alt="Produk {{ $item }}"
                    class="w-full h-48 object-contain bg-gray-100 p-4">
                <div class="p-4 flex-1 flex flex-col justify-between text-center">
                    <p class="text-pink-500 font-bold mb-2">$10</p>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Flower Arrangement</h3>
                    <a href="#"
                        class="mt-auto px-4 py-2 border border-pink-400 text-pink-400 rounded-full hover:bg-pink-500 hover:text-white transition">
                        Add To Cart
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
