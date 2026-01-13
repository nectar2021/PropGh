<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PropertyController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->trim()->toString();
        $status = $request->string('status')->trim()->toString();
        $sort = $request->string('sort', 'newest')->trim()->toString();

        $query = Property::query()->with(['owner', 'images']);

        if ($search !== '') {
            $query->where(function ($builder) use ($search): void {
                $builder
                    ->where('title', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%")
                    ->orWhere('id', $search)
                    ->orWhereHas('owner', function ($ownerQuery) use ($search): void {
                        $ownerQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($status !== '' && $status !== 'all') {
            $query->where('status', $status);
        }

        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at');
                break;
            case 'highest':
                $query->orderByDesc('price');
                break;
            case 'lowest':
                $query->orderBy('price');
                break;
            default:
                $query->orderByDesc('created_at');
        }

        $properties = $query->paginate(10)->withQueryString();

        return view('admin.properties.index', [
            'properties' => $properties,
            'search' => $search,
            'status' => $status ?: 'all',
            'sort' => $sort,
            'statusOptions' => ['all' => 'All statuses'] + $this->statusOptions(),
            'sortOptions' => $this->sortOptions(),
        ]);
    }

    public function create(): View
    {
        $property = new Property();

        return view('admin.properties.create', [
            'property' => $property,
            'owners' => $this->ownerOptions(),
            'imagesText' => '',
            ...$this->formOptions(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);

        $data['slug'] = $this->uniqueSlug($data['slug'] ?? $data['title']);
        $data['owner_id'] = $data['owner_id'] ?? $request->user()?->id;
        $data['listing_type'] = strtolower($data['listing_type']);
        $data['property_type'] = strtolower($data['property_type']);
        $data['price_period'] = strtolower($data['price_period']);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_verified'] = $request->boolean('is_verified');
        $data['amenities'] = array_values(array_filter($data['amenities'] ?? []));
        $data['pets_allowed'] = array_values(array_filter($data['pets_allowed'] ?? []));

        if ($data['status'] === 'live' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        $property = Property::create($data);

        $this->syncImages($property, $request->input('images'));

        return redirect()
            ->route('admin.properties.edit', $property)
            ->with('status', 'Property created successfully.');
    }

    public function edit(Property $property): View
    {
        $property->load(['images', 'owner']);

        $imagesText = $property->images
            ->sortBy('sort_order')
            ->pluck('path')
            ->implode("\n");

        return view('admin.properties.edit', [
            'property' => $property,
            'owners' => $this->ownerOptions(),
            'imagesText' => $imagesText,
            ...$this->formOptions(),
        ]);
    }

    public function update(Request $request, Property $property): RedirectResponse
    {
        $data = $this->validatedData($request, $property);

        $data['slug'] = $this->uniqueSlug($data['slug'] ?? $data['title'], $property->id);
        $data['owner_id'] = $data['owner_id'] ?? $request->user()?->id;
        $data['listing_type'] = strtolower($data['listing_type']);
        $data['property_type'] = strtolower($data['property_type']);
        $data['price_period'] = strtolower($data['price_period']);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_verified'] = $request->boolean('is_verified');
        $data['amenities'] = array_values(array_filter($data['amenities'] ?? []));
        $data['pets_allowed'] = array_values(array_filter($data['pets_allowed'] ?? []));

        if ($data['status'] === 'live' && empty($data['published_at'])) {
            $data['published_at'] = $property->published_at ?? now();
        }

        $property->update($data);

        $this->syncImages($property, $request->input('images'));

        return redirect()
            ->route('admin.properties.edit', $property)
            ->with('status', 'Property updated successfully.');
    }

    public function destroy(Property $property): RedirectResponse
    {
        $property->images()->delete();
        $property->delete();

        return redirect()
            ->route('admin.properties.index')
            ->with('status', 'Property deleted.');
    }

    private function validatedData(Request $request, ?Property $property = null): array
    {
        $yearMax = now()->year + 1;

        return $request->validate([
            'owner_id' => ['nullable', 'exists:users,id'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
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
            'year_built' => ['nullable', 'integer', 'min:1800', 'max:' . $yearMax],
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
            'status' => ['required', 'string', 'in:' . implode(',', array_keys($this->statusOptions()))],
            'visibility' => ['required', 'string', 'in:' . implode(',', array_keys($this->visibilityOptions()))],
            'published_at' => ['nullable', 'date'],
            'images' => ['nullable', 'string'],
        ]);
    }

    private function uniqueSlug(string $value, ?int $ignoreId = null): string
    {
        $base = Str::slug($value);
        $slug = $base;
        $counter = 1;

        while ($this->slugExists($slug, $ignoreId)) {
            $slug = $base . '-' . $counter;
            $counter++;
        }

        return $slug ?: Str::uuid()->toString();
    }

    private function slugExists(string $slug, ?int $ignoreId = null): bool
    {
        $query = Property::where('slug', $slug);

        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        return $query->exists();
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

    private function ownerOptions()
    {
        return User::orderBy('name')
            ->get(['id', 'name', 'role', 'email']);
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
            'petOptions' => [
                'Cats',
                'Dogs',
                'Small pets',
            ],
            'statusOptions' => $this->statusOptions(),
            'visibilityOptions' => $this->visibilityOptions(),
        ];
    }

    private function statusOptions(): array
    {
        return [
            'live' => 'Live',
            'draft' => 'Draft',
            'review' => 'Needs review',
        ];
    }

    private function visibilityOptions(): array
    {
        return [
            'public' => 'Public',
            'private' => 'Private',
            'hidden' => 'Hidden',
        ];
    }

    private function sortOptions(): array
    {
        return [
            'newest' => 'Newest',
            'oldest' => 'Oldest',
            'highest' => 'Highest price',
            'lowest' => 'Lowest price',
        ];
    }
}
