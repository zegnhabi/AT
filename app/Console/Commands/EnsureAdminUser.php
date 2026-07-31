<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class EnsureAdminUser extends Command
{
    protected $signature = 'admin:ensure';

    protected $description = 'Create or update the admin user';

    public function handle(): void
    {
        $username = getenv('ADMIN_USERNAME') ?: 'admin';
        $password = getenv('ADMIN_PASSWORD') ?: 'admin123';
        $name     = getenv('ADMIN_NAME') ?: 'Administrador';

        $user = User::updateOrCreate(
            ['username' => $username],
            ['name' => $name, 'password' => Hash::make($password)]
        );

        $this->info("Admin user ready: {$user->username}");
    }
}
