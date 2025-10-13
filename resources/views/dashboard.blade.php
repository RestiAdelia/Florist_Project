{{-- resources/views/admin/dashboard.blade.php --}}
<x-app-layout>
     <x-slot:title>Dashboard</x-slot:title>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Ringkasan Dashboard</h1>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">
                
                <div class="bg-white overflow-hidden shadow-lg rounded-lg p-6 flex items-center justify-between transition duration-300 hover:shadow-xl hover:scale-[1.02]">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Produk</p>
                        <p class="text-4xl font-extrabold text-teal-600 mt-1">150</p>
                    </div>
                    <i class="bi bi-boxes text-4xl text-teal-400"></i>
                </div>

                <div class="bg-white overflow-hidden shadow-lg rounded-lg p-6 flex items-center justify-between transition duration-300 hover:shadow-xl hover:scale-[1.02]">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Pesanan Baru</p>
                        <p class="text-4xl font-extrabold text-emerald-600 mt-1">12</p>
                    </div>
                    <i class="bi bi-cart-check-fill text-4xl text-emerald-400"></i>
                </div>

                <div class="bg-white overflow-hidden shadow-lg rounded-lg p-6 flex items-center justify-between transition duration-300 hover:shadow-xl hover:scale-[1.02]">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Pelanggan</p>
                        <p class="text-4xl font-extrabold text-indigo-600 mt-1">450</p>
                    </div>
                    <i class="bi bi-people-fill text-4xl text-indigo-400"></i>
                </div>

                <div class="bg-white overflow-hidden shadow-lg rounded-lg p-6 flex items-center justify-between transition duration-300 hover:shadow-xl hover:scale-[1.02]">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Pendapatan (Bulan Ini)</p>
                        <p class="text-2xl font-extrabold text-yellow-600 mt-2">Rp 15.000.000</p>
                    </div>
                    <i class="bi bi-cash-stack text-4xl text-yellow-400"></i>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>