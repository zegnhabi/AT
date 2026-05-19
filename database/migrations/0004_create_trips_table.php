<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->time('departure_time');
            $table->time('arrival_time');
            $table->unsignedBigInteger('bus_id');
            $table->string('departure_terminal', 50);
            $table->string('departure_city', 45);
            $table->date('departure_date');
            $table->string('arrival_terminal', 50);
            $table->string('arrival_city', 45);
            $table->date('arrival_date');
            $table->decimal('price', 10, 2);
            $table->timestamps();

            $table->foreign('bus_id')->references('id')->on('buses')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
