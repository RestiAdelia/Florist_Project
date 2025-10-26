<nav class="bg-white fixed top-0 w-full shadow-md z-50">
    <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
        <!-- Logo kiri -->
        <div class="flex items-center space-x-2 flex-shrink-0">
            <img src="{{ asset('images/logo.png') }}" alt="Icon" class="h-8 w-8">
            <div>
                <span class="text-xl font-extrabold text-teal-600 tracking-wide">Aurora Florist</span>
                <span class="block text-xs text-gray-500 hidden sm:inline">ADV & Florist</span>
            </div>
        </div>
        <!-- Search bar tengah -->
        <div class="hidden md:flex flex-1 justify-center px-4">
            <div class="relative w-full max-w-xl">
                <input type="text" placeholder="Search for flowers..."
                    class="w-full pl-10 pr-4 py-2 rounded-full bg-teal-50 border border-teal-200 focus:outline-none focus:ring-2 focus:ring-teal-300 focus:border-transparent text-gray-700 placeholder-gray-500">
                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-500" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>

        <!-- Menu kanan desktop -->
        <div class="hidden md:flex items-center space-x-6 flex-shrink-0">
            @auth
                @if (Auth::user()->role === 'user')
                    <a href="{{ url('dashboard') }}"
                        class="text-gray-700 hover:text-teal-600 flex flex-col items-center text-xs" title="Home">
                        <i class="bi bi-house text-xl"></i>
                        <span>Home</span>
                    </a>
                    <a href="{{ url('shop') }}"
                        class="text-gray-700 hover:text-teal-600 flex flex-col items-center text-xs" title="Shop">
                        <i class="bi bi-shop text-xl"></i>
                        <span>Shop</span>
                    </a>
                    <a href="{{ url('pesanan') }}"
                        class="text-gray-700 hover:text-teal-600 flex flex-col items-center text-xs" title="Pesanan">
                        <i class="bi bi-truck text-xl"></i>
                        <span>Pesanan</span>
                    </a>
                    <a href="{{ url('keranjang') }}"
                        class="text-gray-700 hover:text-teal-600 flex flex-col items-center text-xs" title="Keranjang">
                        <i class="bi bi-cart text-xl"></i>
                        <span>Keranjang</span>
                    </a>

                    <!-- Profile dropdown -->
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                            <img src="{{ Auth::user()->profile_photo_url ?? 'https://via.placeholder.com/28' }}"
                                alt="Profile" class="w-7 h-7 rounded-full border border-gray-300">
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
                @endif
            @endauth
        </div>

        <!-- Mobile menu right -->
        <div class="md:hidden flex items-center space-x-4 flex-shrink-0">
            <button id="mobile-search-btn" class="text-gray-700 focus:outline-none">
                <i class="bi bi-search text-xl"></i>
            </button>
            @auth
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="focus:outline-none">
                        <img src="{{ Auth::user()->profile_photo_url ?? 'https://via.placeholder.com/28' }}" alt="Profile"
                            class="w-7 h-7 rounded-full border border-gray-300">
                    </button>
                    <div x-show="open" @click.outside="open = false" x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-44 bg-white rounded-md shadow-lg border py-1 z-50">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil</a>
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
            @endauth
        </div>
    </div>
</nav>

{{-- Mobile bottom navigation --}}
<div class="md:hidden fixed bottom-0 w-full bg-white border-t border-gray-200 shadow-xl z-40">
    <div class="flex justify-around items-center h-14">
        @auth
            @if (Auth::user()->role === 'user')
                <a href="{{ url('dashboard') }}"
                    class="text-gray-700 hover:text-teal-600 flex flex-col items-center text-xs">
                    <i class="bi bi-house text-xl"></i>
                    <span>Home</span>
                </a>
                <a href="{{ url('shop') }}"
                    class="text-gray-500 hover:text-teal-600 flex flex-col items-center text-xs">
                    <i class="bi bi-shop text-xl"></i>
                    <span>Shop</span>
                </a>
                <a href="{{ url('keranjang') }}"
                    class="text-gray-500 hover:text-teal-600 flex flex-col items-center text-xs">
                    <i class="bi bi-cart text-xl"></i>
                    <span>Keranjang</span>
                </a>
                <a href="{{ url('pesanan') }}"
                    class="text-gray-500 hover:text-teal-600 flex flex-col items-center text-xs">
                    <i class="bi bi-truck text-xl"></i>
                    <span>Pesanan</span>
                </a>
                <a href="{{ url('profile') }}"
                    class="text-gray-500 hover:text-teal-600 flex flex-col items-center text-xs">
                    <i class="bi bi-speedometer2 text-xl"></i>
                    <span>Akun</span>
                </a>
            @endif
        @endauth
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchBtn = document.getElementById('mobile-search-btn');
        searchBtn?.addEventListener('click', () => {
            console.log('Mobile Search button clicked. Implement modal/overlay here.');
        });
    });
</script>
