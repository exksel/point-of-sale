<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_code')->unique(); // Kode transaksi (TR001, TR002, dst)
            $table->string('email')->nullable();
            $table->string('cashier_name'); // Nama lengkap user yang login
            $table->integer('total'); // Total harga dalam integer
            $table->integer('paid'); // Nominal bayar
            $table->integer('change'); // Kembalian
            $table->string('payment_type');
            $table->timestamp('transaction_date')->useCurrent(); // Waktu transaksi
            $table->timestamps();
        });

        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained('transactions')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('product_name');
            $table->integer('quantity'); // Jumlah barang yang dibeli
            $table->integer('subtotal'); // Subtotal harga (quantity * harga produk)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_details');
        Schema::dropIfExists('transactions');
    }
};
