<x-app-layout>
    <x-slot:title>Detail Produk</x-slot:title>
   <div class="bg-gray-100 min-h-screen py-8">
    <div class="max-w-5xl mx-auto bg-white rounded-lg shadow-lg border border-gray-200 p-8">

        <!-- Judul -->
        <h2 class="text-2xl font-semibold text-teal-700 mb-6 border-b border-gray-200 pb-3">
            Detail Produk
        </h2>

        <!-- Konten utama -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
            <!-- Gambar produk -->
            <div class="flex justify-center">
                @if ($produk->gambar)
                    <img src="{{ asset('storage/' . $produk->gambar) }}" 
                        alt="{{ $produk->nama }}"
                        class="w-72 h-72 object-cover rounded-lg shadow-md border border-gray-200">
                @else
                    <div class="w-72 h-72 flex items-center justify-center bg-gray-100 rounded-lg text-gray-400 italic">
                        Tidak ada gambar
                    </div>
                @endif
            </div>

            <!-- Detail produk -->
            <div>
                <table class="w-full text-sm text-gray-700">
                    <tr>
                        <th class="text-left py-2 w-32 font-medium text-gray-600">Nama</th>
                        <td class="py-2">: {{ $produk->nama }}</td>
                    </tr>
                    <tr>
                        <th class="text-left py-2 font-medium text-gray-600">Kategori</th>
                        <td class="py-2">: {{ $produk->category->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th class="text-left py-2 font-medium text-gray-600">Harga</th>
                        <td class="py-2">: Rp{{ number_format($produk->harga, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th class="text-left py-2 font-medium text-gray-600">Stok</th>
                        <td class="py-2">
                            : 
                            <span class="px-2 py-1 rounded text-white text-xs 
                                {{ $produk->stok == 'tersedia' ? 'bg-emerald-500' : 'bg-red-500' }}">
                                {{ ucfirst($produk->stok) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th class="text-left py-2 align-top font-medium text-gray-600">Deskripsi</th>
                        <td class="py-2">: {{ $produk->deskripsi ?: '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="mt-10 flex justify-between border-t border-gray-200 pt-4">
            <a href="{{ route('produk.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md text-sm flex items-center gap-2">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>

           
        </div>

    </div>
</div>

</x-app-layout>
