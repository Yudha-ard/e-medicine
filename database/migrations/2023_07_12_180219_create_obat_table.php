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
        Schema::create('obat', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('stock');
            $table->integer('harga');
            $table->integer('diskon')->nullable();
            $table->string('img_obat')->default('obat.png')->nullable();
            $table->bigInteger('kategori_id')->unsigned()->nullable();
            $table->bigInteger('apotek_id')->unsigned()->nullable();
            $table->enum('status',['Tersedia','Habis']);	
            $table->text('deskripsi')->nullable();
            $table->timestamps();
            $table->foreign('kategori_id')->references('id')->on('kategori_obat')->onDelete('cascade');
            $table->foreign('apotek_id')->references('id')->on('apotek')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obat');
    }
};
