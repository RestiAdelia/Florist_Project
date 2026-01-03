<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

@php
    $isAdmin = auth()->check() && auth()->user()->email === 'admin@gmail.com';
@endphp

<body class="bg-gray-100 font-sans antialiased">
    <div class="flex min-h-screen">

        {{-- SIDEBAR --}}
        <aside class="bg-teal-700 text-white w-64 flex flex-col shrink-0">

            {{-- LOGO --}}
            <div class="px-6 py-4 text-xl font-bold border-b border-white/20">
                Aurora Florist
            </div>

            {{-- MENU --}}
            <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">

                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded
               {{ request()->routeIs('dashboard') ? 'bg-white/20' : 'hover:bg-white/10' }}">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('profile.edit') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded
               {{ request()->routeIs('profile.*') ? 'bg-white/20' : 'hover:bg-white/10' }}">
                    <i class="bi bi-person-circle"></i>
                    <span>Profile</span>
                </a>

                @if ($isAdmin)
                    <hr class="border-white/20 my-3">

                    <a href="{{ route('produk.index') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded hover:bg-white/10">
                        <i class="bi bi-basket-fill"></i>
                        <span>Produk</span>
                    </a>

                    <a href="{{ route('kategori.index') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded hover:bg-white/10">
                        <i class="bi bi-tags-fill"></i>
                        <span>Kategori</span>
                    </a>

                    <a href="{{ route('admin.orders.index') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded hover:bg-white/10">
                        <i class="bi bi-receipt-cutoff"></i>
                        <span>Pesanan</span>
                    </a>

                    <a href="{{ route('admin.konfirmasi.index') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded hover:bg-white/10">
                        <i class="fa-solid fa-check-circle"></i>
                        <span>Konfirmasi</span>
                    </a>
                @endif
            </nav>
        </aside>

        {{-- CONTENT --}}
        <div class="flex-1 flex flex-col min-h-screen">

            {{-- HEADER --}}
            <header class="bg-white shadow px-4 py-3 flex justify-between items-center">
                <h1 class="text-lg font-semibold">{{ $title ?? '' }}</h1>

                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center gap-2">
                        <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}"
                            class="w-7 h-7 rounded-full border">
                        <span class="text-sm font-medium hidden sm:inline">
                            {{ Auth::user()->name }}
                        </span>
                        <i class="bi bi-chevron-down text-sm"></i>
                    </button>

                    <div x-show="open" @click.outside="open = false"
                        class="absolute right-0 mt-2 w-44 bg-white border rounded shadow">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">
                            <i class="bi bi-person-circle mr-2"></i> Profile
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                <i class="bi bi-box-arrow-right mr-2"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            {{-- PAGE CONTENT --}}
            <main class="flex-1 p-4 overflow-y-auto">
                {{ $slot }}
            </main>

        </div>
    </div>
</body>

</html>
