<x-app-layout>
    <x-slot:title>Laporan Penjualan</x-slot:title>

    <div class="py-6 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Header Compact --}}
            <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Laporan Penjualan</h2>
                    <p class="text-xs text-gray-500">Data per halaman: 4 Transaksi</p>
                </div>
                <div class="mt-2 sm:mt-0 px-3 py-1 bg-white rounded border border-gray-200 text-xs text-gray-600">
                    <span class="font-semibold">Hari ini:</span> {{ \Carbon\Carbon::now()->translatedFormat('d M Y') }}
                </div>
            </div>

            {{-- FILTER & EXPORT --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-4">
                <div class="flex flex-col lg:flex-row justify-between items-end gap-4">
                    <form action="{{ route('admin.laporan.index') }}" method="GET" class="w-full lg:w-auto flex flex-col md:flex-row gap-3 items-end flex-grow">
                        <div class="w-full md:w-auto">
                            <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Dari</label>
                            <input type="date" name="start_date" value="{{ $startDate }}" class="w-full md:w-32 rounded border-gray-300 text-xs py-1.5 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div class="w-full md:w-auto">
                            <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Sampai</label>
                            <input type="date" name="end_date" value="{{ $endDate }}" class="w-full md:w-32 rounded border-gray-300 text-xs py-1.5 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <button type="submit" class="px-4 py-1.5 bg-indigo-600 text-white font-medium text-xs rounded hover:bg-indigo-700 transition flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                            Filter
                        </button>
                    </form>

                    <a href="{{ route('admin.laporan.pdf', ['start_date' => $startDate, 'end_date' => $endDate]) }}" target="_blank" class="px-4 py-1.5 bg-red-50 text-red-700 font-medium text-xs rounded hover:bg-red-100 border border-red-200 transition flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        PDF
                    </a>
                </div>
            </div>

            {{-- STATISTIK MINI --}}
            <div class="grid grid-cols-3 gap-3 mb-4">
                <div class="bg-white rounded p-3 shadow-sm border border-gray-200">
                    <p class="text-[10px] text-gray-400 uppercase font-bold">Total Pendapatan</p>
                    <p class="text-sm font-bold text-emerald-600">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                </div>
                <div class="bg-white rounded p-3 shadow-sm border border-gray-200">
                    <p class="text-[10px] text-gray-400 uppercase font-bold">Total Transaksi</p>
                    <p class="text-sm font-bold text-blue-600">{{ $totalPesanan }}</p>
                </div>
                <div class="bg-white rounded p-3 shadow-sm border border-gray-200">
                    <p class="text-[10px] text-gray-400 uppercase font-bold">Total Pelanggan</p>
                    <p class="text-sm font-bold text-indigo-600">{{ $totalPelanggan }}</p>
                </div>
            </div>

            {{-- TABEL DATA (4 baris per halaman) --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 flex flex-col h-full">
                <div class="px-4 py-3 border-b border-gray-200 bg-gray-50 flex items-center justify-between">
                    <h3 class="text-xs font-bold text-gray-800">Rincian Transaksi</h3>
                    <span class="text-[10px] text-gray-500">Menampilkan {{ $orders->count() }} dari {{ $orders->total() }} data</span>
                </div>
                
                <div class="overflow-x-auto flex-grow">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left text-[10px] font-bold text-gray-500 uppercase tracking-wider w-10">No</th>
                                <th class="px-4 py-2 text-left text-[10px] font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-4 py-2 text-left text-[10px] font-bold text-gray-500 uppercase tracking-wider">Pelanggan</th>
                                <th class="px-4 py-2 text-left text-[10px] font-bold text-gray-500 uppercase tracking-wider">Produk</th>
                                <th class="px-4 py-2 text-left text-[10px] font-bold text-gray-500 uppercase tracking-wider">Total</th>
                                <th class="px-4 py-2 text-center text-[10px] font-bold text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($orders as $index => $order)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-2 text-xs text-gray-500">  
                                        {{ $orders->firstItem() + $index }}
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        <div class="text-xs font-medium text-gray-900">{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y') }}</div>
                                        <div class="text-[10px] text-gray-500">{{ \Carbon\Carbon::parse($order->created_at)->format('H:i') }} WIB</div>
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="text-xs text-gray-900 font-medium">{{ $order->user->name ?? 'Guest' }}</div>
                                        <div class="text-[10px] text-gray-500 truncate max-w-[100px]">{{ $order->user->email ?? '-' }}</div>
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="text-xs text-gray-900 truncate max-w-[120px]" title="{{ $order->product->nama ?? '' }}">
                                            {{ $order->product->nama ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap font-bold text-xs text-emerald-600">
                                        Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap text-center">
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-green-100 text-green-800 border border-green-200">
                                            {{ ucfirst($order->status_pembayaran) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-500 text-xs">
                                        Tidak ada data transaksi.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- SECTION PAGINATION --}}
                <div class="px-4 py-3 border-t border-gray-200 bg-gray-50">
                    {{-- Ini akan memunculkan tombol Previous/Next otomatis dari Laravel --}}
                    {{ $orders->links() }} 
                </div>
            </div>

        </div>
    </div>
</x-app-layout>