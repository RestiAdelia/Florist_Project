<x-app-layout>
    <x-slot:title> Kategori </x-slot:title>

    <div class="py-6 sm:py-8 bg-gray-100">
        <div class="max-w-6xl mx-auto px-4 sm:px-5">
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

            <div class="bg-white shadow-lg rounded-lg border border-gray-200 p-4 sm:p-5">
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-gray-700 mb-3">Tambah Kategori</h2>
                    <form action="{{ route('kategori.store') }}" method="POST"
                        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4 items-end">
                        @csrf
                        <div>
                            <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama
                                Kategori</label>
                            <input type="text" name="nama" id="nama"
                                class="w-full border-gray-300 rounded-md focus:ring-teal-500 focus:border-teal-500 text-sm"
                                required>
                        </div>
                        <div>
                            <label for="deskripsi"
                                class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                            <input type="text" name="deskripsi" id="deskripsi"
                                class="w-full border-gray-300 rounded-md focus:ring-teal-500 focus:border-teal-500 text-sm">
                        </div>

                        <div>
                            <button type="submit"
                                class="w-full bg-gradient-to-r from-green-600 to-teal-600 text-white px-5 py-2 rounded-md hover:from-green-700 hover:to-teal-700 transition font-semibold text-sm">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Form Pencarian --}}
                <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                    <form action="{{ route('kategori.index') }}" method="GET"
                        class="flex items-center gap-2 w-full sm:w-auto">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari kategori..."
                            class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full sm:w-64 focus:ring-teal-500 focus:border-teal-500">
                        <button type="submit"
                            class="bg-teal-600 text-white px-4 py-2 rounded-md hover:bg-teal-700 text-sm font-medium flex items-center gap-1">
                            <i class="bi bi-search"></i> Cari
                        </button>
                    </form>

                    {{-- Tombol reset jika pencarian aktif --}}
                    @if (request('search'))
                        <a href="{{ route('kategori.index') }}"
                            class="text-sm text-gray-600 hover:text-teal-700 flex items-center gap-1">
                            <i class="bi bi-x-circle"></i> Reset
                        </a>
                    @endif
                </div>

                <div class="overflow-x-auto overflow-y-auto max-h-[450px] rounded-md border border-gray-200">
                    <table class="min-w-full text-[15px] text-gray-700 border-collapse">
                        <thead class="bg-gradient-to-r from-teal-600 to-emerald-600 text-white sticky top-0 z-10">
                            <tr class="text-center">
                                <th class="px-4 py-3 font-semibold uppercase tracking-wider text-sm">No</th>
                                <th class="px-4 py-3 font-semibold uppercase tracking-wider text-sm">Nama</th>
                                <th class="px-4 py-3 font-semibold uppercase tracking-wider text-sm">Deskripsi</th>
                                <th class="px-4 py-3 font-semibold uppercase tracking-wider text-sm">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200 bg-white text-center">
                            @forelse($categories as $index => $kategori)
                                <tr class="hover:bg-gray-50 transition" x-data="{ openDetail: false, openEdit: false }">
                                    <td class="px-4 py-3">{{ $categories->firstItem() + $index }}</td>
                                    <td class="px-4 py-3 break-words max-w-[180px] sm:max-w-[240px] text-left">
                                        {{ $kategori->nama }}
                                    </td>
                                    <td class="px-4 py-3 text-gray-600 truncate max-w-[260px] text-left">
                                        {{ \Illuminate\Support\Str::limit($kategori->deskripsi, 60, '...') ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 flex justify-center flex-wrap gap-2">

                                        {{-- Tombol Detail --}}
                                        <button @click="openDetail = true"
                                            class="bg-emerald-500 text-white px-3 py-1 rounded-md hover:bg-emerald-600 text-sm flex items-center gap-1">
                                            <i class="bi bi-eye text-base"></i>
                                        </button>

                                        {{-- Modal Detail --}}
                                        <div x-show="openDetail" x-transition.opacity
                                            class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 flex items-center justify-center"
                                            x-cloak>
                                            <div x-show="openDetail" x-transition.scale.origin.center
                                                class="bg-white rounded-lg shadow-xl max-w-md w-[90%] p-6 relative z-50"
                                                @click.outside="openDetail = false">
                                                <button @click="openDetail = false"
                                                    class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
                                                    <i class="bi bi-x-lg text-lg"></i>
                                                </button>
                                                <h2
                                                    class="text-lg font-semibold text-teal-700 mb-3 border-b pb-2 text-left">
                                                    Detail Kategori
                                                </h2>
                                                <div class="space-y-2 text-[15px] text-gray-700 text-left pl-1">
                                                    <p><strong>Nama:</strong> {{ $kategori->nama }}</p>
                                                    <p><strong>Deskripsi:</strong> {{ $kategori->deskripsi ?? '-' }}</p>
                                                </div>
                                                <div class="mt-5 flex justify-end">
                                                    <button @click="openDetail = false"
                                                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 text-sm">
                                                        Tutup
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Tombol Edit --}}
                                        <button @click="openEdit = true"
                                            class="bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-600 text-sm flex items-center gap-1">
                                            <i class="bi bi-pencil-square text-base"></i>
                                        </button>

                                        {{-- Modal Edit --}}
                                        <div x-show="openEdit" x-transition.opacity
                                            class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 flex items-center justify-center"
                                            x-cloak>
                                            <div x-show="openEdit" x-transition.scale.origin.center
                                                class="bg-white rounded-lg shadow-xl max-w-md w-[90%] p-6 relative z-50"
                                                @click.outside="openEdit = false">
                                                <button @click="openEdit = false"
                                                    class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
                                                    <i class="bi bi-x-lg text-lg"></i>
                                                </button>
                                                <h2
                                                    class="text-lg font-semibold text-teal-700 mb-3 border-b pb-2 text-left">
                                                    Edit Kategori
                                                </h2>

                                                <form action="{{ route('kategori.update', $kategori->id) }}"
                                                    method="POST" class="w-full max-w-md mx-auto text-left">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="space-y-3">
                                                        <!-- Input Nama -->
                                                        <div>
                                                            <label
                                                                class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                                                            <input type="text" name="nama"
                                                                value="{{ $kategori->nama }}"
                                                                class="w-full border-gray-300 rounded-md focus:ring-teal-500 focus:border-blue-500 text-sm px-3 py-2">
                                                        </div>
                                                        <div>
                                                            <label
                                                                class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                                                            <input type="text" name="deskripsi"
                                                                value="{{ $kategori->deskripsi }}"
                                                                class="w-full border-gray-300 rounded-md focus:ring-teal-500 focus:border-teal-500 text-sm px-3 py-2">
                                                        </div>
                                                        <div class="flex justify-end gap-2 pt-3">
                                                            <button type="button" @click="openEdit = false"
                                                                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 text-sm font-medium">
                                                                Batal
                                                            </button>
                                                            <button type="submit"
                                                                class="px-4 py-2 bg-teal-700 text-white rounded-md hover:bg-teal-500 text-sm font-medium">
                                                                Simpan Perubahan
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                        <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600 text-sm flex items-center gap-1">
                                                <i class="bi bi-trash text-base"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada kategori.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 text-sm">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
