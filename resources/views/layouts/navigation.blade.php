<nav class="bg-white fixed top-0 w-full shadow-md z-50">
     <div class="max-w-7xl mx-auto px-8 py-3 flex items-center justify-between">
        <!-- Logo + Nama -->
        <a href="{{ url('/') }}" class="flex items-center space-x-3">
            <img src="{{ asset('images/logoAF.png') }}" alt="Logo" class="h-10 w-10 object-contain">
            <span class="text-2xl font-extrabold text-teal-600 tracking-wide hover:text-teal-700 transition">
                Aurora Florist
            </span>
        </a>

        <div class="hidden md:flex items-center space-x-6">
            <a href="{{ url('/') }}" class="text-gray-700 hover:text-teal-600">Home</a>
            <a href="#about" class="text-gray-700 hover:text-teal-600">About</a>
            <a href="#produk" class="text-gray-700 hover:text-teal-600">Produk</a>
            <a href="#contact" class="text-gray-700 hover:text-teal-600">Contact</a>
            <a href="{{ route('login.page') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Login</a>
        </div>
        <button id="mobile-menu-btn" class="md:hidden text-gray-700 focus:outline-none">
            <i class="bi bi-list text-2xl"></i>
        </button>
    </div>

    <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-200">
        <a href="{{ url('/') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Home</a>
        <a href="#about" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">About</a>
        <a href="#produk" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Produk</a>
        <a href="#contact" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Contact</a>
        <a href="{{ route('login.page') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Login</a>

    </div>
    <script>
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');
        btn?.addEventListener('click', () => menu.classList.toggle('hidden'));
    </script>
</nav>
