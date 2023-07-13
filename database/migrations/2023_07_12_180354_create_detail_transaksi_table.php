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
        Schema::create('detail_transaksi', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("transaksi_id")->unsigned();
            $table->foreign("transaksi_id")->references("id")->on("transaksi")->onDelete("cascade");
            $table->bigInteger("obat_id")->unsigned();
            $table->foreign("obat_id")->references("id")->on("obat")->onDelete("cascade");
            $table->bigInteger("qty")->unsigned();
            $table->bigInteger("total")->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_transaksi');
    }
};
