<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Support\PropertyCatalog;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

class PropertyController extends Controller
{
    public function index(Request $request): Response
    {
        $filterConfiguration = $this->propertyFilterConfiguration();
        $filters = $this->normalizedFilters($request, $filterConfiguration);
        $sort = $this->normalizedSort($request);
        $mapMarkers = $this->mapMarkers($filters, $sort);

        $properties = $this->applyPropertySorting(
            $this->filteredPropertiesQuery($filters)->with('images'),
            $sort,
        )
            ->paginate(4)
            ->withQueryString();

        return response()->view('properties.index', [
            'properties' => $properties,
            'filters' => $filters,
            'mapMarkers' => $mapMarkers,
            'sort' => $sort,
            'sortOptions' => $this->sortOptions(),
            'isLandSearch' => $filters['property_type'] === 'land',
            'listingTypeOptions' => $filterConfiguration['listingTypeOptions'],
            'propertyTypeOptions' => $filterConfiguration['propertyTypeOptions'],
            'locationOptions' => $this->locationOptions(),
        ]);
    }

    public function show(Property $property): Response
    {
        $property->load(['images', 'owner']);

        if (! $this->canPreview($property)) {
            abort(404);
        }

        $property->increment('views');

        return response()->view('properties.show', [
            'property' => $property,
        ]);
    }

    public function map(Request $request): JsonResponse
    {
        $filterConfiguration = $this->propertyFilterConfiguration();
        $filters = $this->normalizedFilters($request, $filterConfiguration);
        $sort = $this->normalizedSort($request);

        return response()->json($this->mapMarkers($filters, $sort));
    }

    private function mapMarkers(array $filters, string $sort): array
    {
        $properties = $this->applyPropertySorting(
            $this->filteredPropertiesQuery($filters, requireCoordinates: true)->with('images'),
            $sort,
        )
            ->get();

        $markers = $properties->values()->map(function (Property $property, int $index): array {
            $imagePath = $property->cover_image?->path ?? 'assets/img/listings/real-estate/01.jpg';

            $addressParts = array_filter([
                $property->address,
                $property->city,
                $property->region,
            ]);

            $address = $addressParts ? implode(', ', $addressParts) : $property->title;
            $location = implode(', ', array_filter([$property->city, $property->region])) ?: 'Land listing';

            return [
                'id' => (string) ($index + 1),
                'coordinates' => [
                    'lat' => (float) $property->latitude,
                    'lng' => (float) $property->longitude,
                ],
                'price' => number_format((float) $property->price),
                'formattedPrice' => $property->formatted_price,
                'address' => $address,
                'location' => $location,
                'area' => (string) ($property->area ?? 0),
                'bedrooms' => (string) ($property->bedrooms ?? 0),
                'bathrooms' => (string) ($property->bathrooms ?? 0),
                'garage' => (string) ($property->garage_spaces ?? 0),
                'image' => asset($imagePath),
                'url' => route('properties.show', $property),
            ];
        })->values();

        return $markers->all();
    }

    private function canPreview(Property $property): bool
    {
        if ($property->status === 'live' && $property->visibility === 'public') {
            return true;
        }

        $user = request()->user();

        return $user && $user->role === 'admin';
    }

    private function propertyTypeVariants(string $propertyType): array
    {
        return PropertyCatalog::propertyTypeVariants($propertyType);
    }

    private function propertyFilterConfiguration(): array
    {
        return [
            'allowedListingTypes' => array_keys(PropertyCatalog::listingTypes()),
            'allowedPropertyTypes' => array_keys(PropertyCatalog::propertyTypes()),
            'listingTypeOptions' => ['' => 'Select listing type'] + PropertyCatalog::listingTypes(),
            'propertyTypeOptions' => ['' => 'Any Property'] + PropertyCatalog::propertyTypes(),
        ];
    }

    private function sortOptions(): array
    {
        return [
            'updated' => 'Updated',
            'price_asc' => 'Price Asc',
            'price_desc' => 'Price Desc',
        ];
    }

    private function normalizedSort(Request $request): string
    {
        $sort = $request->string('sort', 'updated')->trim()->toString();

        return array_key_exists($sort, $this->sortOptions()) ? $sort : 'updated';
    }

    private function normalizedFilters(Request $request, array $filterConfiguration): array
    {
        $listingType = $request->string('listing_type')->trim()->lower()->toString();
        $propertyType = PropertyCatalog::normalizePropertyType($request->string('property_type')->trim()->lower()->toString());
        $maxPrice = $request->filled('max_price') ? max(0, $request->integer('max_price')) : null;

        return [
            'listing_type' => in_array($listingType, $filterConfiguration['allowedListingTypes'], true) ? $listingType : '',
            'property_type' => in_array($propertyType, $filterConfiguration['allowedPropertyTypes'], true) ? $propertyType : '',
            'location' => $request->string('location')->trim()->toString(),
            'max_price' => $maxPrice ?: null,
        ];
    }

    private function filteredPropertiesQuery(array $filters, bool $requireCoordinates = false): Builder
    {
        $query = Property::query()
            ->where('status', 'live')
            ->where('visibility', 'public');

        if ($requireCoordinates) {
            $query
                ->whereNotNull('latitude')
                ->whereNotNull('longitude');
        }

        return $this->applyPropertyFilters($query, $filters);
    }

    private function applyPropertySorting(Builder $query, string $sort): Builder
    {
        return match ($sort) {
            'price_asc' => $query
                ->orderBy('price')
                ->orderByDesc('published_at')
                ->orderByDesc('created_at'),
            'price_desc' => $query
                ->orderByDesc('price')
                ->orderByDesc('published_at')
                ->orderByDesc('created_at'),
            default => $query
                ->orderByDesc('published_at')
                ->orderByDesc('created_at'),
        };
    }

    private function applyPropertyFilters(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['listing_type'] !== '', function (Builder $builder) use ($filters): void {
                $builder->whereRaw('LOWER(listing_type) = ?', [$filters['listing_type']]);
            })
            ->when($filters['property_type'] !== '', function (Builder $builder) use ($filters): void {
                $propertyTypeVariants = $this->propertyTypeVariants($filters['property_type']);

                $builder->where(function (Builder $nestedBuilder) use ($propertyTypeVariants): void {
                    foreach ($propertyTypeVariants as $variant) {
                        $nestedBuilder->orWhereRaw('LOWER(property_type) = ?', [$variant]);
                    }
                });
            })
            ->when($filters['location'] !== '', function (Builder $builder) use ($filters): void {
                $normalizedLocation = strtolower($filters['location']);

                $builder->where(function (Builder $nestedBuilder) use ($normalizedLocation): void {
                    $nestedBuilder
                        ->whereRaw('LOWER(city) = ?', [$normalizedLocation])
                        ->orWhereRaw('LOWER(region) = ?', [$normalizedLocation]);
                });
            })
            ->when($filters['max_price'] !== null, function (Builder $builder) use ($filters): void {
                $builder->where('price', '<=', $filters['max_price']);
            });
    }

    private function locationOptions(): Collection
    {
        return Property::query()
            ->where('status', 'live')
            ->where('visibility', 'public')
            ->whereNotNull('city')
            ->where('city', '!=', '')
            ->select('city')
            ->distinct()
            ->orderBy('city')
            ->limit(20)
            ->pluck('city')
            ->values();
    }
}
