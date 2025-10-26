<x-app-layout>
    <x-slot:title>Produk Karangan Bunga</x-slot:title>

    <div class="bg-gray-100 min-h-screen py-8" x-data="productShow()">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div x-data="{ openAlert: false }" x-init="setTimeout(() => openAlert = true, 200)" x-show="openAlert" x-cloak
                    class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50"
                    x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-90"
                    x-transition:enter-end="opacity-100 scale-100" @click.self="openAlert = false">
                    <div class="relative p-5 border w-96 shadow-lg rounded-md bg-white">
                        <div class="text-center">
                            <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-green-100">
                                <svg class="h-16 w-16 text-green-600" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <h3 class="text-xl leading-6 font-medium text-gray-900 mt-5">
                                {{ session('success') }}
                            </h3>
                            <div class="items-center px-4 py-3 mt-4">
                                <button @click="openAlert = false"
                                    class="px-6 py-2 bg-teal-600 text-white text-base font-medium rounded-md shadow-sm hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                                    OK
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Card utama -->
            <div class="grid grid-cols-1 gap-6 bg-white p-6 shadow-lg rounded-lg border border-gray-200">

                <!-- Form pencarian dan tambah -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                    <form action="{{ route('produk.index') }}" method="GET"
                        class="flex items-center w-full sm:w-auto gap-2">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari produk..."
                            class="border-gray-300 rounded-lg text-sm px-3 py-2 w-full sm:w-64 focus:ring-teal-500 focus:border-teal-500">
                        <button type="submit"
                            class="flex items-center gap-1 bg-teal-600 text-white px-4 py-2 rounded-lg hover:bg-teal-700 text-sm">
                            <i class="bi bi-search"></i> Cari
                        </button>
                    </form>

                    <a href="{{ route('produk.create') }}"
                        class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 text-sm">
                        + Tambah Produk
                    </a>
                </div>

                <!-- Tabel -->
                <div class="overflow-x-auto overflow-y-auto max-h-[70vh] border border-gray-200 rounded-lg shadow-sm">
                    <table class="min-w-full text-sm text-gray-700">
                        <thead class="bg-teal-600 text-white uppercase text-sm sticky top-0">
                            <tr>
                                <th class="px-4 py-3 text-left w-16">No</th>
                                <th class="px-4 py-3 text-left">Gambar</th>
                                <th class="px-4 py-3 text-left">Nama</th>
                                <th class="px-4 py-3 text-left">Kategori</th>
                                <th class="px-4 py-3 text-left">Harga</th>
                                <th class="px-4 py-3 text-left">Stok</th>
                                <th class="px-4 py-3 text-center w-40">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse ($products as $index => $p)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-3">{{ $products->firstItem() + $index }}</td>
                                    <td class="px-4 py-3">
                                        @if ($p->gambar)
                                            <img src="{{ asset('storage/' . $p->gambar) }}" alt="Gambar"
                                                class="w-16 h-16 object-cover rounded-md shadow-sm">
                                        @else
                                            <span class="text-gray-400 italic">Tidak ada</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">{{ $p->nama }}</td>
                                    <td class="px-4 py-3">{{ $p->category->nama ?? '-' }}</td>
                                    <td class="px-4 py-3">Rp{{ number_format($p->harga, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3">
                                        <span
                                            class="px-2 py-1 rounded text-white text-xs {{ $p->stok == 'tersedia' ? 'bg-emerald-500' : 'bg-red-500' }}">
                                            {{ ucfirst($p->stok) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 flex justify-center gap-2">
                                        <a href="{{ route('produk.show', $p->id) }}"
                                            class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-md text-sm">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <a href="{{ route('produk.edit', $p->id) }}"
                                            class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-md text-sm">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <form action="{{ route('produk.destroy', $p->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-sm">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-4 text-gray-500 italic text-center">Belum ada
                                        produk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>


                <!-- Pagination -->
                <div class="mt-4">
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
                show(p) {
                    this.product = p;
                    window.scrollTo({
                        top: document.body.scrollHeight,
                        behavior: 'smooth'
                    });
                },
                clear() {
                    this.product = null;
                },
                formatNumber(n) {
                    if (!n) return '0';
                    return n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                }
            }
        }
    </script>

    </x-layout>
