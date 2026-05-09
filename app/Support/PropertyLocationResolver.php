<?php

namespace App\Support;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PropertyLocationResolver
{
    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public function hydrate(array $data): array
    {
        if ($this->hasCoordinates($data)) {
            if (blank($data['map_embed_url'] ?? null)) {
                $data['map_embed_url'] = self::mapEmbedUrl($data['latitude'], $data['longitude']);
            }

            return $data;
        }

        $location = $this->lookup(
            city: (string) ($data['city'] ?? ''),
            region: $data['region'] ?? null,
            country: $data['country'] ?? null,
            address: $data['address'] ?? null,
        );

        if ($location === null) {
            return $data;
        }

        $data['latitude'] = $location['latitude'];
        $data['longitude'] = $location['longitude'];
        $data['map_embed_url'] = blank($data['map_embed_url'] ?? null)
            ? $location['map_embed_url']
            : $data['map_embed_url'];

        return $data;
    }

    /**
     * @return array{latitude: float, longitude: float, map_embed_url: string, display_name: string}|null
     */
    public function lookup(string $city, ?string $region = null, ?string $country = null, ?string $address = null): ?array
    {
        $queries = $this->buildQueries($city, $region, $country, $address);

        if ($queries === []) {
            return null;
        }

        foreach ($queries as $query) {
            $location = $this->requestLocation($query, $country);

            if ($location === null) {
                continue;
            }

            $latitude = round((float) $location['lat'], 6);
            $longitude = round((float) $location['lon'], 6);

            return [
                'latitude' => $latitude,
                'longitude' => $longitude,
                'map_embed_url' => self::mapEmbedUrl($latitude, $longitude),
                'display_name' => (string) ($location['display_name'] ?? $query),
            ];
        }

        return null;
    }

    /**
     * @param  mixed  $latitude
     * @param  mixed  $longitude
     */
    public static function mapEmbedUrl($latitude, $longitude): string
    {
        return sprintf('https://www.google.com/maps?q=%s,%s&output=embed', $latitude, $longitude);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function hasCoordinates(array $data): bool
    {
        return filled($data['latitude'] ?? null) && filled($data['longitude'] ?? null);
    }

    /**
     * @return list<string>
     */
    private function buildQueries(string $city, ?string $region = null, ?string $country = null, ?string $address = null): array
    {
        return collect([
            [$address, $city, $region, $country],
            [$city, $region, $country],
            [$city, $country],
        ])
            ->map(function (array $parts): string {
                return collect($parts)
                    ->filter(fn ($value) => filled($value))
                    ->map(fn ($value) => Str::of((string) $value)->trim()->value())
                    ->implode(', ');
            })
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    /**
     * @return array<string, mixed>|null
     */
    private function requestLocation(string $query, ?string $country = null): ?array
    {
        $response = Http::acceptJson()
            ->withHeaders([
                'User-Agent' => sprintf('%s property lookup', config('app.name', 'Propsgh')),
            ])
            ->timeout(8)
            ->retry(2, 200)
            ->get('https://nominatim.openstreetmap.org/search', [
                'q' => $query,
                'format' => 'jsonv2',
                'limit' => 1,
                'addressdetails' => 1,
                ...($this->isGhana($country) ? ['countrycodes' => 'gh'] : []),
            ]);

        if (! $response->successful()) {
            return null;
        }

        $location = $response->json('0');

        return is_array($location) && isset($location['lat'], $location['lon'])
            ? $location
            : null;
    }

    private function isGhana(?string $country): bool
    {
        return Str::of((string) $country)->trim()->lower()->value() === 'ghana';
    }
}
