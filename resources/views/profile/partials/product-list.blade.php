<div x-data="{ selectedProduct: null }" x-cloak class="max-w-7xl mx-auto px-4 py-12">
    <div id="produk" class="grid grid-cols-2 md:grid-cols-3 gap-6">
        @forelse ($products as $product)
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition flex flex-col">
                
                <!-- Gambar + stok + wishlist -->
                <div class="relative group">
                    <img src="{{ asset('storage/' . $product['gambar']) }}" 
                         alt="{{ $product['nama'] }}" 
                         class="w-full h-40 sm:h-52 object-cover rounded-lg transition-transform duration-500 group-hover:scale-105">
                    
                    <span class="absolute top-2 left-2 px-2 py-0.5 rounded-full text-xs font-semibold shadow-md {{ $product['stok'] === 'tersedia' ? 'bg-teal-600 text-white' : 'bg-red-600 text-white' }}">
                        {{ $product['stok'] === 'tersedia' ? 'Tersedia' : 'Stok Habis' }}
                    </span>

                    <button title="Tambah ke Wishlist"
                            class="absolute top-2 right-2 p-2 bg-white/80 rounded-full text-gray-600 hover:text-red-500 opacity-0 group-hover:opacity-100 transition">
                        <i class="bi bi-heart text-lg"></i>
                    </button>
                </div>

                <!-- Info produk -->
                <div class="p-4 flex flex-col items-center text-center flex-grow">
                    <h3 class="text-lg font-bold text-teal-700 mb-1">{{ $product['nama'] }}</h3>
                    <p class="text-gray-600 mb-3">Rp {{ number_format($product['harga'],0,',','.') }}</p>
                </div>

                <!-- Tombol aksi -->
                <div class="flex justify-center gap-3 mb-4">
                    <a href="https://wa.me/6281371879674?text=Halo,%20saya%20ingin%20memesan%20{{ urlencode($product['nama']) }}"
                       target="_blank"
                       class="px-4 py-2 bg-teal-600 text-white rounded-full hover:bg-teal-700 transition flex items-center gap-2">
                        <i class="bi bi-cart-fill"></i> Pesan
                    </a>

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
    <div x-show="selectedProduct" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" x-transition>
        <div class="bg-white rounded-xl shadow-lg max-w-3xl w-full p-6 relative flex flex-col md:flex-row gap-4">
            <button @click="selectedProduct = null" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
                <i class="bi bi-x-circle-fill text-2xl"></i>
            </button>

            <template x-if="selectedProduct">
                <div class="flex flex-col md:flex-row gap-4 w-full">
                    <!-- Gambar -->
                    <div class="flex-shrink-0 w-full md:w-1/2">
                        <img :src="'/storage/' + selectedProduct.gambar" :alt="selectedProduct.nama" class="w-full h-60 md:h-full object-cover rounded-lg">
                    </div>

                    <!-- Info Produk -->
                    <div class="flex flex-col justify-between w-full md:w-1/2 p-2 md:p-4">
                        <div>
                            <h2 class="text-2xl font-semibold text-gray-800 mb-2" x-text="selectedProduct.nama"></h2>
                            <p class="text-teal-600 font-bold text-lg mb-2">
                                Rp <span x-text="new Intl.NumberFormat('id-ID').format(selectedProduct.harga)"></span>
                            </p>
                            <p class="text-gray-500 mb-4" x-text="selectedProduct.deskripsi || 'Tidak ada deskripsi.'"></p>
                        </div>

                        <a :href="'https://wa.me/6281371879674?text=Halo,%20saya%20ingin%20memesan%20' + encodeURIComponent(selectedProduct.nama)"
                           target="_blank"
                           class="inline-flex items-center gap-2 px-5 py-2 bg-teal-600 text-white rounded-full hover:bg-teal-700 transition self-start mt-4 md:mt-auto">
                            <i class="bi bi-cart-fill"></i> Pesan Via WA
                        </a>
                    </div>
                </div>
            </template>
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

                    window.scrollTo({ top: 0, behavior: 'smooth' });
                })
                .catch(err => console.error(err));
        }
    });
</script>
