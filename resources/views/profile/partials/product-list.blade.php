<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
    @forelse ($products as $product)
        <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition flex flex-col">
            <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama }}"
                class="w-full h-48 object-contain bg-gray-100 p-4">
            <div class="p-4 flex-1 flex flex-col justify-between text-center">
                <p class="text-teal-500 font-bold mb-2">
                    Rp {{ number_format($product->harga, 0, ',', '.') }}
                </p>
                <h3 class="text-lg font-semibold text-gray-800 mb-4">{{ $product->nama }}</h3>
                <p class="text-sm text-gray-500 mb-3">{{ $product->category->nama ?? '-' }}</p>
                <a href="#"
                    class="mt-auto px-4 py-2 border border-teal-400 text-teal-500 rounded-full hover:bg-teal-500 hover:text-white transition">
                    Pesan
                </a>
            </div>
        </div>
    @empty
        <p class="text-center col-span-full text-gray-500">Belum ada produk tersedia.</p>
    @endforelse
</div>

@if ($products->hasPages())
    <div class="mt-10 flex justify-center pagination">
        {!! $products->links() !!}
    </div>
@endif
