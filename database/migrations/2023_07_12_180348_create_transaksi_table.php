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
            $table->bigInteger('apoteker')->unsigned();
            $table->foreign('apoteker')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('kurir')->unsigned();
            $table->foreign('kurir')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('apotek_id')->unsigned()->nullable();
            $table->foreign('apotek_id')->references('id')->on('apotek')->onDelete('cascade');
            $table->bigInteger('total');
            $table->bigInteger('paid');
            $table->enum('status',['Done','On Process','Delivered','Cancel']);
            $table->timestamps();
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
