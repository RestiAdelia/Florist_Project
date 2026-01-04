<h2>Pesanan Masuk</h2>

<p><strong>ID Pesanan:</strong> {{ $order->transaction_id }}</p>
<p><strong>Produk:</strong> {{ $order->product->nama }}</p>
<p><strong>Total:</strong> Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>
<p><strong>Tanggal Kirim:</strong>
    {{ \Carbon\Carbon::parse($order->tanggal_pengiriman)->format('d M Y') }}
</p>

<hr>

<p>Silakan login ke dashboard admin untuk memproses pesanan.</p>
