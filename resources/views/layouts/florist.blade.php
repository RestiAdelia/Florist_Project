<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aurora Florist</title>
    <!-- Font Awesome 6 CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-K5m1lB7sRMHCOEpU9A0OYZdCv2r0lWkD+Ivo0jzvS/6j2MqjzXbQb6HDFzXZbxdcoyRmAwfKwvFJ6W4KeRBf0A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
<!-- Bootstrap Icons CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background: url("{{ asset('images/bg-florist.png') }}") no-repeat center center fixed;
            background-size: cover;
        }
    </style>
</head>

<body class="antialiased bg-gray-50 min-h-screen flex flex-col justify-between">

    {{-- Navbar --}}
    @include('layouts.navigation')

    {{-- Main Content --}}
    <main class="pt-20 flex-grow">
        @yield('content')
    </main>

 <footer class="bg-teal-700 text-white py-10">
    <div class="container mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-10">
        <!-- Brand -->
        <div>
            <h1 class="text-4xl font-extrabold" style="color:#B8860B;">
                Aurora Adv <br> & Florist
            </h1>
            <p class="mt-3 text-sm">
                Menyediakan layanan dekorasi, bunga, dan periklanan yang elegan dan berkelas.
            </p>
        </div>

        <!-- Navigasi -->
        <div>
            <h3 class="text-lg font-semibold mb-3">Navigasi</h3>
            <ul class="space-y-2 text-sm">
                <li><a href="#" class="hover:text-yellow-200 transition">Beranda</a></li>
                <li><a href="#" class="hover:text-yellow-200 transition">Tentang Kami</a></li>
                <li><a href="#" class="hover:text-yellow-200 transition">Layanan</a></li>
                <li><a href="#" class="hover:text-yellow-200 transition">Kontak</a></li>
            </ul>
        </div>

        <!-- Kontak -->
        <div>
            <h3 class="text-lg font-semibold mb-3">Hubungi Kami</h3>
            <ul class="space-y-2 text-sm">
                <li><i class="bi bi-telephone-fill mr-2 text-yellow-300"></i> +62 813 7187 9674</li>
                <li><i class="bi bi-envelope-fill mr-2 text-yellow-300"></i> aurora.advflorist@gmail.com</li>
                <li><i class="bi bi-geo-alt-fill mr-2 text-yellow-300"></i> Jl. Melati No. 45, Padang</li>
            </ul>
        </div>

        <!-- Sosial Media -->
        <div>
            <h3 class="text-lg font-semibold mb-3">Ikuti Kami</h3>
            <div class="flex space-x-5 text-2xl">
                <a href="https://wa.me/6281371879674" target="_blank" class="hover:text-yellow-300 transition">
                    <i class="bi bi-whatsapp"></i>
                </a>
                <a href="https://www.facebook.com/auroraflorist12" target="_blank" class="hover:text-yellow-300 transition transform hover:scale-110 duration-200">
                    <i class="bi bi-facebook"></i>
  <a href="https://www.instagram.com/karangan_bunga_padang_pariaman?utm_source=ig_web_button_share_sheet&igsh=MTEyYWN2dXlnc3c4eQ==" target="_blank"
                    class="hover:text-yellow-300 transition">
                    <i class="bi bi-instagram"></i>
            </div>
        </div>
    </div>

    <div class="text-center text-sm mt-10 border-t border-teal-500 pt-5">
        © 2025 <span style="color:#B8860B;">Aurora Adv & Florist</span>. All Rights Reserved.
    </div>
</footer>


    </div>
</body>


</html>
