<?php

namespace Tests\Feature;

use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    public function test_admin_dashboard_loads(): void
    {
        $response = $this->get('/admin');
        $response->assertStatus(200);
    }

    public function test_admin_buses_page_loads(): void
    {
        $response = $this->get('/admin/buses');
        $response->assertStatus(200);
    }

    public function test_admin_drivers_page_loads(): void
    {
        $response = $this->get('/admin/drivers');
        $response->assertStatus(200);
    }

    public function test_admin_cities_page_loads(): void
    {
        $response = $this->get('/admin/ciudades');
        $response->assertStatus(200);
    }

    public function test_admin_trips_page_loads(): void
    {
        $response = $this->get('/admin/viajes');
        $response->assertStatus(200);
    }

    public function test_admin_arqueo_page_loads(): void
    {
        $response = $this->get('/admin/arqueo');
        $response->assertStatus(200);
    }

    public function test_admin_corte_page_loads(): void
    {
        $response = $this->get('/admin/corte');
        $response->assertStatus(200);
    }

    public function test_admin_branding_page_loads(): void
    {
        $response = $this->get('/admin/personalizacion');
        $response->assertStatus(200);
    }

    public function test_admin_trips_with_per_page(): void
    {
        $response = $this->get('/admin/viajes?per_page=10');
        $response->assertStatus(200);
    }

    public function test_admin_trips_with_per_page_all(): void
    {
        $response = $this->get('/admin/viajes?per_page=all');
        $response->assertStatus(200);
    }

    public function test_admin_cities_with_per_page(): void
    {
        $response = $this->get('/admin/ciudades?per_page=25');
        $response->assertStatus(200);
    }
}
