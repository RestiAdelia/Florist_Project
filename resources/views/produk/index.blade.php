<x-app-layout>
    <x-slot:title>Produk Karangan Bunga</x-slot:title>

    <div class="bg-gray-100 min-h-screen py-8" x-data="productShow()">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Alert Success --}}
            @if (session('success'))
                <div x-data="{ openAlert: false }" x-init="setTimeout(() => openAlert = true, 200)" x-show="openAlert" x-cloak
                    class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 backdrop-blur-sm"
                    x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-90"
                    x-transition:enter-end="opacity-100 scale-100" @click.self="openAlert = false">
                    <div class="relative p-6 border w-96 shadow-2xl rounded-xl bg-white">
                        <div class="text-center">
                            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-4">
                                <svg class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900">Berhasil!</h3>
                            <p class="text-sm text-gray-500 mt-2">{{ session('success') }}</p>
                            <div class="mt-6">
                                <button @click="openAlert = false"
                                    class="w-full px-4 py-2 bg-teal-600 text-white text-sm font-medium rounded-lg shadow hover:bg-teal-700 transition focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                                    Tutup
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Page Header --}}
            <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-xl font-bold text-gray-900">Produk Karangan Bunga</h1>
                    <p class="text-sm text-gray-500 mt-1">Kelola daftar produk, harga, dan stok toko Anda.</p>
                </div>
                <div>
                    <a href="{{ route('produk.create') }}"
                        class="inline-flex items-center gap-2 bg-teal-600 text-white px-5 py-2.5 rounded-lg hover:bg-teal-700 transition shadow-sm text-sm font-medium">
                        <i class="bi bi-plus-lg text-lg"></i> Tambah Produk
                    </a>
                </div>
            </div>

            <!-- Card Utama -->
           <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">

    <!-- Toolbar: Pencarian (Medium Compact) -->
    <div class="p-4 border-b border-gray-100 bg-gray-50/50 flex flex-col sm:flex-row justify-between items-center gap-3">
        <div class="hidden sm:block text-xs text-gray-500">
            Total Produk: <span class="font-bold text-gray-700">{{ $products->total() ?? 0 }}</span>
        </div>

        <form action="{{ route('produk.index') }}" method="GET" class="w-full sm:w-auto relative">
            <div class="relative w-full sm:w-64">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="bi bi-search text-gray-400"></i>
                </div>
                {{-- Padding vertical input (py) dikurangi --}}
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari nama produk..."
                    class="block w-full pl-10 pr-3 py-1.5 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 sm:text-sm transition duration-150 ease-in-out">
            </div>
        </form>
    </div>

    <!-- Tabel (Medium Compact) -->
    <div class="overflow-x-auto">
        <div class="inline-block min-w-full align-middle">
            <div class="overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-teal-600">
                        <tr>
                            {{-- Padding header (px, py) dikurangi --}}
                            <th scope="col" class="px-4 py-2 text-left text-xs font-bold text-white uppercase tracking-wider w-16">
                                No
                            </th>
                            <th scope="col" class="px-4 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">
                                Gambar
                            </th>
                            <th scope="col" class="px-4 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">
                                Nama Produk
                            </th>
                            <th scope="col" class="px-4 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">
                                Kategori
                            </th>
                            <th scope="col" class="px-4 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">
                                Harga
                            </th>
                            <th scope="col" class="px-4 py-2 text-center text-xs font-bold text-white uppercase tracking-wider">
                                Stok
                            </th>
                            <th scope="col" class="px-4 py-2 text-center text-xs font-bold text-white uppercase tracking-wider w-36">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($products as $index => $p)
                            <tr class="hover:bg-teal-50/30 transition duration-150 ease-in-out">
                                {{-- Padding body (px, py) dikurangi --}}
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 text-center">
                                    {{ $products->firstItem() + $index }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    {{-- Ukuran gambar diperkecil --}}
                                    <div class="flex-shrink-0 h-12 w-12">
                                        @if ($p->gambar)
                                            <img class="h-12 w-12 rounded-lg object-cover border border-gray-200 shadow-sm"
                                                src="{{ asset('storage/' . $p->gambar) }}" alt="{{ $p->nama }}">
                                        @else
                                            <div class="h-12 w-12 rounded-lg bg-gray-100 flex items-center justify-center border border-gray-200">
                                                <i class="bi bi-image text-gray-400 text-xl"></i>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="text-sm font-medium text-gray-900 line-clamp-2 max-w-[200px]" title="{{ $p->nama }}">
                                        {{ $p->nama }}
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ $p->category->nama ?? 'Tanpa Kategori' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="text-sm font-bold text-teal-700">
                                        Rp {{ number_format($p->harga, 0, ',', '.') }}
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-center">
                                    @if($p->stok == 'tersedia')
                                        <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200">
                                            Tersedia
                                        </span>
                                    @else
                                        <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 border border-red-200">
                                            Habis
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex justify-center gap-1.5">
                                        {{-- Padding tombol (p) dikurangi --}}
                                        <a href="{{ route('produk.show', $p->id) }}" title="Lihat Detail"
                                            class="p-1.5 bg-white border border-green-200 text-green-600 rounded-md hover:bg-green-50 transition shadow-sm">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>

                                        <a href="{{ route('produk.edit', $p->id) }}" title="Edit Produk"
                                            class="p-1.5 bg-white border border-blue-200 text-blue-600 rounded-md hover:bg-blue-50 transition shadow-sm">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <form action="{{ route('produk.destroy', $p->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk {{ $p->nama }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Hapus Produk"
                                                class="p-1.5 bg-white border border-red-200 text-red-600 rounded-md hover:bg-red-50 transition shadow-sm">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="bi bi-box-seam text-4xl text-gray-300 mb-3"></i>
                                        <p class="text-base font-medium">Belum ada produk ditemukan.</p>
                                        <p class="text-sm mt-1">Silakan tambah produk baru.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Footer / Pagination -->
    <div class="bg-gray-50 px-4 py-3 border-t border-gray-200">
        {{ $products->links() }}
    </div>
</div>
        </div>
    </div>

    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <script>
        function productShow() {
            return {
                product: null,
                baseUrl: "{{ asset('storage') }}",
                show(p) { this.product = p; },
                clear() { this.product = null; },
            }
        }
    </script>
</x-app-layout>