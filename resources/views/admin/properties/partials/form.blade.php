@if (session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <div class="fw-semibold mb-2">Please fix the following issues:</div>
        <ul class="mb-0 ps-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@php
    $selectedAmenities = old('amenities', $property->amenities ?? []);
    $selectedPets = old('pets_allowed', $property->pets_allowed ?? []);
    $currentListingType = old('listing_type', $property->listing_type);
    $currentPropertyType = old('property_type', $property->property_type);
@endphp

<div class="col-lg-8">
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <h2 class="h5 mb-3">Property details</h2>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Owner</label>
                    <select class="form-select" name="owner_id">
                        <option value="">Assign owner later</option>
                        @foreach ($owners as $owner)
                            <option value="{{ $owner->id }}" @selected(old('owner_id', $property->owner_id) == $owner->id)>
                                {{ $owner->name }} ({{ ucfirst($owner->role) }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Listing type</label>
                    <select class="form-select" name="listing_type" required>
                        @foreach ($listingTypes as $value => $label)
                            <option value="{{ $value }}" @selected(\Illuminate\Support\Str::lower((string) $currentListingType) === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Property title</label>
                    <input type="text" class="form-control" name="title" value="{{ old('title', $property->title) }}" placeholder="Modern 2-bedroom apartment in East Legon" required>
                </div>
                <div class="col-12">
                    <label class="form-label">Slug</label>
                    <input type="text" class="form-control" name="slug" value="{{ old('slug', $property->slug) }}" placeholder="auto-generated-if-empty">
                    <div class="form-text">Leave blank to auto-generate from the title.</div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Property type</label>
                    <select class="form-select" name="property_type" required>
                        @foreach ($propertyTypes as $value => $label)
                            <option value="{{ $value }}" @selected(\Illuminate\Support\Str::lower((string) $currentPropertyType) === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Bedrooms</label>
                    <input type="number" class="form-control" name="bedrooms" min="0" value="{{ old('bedrooms', $property->bedrooms) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Bathrooms</label>
                    <input type="number" class="form-control" name="bathrooms" min="0" value="{{ old('bathrooms', $property->bathrooms) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Garage spaces</label>
                    <input type="number" class="form-control" name="garage_spaces" min="0" value="{{ old('garage_spaces', $property->garage_spaces) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Total rooms</label>
                    <input type="number" class="form-control" name="total_rooms" min="0" value="{{ old('total_rooms', $property->total_rooms) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Floor</label>
                    <input type="number" class="form-control" name="floor" min="0" value="{{ old('floor', $property->floor) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Year built</label>
                    <input type="number" class="form-control" name="year_built" min="1800" value="{{ old('year_built', $property->year_built) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Size (sq.m)</label>
                    <input type="number" class="form-control" name="area" min="0" step="0.1" value="{{ old('area', $property->area) }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" rows="4" name="description" placeholder="Highlight key amenities, nearby landmarks, and unique features." required>{{ old('description', $property->description) }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <h2 class="h5 mb-3">Location &amp; map</h2>
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label">Street address</label>
                    <input type="text" class="form-control" name="address" value="{{ old('address', $property->address) }}" placeholder="No. 12, Liberation Road">
                </div>
                <div class="col-md-6">
                    <label class="form-label">City</label>
                    <input type="text" class="form-control" name="city" value="{{ old('city', $property->city) }}" placeholder="Accra">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Region</label>
                    <input type="text" class="form-control" name="region" value="{{ old('region', $property->region) }}" placeholder="Greater Accra">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Postal code</label>
                    <input type="text" class="form-control" name="postal_code" value="{{ old('postal_code', $property->postal_code) }}" placeholder="00233">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Country</label>
                    <input type="text" class="form-control" name="country" value="{{ old('country', $property->country) }}" placeholder="Ghana">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Latitude</label>
                    <input type="number" class="form-control" name="latitude" step="0.000001" value="{{ old('latitude', $property->latitude) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Longitude</label>
                    <input type="number" class="form-control" name="longitude" step="0.000001" value="{{ old('longitude', $property->longitude) }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Map embed URL</label>
                    <input type="url" class="form-control" name="map_embed_url" value="{{ old('map_embed_url', $property->map_embed_url) }}" placeholder="https://www.google.com/maps/embed?...">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-4">
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <h2 class="h5 mb-3">Pricing</h2>
            <div class="mb-3">
                <label class="form-label">Price</label>
                <input type="number" class="form-control" name="price" min="0" value="{{ old('price', $property->price) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Price period</label>
                <select class="form-select" name="price_period" required>
                    @foreach ($pricePeriods as $value => $label)
                        <option value="{{ $value }}" @selected(old('price_period', $property->price_period) === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label">Deposit</label>
                <input type="number" class="form-control" name="deposit" min="0" value="{{ old('deposit', $property->deposit) }}">
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <h2 class="h5 mb-3">Status &amp; visibility</h2>
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select class="form-select" name="status" required>
                    @foreach ($statusOptions as $value => $label)
                        <option value="{{ $value }}" @selected(old('status', $property->status ?? 'draft') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Visibility</label>
                <select class="form-select" name="visibility" required>
                    @foreach ($visibilityOptions as $value => $label)
                        <option value="{{ $value }}" @selected(old('visibility', $property->visibility ?? 'public') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" name="is_featured" id="isFeatured" value="1" @checked(old('is_featured', $property->is_featured))>
                <label class="form-check-label" for="isFeatured">Featured listing</label>
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="is_verified" id="isVerified" value="1" @checked(old('is_verified', $property->is_verified))>
                <label class="form-check-label" for="isVerified">Verified listing</label>
            </div>
            <div>
                <label class="form-label">Published at</label>
                <input type="datetime-local" class="form-control" name="published_at" value="{{ old('published_at', optional($property->published_at)->format('Y-m-d\\TH:i')) }}">
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <h2 class="h5 mb-3">Amenities</h2>
            <div class="d-flex flex-column gap-2">
                @foreach ($amenityOptions as $amenity)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="amenities[]" id="amenity-{{ \Illuminate\Support\Str::slug($amenity) }}" value="{{ $amenity }}" @checked(in_array($amenity, $selectedAmenities, true))>
                        <label class="form-check-label" for="amenity-{{ \Illuminate\Support\Str::slug($amenity) }}">{{ $amenity }}</label>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <h2 class="h5 mb-3">Pets allowed</h2>
            <div class="d-flex flex-column gap-2">
                @foreach ($petOptions as $pet)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="pets_allowed[]" id="pet-{{ \Illuminate\Support\Str::slug($pet) }}" value="{{ $pet }}" @checked(in_array($pet, $selectedPets, true))>
                        <label class="form-check-label" for="pet-{{ \Illuminate\Support\Str::slug($pet) }}">{{ $pet }}</label>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <h2 class="h5 mb-3">Media</h2>
            <label class="form-label">Image paths (one per line)</label>
            <textarea class="form-control" rows="6" name="images" placeholder="assets/img/listings/real-estate/01.jpg">{{ old('images', $imagesText) }}</textarea>
            <div class="form-text">The first image will be used as the cover.</div>
        </div>
    </div>
</div>

<div class="col-12">
    <div class="d-flex flex-wrap justify-content-end gap-2">
        <a class="btn btn-outline-secondary" href="{{ route('admin.properties.index') }}">Cancel</a>
        <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
    </div>
</div>
