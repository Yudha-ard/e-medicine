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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('img_profile')->default('user.png')->nullable();
            $table->tinyInteger('role')->default(0)->comment('0:Customer, 1:Admin, 2:Apoteker, 3:Kurir');
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->enum('status',['active','inactive']);
            $table->bigInteger('apotek_id')->unsigned()->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('apotek_id')->references('id')->on('apotek');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
