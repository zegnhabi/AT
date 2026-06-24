<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomePageTest extends TestCase
{
    public function test_homepage_loads(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_search_page_loads(): void
    {
        $response = $this->get('/buscar?origin=Mérida&destination=Cancún&date=' . now()->addDay()->format('Y-m-d'));
        $response->assertStatus(200);
    }

    public function test_locale_switch(): void
    {
        $response = $this->get('/lang/es');
        $response->assertRedirect();
    }
}
