<x-app-layout>
    <x-slot:title>Konfirmasi Pesanan</x-slot:title>

    <div class="w-full mx-auto py-12 px-4 sm:px-6 lg:px-8" x-data="{ searchTerm: '' }">

        {{-- Alert Success --}}
        @if (session('success'))
            <div class="mb-8 flex items-center p-4 bg-teal-50 border-l-4 border-teal-500 rounded-r shadow-sm">
                <svg class="h-6 w-6 text-teal-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-teal-900 font-medium">{{ session('success') }}</span>
            </div>
        @endif

        {{-- Card --}}
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-200">

            {{-- Header --}}
            <div
                class="p-6 sm:p-8 border-b border-gray-100 bg-white flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-800">Pesanan Menunggu Konfirmasi</h2>
                    <p class="text-gray-500 mt-1 text-sm sm:text-base">Kelola dan update status pesanan.</p>
                </div>

                {{-- Search --}}
                <div class="relative w-full md:w-80">
                    <input type="text" x-model="searchTerm"
                        class="block w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl bg-gray-50 placeholder-gray-400 focus:ring-2 focus:ring-teal-500 text-sm"
                        placeholder="Cari nama, produk...">

                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- TABLE HEADER --}}
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 table-fixed">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-center text-xs font-bold text-teal-900 uppercase w-1/12">No</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-teal-900 uppercase w-2/12">Pembeli
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-teal-900 uppercase w-2/12">Produk</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-teal-900 uppercase w-2/12">Total
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-teal-900 uppercase w-2/12">Status
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-teal-900 uppercase w-3/12">Update
                                Status</th>
                        </tr>
                    </thead>
                </table>

                {{-- TABLE BODY --}}
                <div class="max-h-80 overflow-y-auto">
                    <table class="min-w-full divide-y divide-gray-100 table-fixed">
                        <tbody class="bg-white divide-y divide-gray-100">
                            @php $index = 0; @endphp

                            @forelse ($orders as $order)
                                @php $index++; @endphp

                                <tr class="hover:bg-teal-50/50 transition-colors duration-200"
                                    x-show="searchTerm === '' ||
                            '{{ strtolower($order->user->name) }}'.includes(searchTerm.toLowerCase()) ||
                            '{{ strtolower($order->product->nama) }}'.includes(searchTerm.toLowerCase())">

                                    {{-- No --}}
                                    <td class="px-6 py-4 text-center text-sm text-gray-600 font-medium w-1/12">
                                        {{ $index }}
                                    </td>

                                    {{-- Pembeli --}}
                                    <td class="px-6 py-4 text-left w-1/12">
                                        <span class="text-sm font-semibold text-gray-900">
                                            {{ $order->user->name }}
                                        </span>
                                    </td>

                                    {{-- Produk --}}
                                    <td class="px-6 py-4 text-left w-3/12">
                                        <span class="text-sm text-gray-700">
                                            {{ $order->product->nama }}
                                        </span>
                                    </td>

                                    {{-- Total --}}
                                    <td class="px-6 py-4 text-left text-sm font-bold text-teal-700 w-3/12">
                                        Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                                    </td>

                                    {{-- Status --}}
                                    <td class="px-6 py-4 text-center   w-3/12">
                                        @php
                                            $statusClass = match ($order->status_pesanan) {
                                                'menunggu_konfirmasi' => 'bg-amber-100 text-amber-800',
                                                'diproses' => 'bg-sky-100 text-sky-800',
                                                'dikirim' => 'bg-indigo-100 text-indigo-800',
                                                'selesai' => 'bg-teal-100 text-teal-800',
                                                'dibatalkan' => 'bg-rose-100 text-rose-800',
                                                default => 'bg-gray-100 text-gray-800',
                                            };
                                        @endphp
                                        <span class="px-3 py-1 text-xs font-bold rounded-full {{ $statusClass }}">
                                            {{ ucfirst(str_replace('_', ' ', $order->status_pesanan)) }}
                                        </span>
                                    </td>

                                    {{-- Update --}}
                                    <td class="px-6 py-4 text-center w-2/12">
                                        <form action="{{ route('admin.orders.updateStatus', $order->id) }}"
                                            method="POST" class="flex items-center justify-center gap-2">
                                            @csrf
                                            @method('PUT')

                                            <select name="status_pesanan"
                                                class="w-36 pl-3 pr-7 py-1.5 text-xs border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 bg-white">
                                                <option value="menunggu_konfirmasi">Menunggu Konfirmasi </option>
                                                <option value="diproses">Diproses</option>
                                                <option value="dikirim">Dikirim</option>
                                                <option value="selesai">Selesai</option>
                                                <option value="dibatalkan">Dibatalkan</option>
                                            </select>

                                            <button type="submit"
                                                class="w-8 h-8 flex items-center justify-center bg-teal-600 text-white rounded-lg hover:bg-teal-700">
                                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                        Tidak ada pesanan masuk.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>


            {{-- Pagination --}}
            {{-- @if (method_exists($orders, 'hasPages') && $orders->hasPages())
                <div class="bg-gray-50 px-6 py-3 border-t border-gray-200">
                    {{ $orders->links() }}
                </div>
            @endif --}}
        </div>
    </div>

    <script src="//unpkg.com/alpinejs" defer></script>
</x-app-layout>
