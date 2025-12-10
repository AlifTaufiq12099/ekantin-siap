<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('admins')->updateOrInsert([
            'username' => 'admin'
        ],[
            'nama' => 'Administrator',
            'password' => Hash::make('123'),
            'no_hp' => null,
            'email' => null,
            'alamat' => null,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
