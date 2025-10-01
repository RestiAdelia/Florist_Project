<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aurora Florist</title>

    <!-- Font Awesome 6 CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-pQp7F3Vx8i/fHaaG9VwXrS/3UQGpR4ihjKpiPht2S3f0XilXzDjxB0l3C9VqCkyo1lz3m5ekvScLhvzDqlf8SA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

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

    {{-- Footer with Contact and Icons --}}
    <footer id="contact" class="bg-gray-900 text-white py-20">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-12">

                <!-- Left Section: Contact Form -->
                <div>
                    <h2 class="text-3xl font-bold mb-2">Contact Us</h2>
                    <div class="w-20 h-1 bg-pink-400 mb-8"></div>

                    <form action="#" method="POST" class="space-y-6">
                        <input type="text" name="name" placeholder="NAME"
                            class="w-full border-b border-gray-600 bg-transparent text-white placeholder-gray-400 py-3 focus:outline-none focus:border-pink-400 transition">
                        <input type="email" name="email" placeholder="EMAIL"
                            class="w-full border-b border-gray-600 bg-transparent text-white placeholder-gray-400 py-3 focus:outline-none focus:border-pink-400 transition">
                        <input type="text" name="phone" placeholder="PHONE NUMBER"
                            class="w-full border-b border-gray-600 bg-transparent text-white placeholder-gray-400 py-3 focus:outline-none focus:border-pink-400 transition">
                        <textarea name="message" placeholder="MESSAGE" rows="4"
                            class="w-full border-b border-gray-600 bg-transparent text-white placeholder-gray-400 py-3 focus:outline-none focus:border-pink-400 transition resize-none"></textarea>
                        <button type="submit"
                            class="bg-pink-400 hover:bg-pink-500 transition text-white font-semibold px-10 py-3 rounded">
                            SEND
                        </button>
                    </form>
                </div>

                <!-- Right Section: Contact Info & Newsletter -->
                <div class="flex flex-col justify-between">
                    <!-- Contact Info -->
                    <div class="space-y-6 mb-12">
                        <div class="flex items-center space-x-4 text-lg">
                            <i class="fas fa-map-marker-alt text-pink-400 text-xl w-6">📍</i>
                            <span>Jl. Contoh Alamat No.123, Jakarta</span>
                        </div>
                        <div class="flex items-center space-x-4 text-lg">
                            <i class="fas fa-phone-alt text-pink-400 text-xl w-6">📞</i>
                            <span>+62 812-3456-7890</span>
                        </div>
                        <div class="flex items-center space-x-4 text-lg">
                            <i class="fas fa-envelope text-pink-400 text-xl w-6">✉️</i>
                            <span>info@auroraflorist.com</span>
                        </div>
                    </div>

                    <!-- Newsletter -->
                    <div>
                        <h3 class="text-2xl font-semibold mb-6">Newsletter</h3>
                        <div class="flex mb-8">
                            <input type="email" placeholder="ENTER YOUR EMAIL"
                                class="flex-1 p-3 bg-white text-gray-800 focus:outline-none">
                            <button
                                class="bg-pink-400 text-white px-8 hover:bg-pink-500 transition font-semibold">SUBSCRIBE</button>
                        </div>

                        <!-- Social Media Icons -->
                        <div class="flex space-x-4">
                            <a href="https://www.facebook.com/share/1Co8capyjW/" target="_blank"
                                class="w-12 h-12 bg-white rounded-full flex items-center justify-center hover:bg-pink-400 transition">
                                <img src="{{ asset('images/icons/facebook.png') }}" class="w-5 h-5" alt="Facebook">
                            </a>
                            <a href="https://www.instagram.com/karangan_bunga_padang_pariaman/" target="_blank"
                                class="w-12 h-12 bg-white rounded-full flex items-center justify-center hover:bg-pink-400 transition">
                                <img src="{{ asset('images/icons/instagram.png') }}" class="w-5 h-5" alt="Instagram">
                            </a>
                            <a href="https://wa.me/6281234567890" target="_blank"
                                class="w-12 h-12 bg-white rounded-full flex items-center justify-center hover:bg-pink-400 transition">
                                <img src="{{ asset('images/icons/whatsapp.png') }}" class="w-5 h-5" alt="WhatsApp">
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Bottom Copyright Line -->
            <div class="border-t border-gray-700 pt-8">
                <div class="text-center text-gray-400">
                    © {{ date('Y') }} Aurora Florist | All rights reserved.
                </div>
            </div>
        </div>
    </footer>

</body>

</html>
