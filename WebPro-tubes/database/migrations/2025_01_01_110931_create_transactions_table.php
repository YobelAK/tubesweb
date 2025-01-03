<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->decimal('harga', 10, 2);
            $table->timestamp('waktu');
            $table->enum('status', ['Sukses', 'Pending', 'Gagal'])->default('Pending');
            $table->string('metode_pembayaran');
            $table->boolean('user_confirm')->default(false);
            $table->string('username');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
