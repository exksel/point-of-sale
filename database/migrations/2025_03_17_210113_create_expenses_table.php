<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id(); // Auto-increment primary key
            $table->string('expense_id')->unique(); // Bukan primary, tapi tetap unik
            $table->string('user_full_name'); // Menyimpan nama lengkap user
            $table->string('expense_name');
            $table->integer('quantity');
            $table->integer('expense_total');
            $table->text('note')->nullable();
            $table->timestamp('expense_date')->default(DB::raw('CURRENT_TIMESTAMP')); // Tanggal otomatis
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
