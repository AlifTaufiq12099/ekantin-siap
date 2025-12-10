<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('lapaks', function (Blueprint $table) {
            $table->id('lapak_id');
            $table->string('nama_lapak');
            $table->string('pemilik')->nullable();
            $table->string('no_hp_pemilik')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lapaks');
    }
};
