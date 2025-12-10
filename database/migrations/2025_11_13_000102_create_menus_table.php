<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id('menu_id');
            $table->string('nama_menu');
            $table->text('deskripsi')->nullable();
            $table->decimal('harga', 12, 2)->default(0);
            $table->string('kategori')->nullable();
            $table->integer('stok')->default(0);
            $table->unsignedBigInteger('lapak_id')->nullable();
            $table->timestamps();

            $table->foreign('lapak_id')->references('lapak_id')->on('lapaks')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('menus');
    }
};
