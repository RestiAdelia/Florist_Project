<div x-data="{ selectedProduct: null }" x-cloak class="max-w-7xl mx-auto px-4 py-12">
    <div id="produk" class="grid grid-cols-2 md:grid-cols-3 gap-6">
        @forelse ($products as $product)
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition flex flex-col">

                <div class="relative group">
                    <img src="{{ asset('storage/' . $product['gambar']) }}" alt="{{ $product['nama'] }}"
                        class="w-full h-40 sm:h-52 object-cover rounded-lg transition-transform duration-500 group-hover:scale-105">

                    <span
                        class="absolute top-2 left-2 px-2 py-0.5 rounded-full text-xs font-semibold shadow-md {{ $product['stok'] === 'tersedia' ? 'bg-teal-600 text-white' : 'bg-red-600 text-white' }}">
                        {{ $product['stok'] === 'tersedia' ? 'Tersedia' : 'Stok Habis' }}
                    </span>

                   
                </div>

                <!-- Info produk -->
                <div class="p-4 flex flex-col items-center text-center flex-grow">
                    <h3 class="text-lg font-bold text-teal-700 mb-1">{{ $product['nama'] }}</h3>
                    <p class="text-gray-600 mb-3">Rp {{ number_format($product['harga'], 0, ',', '.') }}</p>
                </div>

                <!-- Tombol aksi -->
                <div class="flex justify-center gap-3 mb-4">
                    @auth
                        <a href="{{ route('shop') }}" target="_blank"
                            class="px-4 py-2 bg-teal-600 text-white rounded-full hover:bg-teal-700 transition flex items-center gap-2">
                            <i class="bi bi-cart-fill"></i> Pesan
                        </a>
                    @endauth

                    @guest
                        <a href="{{ route('login') }}"
                            class="px-4 py-2 bg-teal-600 text-white rounded-full hover:bg-teal-700 transition flex items-center gap-2">
                            <i class="bi bi-cart-fill"></i> Pesan
                        </a>
                    @endguest


                    <button @click="selectedProduct = {{ json_encode($product) }}"
                        class="px-4 py-2 border border-teal-500 text-teal-600 rounded-full hover:bg-teal-600 hover:text-white transition flex items-center gap-2">
                        <i class="bi bi-info-circle-fill"></i> Detail
                    </button>
                </div>
            </div>
        @empty
            <p class="text-center col-span-full text-gray-500">Belum ada produk tersedia.</p>
        @endforelse
    </div>

    <!-- Modal Detail Produk: Gambar kiri, info kanan -->
   <!-- MODAL DETAIL PRODUK -->
<div x-show="selectedProduct"
     x-cloak
     x-transition
     @click.self="selectedProduct = null"
     @keydown.escape.window="selectedProduct = null"
     class="fixed inset-0 bg-black bg-opacity-50 z-50
            flex items-end md:items-center justify-center">

    <!-- CONTAINER MODAL -->
    <div
        class="bg-white w-full md:max-w-3xl
               h-[95vh] md:h-auto
               md:max-h-[90vh]
               rounded-t-2xl md:rounded-xl
               shadow-lg
               flex flex-col
               overflow-hidden
               relative">

        <!-- HEADER MOBILE -->
        <div class="flex items-center justify-between p-4 border-b md:hidden">
            <h3 class="font-semibold text-gray-800 truncate"
                x-text="selectedProduct?.nama"></h3>

            <button @click="selectedProduct = null"
                    class="text-gray-500 hover:text-gray-700">
                <i class="bi bi-x-lg text-xl"></i>
            </button>
        </div>

        <!-- CONTENT -->
        <template x-if="selectedProduct">
            <div class="flex flex-col md:flex-row gap-4 p-4 overflow-y-auto">

                <!-- GAMBAR (SCROLL JIKA BESAR) -->
                <div class="w-full md:w-1/2
                            max-h-[45vh] md:max-h-[70vh]
                            overflow-auto">
                    <img
                        :src="'/storage/' + selectedProduct.gambar"
                        :alt="selectedProduct.nama"
                        class="w-full object-contain rounded-lg">
                </div>

                <!-- INFO PRODUK -->
                <div class="flex flex-col justify-between w-full md:w-1/2">

                    <div>
                        <h2 class="hidden md:block text-2xl font-semibold text-gray-800 mb-2"
                            x-text="selectedProduct.nama"></h2>

                        <p class="text-teal-600 font-bold text-lg mb-2">
                            Rp
                            <span
                                x-text="new Intl.NumberFormat('id-ID').format(selectedProduct.harga)">
                            </span>
                        </p>

                        <p class="text-gray-500 mb-4"
                           x-text="selectedProduct.deskripsi || 'Tidak ada deskripsi.'">
                        </p>
                    </div>

                    <!-- TOMBOL PESAN -->
                    <a :href="'https://wa.me/6281371879674?text=Halo,%20saya%20ingin%20memesan%20' + encodeURIComponent(selectedProduct.nama)"
                       target="_blank"
                       class="mt-4 inline-flex items-center justify-center gap-2
                              px-5 py-3 bg-teal-600 text-white rounded-full
                              hover:bg-teal-700 transition">
                        <i class="bi bi-cart-fill"></i> Pesan Via WA
                    </a>
                </div>

            </div>
        </template>

        <!-- CLOSE BUTTON DESKTOP -->
        <button @click="selectedProduct = null"
                class="hidden md:block absolute top-3 right-3
                       text-gray-500 hover:text-gray-700 z-10">
            <i class="bi bi-x-circle-fill text-2xl"></i>
        </button>

    </div>
</div>

</div>

<script>
    document.addEventListener('click', function(e) {
        if (e.target.closest('.pagination a')) {
            e.preventDefault();
            let url = e.target.closest('a').getAttribute('href');

            fetch(url)
                .then(res => res.text())
                .then(data => {
                    const newContent = new DOMParser().parseFromString(data, 'text/html')
                        .querySelector('#produk').innerHTML;
                    document.querySelector('#produk').innerHTML = newContent;

                    Alpine.flushAndStopDeferringMutations();
                    Alpine.initTree(document.querySelector('#produk'));

                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                })
                .catch(err => console.error(err));
        }
    });
</script>
