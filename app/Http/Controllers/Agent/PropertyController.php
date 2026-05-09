<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Http\Requests\Agent\StorePropertyRequest;
use App\Http\Requests\Agent\UpdatePropertyRequest;
use App\Models\Property;
use App\Support\PropertyCatalog;
use App\Support\PropertyImageUploader;
use App\Support\PropertyLocationResolver;
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

        $data = $this->propertyLocationResolver->hydrate($request->propertyData());

        $data['owner_id'] = $request->user()->id;
        $data['slug'] = $this->uniqueSlug($data['title']);
        $data['status'] = 'review';
        $data['visibility'] = 'public';
        $data['is_featured'] = false;
        $data['is_verified'] = false;

        $property = Property::create($data);

        $this->propertyImageUploader->store($property, (array) $request->file('images', []));

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

        return view('agent.properties.edit', [
            'property' => $property,
            ...$this->formOptions(),
        ]);
    }

    public function update(UpdatePropertyRequest $request, Property $property): RedirectResponse
    {
        $this->authorizeAgent($request);

        if ($property->owner_id !== $request->user()->id) {
            abort(403);
        }

        $data = $this->propertyLocationResolver->hydrate($request->propertyData());

        $property->update($data);

        $this->propertyImageUploader->store($property, (array) $request->file('images', []), replaceExisting: true);

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

        $this->propertyImageUploader->deleteManagedImages($property);
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

    private function formOptions(): array
    {
        return [
            'listingTypes' => PropertyCatalog::listingTypes(),
            'propertyTypes' => PropertyCatalog::propertyTypes(),
            'ghanaRegions' => PropertyCatalog::ghanaRegions(),
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
            $slug = $original . '-' . $counter++;
        }

        return $slug;
    }
}
