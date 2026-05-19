<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key', 50)->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        DB::table('settings')->insert([
            ['key' => 'company_name', 'value' => 'Autobuses S.A. de C.V'],
            ['key' => 'company_slogan', 'value' => 'Seguridad y confianza en cada viaje'],
            ['key' => 'primary_color', 'value' => '#ffc107'],
            ['key' => 'secondary_color', 'value' => '#212529'],
            ['key' => 'accent_color', 'value' => '#0d6efd'],
            ['key' => 'admin_primary_color', 'value' => '#2c3e50'],
            ['key' => 'admin_accent_color', 'value' => '#3498db'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
