<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan Aurora Florist</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #0d9488; padding-bottom: 10px; }
        .header h2 { color: #0d9488; margin: 0; }
        .info { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f9fafb; color: #666; text-transform: uppercase; font-size: 10px; }
        .text-right { text-align: right; }
        .footer { margin-top: 30px; text-align: right; font-size: 11px; }
        .summary { margin-top: 20px; background: #f0fdfa; padding: 15px; border-radius: 8px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>AURORA FLORIST</h2>
        <p>Laporan Penjualan Rekapitulasi <br> Periode: {{ $startDate }} s/d {{ $endDate }}</p>
    </div>

    <div class="summary">
        <strong>Total Pesanan:</strong> {{ $orders->count() }} Pesanan<br>
        <strong>Total Pendapatan:</strong> Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Pelanggan</th>
                <th>Produk</th>
                <th>Tanggal</th>
                <th class="text-right">Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $order->user->name }}</td>
                <td>{{ $order->product->nama }}</td>
                <td>{{ $order->created_at->format('d/m/Y') }}</td>
                <td class="text-right">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" class="text-right">Grand Total</th>
                <th class="text-right">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        Dicetak pada: {{ now()->format('d M Y H:i') }}
    </div>
</body>
</html>