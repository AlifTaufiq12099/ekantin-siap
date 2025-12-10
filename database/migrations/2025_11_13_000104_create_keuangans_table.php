<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('keuangans', function (Blueprint $table) {
            $table->id('keuangan_id');
            $table->unsignedBigInteger('lapak_id')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('jenis_transaksi')->nullable();
            $table->decimal('jumlah_uang', 14, 2)->default(0);
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('lapak_id')->references('lapak_id')->on('lapaks')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('keuangans');
    }
};
