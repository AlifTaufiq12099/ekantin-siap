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
        if (Schema::hasTable('lapak_logs')) {
            Schema::drop('lapak_logs');
        }

        Schema::create('lapak_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lapak_id');
            $table->unsignedBigInteger('changed_by')->nullable();
            $table->string('changed_by_role')->nullable();
            $table->json('old_data')->nullable();
            $table->json('new_data')->nullable();
            $table->timestamps();
            $table->foreign('lapak_id')->references('lapak_id')->on('lapaks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lapak_logs');
    }
};
