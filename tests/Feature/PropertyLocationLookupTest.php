<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PropertyLocationLookupTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_lookup_a_ghana_location_for_property_forms(): void
    {
        Http::fake(function ($request) {
            $decodedUrl = urldecode($request->url());

            if (str_contains($decodedUrl, 'Tesano Market Road')) {
                return Http::response([], 200);
            }

            return Http::response([
                [
                    'lat' => '5.582904',
                    'lon' => '-0.230903',
                    'display_name' => 'Tesano, Accra, Greater Accra Region, Ghana',
                ],
            ]);
        });

        $agent = User::factory()->create([
            'role' => 'agent',
        ]);

        $response = $this
            ->actingAs($agent)
            ->getJson(route('properties.location.lookup', [
                'address' => 'Tesano Market Road',
                'city' => 'Tesano',
                'region' => 'Greater Accra',
                'country' => 'Ghana',
            ]));

        $response
            ->assertOk()
            ->assertJson([
                'latitude' => 5.582904,
                'longitude' => -0.230903,
                'map_embed_url' => 'https://www.google.com/maps?q=5.582904,-0.230903&output=embed',
                'display_name' => 'Tesano, Accra, Greater Accra Region, Ghana',
            ]);

        Http::assertSent(function ($request): bool {
            $url = $request->url();

            return str_starts_with($url, 'https://nominatim.openstreetmap.org/search')
                && str_contains($url, 'countrycodes=gh')
                && str_contains(urldecode($url), 'Tesano')
                && str_contains(urldecode($url), 'Greater Accra');
        });

            Http::assertSentCount(2);
    }
}
