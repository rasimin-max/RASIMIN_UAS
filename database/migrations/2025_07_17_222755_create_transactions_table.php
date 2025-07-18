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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id(); // primary key
            $table->string('invoice_number'); // contoh: INV-20250718-001
            $table->integer('total_price'); // total harga semua produk
            $table->string('payment_method')->default('Manual Transfer'); // metode bayar
            $table->string('status')->default('Success'); // status transaksi
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};

