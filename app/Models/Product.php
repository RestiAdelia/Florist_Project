<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
     use HasFactory;
    protected $table = 'products';
    protected $fillable = [
        'category_id',
        'nama',
        'harga',
        'stok',
        'deskripsi',
        'gambar',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'stok' => 'string',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
