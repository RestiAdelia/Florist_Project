<nav class="bg-white fixed top-0 w-full shadow-md z-50">
    <div class="container mx-auto px-6 py-3 flex items-center justify-between">
        <!-- Logo -->
        <a href="{{ route('login.page') }}" class="text-2xl font-bold text-pink-600">
            Aurora Florist
        </a>


        <!-- Menu Desktop -->
        <div class="hidden md:flex space-x-6">
            <a href="{{ url('/') }}" class="text-gray-700 hover:text-pink-600">Home</a>
            <a href="#about" class="text-gray-700 hover:text-pink-600">About</a>
            <a href="#produk" class="text-gray-700 hover:text-pink-600">Produk</a>
            <a href="#contact" class="text-gray-700 hover:text-pink-600">Contact</a>
        </div>

        <!-- Tombol menu mobile -->
        <button id="mobile-menu-btn" class="md:hidden text-gray-700 focus:outline-none">
            ☰
        </button>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-200">
        <a href="{{ url('/') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Home</a>
        <a href="#about" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Tentang</a>
        <a href="#produk" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Produk</a>
        <a href="#contact" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Kontak</a>
    </div>

    <script>
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');
        if (btn) {
            btn.addEventListener('click', () => {
                menu.classList.toggle('hidden');
            });
        }
    </script>
</nav>
