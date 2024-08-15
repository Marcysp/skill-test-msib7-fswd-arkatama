<?php

namespace Database\Seeders;

use App\Models\Travel;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Travel::create([
            'tanggal_keberangkatan' => '2024-08-19 08:46:20',
            'kuota' => '50',
        ]);
        Travel::create([
            'tanggal_keberangkatan' => '2024-08-15 10:46:20',
            'kuota' => '20',
        ]);
        Travel::create([
            'tanggal_keberangkatan' => '2024-08-12 09:46:20',
            'kuota' => '15',
        ]);
    }
}
