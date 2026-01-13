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
            ->with(['images' => fn ($query) => $query->orderBy('sort_order')])
            ->orderByDesc('is_featured')
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->limit(8)
            ->get();

        $typeCounts = (clone $baseQuery)
            ->whereNotNull('property_type')
            ->selectRaw('LOWER(property_type) as type, COUNT(*) as total')
            ->groupBy('type')
            ->pluck('total', 'type');

        $listingCounts = (clone $baseQuery)
            ->whereNotNull('listing_type')
            ->selectRaw('LOWER(listing_type) as type, COUNT(*) as total')
            ->groupBy('type')
            ->pluck('total', 'type');

        $newBuildingsCount = (clone $baseQuery)
            ->whereNotNull('year_built')
            ->where('year_built', '>=', now()->year - 2)
            ->count();

        $categoryStats = [
            ['label' => 'Houses', 'key' => 'house', 'count' => (int) ($typeCounts['house'] ?? 0)],
            ['label' => 'Apartments', 'key' => 'apartment', 'count' => (int) ($typeCounts['apartment'] ?? 0)],
            ['label' => 'Commercial', 'key' => 'commercial', 'count' => (int) ($typeCounts['commercial'] ?? 0)],
            ['label' => 'Shortlet', 'key' => 'shortlet', 'count' => (int) ($listingCounts['shortlet'] ?? $typeCounts['shortlet'] ?? 0)],
            ['label' => 'New buildings', 'key' => 'new-buildings', 'count' => $newBuildingsCount],
        ];

        $propertyTypes = (clone $baseQuery)
            ->whereNotNull('property_type')
            ->selectRaw('LOWER(property_type) as type')
            ->distinct()
            ->orderBy('type')
            ->pluck('type')
            ->filter()
            ->values();

        if ($propertyTypes->isEmpty()) {
            $propertyTypes = collect(['house', 'apartment', 'commercial', 'shortlet', 'studio', 'condo', 'townhouse']);
        }

        $primaryTypes = collect(['house', 'apartment', 'commercial', 'shortlet']);
        $extraPropertyTypes = $propertyTypes->diff($primaryTypes)->values();

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

        $listingTypeOptions = [
            'rent' => 'For rent',
            'sale' => 'For sale',
            'shortlet' => 'Shortlet',
        ];

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
            'propertyTypes' => $propertyTypes,
            'extraPropertyTypes' => $extraPropertyTypes,
            'cityStats' => $cityStats,
            'cityImages' => $cityImages,
            'cityOptions' => $cityOptions,
            'listingTypeOptions' => $listingTypeOptions,
        ]);
    }
}
