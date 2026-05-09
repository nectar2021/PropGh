<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePropertyRequest;
use App\Http\Requests\Admin\UpdatePropertyRequest;
use App\Models\Property;
use App\Models\User;
use App\Support\PropertyCatalog;
use App\Support\PropertyImageUploader;
use App\Support\PropertyLocationResolver;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PropertyController extends Controller
{
    public function __construct(
        private PropertyImageUploader $propertyImageUploader,
        private PropertyLocationResolver $propertyLocationResolver,
    ) {}

    public function index(Request $request): View
    {
        $search = $request->string('search')->trim()->toString();
        $status = $request->string('status')->trim()->toString();
        $sort = $request->string('sort', 'newest')->trim()->toString();
        $hasFilters = $search !== '' || ($status !== '' && $status !== 'all') || $sort !== 'newest';

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
        $summary = [
            'total' => Property::count(),
            'live' => Property::where('status', 'live')->count(),
            'review' => Property::where('status', 'review')->count(),
            'draft' => Property::where('status', 'draft')->count(),
        ];

        return view('admin.properties.index', [
            'properties' => $properties,
            'search' => $search,
            'status' => $status ?: 'all',
            'sort' => $sort,
            'hasFilters' => $hasFilters,
            'summary' => $summary,
            'statusOptions' => ['all' => 'All statuses'] + $this->statusOptions(),
            'sortOptions' => $this->sortOptions(),
        ]);
    }

    public function create(): View
    {
        $property = new Property;

        return view('admin.properties.create', [
            'property' => $property,
            'owners' => $this->ownerOptions(),
            ...$this->formOptions(),
        ]);
    }

    public function store(StorePropertyRequest $request): RedirectResponse
    {
        $data = $this->propertyLocationResolver->hydrate($request->propertyData());

        $data['slug'] = $this->uniqueSlug($data['slug'] ?? $data['title']);
        $data['owner_id'] = $data['owner_id'] ?? $request->user()?->id;
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_verified'] = $request->boolean('is_verified');

        if ($data['status'] === 'live' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        $property = Property::create($data);

        $this->propertyImageUploader->store($property, (array) $request->file('images', []));

        return redirect()
            ->route('admin.properties.edit', $property)
            ->with('status', 'Property created successfully.');
    }

    public function edit(Property $property): View
    {
        $property->load(['images', 'owner']);

        return view('admin.properties.edit', [
            'property' => $property,
            'owners' => $this->ownerOptions(),
            ...$this->formOptions(),
        ]);
    }

    public function update(UpdatePropertyRequest $request, Property $property): RedirectResponse
    {
        $data = $this->propertyLocationResolver->hydrate($request->propertyData());

        $data['slug'] = $this->uniqueSlug($data['slug'] ?? $data['title'], $property->id);
        $data['owner_id'] = $data['owner_id'] ?? $request->user()?->id;
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_verified'] = $request->boolean('is_verified');

        if ($data['status'] === 'live' && empty($data['published_at'])) {
            $data['published_at'] = $property->published_at ?? now();
        }

        $property->update($data);

        $this->propertyImageUploader->store($property, (array) $request->file('images', []), replaceExisting: true);

        return redirect()
            ->route('admin.properties.edit', $property)
            ->with('status', 'Property updated successfully.');
    }

    public function destroy(Property $property): RedirectResponse
    {
        $this->propertyImageUploader->deleteManagedImages($property);
        $property->images()->delete();
        $property->delete();

        return redirect()
            ->route('admin.properties.index')
            ->with('status', 'Property deleted.');
    }

    private function uniqueSlug(string $value, ?int $ignoreId = null): string
    {
        $base = Str::slug($value);
        $slug = $base;
        $counter = 1;

        while ($this->slugExists($slug, $ignoreId)) {
            $slug = $base.'-'.$counter;
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

    private function ownerOptions(): EloquentCollection
    {
        return User::whereIn('role', ['agent', 'admin'])
            ->orderBy('name')
            ->get(['id', 'name', 'role', 'email']);
    }

    private function formOptions(): array
    {
        return [
            'listingTypes' => PropertyCatalog::listingTypes(),
            'propertyTypes' => PropertyCatalog::propertyTypes(),
            'ghanaRegions' => PropertyCatalog::ghanaRegions(),
            'currencyOptions' => PropertyCatalog::currencyOptions(),
            'pricePeriods' => PropertyCatalog::pricePeriods(),
            'propertyTypeGroups' => PropertyCatalog::propertyTypeGroups(),
            'propertyTypeGroupMap' => PropertyCatalog::propertyTypeGroupMap(),
            'amenityOptionSets' => PropertyCatalog::amenityOptionSets(),
            'amenityIcons' => PropertyCatalog::amenityIcons(),
            'petChoices' => PropertyCatalog::petOptions(),
            'petEmojis' => PropertyCatalog::petEmojis(),
            'petOptions' => PropertyCatalog::petLabels(),
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
