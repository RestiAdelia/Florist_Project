<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'no_telepon',
        'jenis_ucapan',
        'pesan_dari',
        'pesan_untuk',
        'text_ucapan',
        'alamat',
        'tanggal_pengiriman',
        'snap_token',
        'transaction_id',
        'payment_type',
        'metode_pembayaran',
        'bukti_transfer',
        'status_pembayaran',
        'status_pesanan',
        'total_harga',
    ];

    protected $casts = [
        'tanggal_pengiriman' => 'date',
        'total_harga' => 'decimal:2',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
