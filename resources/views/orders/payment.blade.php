@extends('layouts.app-user')

@section('content')
<div class="pt-20 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
    <div class="bg-white rounded-xl shadow-lg p-6 md:p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 border-b pb-4">
            Pembayaran Pesanan
        </h1>

        <!-- Order Summary -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Detail Pesanan</h2>
            
            <div class="bg-gray-50 rounded-lg p-6 space-y-4">
                <div class="flex items-start space-x-4">
                    <img src="{{ asset('storage/' . $order->product->gambar) }}" 
                         alt="{{ $order->product->nama }}"
                         class="w-24 h-24 object-cover rounded-lg flex-shrink-0">
                    <div class="flex-grow">
                        <h3 class="font-bold text-lg text-gray-800">{{ $order->product->nama }}</h3>
                        <p class="text-sm text-gray-600 mt-1">Order ID: #{{ $order->id }}</p>
                    </div>
                </div>

                <div class="border-t pt-4 space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">No. Telepon:</span>
                        <span class="font-semibold">{{ $order->no_telepon }}</span>
                    </div>
                    @if($order->jenis_ucapan)
                    <div class="flex justify-between">
                        <span class="text-gray-600">Jenis Ucapan:</span>
                        <span class="font-semibold">{{ $order->jenis_ucapan }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between">
                        <span class="text-gray-600">Tanggal Pengiriman:</span>
                        <span class="font-semibold">{{ $order->tanggal_pengiriman->format('d F Y') }}</span>
                    </div>
                    <div class="flex justify-between items-start">
                        <span class="text-gray-600">Alamat:</span>
                        <span class="font-semibold text-right max-w-xs">{{ $order->alamat }}</span>
                    </div>
                </div>

                <div class="border-t pt-4">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-bold text-gray-800">Total Pembayaran:</span>
                        <span class="text-2xl font-bold text-teal-600">
                            Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Button -->
        <div class="text-center">
            <button id="pay-button" 
                    class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 px-8 rounded-lg text-lg transition duration-200 shadow-md hover:shadow-lg">
                Bayar Sekarang
            </button>
            
            <p class="text-sm text-gray-500 mt-4">
                Anda akan diarahkan ke halaman pembayaran Midtrans yang aman
            </p>

            <a href="{{ route('orders.index') }}" 
               class="inline-block mt-6 text-teal-600 hover:text-teal-700 font-medium">
                ← Kembali ke Daftar Pesanan
            </a>
        </div>
    </div>
</div>

<!-- Midtrans Snap Script -->
@if(config('midtrans.is_production'))
    <script src="https://app.midtrans.com/snap/snap.js" 
            data-client-key="{{ config('midtrans.client_key') }}"></script>
@else
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" 
            data-client-key="{{ config('midtrans.client_key') }}"></script>
@endif

<script type="text/javascript">
    const payButton = document.getElementById('pay-button');
    
    payButton.addEventListener('click', function () {
        snap.pay('{{ $snapToken }}', {
            onSuccess: function(result) {
                console.log('Payment success:', result);
                window.location.href = '{{ route("orders.show", $order->id) }}?payment=success';
            },
            onPending: function(result) {
                console.log('Payment pending:', result);
                window.location.href = '{{ route("orders.show", $order->id) }}?payment=pending';
            },
            onError: function(result) {
                console.log('Payment error:', result);
                alert('Pembayaran gagal! Silakan coba lagi.');
            },
            onClose: function() {
                console.log('Payment popup closed');
                alert('Anda menutup popup pembayaran sebelum menyelesaikan pembayaran');
            }
        });
    });
</script>
@endsection