<nav class="bg-white fixed top-0 w-full shadow-md z-50">
    <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">

        {{-- LOGO --}}
        <div class="flex items-center space-x-2 flex-shrink-0">
            <img src="{{ asset('images/logo.png') }}" class="h-8 w-8">
            <div>
                <span class="text-xl font-extrabold text-teal-600">Aurora Florist</span>
                <span class="block text-xs text-gray-500 hidden sm:inline">ADV & Florist</span>
            </div>
        </div>

        {{-- SEARCH (USER ONLY) --}}
        @auth
            @if(Auth::user()->email !== 'admin@gmail.com')
                <div class="hidden md:flex flex-1 justify-center px-4">
                    <div class="relative w-full max-w-xl">
                        <input type="text" placeholder="Search for flowers..."
                            class="w-full pl-10 pr-4 py-2 rounded-full bg-teal-50 border border-teal-200
                                   focus:ring-2 focus:ring-teal-300">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-500"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
            @endif
        @endauth

        {{-- MENU KANAN --}}
        <div class="hidden md:flex items-center space-x-6">
            @auth
                @php
                    $isAdmin = Auth::user()->email === 'admin@gmail.com';
                @endphp

                {{-- ================= USER MENU ================= --}}
                @if (!$isAdmin)
                    <a href="{{ url('dashboard') }}" class="nav-icon">
                        <i class="bi bi-house"></i><span>Home</span>
                    </a>

                    <a href="{{ url('shop') }}" class="nav-icon">
                        <i class="bi bi-shop"></i><span>Shop</span>
                    </a>

                    <a href="{{ route('orders.index') }}" class="nav-icon">
                        <i class="bi bi-truck"></i><span>Pesanan</span>
                    </a>
                @endif

                {{-- ================= ADMIN MENU ================= --}}
                @if ($isAdmin)
                    <a href="{{ route('dashboard') }}" class="nav-icon">
                        <i class="bi bi-speedometer2"></i><span>Dashboard</span>
                    </a>

                    <a href="{{ route('produk.index') }}" class="nav-icon">
                        <i class="bi bi-basket"></i><span>Produk</span>
                    </a>

                    <a href="{{ route('kategori.index') }}" class="nav-icon">
                        <i class="bi bi-tags"></i><span>Kategori</span>
                    </a>

                    <a href="{{ route('admin.orders.index') }}" class="nav-icon">
                        <i class="bi bi-receipt"></i><span>Pesanan</span>
                    </a>
                @endif

                {{-- PROFILE --}}
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center gap-2">
                        <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}"
                            class="w-7 h-7 rounded-full border">
                        <i class="bi bi-chevron-down text-sm"></i>
                    </button>

                    <div x-show="open" @click.outside="open=false"
                        class="absolute right-0 mt-2 w-44 bg-white border rounded shadow z-50">
                        <a href="{{ route('profile.edit') }}"
                            class="block px-4 py-2 hover:bg-gray-100">
                            <i class="bi bi-person-circle mr-2"></i>Profile
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50">
                                <i class="bi bi-box-arrow-right mr-2"></i>Logout
                            </button>
                        </form>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</nav>


<!-- MOBILE NAVIGATION -->
<div class="md:hidden fixed bottom-0 w-full bg-white border-t shadow z-40">
    <div class="flex justify-around items-center h-14">
        @auth
            @php
                $isAdmin = Auth::user()->email === 'admin@gmail.com';
            @endphp

            @if (!$isAdmin)
                <a href="{{ url('dashboard') }}" class="mobile-nav">
                    <i class="bi bi-house"></i><span>Home</span>
                </a>
                <a href="{{ url('shop') }}" class="mobile-nav">
                    <i class="bi bi-shop"></i><span>Shop</span>
                </a>
                <a href="{{ route('orders.index') }}" class="mobile-nav">
                    <i class="bi bi-truck"></i><span>Pesanan</span>
                </a>
                <a href="{{ route('profile.edit') }}" class="mobile-nav">
                    <i class="bi bi-person"></i><span>Akun</span>
                </a>
            @else
                <a href="{{ route('dashboard') }}" class="mobile-nav">
                    <i class="bi bi-speedometer2"></i><span>Admin</span>
                </a>
                <a href="{{ route('produk.index') }}" class="mobile-nav">
                    <i class="bi bi-basket"></i><span>Produk</span>
                </a>
                <a href="{{ route('admin.orders.index') }}" class="mobile-nav">
                    <i class="bi bi-receipt"></i><span>Pesanan</span>
                </a>
            @endif
        @endauth
    </div>
</div>

