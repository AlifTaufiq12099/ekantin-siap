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
        Schema::create('messages', function (Blueprint $table) {
            $table->id('message_id');
            $table->unsignedBigInteger('sender_id');
            $table->string('sender_type'); // 'pembeli' or 'penjual'
            $table->unsignedBigInteger('receiver_id');
            $table->string('receiver_type'); // 'pembeli' or 'penjual'
            $table->unsignedBigInteger('lapak_id');
            $table->text('message');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            $table->foreign('lapak_id')->references('lapak_id')->on('lapaks')->onDelete('cascade');
            // No direct foreign keys to users/penjuals as sender/receiver can be either
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
