<?php

use App\Models\PricingLane;
use App\Models\User;

it('preserves active lane prices in both public calculator endpoints', function () {
    PricingLane::create(['origin' => 'Origin', 'destination' => 'Destination', 'distance_km' => 123, 'price' => 456.75, 'is_firm' => true, 'is_active' => true]);
    PricingLane::create(['origin' => 'Hidden', 'destination' => 'Route', 'distance_km' => 10, 'price' => 99, 'is_active' => false]);
    foreach (['/pricing-data', '/api/pricing'] as $path) {
        $this->getJson($path)->assertOk()->assertJsonCount(1, 'lanes')
            ->assertJsonPath('lanes.0.price', 456.75)->assertJsonPath('lanes.0.km', 123)
            ->assertJsonPath('lanes.0.firm', true);
    }
});

it('preserves quote creation and requires authentication for quote listing', function () {
    $data = ['name' => 'Migration fixture', 'origin' => 'Origin', 'destination' => 'Destination', 'phone' => '0500000000', 'truck_type' => 'Truck', 'cargo_type' => 'Cargo', 'weight_band' => 'Light', 'truck_count' => 2];
    $this->postJson('/quotes', $data)->assertSuccessful()->assertJsonPath('truck_count', 2);
    $this->assertDatabaseCount('quotes', 1);
    $this->get('/quotes')->assertRedirect(route('login'));
});

it('keeps administrative lane changes reflected in the public calculator', function () {
    $lane = PricingLane::create(['origin' => 'Origin', 'destination' => 'Destination', 'distance_km' => 123, 'price' => 400]);
    $this->patch('/admin/pricing/'.$lane->id, ['price' => 500])->assertRedirect(route('login'));
    $this->actingAs(User::factory()->create(['is_admin' => true]))->patch('/admin/pricing/'.$lane->id, ['price' => 500])->assertRedirect();
    $this->getJson('/pricing-data')->assertJsonPath('lanes.0.price', 500);
});
