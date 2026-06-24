<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            DriverSeeder::class,
            BusSeeder::class,
            TripSeeder::class,
            TranslationSeeder::class,
        ]);
    }
}
