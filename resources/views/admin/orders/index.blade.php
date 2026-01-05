<x-app-layout>
    <x-slot:title>Data Pesanan</x-slot:title>

    <div class="p-6 bg-gray-50 min-h-screen">

        {{-- HEADER & PENCARIAN --}}
        <div class="flex flex-col md:flex-row items-center justify-between mb-6 gap-4">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Daftar Pesanan</h2>
                <p class="text-xs text-gray-500">Menampilkan pesanan yang sudah dibayar & siap diproses.</p>
            </div>
            
           
            <form action="{{ route('admin.orders.index') }}" method="GET" class="w-full md:w-auto flex-1 max-w-md">
                <div class="relative">
                   
                    <input 
                        type="text" 
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari pemesan, produk, ucapan..."
                        class="w-full border border-gray-300 rounded-lg pl-4 pr-10 py-2 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 focus:outline-none text-sm shadow-sm transition">
                    
                 
                    <button type="submit" class="absolute right-3 top-2.5 text-gray-400 hover:text-teal-600 transition">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-xl shadow-md border border-gray-200 flex flex-col overflow-hidden">
            
           
            <div class="overflow-x-auto overflow-y-auto max-h-[600px] relative">
                <table class="w-full text-sm text-gray-700 table-auto border-collapse">
                    
                    {{-- Sticky Header --}}
                    <thead class="bg-gray-100 text-gray-800 font-bold sticky top-0 z-10 shadow-sm">
                        <tr>
                            <th class="px-4 py-3 border-b text-center w-12 bg-gray-100">No</th>
                            <th class="px-4 py-3 border-b text-left min-w-[150px] bg-gray-100">Nama Pemesan</th>
                            <th class="px-4 py-3 border-b text-left min-w-[150px] bg-gray-100">Produk</th>
                            <th class="px-4 py-3 border-b text-center bg-gray-100">Gambar</th>
                            <th class="px-4 py-3 border-b text-left min-w-[120px] bg-gray-100">No Telepon</th>
                            <th class="px-4 py-3 border-b text-left bg-gray-100">Jenis Ucapan</th>
                            <th class="px-4 py-3 border-b text-center min-w-[120px] bg-gray-100">Jadwal Kirim</th>
                            <th class="px-4 py-3 border-b text-center bg-gray-100">Aksi</th>
                        </tr>
                    </thead>
                    
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($orders as $index => $order)
                            {{-- Row Hover: Diganti ke Teal --}}
                            <tr class="hover:bg-teal-50/40 transition duration-150">
                                <td class="px-4 py-3 text-center text-gray-500">
                                    {{ $orders->firstItem() + $index }}
                                </td>
                                <td class="px-4 py-3 font-medium text-gray-900">
                                    {{ $order->user->name ?? 'User Dihapus' }}
                                </td>
                                {{-- Nama Produk: Text Teal --}}
                                <td class="px-4 py-3 font-semibold text-teal-700">
                                    {{ $order->product->nama ?? 'Produk Dihapus' }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if ($order->product && $order->product->gambar)
                                        <img src="{{ asset('storage/' . $order->product->gambar) }}" 
                                             alt="Img" 
                                             class="h-10 w-10 rounded object-cover mx-auto border border-gray-200">
                                    @else
                                        <span class="text-[10px] text-gray-400 italic">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-gray-600">
                                    {{ $order->no_telepon }}
                                </td>
                                <td class="px-4 py-3 text-xs text-gray-600 max-w-[200px] truncate" title="{{ $order->jenis_ucapan }}">
                                    {{ Str::limit($order->jenis_ucapan, 25) }}
                                </td>
                                <td class="px-4 py-3 text-center whitespace-nowrap">
                                   
                                    <span class="px-2 py-1 rounded bg-teal-50 text-teal-700 font-semibold text-xs border border-teal-100">
                                        {{ \Carbon\Carbon::parse($order->tanggal_pengiriman)->format('d M Y') }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                  
                                    <a href="{{ route('admin.orders.show', $order->id) }}"
                                       class="inline-flex items-center justify-center px-3 py-1.5 bg-white border border-gray-300 text-gray-700 rounded hover:bg-teal-600 hover:text-white hover:border-teal-600 transition text-xs font-semibold">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-10">
                                    <div class="flex flex-col items-center justify-center text-gray-400">
                                        <i class="fa-solid fa-clipboard-list text-4xl mb-2"></i>
                                        <p class="text-sm">Tidak ada data pesanan yang sesuai.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- FOOTER PAGINATION --}}
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                {{-- Pagination default Laravel biasanya abu-abu/biru. 
                     Jika ingin teal sempurna, perlu publish vendor:pagination dan edit manual, 
                     atau gunakan CSS global. Tapi secara layout ini sudah rapi. --}}
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</x-app-layout>