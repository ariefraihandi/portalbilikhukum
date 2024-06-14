<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagihanTable extends Migration
{
    public function up()
    {
        Schema::create('tagihan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // ID pengguna yang ditagih
            $table->decimal('amount', 30, 2); // Jumlah tagihan
            $table->text('note'); // Catatan tagihan
            $table->enum('status', ['unpaid', 'paid']); // Status pembayaran
            $table->string('payment_method')->nullable(); // Metode pembayaran
            $table->timestamp('due_date')->nullable(); // Tanggal jatuh tempo
            $table->timestamp('paid_date')->nullable(); // Tanggal pembayaran
            $table->string('reference_id')->nullable(); // ID referensi (optional)
            $table->string('transaction_id')->nullable(); // ID transaksi (optional)
            $table->string('invoice_number')->unique(); // Nomor faktur/tagihan
            $table->string('currency', 3)->default('IDR'); // Mata uang (default ke IDR)
            $table->timestamps();

            // Foreign key
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tagihan');
    }
}
