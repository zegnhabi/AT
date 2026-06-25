<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_admin_dashboard_loads(): void
    {
        $response = $this->actingAs($this->user)->get('/admin');
        $response->assertStatus(200);
    }

    public function test_admin_buses_page_loads(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/buses');
        $response->assertStatus(200);
    }

    public function test_admin_drivers_page_loads(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/drivers');
        $response->assertStatus(200);
    }

    public function test_admin_cities_page_loads(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/ciudades');
        $response->assertStatus(200);
    }

    public function test_admin_trips_page_loads(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/viajes');
        $response->assertStatus(200);
    }

    public function test_admin_arqueo_page_loads(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/arqueo');
        $response->assertStatus(200);
    }

    public function test_admin_corte_page_loads(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/corte');
        $response->assertStatus(200);
    }

    public function test_admin_branding_page_loads(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/personalizacion');
        $response->assertStatus(200);
    }

    public function test_admin_trips_with_per_page(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/viajes?per_page=10');
        $response->assertStatus(200);
    }

    public function test_admin_trips_with_per_page_all(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/viajes?per_page=all');
        $response->assertStatus(200);
    }

    public function test_admin_cities_with_per_page(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/ciudades?per_page=25');
        $response->assertStatus(200);
    }
}
