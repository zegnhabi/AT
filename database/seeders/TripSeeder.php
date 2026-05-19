<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TripSeeder extends Seeder
{
    public function run(): void
    {
        $trips = [];
        $id = 1;

        $routes = [
            ['from' => 'MARTINEZ DE LA TORRE', 'to' => 'TLAPACOYAN', 'bus' => 1],
            ['from' => 'MARTINEZ DE LA TORRE', 'to' => 'TLAPACOYAN', 'bus' => 2],
            ['from' => 'MARTINEZ DE LA TORRE', 'to' => 'TLAPACOYAN', 'bus' => 3],
            ['from' => 'TLAPACOYAN', 'to' => 'MARTINEZ DE LA TORRE', 'bus' => 4],
            ['from' => 'TLAPACOYAN', 'to' => 'MARTINEZ DE LA TORRE', 'bus' => 1],
            ['from' => 'TLAPACOYAN', 'to' => 'MARTINEZ DE LA TORRE', 'bus' => 2],
        ];

        $times = [
            ['departure' => '07:00:00', 'arrival' => '00:30:00'],
            ['departure' => '10:30:00', 'arrival' => '11:00:00'],
            ['departure' => '14:00:00', 'arrival' => '14:30:00'],
            ['departure' => '17:30:00', 'arrival' => '18:00:00'],
            ['departure' => '20:00:00', 'arrival' => '20:30:00'],
            ['departure' => '23:00:00', 'arrival' => '23:30:00'],
        ];

        for ($day = 0; $day < 30; $day++) {
            $date = now()->addDays($day)->format('Y-m-d');
            foreach ($routes as $i => $route) {
                $t = $times[$i % count($times)];
                $trips[] = [
                    'departure_time' => $t['departure'],
                    'arrival_time' => $t['arrival'],
                    'bus_id' => $route['bus'],
                    'departure_terminal' => $route['from'],
                    'departure_city' => $route['from'],
                    'departure_date' => $date,
                    'arrival_terminal' => $route['to'],
                    'arrival_city' => $route['to'],
                    'arrival_date' => $date,
                    'price' => 13.50,
                ];
            }
        }

        DB::table('trips')->insert($trips);
    }
}
