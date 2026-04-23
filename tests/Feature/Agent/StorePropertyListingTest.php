<?php

namespace Tests\Feature\Agent;

use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class StorePropertyListingTest extends TestCase
{
    use RefreshDatabase;

    public function test_agent_can_store_a_land_listing_without_room_fields(): void
    {
        Storage::fake('public');

        $agent = User::factory()->create([
            'role' => 'agent',
        ]);

        $response = $this->actingAs($agent)->post(route('agent.properties.store'), [
            'listing_type' => 'sale',
            'property_type' => 'land',
            'title' => 'Roadside plot near Airport Hills',
            'description' => 'Serviced land with strong road access and clean title.',
            'area' => 950,
            'address' => 'Plot 8 Liberation Road',
            'city' => 'Accra',
            'region' => 'Greater Accra',
            'postal_code' => 'GA-231-4432',
            'country' => 'Ghana',
            'latitude' => 5.603717,
            'longitude' => -0.186964,
            'price' => 250000,
            'currency' => 'GHS',
            'price_period' => 'year',
            'deposit' => 25000,
            'amenities' => ['Titled', 'Roadside', 'Utility access'],
            'images' => [
                UploadedFile::fake()->image('land-cover.jpg'),
                UploadedFile::fake()->image('land-access.jpg'),
            ],
        ]);

        $response->assertRedirect(route('agent.properties.index'));

        $property = Property::query()->with('images')->sole();

        $this->assertSame($agent->id, $property->owner_id);
        $this->assertSame('land', $property->property_type);
        $this->assertSame('sale', $property->listing_type);
        $this->assertSame('GHS', $property->currency);
        $this->assertSame('review', $property->status);
        $this->assertSame(0, $property->bedrooms);
        $this->assertSame(0, $property->bathrooms);
        $this->assertSame(0, $property->garage_spaces);
        $this->assertNull($property->total_rooms);
        $this->assertNull($property->floor);
        $this->assertNull($property->year_built);
        $this->assertSame(['Titled', 'Roadside', 'Utility access'], $property->amenities);
        $this->assertSame([], $property->pets_allowed);
        $this->assertCount(2, $property->images);
        $this->assertTrue((bool) $property->images[0]->is_cover);
        $this->assertFalse((bool) $property->images[1]->is_cover);

        foreach ($property->images as $image) {
            $this->assertTrue(Str::startsWith($image->path, 'storage/properties/'));
            Storage::disk('public')->assertExists(Str::after($image->path, 'storage/'));
        }
    }

    public function test_agent_can_store_a_residential_listing_with_optional_numeric_fields_left_blank(): void
    {
        Storage::fake('public');

        $agent = User::factory()->create([
            'role' => 'agent',
        ]);

        $response = $this->actingAs($agent)->post(route('agent.properties.store'), [
            'listing_type' => 'shortlet',
            'property_type' => 'apartment',
            'title' => 'Furnished shortlet apartment in Cantonments',
            'description' => 'A premium serviced apartment with pool access and fast WiFi.',
            'area' => 140,
            'address' => '14 Independence Avenue',
            'city' => 'Accra',
            'region' => 'Greater Accra',
            'postal_code' => 'GA-553-0031',
            'country' => 'Ghana',
            'price' => 350,
            'currency' => 'USD',
            'price_period' => 'day',
            'deposit' => '',
            'bedrooms' => 2,
            'bathrooms' => 2,
            'garage_spaces' => '',
            'total_rooms' => '',
            'floor' => '',
            'year_built' => '',
            'amenities' => ['WiFi', 'Pool', 'Balcony'],
            'pets_allowed' => ['Cats'],
            'images' => [
                UploadedFile::fake()->image('apartment-cover.jpg'),
            ],
        ]);

        $response->assertRedirect(route('agent.properties.index'));

        $property = Property::query()->with('images')->sole();

        $this->assertSame('apartment', $property->property_type);
        $this->assertSame('shortlet', $property->listing_type);
        $this->assertSame('USD', $property->currency);
        $this->assertSame(2, $property->bedrooms);
        $this->assertSame(2, $property->bathrooms);
        $this->assertSame(0, $property->garage_spaces);
        $this->assertNull($property->total_rooms);
        $this->assertNull($property->floor);
        $this->assertNull($property->year_built);
        $this->assertNull($property->deposit);
        $this->assertSame(['WiFi', 'Pool', 'Balcony'], $property->amenities);
        $this->assertSame(['Cats'], $property->pets_allowed);
        $this->assertCount(1, $property->images);
        $this->assertTrue((bool) $property->images[0]->is_cover);
        Storage::disk('public')->assertExists(Str::after($property->images[0]->path, 'storage/'));
    }

    public function test_land_listing_rejects_amenities_that_do_not_match_the_property_type(): void
    {
        Storage::fake('public');

        $agent = User::factory()->create([
            'role' => 'agent',
        ]);

        $response = $this
            ->actingAs($agent)
            ->from(route('agent.properties.create'))
            ->post(route('agent.properties.store'), [
                'listing_type' => 'sale',
                'property_type' => 'land',
                'title' => 'Litigation-free plot near Tema',
                'description' => 'A titled parcel with direct access to a paved road.',
                'area' => 600,
                'address' => '27 Tema Harbour Road',
                'city' => 'Tema',
                'region' => 'Greater Accra',
                'country' => 'Ghana',
                'price' => 185000,
                'currency' => 'GHS',
                'price_period' => 'year',
                'amenities' => ['WiFi'],
                'images' => [
                    UploadedFile::fake()->image('invalid-land.jpg'),
                ],
            ]);

        $response
            ->assertRedirect(route('agent.properties.create'))
            ->assertSessionHasErrors(['amenities.0']);

        $this->assertDatabaseCount('properties', 0);
        $this->assertDatabaseCount('property_images', 0);
    }
}
