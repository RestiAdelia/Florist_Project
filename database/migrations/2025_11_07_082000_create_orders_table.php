<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')
                ->constrained('products')
                ->onDelete('cascade');
           $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->string('no_telepon');
            $table->string('jenis_ucapan')->nullable();
            $table->text('pesan_dari')->nullable();
            $table->text('pesan_untuk')->nullable();
            $table->text('text_ucapan')->nullable();
            $table->text('alamat');
            $table->date('tanggal_pengiriman');
            $table->string('snap_token')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('payment_type')->nullable();
            $table->enum('metode_pembayaran', ['COD', 'Transfer', 'E-Wallet'])->nullable();
            $table->string('bukti_transfer')->nullable();
            $table->enum('status_pembayaran', [
                'menunggu_pembayaran',
                'dibayar',
                'diproses',
                'dikirim',
                'selesai',
                'dibatalkan',
            ])->default('menunggu_pembayaran');


            $table->decimal('total_harga', 12, 2);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
