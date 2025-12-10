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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id('rating_id');
            $table->unsignedBigInteger('transaksi_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('lapak_id');
            $table->tinyInteger('rating')->comment('Rating 1-5');
            $table->text('feedback')->nullable();
            $table->timestamps();
            
            $table->foreign('transaksi_id')->references('transaksi_id')->on('transaksis')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('lapak_id')->references('lapak_id')->on('lapaks')->onDelete('cascade');
            
            // Satu transaksi hanya bisa di-rating sekali
            $table->unique('transaksi_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
