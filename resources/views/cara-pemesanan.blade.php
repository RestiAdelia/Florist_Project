@extends('layouts.florist')

@section('content')
<section class="px-6 py-20">
    <div class="container mx-auto max-w-4xl">
        <h1 class="text-4xl font-extrabold text-teal-600 mb-6">Langkah-langkah Pemesanan</h1>
        <ol class="list-decimal list-inside text-gray-700 text-lg md:text-xl space-y-4">
            <li>Pilih karangan bunga yang Anda inginkan di halaman produk.</li>
            <li>Klik tombol "Add to Cart" untuk memasukkan produk ke keranjang.</li>
            <li>Isi form data pemesanan dengan lengkap dan benar.</li>
            <li>Lakukan pembayaran sesuai instruksi yang diberikan.</li>
            <li>Tunggu konfirmasi dari Aurora Adv & Florist.</li>
            <li>Karangan bunga akan dikirim sesuai alamat yang Anda berikan.</li>
        </ol>
        <a href="{{ url('/') }}"
           class="mt-8 inline-block px-8 py-4 bg-teal-600 text-white rounded-xl shadow-lg font-semibold hover:bg-teal-700 transition">
           Kembali ke Beranda
        </a>
    </div>
</section>
@endsection
