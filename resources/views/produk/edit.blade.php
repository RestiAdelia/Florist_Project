<x-app-layout>
    <x-slot:title>Edit Produk</x-slot:title>

    <div class="flex justify-center py-8 px-4 sm:px-6 lg:px-8 min-h-screen bg-gray-100">
        <div class="w-full max-w-6xl h-full max-h-screen overflow-y-auto p-2 sm:p-4">
            <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data"
                  class="w-full bg-white shadow-xl rounded-xl border border-gray-100 p-6 sm:p-8 space-y-6">
                @csrf
                @method('PUT')

                {{-- Header --}}
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 sm:mb-8 gap-4 sm:gap-0">
                    <h2 class="text-2xl font-bold text-gray-800">Edit Produk</h2>
                    <a href="{{ route('produk.index') }}"
                       class="px-3 py-2 bg-teal-500 text-white rounded-md hover:bg-teal-600 text-sm flex items-center space-x-1">
                        <i class="bi bi-arrow-left"></i>
                        <span>Kembali ke Daftar</span>
                    </a>
                </div>

                {{-- Grid Form --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">

                    {{-- Kategori --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Kategori</label>
                        <select name="category_id"
                                class="w-full border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-teal-500 focus:border-teal-500">
                            @foreach ($categories as $c)
                                <option value="{{ $c->id }}" {{ $produk->category_id == $c->id ? 'selected' : '' }}>
                                    {{ $c->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Nama Produk --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Produk</label>
                        <input type="text" name="nama" value="{{ $produk->nama }}"
                               class="w-full border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-teal-500 focus:border-teal-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Harga (Rp)</label>
                        <input type="number" name="harga" value="{{ $produk->harga }}"
                               class="w-full border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-teal-500 focus:border-teal-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Stok</label>
                        <select name="stok"
                                class="w-full border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-teal-500 focus:border-teal-500">
                            @foreach ($stokOptions as $stok)
                                <option value="{{ $stok }}" {{ $produk->stok == $stok ? 'selected' : '' }}>
                                    {{ ucfirst($stok) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                     <div class="lg:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi</label>
                        <textarea name="deskripsi" rows="4"
                                  class="w-full border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-teal-500 focus:border-teal-500 resize-none">{{ $produk->deskripsi }}</textarea>
                    </div>

                    {{-- Upload & Preview Gambar --}}
                    <div class="lg:col-span-2 bg-gray-50 p-4 sm:p-6 rounded-xl border border-gray-100 shadow-sm">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Gambar Produk</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                            {{-- Dropzone --}}
                            <div id="dropZone"
                                class="w-full border-2 border-dashed border-gray-300 rounded-xl p-6 text-center cursor-pointer bg-white hover:bg-gray-100 transition duration-150"
                                onclick="document.getElementById('gambar').click()"
                                ondragover="event.preventDefault(); this.classList.add('border-teal-500','bg-teal-50')"
                                ondragleave="this.classList.remove('border-teal-500','bg-teal-50')"
                                ondrop="handleDrop(event)">
                                <i class="bi bi-cloud-upload text-3xl text-teal-500 mb-2"></i>
                                <p class="text-gray-600 font-medium">Drag & Drop gambar di sini</p>
                                <p class="text-sm text-gray-500">atau <span class="text-teal-600 underline">Pilih file</span></p>
                                <p class="text-xs text-gray-400 mt-1">Tipe file: .jpg, .jpeg, .png</p>
                            </div>

                            {{-- Preview --}}
                            <div id="previewContainer" class="flex flex-col items-center justify-center border border-dashed border-gray-200 rounded-xl p-4 bg-white">
                                <img id="imagePreview" class="max-h-64 w-auto rounded-lg shadow-md {{ $produk->gambar ? '' : 'hidden' }}" 
                                     src="{{ $produk->gambar ? asset('storage/' . $produk->gambar) : '' }}" alt="Preview Gambar">
                                <span id="noImageText" class="text-gray-400 text-sm mt-2 {{ $produk->gambar ? 'hidden' : '' }}">Belum ada gambar</span>
                                <button type="button" id="removeImageBtn" onclick="removeImage()"
                                        class="mt-3 px-3 py-1 text-sm bg-red-500 text-white rounded hover:bg-red-600 {{ $produk->gambar ? '' : 'hidden' }}">
                                    Hapus Gambar
                                </button>
                            </div>
                        </div>
                        <input type="file" id="gambar" name="gambar" accept="image/*" class="hidden" onchange="previewImage(event)">
                    </div>

                    {{-- Deskripsi --}}
                   
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex flex-col sm:flex-row justify-end gap-3 pt-6 sm:pt-8">
                    <a href="{{ route('produk.index') }}"
                       class="px-5 py-2 border border-gray-300 bg-white text-gray-700 rounded-lg hover:bg-gray-100 text-base font-medium text-center">
                        Batal
                    </a>
                    <button type="submit"
                            class="px-5 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 text-base font-medium shadow-md shadow-teal-300/50 flex items-center justify-center gap-1">
                        <i class="bi bi-save"></i> Perbarui Produk
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const dropZone = document.getElementById('dropZone');
        const inputFile = document.getElementById('gambar');
        const preview = document.getElementById('imagePreview');
        const noText = document.getElementById('noImageText');
        const removeBtn = document.getElementById('removeImageBtn');

        function handleDrop(event) {
            event.preventDefault();
            dropZone.classList.remove('border-teal-500', 'bg-teal-50');
            const file = event.dataTransfer.files[0];
            if (file) {
                inputFile.files = event.dataTransfer.files;
                previewImage({ target: inputFile });
            }
        }

        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = e => {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    noText.classList.add('hidden');
                    removeBtn.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                removeImage();
            }
        }

        function removeImage() {
            inputFile.value = "";
            preview.src = "";
            preview.classList.add('hidden');
            noText.classList.remove('hidden');
            removeBtn.classList.add('hidden');
        }
    </script>
w