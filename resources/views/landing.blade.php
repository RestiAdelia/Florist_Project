@extends('layouts.florist')

@section('content')
    <section class="px-6 py-20 bg-transparent">
        <div class="container mx-auto grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div class="flex justify-center md:justify-start">
                <img src="{{ asset('images/logo.png') }}" alt="Florist"
                    class="w-64 md:w-80 lg:w-[420px] drop-shadow-xl mt-8 md:mt-12 lg:mt-16">
            </div>
            <div class="max-w-xl text-center md:text-left">
                <h1 class="text-5xl md:text-6xl font-extrabold text-[#b8860b] leading-tight tracking-wide drop-shadow-md">
                    Aurora Adv <br> & Florist
                </h1>

                <p class="mt-6 text-lg md:text-xl text-gray-800 leading-relaxed drop-shadow-sm">
                    Kami menyediakan berbagai <span class="font-semibold text-white ">karangan bunga</span>
                    untuk acara <span class="italic">pernikahan</span>, wisuda, ulang tahun,
                    dan momen spesial Anda.
                </p>
                <div class="mt-8 flex flex-col md:flex-row gap-4 md:gap-6 justify-center md:justify-start">
                    <a href="#produk"
                        class="px-8 py-4 bg-teal-600 text-white rounded-xl shadow-lg text-lg font-semibold hover:bg-teal-700 transition">
                        Pesan Sekarang
                    </a>
                    <a href="#about"
                        class="px-8 py-4 border-2 border-teal-600 text-teal-600 rounded-xl text-lg font-semibold hover:bg-teal-600 hover:text-white transition">
                        Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>

        </div>
    </section>
    <section id="about" class="relative bg-teal-50 overflow-hidden py-40">
        <div class="container mx-auto flex flex-col items-start gap-6 px-6 relative z-10 max-w-3xl">
            <h2 class="text-4xl md:text-5xl font-extrabold text-teal-600 mb-4">
                Tentang Aurora Adv & Florist
            </h2>
            <p class="text-gray-700 text-base md:text-lg leading-relaxed mb-3">
                Aurora Adv & Florist hadir untuk membantu Anda merayakan setiap momen spesial dengan <span
                    class="font-semibold text-teal-600">karangan bunga</span> yang cantik dan berkualitas. Kami
                menyediakan layanan untuk pernikahan, ulang tahun, wisuda, dan acara penting lainnya.
            </p>
            <p class="text-gray-700 text-base md:text-lg leading-relaxed mb-4">
                Tim kami berdedikasi untuk menciptakan desain bunga yang unik dan sesuai dengan selera Anda, menjadikan
                setiap momen lebih berkesan.
            </p>
            <a href="{{ url('/cara-pemesanan') }}"
                class="inline-block px-6 py-3 bg-teal-600 text-white rounded-xl shadow-lg text-base font-semibold hover:bg-teal-700 transition">
                Read More
            </a>
        </div>
        <div class="absolute top-0 right-0 h-full">
            <img src="{{ asset('images/about.png') }}" alt="About Aurora Florist"
                class="h-full max-h-[500px] w-auto object-cover drop-shadow-xl rounded-l-lg">
        </div>
    </section>

    <section id="produk" class="px-6 py-20 bg-gray-50">
        <div class="container mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800">Our Featured Products</h2>
                <p class="text-gray-500 mt-2">Kami menyediakan berbagai karangan bunga berkualitas</p>
            </div>

            <div class="flex justify-left flex-wrap gap-3 mb-10">
                <button data-id="" class="filter-btn bg-teal-600 text-white px-4 py-2 rounded-full">
                    Semua
                </button>
                @foreach ($categories as $category)
                    <button data-id="{{ $category->id }}"
                        class="filter-btn border border-teal-500 text-teal-600 px-4 py-2 rounded-full hover:bg-teal-500 hover:text-white transition">
                        {{ $category->nama }}
                    </button>
                @endforeach
            </div>
            <div id="product-list">
                @include('profile.partials.product-list', ['products' => $products])
            </div>
        </div>
    </section>
    <script>
        let currentCategory = '';

        function filterProduk(categoryId = '', pageUrl = null, pushState = true) {
            currentCategory = categoryId;
            let url = pageUrl ?? `/filter-produk?category_id=${categoryId}`;

            // Pastikan URL paginator tetap membawa category_id
            if (pageUrl && currentCategory) {
                const hasQuery = url.includes('?');
                if (!url.includes('category_id=')) {
                    url += (hasQuery ? '&' : '?') + 'category_id=' + currentCategory;
                }
            }

            // tampilkan loading
            document.querySelector('#product-list').innerHTML =
                `<div class="text-center py-10 text-gray-500">Memuat produk...</div>`;

            fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })

                .then(res => res.text())
                .then(html => {
                    document.querySelector('#product-list').innerHTML = html;
                    bindPagination();
                    highlightButton(categoryId);

                    if (pushState) {
                        window.history.pushState({
                            categoryId,
                            url
                        }, '', url);
                    }

                    document.querySelector('#produk').scrollIntoView({
                        behavior: 'smooth'
                    });
                })
                .catch(() => {
                    document.querySelector('#product-list').innerHTML =
                        `<div class="text-center py-10 text-red-500">Gagal memuat produk.</div>`;
                });
        }

        function bindPagination() {
            document.querySelectorAll('#product-list a.page-link, #product-list .pagination a').forEach(link => {
                link.addEventListener('click', e => {
                    e.preventDefault();
                    const url = e.currentTarget.getAttribute('href');
                    filterProduk(currentCategory, url);
                });
            });
        }

        function highlightButton(categoryId) {
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.classList.remove('bg-teal-600', 'text-white');
                btn.classList.add('border', 'border-teal-500', 'text-teal-600');
            });

            const activeBtn = document.querySelector(`.filter-btn[data-id="${categoryId}"]`);
            if (activeBtn) {
                activeBtn.classList.remove('border', 'border-teal-500', 'text-teal-600');
                activeBtn.classList.add('bg-teal-600', 'text-white');
            } else {
                document.querySelector('.filter-btn[data-id=""]').classList.add('bg-teal-600', 'text-white');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            bindPagination();

            // pasang event click ke tombol filter
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const id = btn.dataset.id;
                    filterProduk(id);
                });
            });
        });

        window.addEventListener('popstate', e => {
            if (e.state && e.state.url) {
                filterProduk(e.state.categoryId || '', e.state.url, false);
            }
        });
    </script>
