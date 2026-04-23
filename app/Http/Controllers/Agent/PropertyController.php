<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Http\Requests\Agent\StorePropertyRequest;
use App\Models\Property;
use App\Support\PropertyCatalog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PropertyController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorizeAgent($request);

        $properties = Property::where('owner_id', $request->user()->id)
            ->with('images')
            ->orderByDesc('created_at')
            ->paginate(12);

        return view('agent.properties.index', compact('properties'));
    }

    public function create(Request $request): View
    {
        $this->authorizeAgent($request);

        return view('agent.properties.create', [
            'property' => new Property,
            ...$this->formOptions(),
        ]);
    }

    public function store(StorePropertyRequest $request): RedirectResponse
    {
        $this->authorizeAgent($request);

        $data = $this->normalizedStoreData($request->validated());

        $data['owner_id'] = $request->user()->id;
        $data['slug'] = $this->uniqueSlug($data['title']);
        $data['status'] = 'review';
        $data['visibility'] = 'public';
        $data['is_featured'] = false;
        $data['is_verified'] = false;

        $property = Property::create($data);

        $this->storeUploadedImages($property, $request->file('images', []));

        return redirect()
            ->route('agent.properties.index')
            ->with('status', 'Property submitted for review. It will be visible once approved by an admin.');
    }

    public function edit(Request $request, Property $property): View
    {
        $this->authorizeAgent($request);

        if ($property->owner_id !== $request->user()->id) {
            abort(403);
        }

        $property->load('images');

        $imagesText = $property->images
            ->sortBy('sort_order')
            ->pluck('path')
            ->implode("\n");

        return view('agent.properties.edit', [
            'property' => $property,
            'imagesText' => $imagesText,
            ...$this->formOptions(),
        ]);
    }

    public function update(Request $request, Property $property): RedirectResponse
    {
        $this->authorizeAgent($request);

        if ($property->owner_id !== $request->user()->id) {
            abort(403);
        }

        $data = $this->validatedData($request);

        $data['listing_type'] = strtolower($data['listing_type']);
        $data['property_type'] = PropertyCatalog::normalizePropertyType($data['property_type']);
        $data['currency'] = strtoupper($data['currency']);
        $data['price_period'] = strtolower($data['price_period']);
        $data['amenities'] = array_values(array_filter($data['amenities'] ?? []));
        $data['pets_allowed'] = array_values(array_filter($data['pets_allowed'] ?? []));

        $property->update($data);

        $this->syncImages($property, $request->input('images'));

        return redirect()
            ->route('agent.properties.edit', $property)
            ->with('status', 'Property updated successfully.');
    }

    public function destroy(Request $request, Property $property): RedirectResponse
    {
        $this->authorizeAgent($request);

        if ($property->owner_id !== $request->user()->id) {
            abort(403);
        }

        $this->deleteManagedImages($property);
        $property->images()->delete();
        $property->delete();

        return redirect()
            ->route('agent.properties.index')
            ->with('status', 'Property deleted.');
    }

    private function authorizeAgent(Request $request): void
    {
        if (! $request->user()->isAgent() && ! $request->user()->isAdmin()) {
            abort(403);
        }
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'listing_type' => ['required', Rule::in(array_keys(PropertyCatalog::listingTypes()))],
            'property_type' => ['required', Rule::in(array_keys(PropertyCatalog::propertyTypes()))],
            'price' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', Rule::in(array_keys(PropertyCatalog::currencyOptions()))],
            'price_period' => ['required', Rule::in(array_keys(PropertyCatalog::pricePeriods()))],
            'deposit' => ['nullable', 'numeric', 'min:0'],
            'bedrooms' => ['nullable', 'integer', 'min:0'],
            'bathrooms' => ['nullable', 'integer', 'min:0'],
            'garage_spaces' => ['nullable', 'integer', 'min:0'],
            'area' => ['nullable', 'numeric', 'min:0'],
            'year_built' => ['nullable', 'integer', 'min:1800', 'max:'.(now()->year + 1)],
            'floor' => ['nullable', 'integer', 'min:0'],
            'total_rooms' => ['nullable', 'integer', 'min:0'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'region' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:40'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'map_embed_url' => ['nullable', 'url', 'max:2048'],
            'amenities' => ['nullable', 'array'],
            'amenities.*' => ['string', 'max:50'],
            'pets_allowed' => ['nullable', 'array'],
            'pets_allowed.*' => ['string', 'max:50'],
            'images' => ['nullable', 'string'],
        ]);
    }

    private function formOptions(): array
    {
        return [
            'listingTypes' => PropertyCatalog::listingTypes(),
            'propertyTypes' => PropertyCatalog::propertyTypes(),
            'propertyTypeGroups' => PropertyCatalog::propertyTypeGroups(),
            'propertyTypeGroupMap' => PropertyCatalog::propertyTypeGroupMap(),
            'currencyOptions' => PropertyCatalog::currencyOptions(),
            'pricePeriods' => PropertyCatalog::pricePeriods(),
            'amenityOptionSets' => PropertyCatalog::amenityOptionSets(),
            'amenityIcons' => PropertyCatalog::amenityIcons(),
            'amenityOptions' => PropertyCatalog::flatAmenityLabels(),
            'petChoices' => PropertyCatalog::petOptions(),
            'petEmojis' => PropertyCatalog::petEmojis(),
            'petOptions' => PropertyCatalog::petLabels(),
        ];
    }

    private function uniqueSlug(string $title): string
    {
        $slug = Str::slug($title);
        $original = $slug;
        $counter = 1;

        while (Property::where('slug', $slug)->exists()) {
            $slug = $original.'-'.$counter++;
        }

        return $slug;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function normalizedStoreData(array $data): array
    {
        $propertyType = PropertyCatalog::normalizePropertyType($data['property_type'] ?? '');

        $normalizedData = [
            ...$data,
            'listing_type' => strtolower((string) $data['listing_type']),
            'property_type' => $propertyType,
            'currency' => strtoupper((string) ($data['currency'] ?? PropertyCatalog::defaultCurrency())),
            'price_period' => strtolower((string) $data['price_period']),
            'bedrooms' => (int) ($data['bedrooms'] ?? 0),
            'bathrooms' => (int) ($data['bathrooms'] ?? 0),
            'garage_spaces' => (int) ($data['garage_spaces'] ?? 0),
            'floor' => $data['floor'] ?? null,
            'total_rooms' => $data['total_rooms'] ?? null,
            'year_built' => $data['year_built'] ?? null,
            'amenities' => array_values(array_filter($data['amenities'] ?? [])),
            'pets_allowed' => array_values(array_filter($data['pets_allowed'] ?? [])),
        ];

        if (PropertyCatalog::isLand($propertyType)) {
            $normalizedData['bedrooms'] = 0;
            $normalizedData['bathrooms'] = 0;
            $normalizedData['garage_spaces'] = 0;
            $normalizedData['floor'] = null;
            $normalizedData['total_rooms'] = null;
            $normalizedData['year_built'] = null;
            $normalizedData['pets_allowed'] = [];
        }

        if (PropertyCatalog::isCommercial($propertyType)) {
            $normalizedData['bedrooms'] = 0;
            $normalizedData['bathrooms'] = 0;
            $normalizedData['total_rooms'] = null;
            $normalizedData['pets_allowed'] = [];
        }

        return $normalizedData;
    }

    private function syncImages(Property $property, ?string $imagesText): void
    {
        $paths = collect(preg_split('/\r\n|\r|\n/', (string) $imagesText))
            ->map(fn ($path) => trim($path))
            ->filter()
            ->values();

        $property->images()->delete();

        foreach ($paths as $index => $path) {
            $property->images()->create([
                'path' => $path,
                'is_cover' => $index === 0,
                'sort_order' => $index,
            ]);
        }
    }

    /**
     * @param  array<int, UploadedFile>  $uploadedImages
     */
    private function storeUploadedImages(Property $property, array $uploadedImages): void
    {
        foreach ($uploadedImages as $index => $uploadedImage) {
            $storedPath = $uploadedImage->store('properties/'.$property->id, 'public');

            $property->images()->create([
                'path' => 'storage/'.$storedPath,
                'is_cover' => $index === 0,
                'sort_order' => $index,
            ]);
        }
    }

    private function deleteManagedImages(Property $property): void
    {
        $property->loadMissing('images');

        foreach ($property->images as $image) {
            if (! str_starts_with($image->path, 'storage/properties/')) {
                continue;
            }

            Storage::disk('public')->delete(Str::after($image->path, 'storage/'));
        }
    }
}
