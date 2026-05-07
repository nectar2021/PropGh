<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Support\HomePageSettings;
use App\Support\PropertyCatalog;
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
                $key = PropertyCatalog::normalizePropertyType((string) $row->type);

                if ($key === '') {
                    return $carry;
                }

                $carry[$key] = ($carry[$key] ?? 0) + (int) $row->total;

                return $carry;
            }, []);

        $homePage = HomePageSettings::resolved();
        $categoryLabels = $homePage['categories']['labels'];

        $countTypes = static function (array $counts, string ...$keys): int {
            $total = 0;

            foreach ($keys as $key) {
                $total += (int) ($counts[$key] ?? 0);
            }

            return $total;
        };

        $listingTypeOptions = ['' => 'Select listing type'] + PropertyCatalog::listingTypes();
        $propertyTypeOptions = ['' => 'Any Property'] + PropertyCatalog::propertyTypes();

        $categoryStats = [
            ['label' => $categoryLabels['land'], 'key' => 'land', 'count' => $countTypes($typeCounts, 'land', 'lands')],
            ['label' => $categoryLabels['house'], 'key' => 'house', 'count' => $countTypes($typeCounts, 'house')],
            ['label' => $categoryLabels['apartment'], 'key' => 'apartment', 'count' => $countTypes($typeCounts, 'apartment')],
            ['label' => $categoryLabels['townhouse'], 'key' => 'townhouse', 'count' => $countTypes($typeCounts, 'townhouse')],
            ['label' => $categoryLabels['office'], 'key' => 'office', 'count' => $countTypes($typeCounts, 'office')],
        ];

        $extraPropertyTypes = collect($propertyTypeOptions)
            ->except(['', 'land', 'house', 'apartment', 'townhouse', 'office'])
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

        return response()->view('home', [
            'topOffers' => $topOffers,
            'categoryStats' => $categoryStats,
            'extraPropertyTypes' => $extraPropertyTypes,
            'homePage' => $homePage,
            'cityStats' => $cityStats,
            'cityOptions' => $cityOptions,
            'listingTypeOptions' => $listingTypeOptions,
            'propertyTypeOptions' => $propertyTypeOptions,
            'budgetRange' => [
                'min' => 500,
                'max' => $maxBudget,
            ],
        ]);
    }
}
