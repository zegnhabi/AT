<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Trip;

class SeatsPageTest extends TestCase
{
    public function test_seats_page_loads_with_valid_trip(): void
    {
        $trip = Trip::first();
        if ($trip) {
            $response = $this->get("/elegir/{$trip->id}");
            $response->assertStatus(200);
        }
    }

    public function test_seats_page_returns_404_with_invalid_trip(): void
    {
        $response = $this->get('/elegir/99999');
        $response->assertStatus(404);
    }
}
