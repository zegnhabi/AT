<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BusSeeder extends Seeder
{
    public function run(): void
    {
        $buses = [
            ['seat_count' => 36, 'model_year' => 2009, 'serial_number' => 'WE435TF6', 'driver_id' => 1],
            ['seat_count' => 36, 'model_year' => 2009, 'serial_number' => 'WE435TF6', 'driver_id' => 2],
            ['seat_count' => 36, 'model_year' => 2009, 'serial_number' => 'WE435TF6', 'driver_id' => 3],
            ['seat_count' => 36, 'model_year' => 2009, 'serial_number' => 'WE435TF6', 'driver_id' => 4],
            ['seat_count' => 36, 'model_year' => 2009, 'serial_number' => 'WE435TF6', 'driver_id' => 5],
        ];

        DB::table('buses')->insert($buses);
    }
}
