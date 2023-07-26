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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->timestamp('tgl_transaksi');
            $table->string('no_transaksi');
            $table->enum('pembayaran',['Bank', 'Tunai','E-Wallet']);
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('apotek_id')->unsigned()->nullable();
            $table->bigInteger('total');
            $table->bigInteger('paid');
            $table->enum('status',['Done','Accept','On Process','Delivered','Cancel','Pending']);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('apotek_id')->references('id')->on('apotek')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
