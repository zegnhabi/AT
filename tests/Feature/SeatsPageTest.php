<?php

namespace Tests\Feature;

use Tests\TestCase;

class SeatsPageTest extends TestCase
{
    public function test_seats_page_returns_404_with_invalid_trip(): void
    {
        $response = $this->get('/elegir/99999');
        $response->assertStatus(404);
    }
}
