<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;

class OrderController extends Controller
{
    public function __construct()
    {
        // Set konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    /**
     * Daftar pesanan user login
     */
  
    public function index(Request $request)
{
    $userId = Auth::id();
    
    // Gunakan nama variabel 'filter' atau 'status' agar tidak bingung dengan nama kolom DB
    $currentStatus = $request->get('status', 'All'); 

    // Query Dasar
    $query = Order::where('user_id', $userId)
        ->with('product')
        ->latest();

    // --- LOGIKA FILTERING YANG DIPERBAIKI ---
    if ($currentStatus === 'menunggu_pembayaran') {
        // Tampilkan yang belum bayar, TAPI jangan tampilkan yang sudah dibatalkan
        $query->where('status_pembayaran', 'menunggu_pembayaran')
              ->where('status_pesanan', '!=', 'dibatalkan');
              
    } elseif ($currentStatus === 'dibayar') {
        $query->where('status_pesanan', 'menunggu_konfirmasi');
        
    } elseif ($currentStatus === 'diproses') {
        $query->where('status_pesanan', 'diproses');
        
    } elseif ($currentStatus === 'selesai') {
        $query->where('status_pesanan', 'selesai');
        
    } elseif ($currentStatus === 'dibatalkan') {
        $query->where('status_pesanan', 'dibatalkan');
    }

    $orders = $query->paginate(10)->withQueryString();

    // --- MENGHITUNG JUMLAH (BADGE) ---
    // Kita clone query dasar user agar tidak mereset filter
    $baseCount = Order::where('user_id', $userId);
    
    $statusCounts = [
        'All' => (clone $baseCount)->count(),
        
        // Perbaikan logika hitung 'Belum Bayar': Kecualikan yang batal
        'menunggu_pembayaran' => (clone $baseCount)
            ->where('status_pembayaran', 'menunggu_pembayaran')
            ->where('status_pesanan', '!=', 'dibatalkan')
            ->count(),
            
        'dibayar' => (clone $baseCount)->where('status_pesanan', 'menunggu_konfirmasi')->count(),
        'diproses' => (clone $baseCount)->where('status_pesanan', 'diproses')->count(),
        'selesai' => (clone $baseCount)->where('status_pesanan', 'selesai')->count(),
        'dibatalkan' => (clone $baseCount)->where('status_pesanan', 'dibatalkan')->count(),
    ];

    return view('orders.index', compact('orders', 'statusCounts', 'currentStatus'));
}

    /**
     * Form pemesanan produk
     */
    public function create($productId)
    {
        $product = Product::findOrFail($productId);
        return view('orders.create', compact('product'));
    }

    /**
     * Simpan pesanan baru dan redirect ke halaman pembayaran Midtrans
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'no_telepon' => 'required|string|max:20',
            'jenis_ucapan' => 'nullable|string|max:100',
            'pesan_dari' => 'nullable|string',
            'pesan_untuk' => 'nullable|string',
            'text_ucapan' => 'nullable|string',
            'alamat' => 'required|string',
            'tanggal_pengiriman' => 'required|date|after_or_equal:today',
        ]);

        $product = Product::findOrFail($validated['product_id']);
        $user = Auth::user();

        // Buat pesanan
        $order = Order::create([
            'product_id' => $product->id,
            'user_id' => $user->id,
            'no_telepon' => $validated['no_telepon'],
            'jenis_ucapan' => $validated['jenis_ucapan'],
            'pesan_dari' => $validated['pesan_dari'],
            'pesan_untuk' => $validated['pesan_untuk'],
            'text_ucapan' => $validated['text_ucapan'],
            'alamat' => $validated['alamat'],
            'tanggal_pengiriman' => $validated['tanggal_pengiriman'],
            'total_harga' => $product->harga,
            'status_pembayaran' => 'menunggu_pembayaran',
        ]);

        try {
            // Parameter untuk Midtrans
            $transactionId = 'ORDER-' . $order->id . '-' . time();

            $params = [
                'transaction_details' => [
                    'order_id' => $transactionId,
                    'gross_amount' => (int) $product->harga,
                ],
                'customer_details' => [
                    'first_name' => $user->name ?? 'Pelanggan',
                    'email' => $user->email ?? '',
                    'phone' => $validated['no_telepon'],
                    'billing_address' => [
                        'address' => $validated['alamat'],
                    ],
                    'shipping_address' => [
                        'address' => $validated['alamat'],
                    ],
                ],
                'item_details' => [
                    [
                        'id' => $product->id,
                        'price' => (int) $product->harga,
                        'quantity' => 1,
                        'name' => $product->nama,
                    ]
                ],
            ];

            // Generate Snap Token
            $snapToken = Snap::getSnapToken($params);

            // Simpan snap token dan transaction_id ke order
            $order->update([
                'snap_token' => $snapToken,
                'transaction_id' => $transactionId,
            ]);

            // Redirect ke halaman pembayaran
            return view('orders.payment', compact('order', 'snapToken'));
        } catch (\Exception $e) {
            // Hapus order jika gagal generate token
            $order->delete();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal membuat transaksi pembayaran: ' . $e->getMessage());
        }
    }

    /**
     * Callback dari Midtrans (webhook)
     */
    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash(
            'sha512',
            $request->order_id .
                $request->status_code .
                $request->gross_amount .
                $serverKey
        );

        // Validasi signature key
        if ($hashed !== $request->signature_key) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // Ambil order berdasarkan transaction_id
        $order = Order::where('transaction_id', $request->order_id)->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Update status berdasarkan transaction_status dari Midtrans
        $transactionStatus = $request->transaction_status;
        $paymentType = $request->payment_type;

        switch ($transactionStatus) {
            case 'capture':
                if ($paymentType == 'credit_card') {
                    if ($request->fraud_status == 'challenge') {
                        $order->status_pembayaran = 'menunggu_pembayaran';
                    } else {
                        $order->status_pembayaran = 'dibayar';
                    }
                }
                break;

            case 'settlement':
                $order->status_pembayaran = 'dibayar';
                break;

            case 'pending':
                $order->status_pembayaran = 'menunggu_pembayaran';
                break;

            case 'deny':
            case 'expire':
            case 'cancel':
                $order->status_pembayaran = 'dibatalkan';
                break;
        }

        $order->payment_type = $paymentType;
        $order->save();

        return response()->json(['message' => 'Callback received']);
    }

