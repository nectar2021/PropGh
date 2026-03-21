<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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
            'imagesText' => '',
            ...$this->formOptions(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorizeAgent($request);

        $data = $this->validatedData($request);

        $data['owner_id'] = $request->user()->id;
        $data['slug'] = $this->uniqueSlug($data['title']);
        $data['listing_type'] = strtolower($data['listing_type']);
        $data['property_type'] = strtolower($data['property_type']);
        $data['price_period'] = strtolower($data['price_period']);
        $data['status'] = 'review';
        $data['visibility'] = 'public';
        $data['is_featured'] = false;
        $data['is_verified'] = false;
        $data['amenities'] = array_values(array_filter($data['amenities'] ?? []));
        $data['pets_allowed'] = array_values(array_filter($data['pets_allowed'] ?? []));

        $property = Property::create($data);

        $this->syncImages($property, $request->input('images'));

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
        $data['property_type'] = strtolower($data['property_type']);
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
            'listing_type' => ['required', 'string', 'max:50'],
            'property_type' => ['required', 'string', 'max:50'],
            'price' => ['required', 'numeric', 'min:0'],
            'price_period' => ['required', 'string', 'max:20'],
            'deposit' => ['nullable', 'numeric', 'min:0'],
            'bedrooms' => ['nullable', 'integer', 'min:0'],
            'bathrooms' => ['nullable', 'integer', 'min:0'],
            'garage_spaces' => ['nullable', 'integer', 'min:0'],
            'area' => ['nullable', 'numeric', 'min:0'],
            'year_built' => ['nullable', 'integer', 'min:1800', 'max:' . (now()->year + 1)],
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
            'listingTypes' => [
                'rent' => 'For rent',
                'sale' => 'For sale',
                'shortlet' => 'Shortlet',
            ],
            'propertyTypes' => [
                'apartment' => 'Apartment',
                'house' => 'House',
                'studio' => 'Studio',
                'condo' => 'Condo',
                'townhouse' => 'Townhouse',
                'shortlet' => 'Shortlet',
            ],
            'pricePeriods' => [
                'day' => 'Daily',
                'week' => 'Weekly',
                'month' => 'Monthly',
                'year' => 'Yearly',
            ],
            'amenityOptions' => [
                'WiFi',
                'Dishwasher',
                'Air conditioning',
                'Parking',
                'Laundry',
                'Security cameras',
                'Pool',
                'Gym',
                'Balcony',
            ],
            'petOptions' => ['Cats', 'Dogs', 'Small pets'],
        ];
    }

    private function uniqueSlug(string $title): string
    {
        $slug = Str::slug($title);
        $original = $slug;
        $counter = 1;

        while (Property::where('slug', $slug)->exists()) {
            $slug = $original . '-' . $counter++;
        }

        return $slug;
    }

    private function syncImages(Property $property, ?string $imagesText): void
    {
        $paths = collect(preg_split('/\r\n|\r|\n/', (string) $imagesText))
            ->map(fn($path) => trim($path))
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
}
