<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Aurora Florist | Login & Register</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="min-h-screen bg-gradient-to-br from-[#f8fafc] to-[#e2f3f2] flex items-center justify-center p-4">
    <div>
        @if (session('success'))
            <div x-data="{ open: true }" x-show="open"
                class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50">
                <div class="bg-white rounded-xl shadow-lg p-6 w-[380px] text-center">
                    <div class="flex justify-center mb-4">
                        <div class="bg-green-100 p-3 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    </div>
                    <h2 class="text-lg font-semibold text-gray-800">Pendaftaran Akun Berhasil</h2>
                    <p class="text-gray-600 text-sm mt-1">Silakan masuk untuk memulai proses perizinan berusaha.</p>

                    <button @click="open = false"
                        class="mt-6 w-full bg-[#0B3C49] hover:bg-[#145c5c] text-white py-2.5 rounded-lg font-medium transition">
                        Oke
                    </button>
                </div>
            </div>
        @endif
    </div>
    <div x-data="{ showRegister: false, showLoginPass: false, showRegPass: false, showRegConfirm: false }"
        class="relative flex bg-white shadow-2xl rounded-3xl overflow-hidden w-full max-w-5xl h-[90vh] transition-all duration-700">
        <div class="absolute inset-0 flex flex-col lg:flex-row transition-all duration-700 ease-in-out"
            :class="showRegister ? '-translate-x-full opacity-0' : 'translate-x-0 opacity-100'">
            <div
                class="hidden lg:flex w-1/2 bg-gradient-to-br from-[#0B3C49] via-[#146773] to-[#1E8A89]
                  text-white flex-col justify-center items-center p-10 relative overflow-hidden">
                <div class="absolute inset-0 opacity-20">
                    <div class="absolute top-1/3 left-1/4 w-64 h-64 bg-white rounded-full blur-3xl animate-pulse"></div>
                    <div
                        class="absolute bottom-1/4 right-1/4 w-80 h-80 bg-white rounded-full blur-3xl animate-pulse delay-700">
                    </div>
                </div>
                <img src="{{ asset('images/logo.png') }}" alt="Aurora Florist" class="w-24 h-24 mb-4 relative z-10">
                <h2 class="text-4xl font-bold mb-3 relative z-10">Selamat Datang 🌸</h2>
                <p class="text-center text-white/80 max-w-sm relative z-10 text-lg leading-relaxed">
                    Masuk untuk mengelola akun dan nikmati layanan terbaik dari Aurora Florist.
                </p>
            </div>
            <div class="w-full lg:w-1/2 flex items-center justify-center p-6 lg:p-12 bg-white">
                <form method="POST" action="{{ route('login') }}" class="w-full max-w-md space-y-6">
                    @csrf
                    <div class="text-center mb-4">
                        <h2 class="text-4xl font-bold text-[#0B3C49]">Login</h2>
                        <p class="text-gray-600 mt-1 text-base">Masuk ke akun Anda</p>
                    </div>
                 <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" id="email" name="email" required
                            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-[#1E8A89] focus:outline-none">
                    </div>
                    <div class="relative">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input :type="showLoginPass ? 'text' : 'password'" id="password" name="password" required
                            class="w-full border border-gray-300 rounded-lg p-3 pr-10 focus:ring-2 focus:ring-[#1E8A89] focus:outline-none">
                        <button type="button" @click="showLoginPass = !showLoginPass"
                            class="absolute right-3 top-9 text-gray-500 hover:text-[#0B3C49]">
                            <i :class="showLoginPass ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
                        </button>
                    </div>
                    <button type="submit"
                        class="w-full bg-gradient-to-r from-[#0E4D57] to-[#1E8A89] text-white py-3 rounded-lg font-semibold hover:scale-[1.02] transition-all duration-200">
                        Masuk
                    </button>
                    <p class="text-sm text-center text-gray-600 mt-4">
                        Belum punya akun?
                        <button type="button" @click="showRegister = true"
                            class="text-[#0B3C49] font-semibold hover:underline">
                            Daftar
                        </button>
                    </p>
                </form>
            </div>
        </div>
        <div class="absolute inset-0 flex flex-col lg:flex-row transition-all duration-700 ease-in-out"
            :class="showRegister ? 'translate-x-0 opacity-100' : 'translate-x-full opacity-0'">
            <div
                class="hidden lg:flex w-1/2 order-last bg-gradient-to-br from-[#0B3C49] via-[#146773] to-[#1E8A89]
                  text-white flex-col justify-center items-center p-10 relative overflow-hidden">
                <div class="absolute inset-0 opacity-20">
                    <div class="absolute top-1/3 right-1/4 w-64 h-64 bg-white rounded-full blur-3xl animate-pulse">
                    </div>
                    <div
                        class="absolute bottom-1/4 left-1/4 w-80 h-80 bg-white rounded-full blur-3xl animate-pulse delay-700">
                    </div>
                </div>
                <img src="{{ asset('images/logo.png') }}" alt="Aurora Florist" class="w-24 h-24 mb-4 relative z-10">
                <h2 class="text-4xl font-bold mb-3 relative z-10">Bergabung Sekarang 🌺</h2>
                <p class="text-center text-white/80 max-w-sm relative z-10 text-lg leading-relaxed">
                    Buat akun baru dan jelajani produk kami!! Aurora Florist.
                </p>
            </div>
            <div class="w-full lg:w-1/2 flex items-center justify-center p-6 lg:p-10 bg-white">
                <form method="POST" action="{{ route('register') }}" class="w-full max-w-md space-y-4">
                    @csrf
                    <div class="text-center mb-2">
                        <h2 class="text-3xl font-bold text-[#0B3C49]">Daftar Akun</h2>
                        <p class="text-gray-600 mt-1 text-sm">Isi data berikut untuk membuat akun</p>
                    </div>

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" id="name" name="name" required
                            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-[#1E8A89] focus:outline-none">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" id="email" name="email" required
                            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-[#1E8A89] focus:outline-none">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="relative">
                            <label for="password"
                                class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <input :type="showRegPass ? 'text' : 'password'" id="password_reg" name="password"
                                required
                                class="w-full border border-gray-300 rounded-lg p-3 pr-10 focus:ring-2 focus:ring-[#1E8A89] focus:outline-none">
                           <p class="text-xs text-gray-500 mt-1">Minimal 8 karakter</p>
                                <button type="button" @click="showRegPass = !showRegPass"
                                class="absolute right-3 top-9 text-gray-500 hover:text-[#0B3C49]">
                                <i :class="showRegPass ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
                            </button>
                        </div>
                        <div class="relative">
                            <label for="password_confirmation"
                                class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi</label>
                            <input :type="showRegConfirm ? 'text' : 'password'" id="password_confirmation"
                                name="password_confirmation" required
                                class="w-full border border-gray-300 rounded-lg p-3 pr-10 focus:ring-2 focus:ring-[#1E8A89] focus:outline-none">
                            <button type="button" @click="showRegConfirm = !showRegConfirm"
                                class="absolute right-3 top-9 text-gray-500 hover:text-[#0B3C49]">
                                <i :class="showRegConfirm ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
                            </button>
                        </div>
                    </div>
                    <button type="submit"
                        class="w-full bg-gradient-to-r from-[#0E4D57] to-[#1E8A89] text-white py-3 rounded-lg font-semibold hover:scale-[1.02] transition-all duration-200">
                        Daftar
                    </button>
                    <p class="text-sm text-center text-gray-600 mt-4">
                        Sudah punya akun?
                        <button type="button" @click="showRegister = false"
                            class="text-[#0B3C49] font-semibold hover:underline">
                            Login
                        </button>
                    </p>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
