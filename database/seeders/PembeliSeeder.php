<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Lapak;
use App\Models\Menu;

class PembeliSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks for safe truncation
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        if (DB::getSchemaBuilder()->hasTable('transaksis')) {
            DB::table('transaksis')->truncate();
        }
        if (DB::getSchemaBuilder()->hasTable('users')) {
            DB::table('users')->truncate();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Create sample pembeli accounts
        $users = [
            ['name' => 'Budi', 'email' => 'budi@example.com', 'password' => Hash::make('secret123')],
            ['name' => 'Siti', 'email' => 'siti@example.com', 'password' => Hash::make('secret123')],
        ];

        foreach ($users as $u) {
            User::create($u);
        }

        // For each existing lapak, create example menus if none exist
        $lapaks = Lapak::all();
        foreach ($lapaks as $lapak) {
            $count = Menu::where('lapak_id', $lapak->lapak_id)->count();
            if ($count === 0) {
                Menu::create([
                    'nama_menu' => 'Nasi Goreng ' . $lapak->nama_lapak,
                    'deskripsi' => 'Nasi goreng spesial dari ' . $lapak->nama_lapak,
                    'harga' => 12000,
                    'kategori' => 'makanan',
                    'stok' => 30,
                    'lapak_id' => $lapak->lapak_id,
                ]);

                Menu::create([
                    'nama_menu' => 'Es Teh ' . $lapak->nama_lapak,
                    'deskripsi' => 'Es teh manis segar',
                    'harga' => 4000,
                    'kategori' => 'minuman',
                    'stok' => 50,
                    'lapak_id' => $lapak->lapak_id,
                ]);
            }
        }
    }
}
