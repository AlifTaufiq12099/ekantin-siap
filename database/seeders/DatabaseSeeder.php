<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\AdminSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Seed default admin
        $this->call(AdminSeeder::class);

        // Seed example penjual + lapak
        $this->call(\Database\Seeders\PenjualSeeder::class);

        // Seed example pembeli (accounts for buyers)
        $this->call(\Database\Seeders\PembeliSeeder::class);
    }
}
