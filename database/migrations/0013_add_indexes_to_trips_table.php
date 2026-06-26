<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->index('departure_date', 'trips_departure_date_index');
            $table->index('departure_city', 'trips_departure_city_index');
            $table->index('arrival_city', 'trips_arrival_city_index');
            $table->index('bus_id', 'trips_bus_id_index');
        });
    }

    public function down(): void
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->dropIndex('trips_departure_date_index');
            $table->dropIndex('trips_departure_city_index');
            $table->dropIndex('trips_arrival_city_index');
            $table->dropIndex('trips_bus_id_index');
        });
    }
};