    /**
     * Tampilkan detail pesanan
     */
    public function show($id)
    {
        $order = Order::where('user_id', Auth::id())
            ->where('id', $id)
            ->with('product')
            ->firstOrFail();

        $statuses = [
            'menunggu_pembayaran' => 'Belum Bayar',
            'dibayar' => 'Sudah Bayar',
            'diproses' => 'Diproses',
            'dikirim' => 'Dikirim',
            'selesai' => 'Selesai',
            'dibatalkan' => 'Dibatalkan',
        ];

        return view('orders.show', compact('order', 'statuses'));
    }

    /**
     * Halaman untuk bayar ulang jika pembayaran pending
     */
    public function pay($id)
    {
        $order = Order::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        if ($order->status_pembayaran !== 'menunggu_pembayaran') {
            return redirect()->route('orders.show', $order->id)
                ->with('error', 'Pesanan ini tidak dapat dibayar');
        }

        $snapToken = $order->snap_token;

        return view('orders.payment', compact('order', 'snapToken'));
    }

    /**
     * Check status pembayaran manual (untuk testing tanpa webhook)
     */
    public function checkStatus($id)
    {
        $order = Order::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        if (!$order->transaction_id) {
            return redirect()->back()->with('error', 'Transaction ID tidak ditemukan');
        }

        try {
            // Import Midtrans Transaction
            $status = \Midtrans\Transaction::status($order->transaction_id);

            // Update status order berdasarkan response Midtrans
            $transactionStatus = $status->transaction_status;

            switch ($transactionStatus) {
                case 'capture':
                    if ($status->payment_type == 'credit_card') {
                        if ($status->fraud_status == 'challenge') {
                            $order->status_pembayaran = 'menunggu_pembayaran';
                        } else {
                            $order->status_pembayaran = 'dibayar';
                        }
                    }
                    break;

                case 'settlement':
                    $order->status_pembayaran = 'dibayar';
                    break;

                case 'pending':
                    $order->status_pembayaran = 'menunggu_pembayaran';
                    break;

                case 'deny':
                case 'expire':
                case 'cancel':
                    $order->status_pembayaran = 'dibatalkan';
                    break;
            }

            $order->payment_type = $status->payment_type ?? null;
            $order->save();

            return redirect()->route('orders.show', $order->id)
                ->with('success', 'Status pembayaran berhasil diperbarui: ' . $order->status_pembayaran);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengecek status: ' . $e->getMessage());
        }
    }
}