<?php

namespace Tests\Feature\Admin;

use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManagePropertyCurrencyTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_store_property_with_selected_currency(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.properties.store'), [
            'title' => 'Prime office floor in Airport City',
            'slug' => '',
            'description' => 'Flexible office suite with backup power and conference rooms.',
            'listing_type' => 'rent',
            'property_type' => 'office',
            'price' => 180000,
            'currency' => 'EUR',
            'price_period' => 'month',
            'deposit' => 90000,
            'bedrooms' => 0,
            'bathrooms' => 2,
            'garage_spaces' => 8,
            'area' => 620,
            'year_built' => 2021,
            'floor' => 4,
            'total_rooms' => 12,
            'address' => '24 Liberation Road',
            'city' => 'Accra',
            'region' => 'Greater Accra',
            'country' => 'Ghana',
            'postal_code' => 'GA-442-0192',
            'latitude' => 5.603717,
            'longitude' => -0.186964,
            'map_embed_url' => 'https://www.google.com/maps/embed?pb=test',
            'amenities' => ['Parking', 'Backup power'],
            'pets_allowed' => [],
            'status' => 'live',
            'visibility' => 'public',
            'published_at' => now()->format('Y-m-d H:i:s'),
            'images' => "assets/img/listings/real-estate/01.jpg\nassets/img/listings/real-estate/02.jpg",
        ]);

        $property = Property::query()->firstOrFail();

        $response->assertRedirect(route('admin.properties.edit', $property));

        $this->assertSame('EUR', $property->currency);
        $this->assertSame('€', $property->currency_symbol);
        $this->assertSame('€ 180,000', $property->formatted_price);
        $this->assertSame($admin->id, $property->owner_id);
        $this->assertDatabaseHas('properties', [
            'id' => $property->id,
            'currency' => 'EUR',
        ]);
    }
}
