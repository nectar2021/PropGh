<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Response;

class HomeController extends Controller
{
    public function index(): Response
    {
        $baseQuery = Property::query()
            ->where('status', 'live')
            ->where('visibility', 'public');

        $topOffers = (clone $baseQuery)
            ->with(['images' => fn($query) => $query->orderBy('sort_order')])
            ->orderByDesc('is_featured')
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->limit(8)
            ->get();

        $typeCounts = (clone $baseQuery)
            ->whereNotNull('property_type')
            ->selectRaw('LOWER(property_type) as type, COUNT(*) as total')
            ->groupBy('type')
            ->get()
            ->reduce(function (array $carry, $row): array {
                $key = $this->normalizePropertyType((string) $row->type);

                if ($key === '') {
                    return $carry;
                }

                $carry[$key] = ($carry[$key] ?? 0) + (int) $row->total;

                return $carry;
            }, []);

        $countTypes = static function (array $counts, string ...$keys): int {
            $total = 0;

            foreach ($keys as $key) {
                $total += (int) ($counts[$key] ?? 0);
            }

            return $total;
        };

        $listingTypeOptions = [
            '' => 'Select listing type',
            'sale' => 'For Sale',
            'rent' => 'For Rent',
            'shortlet' => 'Shortlet',
        ];

        $propertyTypeOptions = [
            '' => 'Any Property',
            'land' => 'Land',
            'house' => 'House',
            'apartment' => 'Apartment',
            'townhouse' => 'Townhouse',
            'vacation-home' => 'Vacation Home',
            'office' => 'Office',
            'warehouse' => 'Warehouse',
            'retail-space' => 'Retail Space',
        ];

        $categoryStats = [
            ['label' => 'Lands', 'key' => 'land', 'count' => $countTypes($typeCounts, 'land', 'lands')],
            ['label' => 'Houses', 'key' => 'house', 'count' => $countTypes($typeCounts, 'house')],
            ['label' => 'Apartments', 'key' => 'apartment', 'count' => $countTypes($typeCounts, 'apartment')],
            ['label' => 'Townhouses', 'key' => 'townhouse', 'count' => $countTypes($typeCounts, 'townhouse')],
        ];

        $extraPropertyTypes = collect($propertyTypeOptions)
            ->except(['', 'land', 'house', 'apartment', 'townhouse'])
            ->all();

        $cityStats = (clone $baseQuery)
            ->whereNotNull('city')
            ->where('city', '!=', '')
            ->selectRaw(
                "city,
                SUM(CASE WHEN LOWER(listing_type) = 'sale' THEN 1 ELSE 0 END) as sale_count,
                SUM(CASE WHEN LOWER(listing_type) IN ('rent', 'shortlet') THEN 1 ELSE 0 END) as rent_count,
                COUNT(*) as total"
            )
            ->groupBy('city')
            ->orderByDesc('total')
            ->limit(6)
            ->get();

        $cityOptions = (clone $baseQuery)
            ->whereNotNull('city')
            ->where('city', '!=', '')
            ->select('city')
            ->distinct()
            ->orderBy('city')
            ->limit(12)
            ->pluck('city')
            ->values();

        if ($cityOptions->isEmpty()) {
            $cityOptions = collect([
                'Accra',
                'Kumasi',
                'Takoradi',
                'Cape Coast',
                'Tamale',
                'Ho',
            ]);
        }

        $maxBudget = max(
            4000,
            (int) ceil((((clone $baseQuery)->max('price')) ?: 0) / 500) * 500,
        );

        $cityImages = [
            'assets/img/home/real-estate/cities/01.jpg',
            'assets/img/home/real-estate/cities/02.jpg',
            'assets/img/home/real-estate/cities/03.jpg',
            'assets/img/home/real-estate/cities/04.jpg',
            'assets/img/home/real-estate/cities/05.jpg',
            'assets/img/home/real-estate/cities/06.jpg',
        ];

        return response()->view('home', [
            'topOffers' => $topOffers,
            'categoryStats' => $categoryStats,
            'extraPropertyTypes' => $extraPropertyTypes,
            'cityStats' => $cityStats,
            'cityImages' => $cityImages,
            'cityOptions' => $cityOptions,
            'listingTypeOptions' => $listingTypeOptions,
            'propertyTypeOptions' => $propertyTypeOptions,
            'budgetRange' => [
                'min' => 500,
                'max' => $maxBudget,
            ],
        ]);
    }

    private function normalizePropertyType(?string $type): string
    {
        if ($type === null) {
            return '';
        }

        return str_replace([' ', '_'], '-', strtolower(trim($type)));
    }
}
