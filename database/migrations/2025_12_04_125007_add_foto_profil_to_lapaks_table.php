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
        Schema::table('lapaks', function (Blueprint $table) {
            if (!Schema::hasColumn('lapaks', 'foto_profil')) {
                $table->string('foto_profil')->nullable()->after('no_hp_pemilik');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lapaks', function (Blueprint $table) {
            if (Schema::hasColumn('lapaks', 'foto_profil')) {
                $table->dropColumn('foto_profil');
            }
        });
    }
};
