<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel - {{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>


<body class="bg-gray-100 font-sans antialiased">
    <div class="flex h-screen">
      <aside class="group bg-teal-700 text-white flex flex-col h-screen w-20 hover:w-64 transition-all duration-300 flex-shrink-0 overflow-hidden">
    
    <!-- LOGO SECTION -->
    <div class="px-6 py-5 flex items-center h-16 whitespace-nowrap">
        <!-- Nama Singkat (Muncul saat sidebar kecil) -->
        <span class="block group-hover:hidden text-2xl font-bold w-8 text-center transition-all duration-300">
            AF
        </span>
        
        <!-- Nama Lengkap (Muncul saat sidebar di-hover) -->
        <span class="hidden group-hover:block text-xl font-bold opacity-0 group-hover:opacity-100 transition-all duration-500 delay-100">
            Aurora Florist
        </span>
    </div>

    <!-- NAV UTAMA -->
    <nav class="flex-1 mt-4 space-y-2 px-2 overflow-y-auto custom-scrollbar">
        <a href="{{ route('dashboard') }}"
            class="flex items-center gap-3 py-3 px-2 hover:bg-white/20 rounded transition-colors" title="Dashboard">
            <i class="bi bi-speedometer2 w-8 text-center text-xl"></i>
            <span class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap font-medium text-sm">
                Dashboard
            </span>
        </a>

        <a href="{{ route('produk.index') }}"
            class="flex items-center gap-3 py-3 px-2 hover:bg-white/20 rounded transition-colors" title="Produk">
            <i class="bi bi-basket-fill w-8 text-center text-xl"></i>
            <span class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap font-medium text-sm">
                Produk
            </span>
        </a>

        <a href="{{ route('kategori.index') }}"
            class="flex items-center gap-3 py-3 px-2 hover:bg-white/20 rounded transition-colors" title="Kategori">
            <i class="bi bi-tags-fill w-8 text-center text-xl"></i>
            <span class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap font-medium text-sm">
                Kategori
            </span>
        </a>

        <a href="{{ route('admin.orders.index') }}" 
            class="flex items-center gap-3 py-3 px-2 hover:bg-white/20 rounded transition-colors" title="Pesanan">
            <i class="bi bi-receipt-cutoff w-8 text-center text-xl"></i>
            <span class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap font-medium text-sm">
                Pesanan
            </span>
        </a>

        <a href="{{ route('admin.konfirmasi.index') }}" 
            class="flex items-center gap-3 py-3 px-2 hover:bg-white/20 rounded transition-colors" title="Konfirmasi">
            <i class="bi bi-check-circle-fill w-8 text-center text-xl"></i>
            <span class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap font-medium text-sm">
               Konfirmasi & Status
            </span>
        </a>
      
        <a href="{{ route('admin.laporan.index') }}" 
            class="flex items-center gap-3 py-3 px-2 hover:bg-white/20 rounded transition-colors" title="Laporan">
            <i class="bi bi-bar-chart-fill w-8 text-center text-xl"></i>
            <span class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap font-medium text-sm">
                Laporan
            </span>
        </a>
    </nav>

    <!-- PENGATURAN (DI PALING BAWAH) -->
    <div class="mt-auto mb-4 px-2 space-y-2 border-t border-white/10 pt-4">
        <a href="{{ route('profile.show') }}" class="flex items-center gap-3 py-3 px-2 hover:bg-white/20 rounded transition-colors" title="Pengaturan">
            <i class="bi bi-gear-fill w-8 text-center text-xl"></i>
            <span class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap font-medium text-sm">
                Pengaturan
            </span>
        </a>
    </div>
</aside>
        <div class="flex-1 flex flex-col">
            <header class="bg-white shadow p-2.5 flex justify-between items-center">
                <h1 class="text-lg font-semibold">{{ $title ?? ' ' }}</h1>

                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                       
                        <span class="font-medium text-gray-700 hidden sm:inline text-sm"> Hallo, 
                            {{ Auth::user()->name ?? 'Admin' }}
                        </span>
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" @click.outside="open = false"
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-44 bg-white rounded-md shadow-lg border py-1 z-50">
                        <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="bi bi-person-circle mr-2"></i> Profil
                        </a>
                        <div class="border-t border-gray-100"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 hover:text-red-700">
                                <i class="bi bi-box-arrow-right mr-2"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </header>
            {{ $slot ?? ' ' }}
        </div>
    </div>
</body>
</html>