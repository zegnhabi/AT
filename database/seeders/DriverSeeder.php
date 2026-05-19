<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DriverSeeder extends Seeder
{
    public function run(): void
    {
        $drivers = [
            ['name' => 'PONCE GONZALEZ ERIKA JAZMIN', 'gender' => 'F', 'age' => 19, 'phone' => '2271000000'],
            ['name' => 'DIAZ MELENDEZ YULIANA', 'gender' => 'F', 'age' => 25, 'phone' => '2221056489'],
            ['name' => 'HERNANDEZ GONZALEZ EDGAR', 'gender' => 'M', 'age' => 65, 'phone' => '2254896788'],
            ['name' => 'GOLPE PAXTIAN JOSE MANUEL', 'gender' => 'M', 'age' => 45, 'phone' => '2654112458'],
            ['name' => 'SANDOVAL GALLEGOS SULEMA', 'gender' => 'M', 'age' => 24, 'phone' => null],
            ['name' => 'PAREDES GUTIERREZ MAYRA DENISSE', 'gender' => 'F', 'age' => 22, 'phone' => null],
            ['name' => 'VILLEGAS GARCIA RUTH EUNICE', 'gender' => 'F', 'age' => 26, 'phone' => null],
            ['name' => 'AMARAL JAUREGUI JESUS ALONSO', 'gender' => 'M', 'age' => 23, 'phone' => null],
            ['name' => 'LOPEZ ARREOLA SORAYA IMET', 'gender' => 'F', 'age' => 56, 'phone' => null],
            ['name' => 'BELTRAN ESCARCEGA JESUS MANUEL', 'gender' => 'M', 'age' => 26, 'phone' => null],
            ['name' => 'PEREZ MORENO ISAAC', 'gender' => 'M', 'age' => 45, 'phone' => null],
            ['name' => 'MERIDA GARCIA HENRI JOSUE', 'gender' => 'M', 'age' => 26, 'phone' => null],
        ];

        DB::table('drivers')->insert($drivers);
    }
}
