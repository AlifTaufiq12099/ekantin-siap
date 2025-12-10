<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PenjualSeeder extends Seeder
{
    public function run(): void
    {
        // Create a lapak
        $lapakId = DB::table('lapaks')->insertGetId([
            'nama_lapak' => 'Lapak IFA',
            'pemilik' => 'Ifa',
            'no_hp_pemilik' => '081234567890',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Create penjual linked to lapak
        DB::table('penjuals')->updateOrInsert([
            'email' => 'ifa@example.com'
        ],[
            'nama_penjual' => 'Ifa Pemilik',
            'password' => Hash::make('123'),
            'no_hp' => '081234567890',
            'lapak_id' => $lapakId,
            'created_at' => now(),
            'updated_at' => now()
        ]);

                // 2. Lapak ALYA
        $lapak2 = DB::table('lapaks')->insertGetId([
            'nama_lapak' => 'Lapak ALYA',
            'pemilik' => 'Alya',
            'no_hp_pemilik' => '081234567891',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('penjuals')->updateOrInsert([
            'email' => 'alya@example.com'
        ],[
            'nama_penjual' => 'Alya Pemilik',
            'password' => Hash::make('123'),
            'no_hp' => '081234567891',
            'lapak_id' => $lapak2,
            'created_at' => now(),
            'updated_at' => now()
        ]);


        // 3. Lapak BUDI
        $lapak3 = DB::table('lapaks')->insertGetId([
            'nama_lapak' => 'Lapak BUDI',
            'pemilik' => 'Budi',
            'no_hp_pemilik' => '081234567892',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('penjuals')->updateOrInsert([
            'email' => 'budi@example.com'
        ],[
            'nama_penjual' => 'Budi Pemilik',
            'password' => Hash::make('123'),
            'no_hp' => '081234567892',
            'lapak_id' => $lapak3,
            'created_at' => now(),
            'updated_at' => now()
        ]);


        // 4. Lapak CITRA
        $lapak4 = DB::table('lapaks')->insertGetId([
            'nama_lapak' => 'Lapak CITRA',
            'pemilik' => 'Citra',
            'no_hp_pemilik' => '081234567893',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('penjuals')->updateOrInsert([
            'email' => 'citra@example.com'
        ],[
            'nama_penjual' => 'Citra Pemilik',
            'password' => Hash::make('123'),
            'no_hp' => '081234567893',
            'lapak_id' => $lapak4,
            'created_at' => now(),
            'updated_at' => now()
        ]);


        // 5. Lapak DONI
        $lapak5 = DB::table('lapaks')->insertGetId([
            'nama_lapak' => 'Lapak DONI',
            'pemilik' => 'Doni',
            'no_hp_pemilik' => '081234567894',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('penjuals')->updateOrInsert([
            'email' => 'doni@example.com'
        ],[
            'nama_penjual' => 'Doni Pemilik',
            'password' => Hash::make('123'),
            'no_hp' => '081234567894',
            'lapak_id' => $lapak5,
            'created_at' => now(),
            'updated_at' => now()
        ]);


        // 6. Lapak EKA
        $lapak6 = DB::table('lapaks')->insertGetId([
            'nama_lapak' => 'Lapak EKA',
            'pemilik' => 'Eka',
            'no_hp_pemilik' => '081234567895',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('penjuals')->updateOrInsert([
            'email' => 'eka@example.com'
        ],[
            'nama_penjual' => 'Eka Pemilik',
            'password' => Hash::make('123'),
            'no_hp' => '081234567895',
            'lapak_id' => $lapak6,
            'created_at' => now(),
            'updated_at' => now()
        ]);


        // 7. Lapak FAJAR
        $lapak7 = DB::table('lapaks')->insertGetId([
            'nama_lapak' => 'Lapak FAJAR',
            'pemilik' => 'Fajar',
            'no_hp_pemilik' => '081234567896',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('penjuals')->updateOrInsert([
            'email' => 'fajar@example.com'
        ],[
            'nama_penjual' => 'Fajar Pemilik',
            'password' => Hash::make('123'),
            'no_hp' => '081234567896',
            'lapak_id' => $lapak7,
            'created_at' => now(),
            'updated_at' => now()
        ]);


        // 8. Lapak GINA
        $lapak8 = DB::table('lapaks')->insertGetId([
            'nama_lapak' => 'Lapak GINA',
            'pemilik' => 'Gina',
            'no_hp_pemilik' => '081234567897',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('penjuals')->updateOrInsert([
            'email' => 'gina@example.com'
        ],[
            'nama_penjual' => 'Gina Pemilik',
            'password' => Hash::make('123'),
            'no_hp' => '081234567897',
            'lapak_id' => $lapak8,
            'created_at' => now(),
            'updated_at' => now()
        ]);


        // 9. Lapak HADI
        $lapak9 = DB::table('lapaks')->insertGetId([
            'nama_lapak' => 'Lapak HADI',
            'pemilik' => 'Hadi',
            'no_hp_pemilik' => '081234567898',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('penjuals')->updateOrInsert([
            'email' => 'hadi@example.com'
        ],[
            'nama_penjual' => 'Hadi Pemilik',
            'password' => Hash::make('123'),
            'no_hp' => '081234567898',
            'lapak_id' => $lapak9,
            'created_at' => now(),
            'updated_at' => now()
        ]);


        // 10. Lapak INTAN
        $lapak10 = DB::table('lapaks')->insertGetId([
            'nama_lapak' => 'Lapak INTAN',
            'pemilik' => 'Intan',
            'no_hp_pemilik' => '081234567899',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('penjuals')->updateOrInsert([
            'email' => 'intan@example.com'
        ],[
            'nama_penjual' => 'Intan Pemilik',
            'password' => Hash::make('123'),
            'no_hp' => '081234567899',
            'lapak_id' => $lapak10,
            'created_at' => now(),
            'updated_at' => now()
        ]);

    }
}
