<?php

namespace Tests\Feature\Agent;

use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
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
                UploadedFile::fake()->image('land-cover.jpg', 2400, 1800),
                UploadedFile::fake()->image('land-access.jpg', 3200, 1800),
            ],
        ]);

        $response->assertRedirect(route('agent.properties.index'));

        $property = Property::query()->with('images')->sole();

        $this->assertSame($agent->id, $property->owner_id);
        $this->assertSame('land', $property->property_type);
        $this->assertSame('sale', $property->listing_type);
        $this->assertSame('GHS', $property->currency);
        $this->assertSame('review', $property->status);
        $this->assertNull($property->bedrooms);
        $this->assertNull($property->bathrooms);
        $this->assertNull($property->garage_spaces);
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
            $this->assertTrue(Storage::disk('public')->exists(Str::after($image->path, 'storage/')));
        }

        $coverImageDimensions = getimagesizefromstring(
            Storage::disk('public')->get(Str::after($property->images[0]->path, 'storage/'))
        );

        $galleryImageDimensions = getimagesizefromstring(
            Storage::disk('public')->get(Str::after($property->images[1]->path, 'storage/'))
        );

        $this->assertNotFalse($coverImageDimensions);
        $this->assertNotFalse($galleryImageDimensions);
        $this->assertSame(1600, $coverImageDimensions[0]);
        $this->assertSame(1200, $coverImageDimensions[1]);
        $this->assertSame(1600, $galleryImageDimensions[0]);
        $this->assertSame(900, $galleryImageDimensions[1]);
    }

    public function test_agent_can_store_a_residential_listing_with_optional_numeric_fields_left_blank(): void
    {
        Storage::fake('public');
        Http::fake([
            'https://nominatim.openstreetmap.org/search*' => Http::response([
                [
                    'lat' => '5.560011',
                    'lon' => '-0.175432',
                    'display_name' => 'Cantonments, Accra, Greater Accra Region, Ghana',
                ],
            ]),
        ]);

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
        $this->assertNull($property->garage_spaces);
        $this->assertNull($property->total_rooms);
        $this->assertNull($property->floor);
        $this->assertNull($property->year_built);
        $this->assertNull($property->deposit);
        $this->assertSame(5.560011, (float) $property->latitude);
        $this->assertSame(-0.175432, (float) $property->longitude);
        $this->assertSame('https://www.google.com/maps?q=5.560011,-0.175432&output=embed', $property->map_embed_url);
        $this->assertSame(['WiFi', 'Pool', 'Balcony'], $property->amenities);
        $this->assertSame(['Cats'], $property->pets_allowed);
        $this->assertCount(1, $property->images);
        $this->assertTrue((bool) $property->images[0]->is_cover);
        $this->assertTrue(Storage::disk('public')->exists(Str::after($property->images[0]->path, 'storage/')));

        Http::assertSentCount(1);
    }

    public function test_agent_cannot_store_property_with_a_non_ghana_region(): void
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
                'property_type' => 'apartment',
                'title' => 'Invalid region listing',
                'description' => 'This should fail region validation.',
                'area' => 120,
                'address' => '5 Test Street',
                'city' => 'Accra',
                'region' => 'Brooklyn',
                'country' => 'Ghana',
                'price' => 450000,
                'currency' => 'GHS',
                'price_period' => 'year',
                'bedrooms' => 2,
                'bathrooms' => 2,
                'images' => [
                    UploadedFile::fake()->image('invalid-region.jpg'),
                ],
            ]);

        $response
            ->assertRedirect(route('agent.properties.create'))
            ->assertSessionHasErrors(['region']);

        $this->assertDatabaseCount('properties', 0);
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

    public function test_uploaded_property_images_are_rendered_on_listing_pages_without_stock_fallbacks(): void
    {
        Storage::fake('public');
        Http::fake([
            'https://nominatim.openstreetmap.org/search*' => Http::response([
                [
                    'lat' => '5.571419',
                    'lon' => '-0.187094',
                    'display_name' => 'Ridge, Accra, Greater Accra Region, Ghana',
                ],
            ]),
        ]);

        $agent = User::factory()->create([
            'role' => 'agent',
        ]);

        $this->actingAs($agent)->post(route('agent.properties.store'), [
            'listing_type' => 'sale',
            'property_type' => 'apartment',
            'title' => 'Gallery-ready apartment in Ridge',
            'description' => 'Freshly listed apartment with a real uploaded gallery image.',
            'area' => 180,
            'address' => '14 Ridge Street',
            'city' => 'Accra',
            'region' => 'Greater Accra',
            'postal_code' => 'GA-201-4421',
            'country' => 'Ghana',
            'price' => 640000,
            'currency' => 'GHS',
            'price_period' => 'year',
            'bedrooms' => 3,
            'bathrooms' => 2,
            'images' => [
                UploadedFile::fake()->image('ridge-cover.jpg', 2200, 1600),
            ],
        ])->assertRedirect(route('agent.properties.index'));

        $property = Property::query()->with('images')->sole();

        $property->update([
            'status' => 'live',
            'visibility' => 'public',
            'published_at' => now(),
        ]);

        $property->refresh()->load('images');
        $imagePath = $property->images->firstOrFail()->path;

        $this->actingAs($agent)
            ->get(route('agent.properties.index'))
            ->assertOk()
            ->assertSee($imagePath, false)
            ->assertDontSee('assets/img/listings/real-estate/01.jpg', false);

        $this->get(route('properties.index'))
            ->assertOk()
            ->assertSee($imagePath, false)
            ->assertDontSee('assets/img/listings/real-estate/01.jpg', false);

        $this->get(route('properties.show', $property))
            ->assertOk()
            ->assertSee($imagePath, false)
            ->assertDontSee('assets/img/listings/real-estate/single/01.jpg', false)
            ->assertDontSee('assets/img/listings/real-estate/single/02.jpg', false)
            ->assertDontSee('assets/img/listings/real-estate/single/03.jpg', false);
    }
}
