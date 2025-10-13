<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Aurora Florist</title>

    <!-- Fonts & Tailwind -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased min-h-screen flex items-center justify-center p-6">

    <div class="flex items-center justify-center w-full">
        <div class="flex w-full max-w-6xl bg-white rounded-3xl shadow-2xl overflow-hidden">

            <!-- KIRI -->
            <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-[#0B3C49] via-[#146773] to-[#1E8A89] flex-col justify-center items-center text-white p-12 relative overflow-hidden">

                <!-- efek background lembut -->
                <div class="absolute inset-0 opacity-20">
                    <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-white rounded-full blur-3xl animate-pulse"></div>
                    <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-white rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
                </div>

                <!-- dekorasi floral emoji -->
                <div class="absolute top-12 left-12 text-6xl opacity-30 animate-bounce" style="animation-duration: 3s;">🌿</div>
                <div class="absolute bottom-20 right-12 text-6xl opacity-30 animate-bounce" style="animation-duration: 4s; animation-delay: 1s;">🌼</div>
                <div class="absolute bottom-12 left-16 text-6xl opacity-30 animate-bounce" style="animation-duration: 3.5s; animation-delay: 2s;">🌺</div>

                <!-- teks welcome -->
                <div class="relative z-10 text-center">
                    <img src="{{ asset('images/logo.png') }}" alt="Aurora Florist" class="w-28 h-28 mx-auto mb-4">
                    <h2 class="text-5xl font-bold mb-4 drop-shadow-lg">Welcome Back!</h2>
                    <p class="text-xl text-white/90 leading-relaxed mb-8 max-w-md">
                        Masuk untuk Mengelola Product Anda🌸
                    </p>
                    <div class="my-8 flex items-center justify-center">
                        <div class="h-px bg-white/30 w-24"></div>
                        <span class="mx-4 text-white/70">✨</span>
                        <div class="h-px bg-white/30 w-24"></div>
                    </div>
                </div>
            </div>

            <!-- KANAN -->
            <div class="w-full lg:w-1/2 p-12 lg:p-16 flex flex-col justify-center">

                <!-- Judul -->
                <div class="flex flex-col items-center mb-10">
                    <h2 class="text-4xl font-bold text-[#0B3C49] mb-2">Login</h2>
                    <p class="text-gray-600 text-center">Silakan masuk ke akun Anda</p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" class="text-base font-semibold text-gray-700" />
                        <div class="relative mt-2">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <x-text-input id="email"
                                class="block w-full pl-12 pr-4 py-3 border-2 border-gray-300 focus:border-[#1E8A89] focus:ring-[#1E8A89] rounded-xl text-base transition-all"
                                type="email"
                                name="email"
                                :value="old('email')"
                                placeholder="nama@email.com"
                                required autofocus autocomplete="username" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')" class="text-base font-semibold text-gray-700" />
                        <div class="relative mt-2">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <x-text-input id="password"
                                class="block w-full pl-12 pr-4 py-3 border-2 border-gray-300 focus:border-[#1E8A89] focus:ring-[#1E8A89] rounded-xl text-base transition-all"
                                type="password"
                                name="password"
                                placeholder="••••••••"
                                required autocomplete="current-password" />
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Forgot Password -->
                    <div class="flex justify-end items-center pt-2">
                        @if (Route::has('password.request'))
                            <a class="text-sm text-[#1E8A89] hover:text-[#146773] font-semibold hover:underline transition-colors"
                                href="{{ route('password.request') }}">
                                {{ __('Lupa Password?') }}
                            </a>
                        @endif
                    </div>

                    <!-- Tombol Login -->
                    <div class="pt-4">
                        <x-primary-button
                            class="w-full justify-center bg-gradient-to-r from-[#0E4D57] to-[#1E8A89] hover:from-[#146773] hover:to-[#25999A] text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 text-base">
                            {{ __('Masuk') }} →
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
