@extends('layouts.app-user')

@section('content')
    <div class="pt-20 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold text-gray-800 mb-8 border-b-2 pb-2">
            Buat Pesanan
        </h1>
        <form id="orderForm" action="{{ route('orders.store') }}" method="POST"
            class="bg-white p-6 rounded-xl shadow-md space-y-6">
            @csrf

            <div class="flex items-center space-x-4 border-b pb-4">
                <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama }}"
                    class="w-24 h-24 object-cover rounded-lg">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">{{ $product->nama }}</h2>
                    <p class="text-teal-600 font-semibold">
                        Rp {{ number_format($product->harga, 0, ',', '.') }}
                    </p>
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                </div>
            </div>

            <div>
                <label class="block font-semibold text-gray-700 mb-2">Nomor Telepon</label>
                <input type="text" name="no_telepon" id="no_telepon"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-teal-500 focus:border-teal-500"
                    placeholder="08123456789" required>
            </div>

            <div>
                <label class="block font-semibold text-gray-700 mb-2">Jenis Ucapan</label>
                <select name="jenis_ucapan" id="jenis_ucapan" class="w-full border-gray-300 rounded-lg shadow-sm">
                    <option value="">Pilih jenis ucapan</option>
                    <option value="Selamat Ulang Tahun">Selamat Ulang Tahun</option>
                    <option value="Selamat Pernikahan">Selamat Pernikahan</option>
                    <option value="Selamat Wisuda">Selamat Wisuda</option>
                    <option value="Selamat Sukses">Selamat Sukses</option>
                    <option value="Turut Berduka Cita">Turut Berduka Cita</option>
                    <option value="Ucapan Lainnya">Ucapan Lainnya</option>
                </select>
            </div>

            <div>
                <label class="block font-semibold text-gray-700 mb-2">Pesan Dari</label>
                <textarea name="pesan_dari" id="pesan_dari" rows="2" class="w-full border-gray-300 rounded-lg shadow-sm"
                    placeholder="Nama pengirim (opsional)"></textarea>
            </div>

            <div>
                <label class="block font-semibold text-gray-700 mb-2">Pesan Untuk</label>
                <textarea name="pesan_untuk" id="pesan_untuk" rows="2" class="w-full border-gray-300 rounded-lg shadow-sm"
                    placeholder="Nama penerima (opsional)"></textarea>
            </div>

            <div>
                <label class="block font-semibold text-gray-700 mb-2">Teks Ucapan</label>
                <textarea name="text_ucapan" id="text_ucapan" rows="3" class="w-full border-gray-300 rounded-lg shadow-sm"
                    placeholder="Isi ucapan di papan bunga"></textarea>
            </div>

            {{-- <div class="mb-4">
            <label for="tanggal_pengiriman" class="block text-sm font-semibold text-gray-700">
                Tanggal Pengiriman <span class="text-red-500">*</span>
            </label>
            <input type="date" name="tanggal_pengiriman" id="tanggal_pengiriman"
                class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm px-3 py-2 focus:ring-teal-500 focus:border-teal-500"
                required min="{{ date('Y-m-d') }}">
            @error('tanggal_pengiriman')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div> --}}
            <div class="mb-4">
                <label for="tanggal_pengiriman" class="block text-gray-700 font-semibold mb-2">
                    Tanggal Pengiriman
                </label>
                <input type="date" name="tanggal_pengiriman" id="tanggal_pengiriman"
                    class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-teal-500" required
                    min="{{ date('Y-m-d') }}">
            </div>


            <!-- ✅ Tambahan field baru -->
            <div>
                <label class="block font-semibold text-gray-700 mb-2">Alamat Pengantaran</label>
                <textarea name="alamat" id="alamat" rows="3"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-teal-500 focus:border-teal-500"
                    placeholder="Masukkan alamat lengkap pengantaran" required></textarea>
            </div>
            <!-- ✅ Akhir tambahan -->

            <div class="border-t pt-4">
                <p class="text-right text-lg font-semibold text-gray-800">
                    Total: <span id="total_harga_form">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                </p>
            </div>

            <div class="text-right">
                <button type="button" id="confirmOrder"
                    class="bg-teal-600 hover:bg-teal-700 text-white font-semibold py-2 px-6 rounded-lg">
                    Buat Pesanan
                </button>
            </div>
        </form>
    </div>

    <!-- ✅ Modal Konfirmasi -->
    <div id="confirmModal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-lg mx-4 lg:mx-0 max-h-[90vh] flex flex-col">
            <h2 class="text-2xl font-bold text-gray-800 mb-4 border-b pb-2 flex-shrink-0">
                Konfirmasi Detail Pesanan Anda
            </h2>

            <div class="flex-grow overflow-y-auto pr-2 custom-scrollbar">
                <div class="mb-4 flex-shrink-0">
                    <h3 class="text-lg font-bold text-gray-700 mb-2">Produk Dipilih:</h3>
                    <div class="flex items-center space-x-4">
                        <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama }}"
                            class="w-16 h-16 object-cover rounded-lg flex-shrink-0">
                        <div>
                            <p class="font-semibold text-gray-800">{{ $product->nama }}</p>
                            <p class="text-teal-600 font-bold" id="modalProductPrice">
                                Rp {{ number_format($product->harga, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mb-6 space-y-2 text-sm">
                    <h3 class="text-lg font-bold text-gray-700 mb-2">Detail Pesanan:</h3>
                    <p><span class="font-medium text-gray-600">No. Telepon:</span>
                        <span id="modalNoTelepon" class="font-semibold"></span>
                    </p>
                    <p><span class="font-medium text-gray-600">Jenis Ucapan:</span>
                        <span id="modalJenisUcapan" class="font-semibold"></span>
                    </p>
                    <p><span class="font-medium text-gray-600">Pesan Dari:</span>
                        <span id="modalPesanDari" class="font-semibold italic"></span>
                    </p>
                    <p><span class="font-medium text-gray-600">Pesan Untuk:</span>
                        <span id="modalPesanUntuk" class="font-semibold italic"></span>
                    </p>
                    <div class="border-t pt-2">
                        <p class="font-medium text-gray-600">Teks Ucapan:</p>
                        <p id="modalTextUcapan" class="whitespace-pre-wrap mt-1 p-2 bg-gray-100 rounded"></p>
                    </div>
                    <div class="border-t pt-2">
                        <p class="font-medium text-gray-600">Alamat Pengantaran:</p>
                        <p id="modalAlamat" class="font-semibold mt-1"></p>
                    </div>
                </div>
            </div>

            <div class="border-t pt-4 flex-shrink-0">
                <p class="text-right text-xl font-bold text-gray-800 mb-4">
                    TOTAL:
                    <span id="modalTotalHarga" class="text-teal-600">
                        Rp {{ number_format($product->harga, 0, ',', '.') }}
                    </span>
                </p>

                <div class="flex items-start mb-6">
                    <input type="checkbox" id="agreementCheckbox"
                        class="mt-1 h-4 w-4 text-teal-600 border-gray-300 rounded focus:ring-teal-500">
                    <label for="agreementCheckbox" class="ml-2 text-sm text-gray-700">
                        Saya telah memeriksa bahwa <strong>semua data yang dimasukkan sudah benar</strong> dan saya
                        menyetujui
                        <a href="#" class="text-teal-600 hover:text-teal-700 font-medium underline">
                            Syarat & Ketentuan
                        </a>
                        pemesanan.
                    </label>
                </div>
            </div>

            <div class="flex justify-end space-x-4 flex-shrink-0">
                <button type="button" id="cancelModal"
                    class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400 font-semibold">Batal</button>
                <button type="button" id="submitOrder" disabled
                    class="px-4 py-2 bg-teal-400 text-white rounded-lg cursor-not-allowed font-semibold">
                    Lanjut Pembayaran
                </button>
            </div>
        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const confirmOrderButton = document.getElementById('confirmOrder');
            const confirmModal = document.getElementById('confirmModal');
            const cancelModalButton = document.getElementById('cancelModal');
            const submitOrderButton = document.getElementById('submitOrder');
            const agreementCheckbox = document.getElementById('agreementCheckbox');
            const orderForm = document.getElementById('orderForm');

            function showConfirmationModal() {
                const noTelepon = document.getElementById('no_telepon').value.trim();
                const alamat = document.getElementById('alamat').value.trim();

                if (!noTelepon || !alamat) {
                    alert('Mohon lengkapi Nomor Telepon dan Alamat Pengantaran sebelum melanjutkan.');
                    return;
                }

                const jenisUcapan = document.getElementById('jenis_ucapan').value || 'Tidak Dipilih';
                const pesanDari = document.getElementById('pesan_dari').value || '-';
                const pesanUntuk = document.getElementById('pesan_untuk').value || '-';
                const textUcapan = document.getElementById('text_ucapan').value || '-';

                document.getElementById('modalNoTelepon').textContent = noTelepon;
                document.getElementById('modalJenisUcapan').textContent = jenisUcapan;
                document.getElementById('modalPesanDari').textContent = pesanDari;
                document.getElementById('modalPesanUntuk').textContent = pesanUntuk;
                document.getElementById('modalTextUcapan').textContent = textUcapan;
                document.getElementById('modalAlamat').textContent = alamat;

                agreementCheckbox.checked = false;
                submitOrderButton.disabled = true;
                submitOrderButton.classList.remove('bg-teal-600', 'hover:bg-teal-700');
                submitOrderButton.classList.add('bg-teal-400', 'cursor-not-allowed');

                confirmModal.classList.remove('hidden');
            }

            confirmOrderButton.addEventListener('click', showConfirmationModal);

            cancelModalButton.addEventListener('click', () => {
                confirmModal.classList.add('hidden');
            });

            agreementCheckbox.addEventListener('change', () => {
                if (agreementCheckbox.checked) {
                    submitOrderButton.disabled = false;
                    submitOrderButton.classList.remove('bg-teal-400', 'cursor-not-allowed');
                    submitOrderButton.classList.add('bg-teal-600', 'hover:bg-teal-700');
                } else {
                    submitOrderButton.disabled = true;
                    submitOrderButton.classList.remove('bg-teal-600', 'hover:bg-teal-700');
                    submitOrderButton.classList.add('bg-teal-400', 'cursor-not-allowed');
                }
            });

            submitOrderButton.addEventListener('click', () => {
                if (agreementCheckbox.checked) orderForm.submit();
                else alert('Anda harus menyetujui Syarat & Ketentuan untuk melanjutkan.');
            });

            confirmModal.addEventListener('click', (e) => {
                if (e.target === confirmModal) confirmModal.classList.add('hidden');
            });
        });
    </script>
@endsection
