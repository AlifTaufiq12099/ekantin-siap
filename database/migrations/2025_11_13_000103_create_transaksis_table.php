<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id('transaksi_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('menu_id')->nullable();
            $table->unsignedBigInteger('lapak_id')->nullable();
            $table->timestamp('waktu_transaksi')->nullable();
            $table->integer('jumlah')->default(1);
            $table->decimal('total_harga', 12, 2)->default(0);
            $table->string('metode_pembayaran')->nullable();
            $table->string('status_transaksi')->default('diproses');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('menu_id')->references('menu_id')->on('menus')->onDelete('set null');
            $table->foreign('lapak_id')->references('lapak_id')->on('lapaks')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('transaksis');
    }
};
