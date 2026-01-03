<x-app-layout>
    <x-slot:title> Laporan Penjualan</x-slot:title>
    <div class="h-screen bg-gray-50 pt-2 flex flex-col">
        <div class="flex-1 overflow-hidden flex flex-col px-4 pb-4 max-w-7xl mx-auto w-full">
            <div class="flex flex-col md:flex-row md:items-center justify-between py-4 gap-3 flex-shrink-0">
                <div>
                    <p class="text-xs text-gray-500 font-medium mt-1">Pantau performa bisnis Aurora Florist Anda.</p>
                </div>
                <div class="flex items-center gap-2">
                    <button
                        class="flex items-center px-3 py-2 bg-teal-600 text-white rounded-xl font-medium text-[11px] hover:bg-teal-700 transition-all shadow-md shadow-teal-100">
                        <i class="bi bi-printer mr-1.5 text-sm"></i> Cetak PDF
                    </button>
                </div>
            </div>

            <div class="flex-shrink-0 space-y-3 mb-4">
                <div class="bg-white p-3 rounded-xl shadow-sm border border-gray-100">
                    <form action="" method="GET" class="flex flex-wrap items-end gap-3">
                        <div class="flex-1 min-w-[120px]">
                            <label
                                class="block text-[9px] font-medium text-gray-400 uppercase tracking-widest mb-1 ml-1">
                                Dari Tanggal
                            </label>
                            <input type="date" name="start_date" value="{{ $startDate }}"
                                class="w-full px-3 py-1.5 bg-gray-50 border border-gray-100 rounded-lg focus:ring-2 focus:ring-teal-500/20 focus:bg-white focus:border-teal-500 outline-none transition-all text-xs text-gray-600 font-medium">
                        </div>
                        <div class="flex-1 min-w-[120px]">
                            <label
                                class="block text-[9px] font-medium text-gray-400 uppercase tracking-widest mb-1 ml-1">
                                Sampai Tanggal
                            </label>
                            <input type="date" name="end_date" value="{{ $endDate }}"
                                class="w-full px-3 py-1.5 bg-gray-50 border border-gray-100 rounded-lg focus:ring-2 focus:ring-teal-500/20 focus:bg-white focus:border-teal-500 outline-none transition-all text-xs text-gray-600 font-medium">
                        </div>
                        <button type="submit"
                            class="px-4 py-1.5 bg-gray-800 text-white rounded-lg font-medium text-xs hover:bg-black transition-all h-[34px]">
                            Filter
                        </button>
                    </form>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div class="bg-white p-2.5 rounded-xl border border-gray-100 shadow-sm flex items-center">
                        <div
                            class="w-8 h-8 bg-teal-50 text-teal-600 rounded-lg flex items-center justify-center mr-2.5 flex-shrink-0">
                            <i class="bi bi-currency-dollar text-base"></i>
                        </div>
                        <div class="min-w-0">
                            <p class="text-[9px] font-medium text-gray-400 uppercase tracking-widest truncate">
                                Pendapatan</p>
                            <h3 class="text-sm font-bold text-gray-800 truncate">
                                Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                            </h3>
                        </div>
                    </div>
                    <div class="bg-white p-2.5 rounded-xl border border-gray-100 shadow-sm flex items-center">
                        <div
                            class="w-8 h-8 bg-orange-50 text-orange-600 rounded-lg flex items-center justify-center mr-2.5 flex-shrink-0">
                            <i class="bi bi-bag-check text-base"></i>
                        </div>
                        <div class="min-w-0">
                            <p class="text-[9px] font-medium text-gray-400 uppercase tracking-widest truncate">Selesai
                            </p>
                            <h3 class="text-sm font-bold text-gray-800 truncate">{{ $totalPesanan }}</h3>
                        </div>
                    </div>
                    <div class="bg-white p-2.5 rounded-xl border border-gray-100 shadow-sm flex items-center">
                        <div
                            class="w-8 h-8 bg-purple-50 text-purple-600 rounded-lg flex items-center justify-center mr-2.5 flex-shrink-0">
                            <i class="bi bi-people text-base"></i>
                        </div>
                        <div class="min-w-0">
                            <p class="text-[9px] font-medium text-gray-400 uppercase tracking-widest truncate">Pelanggan
                            </p>
                            <h3 class="text-sm font-bold text-gray-800 truncate">
                                {{ $orders->unique('user_id')->count() }}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex-1 bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col overflow-hidden">
                <div class="overflow-y-auto overflow-x-auto flex-1 custom-scrollbar">
                    <table class="w-full text-left border-separate border-spacing-0">
                        <thead class="sticky top-0 z-10">
                            <tr class="bg-gray-50">
                                <th
                                    class="px-6 py-4 text-[10px] font-medium text-gray-400 uppercase tracking-widest border-b border-gray-100">
                                    NO</th>
                                <th
                                    class="px-6 py-4 text-[10px] font-medium text-gray-400 uppercase tracking-widest border-b border-gray-100">
                                    Pelanggan</th>
                                <th
                                    class="px-6 py-4 text-[10px] font-medium text-gray-400 uppercase tracking-widest border-b border-gray-100">
                                    Produk</th>
                                <th
                                    class="px-6 py-4 text-[10px] font-medium text-gray-400 uppercase tracking-widest border-b border-gray-100 text-right">
                                    Total</th>
                                <th
                                    class="px-6 py-4 text-[10px] font-medium text-gray-400 uppercase tracking-widest border-b border-gray-100 text-center">
                                    Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse ($orders as $order)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4 text-sm font-medium text-teal-600 whitespace-nowrap">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-700">{{ $order->user->name }}</div>
                                        <div class="text-[11px] text-gray-400 font-medium">{{ $order->user->email }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-600 whitespace-nowrap">
                                        {{ $order->product->nama }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-bold text-gray-800 text-right whitespace-nowrap">
                                        Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        <span
                                            class="px-3 py-1 bg-teal-50 text-teal-600 rounded-full text-[10px] font-bold uppercase tracking-wider">
                                            {{ $order->status_pembayaran }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-20 text-center">
                                        <div class="flex flex-col items-center">
                                            <i class="bi bi-inbox text-5xl text-gray-200 mb-3"></i>
                                            <p class="text-gray-400 font-medium text-sm">Tidak ada data pesanan pada
                                                periode ini.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #cbd5e1;
        }
    </style>
</x-app-layout>



