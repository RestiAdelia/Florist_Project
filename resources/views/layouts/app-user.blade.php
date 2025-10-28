<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-p6dC/GL2tR+1iTRJ+f0R7cHhIhRtbwV0BvMVE0rW6+I6k5xqGfIYrX+I19p5Xk3cG3iCx3wzXqNfI3xN9eFfQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen"> 
        @include('layouts.navigation-user')

        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main class="pt-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @yield('content')
        </main>
        

        <footer class="bg-teal-700 text-white  py-6 mt-10" id="contact"   >
        <div class="container mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-10">
            <div>
                <h1 class="text-4xl font-extrabold" style="color:#B8860B;">
                    Aurora Adv <br> & Florist
                </h1>
                <p class="mt-3 text-sm">
                    Menyediakan layanan dekorasi, bunga, dan periklanan yang elegan dan berkelas.
                </p>
            </div>
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
                    <a href="https://www.facebook.com/auroraflorist12" target="_blank"
                        class="hover:text-yellow-300 transition transform hover:scale-110 duration-200">
                        <i class="bi bi-facebook"></i>
                        <a href="https://www.instagram.com/karangan_bunga_padang_pariaman?utm_source=ig_web_button_share_sheet&igsh=MTEyYWN2dXlnc3c4eQ=="
                            target="_blank" class="hover:text-yellow-300 transition">
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
