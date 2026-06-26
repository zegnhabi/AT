<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $username = env('ADMIN_USERNAME', 'admin');
        $password = env('ADMIN_PASSWORD', 'admin123');
        $name     = env('ADMIN_NAME', 'Administrador');

        User::updateOrCreate(
            ['username' => $username],
            ['name' => $name, 'password' => Hash::make($password)]
        );
    }
}
