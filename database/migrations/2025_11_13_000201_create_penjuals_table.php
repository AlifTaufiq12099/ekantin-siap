<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('penjuals', function (Blueprint $table) {
            $table->id('penjual_id');
            $table->string('nama_penjual');
            $table->string('email')->nullable();
            $table->string('password');
            $table->string('no_hp')->nullable();
            $table->unsignedBigInteger('lapak_id')->nullable();
            $table->timestamps();

            $table->foreign('lapak_id')->references('lapak_id')->on('lapaks')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('penjuals');
    }
};
