<nav class="bg-white fixed top-0 w-full shadow-sm border-b border-gray-100 z-50">
    <div class="max-w-7xl mx-auto px-4 py-2.5 flex items-center justify-between">

        <!-- Logo Section -->
        <div class="flex items-center space-x-2 flex-shrink-0">
            <img src="{{ asset('images/logo.png') }}" alt="Icon" class="h-8 w-8">
            <div>
                <span class="text-xl font-bold text-teal-600 tracking-tight leading-none">Aurora Florist</span>
                <span class="block text-[10px] text-gray-400 hidden sm:inline tracking-widest uppercase font-medium">ADV
                    & Florist</span>
            </div>
        </div>

        <!-- Search Bar Desktop -->
        <div class="hidden md:flex flex-1 justify-center px-4">
            <div class="relative w-full max-w-xl">
                <input type="text" placeholder="Search ..."
                    class="w-full pl-10 pr-4 py-2 rounded-full bg-teal-50 border border-teal-200 focus:outline-none focus:ring-2 focus:ring-teal-300 focus:border-transparent text-gray-700 placeholder-gray-500">
                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-500" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>

        <!-- Menu Kanan Desktop -->
        <div class="hidden md:flex items-center space-x-8 flex-shrink-0">
            @auth
                @if (Auth::user()->role === 'user')
                    <a href="{{ route('user.dashboard') }}"
                        class="group flex flex-col items-center {{ request()->routeIs('user.dashboard') ? 'text-teal-600' : 'text-gray-500 hover:text-teal-600' }} transition-colors">
                        <i class="bi bi-house{{ request()->routeIs('user.dashboard') ? '-fill' : '' }} text-xl mb-0.5"></i>
                        <span class="text-[10px] font-medium uppercase tracking-wider">Home</span>
                    </a>

                    <a href="{{ url('shop') }}"
                        class="group flex flex-col items-center {{ request()->is('shop*') ? 'text-teal-600' : 'text-gray-500 hover:text-teal-600' }} transition-colors">
                        <i class="bi bi-shop text-xl mb-0.5"></i>
                        <span class="text-[10px] font-medium uppercase tracking-wider">Shop</span>
                    </a>

                    <a href="{{ route('orders.index') }}"
                        class="group flex flex-col items-center {{ request()->routeIs('orders.*') ? 'text-teal-600' : 'text-gray-500 hover:text-teal-600' }} transition-colors">
                        <i class="bi bi-truck{{ request()->routeIs('orders.*') ? '-fill' : '' }} text-xl mb-0.5"></i>
                        <span class="text-[10px] font-medium uppercase tracking-wider">Pesanan</span>
                    </a>

                    <!-- AKUN DESKTOP (Dropdown ke bawah) -->
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open"
                            class="flex flex-col items-center focus:outline-none {{ request()->routeIs('profile.*') ? 'text-teal-600' : 'text-gray-500 hover:text-teal-600' }}">
                            <i
                                class="bi bi-person-circle{{ request()->routeIs('profile.*') ? '-fill' : '' }} text-xl mb-0.5"></i>
                            <span class="text-[10px] font-medium uppercase tracking-wider">Akun</span>
                        </button>

                        <!-- Dropdown Box (Posisi di bawah button) -->
                        <div x-show="open" @click.outside="open = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-2"
                            class="absolute right-0 mt-2 w-44 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50 overflow-hidden">

                            <a href="{{ route('profile.show') }}"
                                class="flex items-center px-4 py-2.5 text-sm text-gray-600 hover:bg-teal-50 hover:text-teal-700 font-medium transition-colors">
                                <i class="bi bi-person-vcard mr-3"></i> Profil
                            </a>

                            <hr class="my-1 border-gray-50">

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center px-4 py-2.5 text-sm text-red-500 hover:bg-red-50 font-medium transition-colors">
                                    <i class="bi bi-box-arrow-right mr-3"></i> Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            @endauth
        </div>
    </div>
</nav>

<!-- Mobile Bottom Navigation -->
<div
    class="md:hidden fixed bottom-0 w-full bg-white border-t border-gray-100 shadow-[0_-4px_10px_rgba(0,0,0,0.03)] z-40">
    <div class="flex justify-around items-center h-16">
        @auth
            @if (Auth::user()->role === 'user')
                <a href="{{ route('user.dashboard') }}"
                    class="flex flex-col items-center space-y-1 {{ request()->routeIs('user.dashboard') ? 'text-teal-600' : 'text-gray-400' }}">
                    <i class="bi bi-house{{ request()->routeIs('user.dashboard') ? '-fill' : '' }} text-xl"></i>
                    <span class="text-[10px] font-medium tracking-wide">Home</span>
                </a>

                <a href="{{ url('shop') }}"
                    class="flex flex-col items-center space-y-1 {{ request()->is('shop*') ? 'text-teal-600' : 'text-gray-400' }}">
                    <i class="bi bi-shop text-xl"></i>
                    <span class="text-[10px] font-medium tracking-wide">Shop</span>
                </a>

                <a href="{{ route('orders.index') }}"
                    class="flex flex-col items-center space-y-1 {{ request()->routeIs('orders.*') ? 'text-teal-600' : 'text-gray-400' }}">
                    <i class="bi bi-truck{{ request()->routeIs('orders.*') ? '-fill' : '' }} text-xl"></i>
                    <span class="text-[10px] font-medium tracking-wide">Pesanan</span>
                </a>

                <!-- AKUN MOBILE (Muncul Dropdown ke Atas) -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                        class="flex flex-col items-center space-y-1 focus:outline-none {{ request()->routeIs('profile.*') ? 'text-teal-600' : 'text-gray-400' }}">
                        <i class="bi bi-person-circle{{ request()->routeIs('profile.*') ? '-fill' : '' }} text-xl"></i>
                        <span class="text-[10px] font-medium tracking-wide">Akun</span>
                    </button>

                    <!-- Dropdown Mobile (Muncul ke Atas) -->
                    <div x-show="open" @click.outside="open = false" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        class="absolute bottom-full right-0 mb-4 w-40 bg-white rounded-xl shadow-2xl border border-gray-100 py-2 z-50">
                        <a href="{{ route('profile.show') }}"
                            class="flex items-center px-4 py-2 text-sm text-gray-600 font-medium">
                            <i class="bi bi-person mr-2 text-teal-600"></i> Profil
                        </a>
                        <hr class="my-1 border-gray-50">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center px-4 py-2 text-sm text-red-500 font-medium">
                                <i class="bi bi-box-arrow-right mr-2"></i> Keluar
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        @endauth
    </div>
</div>
