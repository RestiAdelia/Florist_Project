<x-app-layout>
    <x-slot:title>Data Pesanan</x-slot:title>

    <div class="p-6 bg-gray-50 min-h-screen" x-data="{ search: '' }">

        <!-- Pencarian -->
        <div class="flex items-center justify-between mb-6 gap-3">
            <div class="flex-1 max-w-md w-full">
                <input 
                    type="text" 
                    x-model="search"
                    placeholder="🔍 Cari nama pemesan, produk, atau jenis ucapan..."
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-pink-500 focus:outline-none text-gray-700">
            </div>
        </div>

        <!-- TABEL PESANAN -->
        <div class="overflow-x-auto bg-white rounded-xl shadow-md">
            <table class="w-full border border-gray-200 text-sm text-gray-700 table-auto">
                <thead class="bg-gray-100 text-gray-800 font-semibold">
                    <tr>
                        <th class="px-4 py-2 border">No</th>
                        <th class="px-4 py-2 border">Nama Pemesan</th>
                        <th class="px-4 py-2 border">Produk</th>
                        <th class="px-4 py-2 border">Gambar Produk</th>
                        <th class="px-4 py-2 border">No Telepon</th>
                        <th class="px-4 py-2 border">Jenis Ucapan</th>
                        <th class="px-4 py-2 border">Total Harga</th>
                        <th class="px-4 py-2 border">Tanggal Pengiriman</th>
                        <th class="px-4 py-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $index => $order)
                        <tr 
                            class="border hover:bg-gray-50 text-center transition"
                            x-show="
                                '{{ strtolower($order->user->name ?? '') }}'.includes(search.toLowerCase()) ||
                                '{{ strtolower($order->product->nama ?? '') }}'.includes(search.toLowerCase()) ||
                                '{{ strtolower($order->jenis_ucapan ?? '') }}'.includes(search.toLowerCase()) ||
                                '{{ strtolower($order->no_telepon ?? '') }}'.includes(search.toLowerCase())
                            "
                        >
                            <td class="px-4 py-2">{{ $index + 1 }}</td>
                            <td class="px-4 py-2">{{ $order->user->name ?? '-' }}</td>
                            <td class="px-4 py-2 font-semibold text-gray-800">{{ $order->product->nama ?? '-' }}</td>
                            <td class="px-4 py-2 text-center">
                                @if ($order->product && $order->product->gambar)
                                    <img src="{{ asset('storage/' . $order->product->gambar) }}" 
                                         alt="{{ $order->product->nama }}" 
                                         class="w-16 h-16 rounded-lg object-cover mx-auto border border-gray-200 shadow-sm">
                                @else
                                    <span class="text-gray-400 italic text-xs">Tidak ada gambar</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">{{ $order->no_telepon }}</td>
                            <td class="px-4 py-2">{{ $order->jenis_ucapan }}</td>
                            <td class="px-4 py-2 font-semibold text-green-700">
                                Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-2 text-gray-600">
                                {{ \Carbon\Carbon::parse($order->tanggal_pengiriman)->format('d M Y') }}
                            </td>
                            <td class="px-4 py-2">
                                <a href="{{ route('admin.orders.show', $order->id) }}"
                                   class="px-3 py-1 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition inline-flex items-center gap-1">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-gray-500 py-4">Tidak ada pesanan ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <script src="//unpkg.com/alpinejs" defer></script>
    </div>
</x-app-layout>
