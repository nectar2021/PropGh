@once
    @push('styles')
        <style>
            [data-conditional-section][hidden] {
                display: none !important;
            }

            .admin-property-upload {
                border: 1.5px dashed rgba(148, 163, 184, 0.55);
                border-radius: 1rem;
                background: linear-gradient(180deg, rgba(248, 250, 252, 0.92), rgba(255, 255, 255, 0.98));
                padding: 1rem;
            }

            .admin-property-image-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(92px, 1fr));
                gap: 0.75rem;
            }

            .admin-property-image {
                position: relative;
                overflow: hidden;
                border-radius: 0.85rem;
                background: var(--bs-tertiary-bg);
                aspect-ratio: 4 / 3;
            }

            .admin-property-image img,
            .admin-property-preview-thumb {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .admin-property-cover-badge {
                position: absolute;
                top: 0.45rem;
                left: 0.45rem;
                z-index: 2;
                border-radius: 999px;
                background: rgba(12, 18, 32, 0.82);
                color: #fff;
                font-size: 0.65rem;
                font-weight: 700;
                padding: 0.18rem 0.45rem;
            }
        </style>
    @endpush
@endonce

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
    $currentListingType = \Illuminate\Support\Str::lower((string) old('listing_type', $property->listing_type));
    $currentPropertyType = \App\Support\PropertyCatalog::normalizePropertyType(old('property_type', $property->property_type ?: 'house'));
    $currentCurrency = strtoupper((string) old('currency', $property->currency ?: \App\Models\Property::defaultCurrency()));
    $existingImages = $property->exists ? $property->images->sortBy('sort_order') : collect();
@endphp

<div class="col-lg-8">
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <h2 class="h5 mb-3">Core details</h2>
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
                            <option value="{{ $value }}" @selected($currentListingType === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    <div class="form-text">Shortlet remains a listing type, not a property type.</div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Property type</label>
                    <select class="form-select" name="property_type" data-property-type required>
                        @foreach ($propertyTypes as $value => $label)
                            <option value="{{ $value }}" @selected($currentPropertyType === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Slug</label>
                    <input type="text" class="form-control" name="slug" value="{{ old('slug', $property->slug) }}" placeholder="auto-generated-if-empty">
                    <div class="form-text">Leave blank to auto-generate from the title.</div>
                </div>
                <div class="col-12">
                    <label class="form-label">Property title</label>
                    <input type="text" class="form-control" name="title" value="{{ old('title', $property->title) }}" placeholder="Modern office suite in Airport City" required>
                </div>
                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" rows="5" name="description" placeholder="Highlight access, condition, amenities, nearby landmarks, and ideal buyer or tenant." required>{{ old('description', $property->description) }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <h2 class="h5 mb-3">Type-specific details</h2>
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label" data-area-label>Property size (sq.m)</label>
                    <input type="number" class="form-control" name="area" min="0" step="0.01" value="{{ old('area', $property->area) }}" required>
                    <div class="form-text" data-area-help>Use internal, usable, or plot size depending on the selected property type.</div>
                </div>
            </div>

            <div class="alert alert-info mt-3 mb-0" data-conditional-section data-property-groups="land">
                Land mode is active. Room, floor, parking, year-built, and pet fields are disabled so land never behaves like an apartment.
            </div>

            <div class="row g-3 mt-1" data-conditional-section data-property-groups="residential">
                <div class="col-md-3">
                    <label class="form-label">Bedrooms</label>
                    <input type="number" class="form-control" name="bedrooms" min="0" value="{{ old('bedrooms', $property->bedrooms) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Bathrooms</label>
                    <input type="number" class="form-control" name="bathrooms" min="0" value="{{ old('bathrooms', $property->bathrooms) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Garage / parking</label>
                    <input type="number" class="form-control" name="garage_spaces" min="0" value="{{ old('garage_spaces', $property->garage_spaces) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Total rooms</label>
                    <input type="number" class="form-control" name="total_rooms" min="0" value="{{ old('total_rooms', $property->total_rooms) }}">
                </div>
            </div>

            <div class="row g-3 mt-1" data-conditional-section data-property-groups="residential,commercial">
                <div class="col-md-6">
                    <label class="form-label">Floor</label>
                    <input type="number" class="form-control" name="floor" min="0" value="{{ old('floor', $property->floor) }}">
                    <div class="form-text">Optional. Leave blank if not relevant.</div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Year built</label>
                    <input type="number" class="form-control" name="year_built" min="1800" value="{{ old('year_built', $property->year_built) }}">
                </div>
            </div>

            <div class="row g-3 mt-1" data-conditional-section data-property-groups="commercial">
                <div class="col-md-6">
                    <label class="form-label">Parking / loading spaces</label>
                    <input type="number" class="form-control" name="garage_spaces" min="0" value="{{ old('garage_spaces', $property->garage_spaces) }}">
                    <div class="form-text">Use this for dedicated parking, loading bays, or vehicle space.</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <h2 class="h5 mb-3">Location &amp; map</h2>
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label">Street address</label>
                    <input type="text" class="form-control" name="address" value="{{ old('address', $property->address) }}" placeholder="No. 12 Liberation Road" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">City</label>
                    <input type="text" class="form-control" name="city" value="{{ old('city', $property->city) }}" placeholder="Accra" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Region</label>
                    <input type="text" class="form-control" name="region" value="{{ old('region', $property->region) }}" placeholder="Greater Accra" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Postal code</label>
                    <input type="text" class="form-control" name="postal_code" value="{{ old('postal_code', $property->postal_code) }}" placeholder="GA-123-4567">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Country</label>
                    <input type="text" class="form-control" name="country" value="{{ old('country', $property->country ?: 'Ghana') }}" placeholder="Ghana" required>
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

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <h2 class="h5 mb-3">Media</h2>
            <div class="admin-property-upload">
                <label class="form-label">Upload property images</label>
                <input class="form-control" type="file" name="images[]" multiple accept="image/*" @required(! $property->exists)>
                <div class="form-text">Upload real image files. The first uploaded image becomes the cover. Uploading new images on edit replaces the existing gallery.</div>

                @if ($existingImages->isNotEmpty())
                    <div class="mt-3">
                        <div class="fw-semibold fs-sm mb-2">Current gallery</div>
                        <div class="admin-property-image-grid">
                            @foreach ($existingImages as $image)
                                <div class="admin-property-image">
                                    @if ($image->is_cover)
                                        <span class="admin-property-cover-badge">Cover</span>
                                    @endif
                                    <img src="{{ asset($image->path) }}" alt="{{ $property->title }}">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="admin-property-image-grid mt-3" data-image-preview></div>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-4">
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <h2 class="h5 mb-3">Pricing</h2>
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label">Price</label>
                    <input type="number" class="form-control" name="price" min="0" value="{{ old('price', $property->price) }}" required>
                </div>
                <div class="col-12">
                    <label class="form-label">Currency</label>
                    <select class="form-select" name="currency" required>
                        @foreach ($currencyOptions as $value => $currency)
                            <option value="{{ $value }}" @selected($currentCurrency === $value)>{{ $value }} — {{ $currency['label'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Price period</label>
                    <select class="form-select" name="price_period" required>
                        @foreach ($pricePeriods as $value => $label)
                            <option value="{{ $value }}" @selected(old('price_period', $property->price_period) === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Deposit</label>
                    <input type="number" class="form-control" name="deposit" min="0" value="{{ old('deposit', $property->deposit) }}">
                </div>
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
            <div class="d-flex flex-column gap-3">
                @foreach ($amenityOptionSets as $scope => $set)
                    <div data-conditional-section data-property-types="{{ implode(',', $set['property_types']) }}">
                        <div class="fw-semibold fs-sm mb-2">{{ $set['title'] }}</div>
                        <div class="d-flex flex-column gap-2">
                            @foreach ($set['options'] as $optionKey => $optionLabel)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="amenities[]" id="amenity-{{ $scope }}-{{ $optionKey }}" value="{{ $optionLabel }}" @checked(in_array($optionLabel, $selectedAmenities, true))>
                                    <label class="form-check-label" for="amenity-{{ $scope }}-{{ $optionKey }}">
                                        <i class="{{ $amenityIcons[$optionKey] ?? 'fi-check' }} me-1"></i>{{ $optionLabel }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm" data-conditional-section data-property-groups="residential">
        <div class="card-body p-4">
            <h2 class="h5 mb-3">Pets allowed</h2>
            <div class="d-flex flex-column gap-2">
                @foreach ($petChoices as $petKey => $petLabel)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="pets_allowed[]" id="pet-{{ $petKey }}" value="{{ $petLabel }}" @checked(in_array($petLabel, $selectedPets, true))>
                        <label class="form-check-label" for="pet-{{ $petKey }}">{{ $petEmojis[$petKey] ?? '🐾' }} {{ $petLabel }}</label>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="col-12">
    <div class="d-flex flex-wrap justify-content-end gap-2">
        <a class="btn btn-outline-secondary" href="{{ route('admin.properties.index') }}">Cancel</a>
        <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
    </div>
</div>

@once
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const form = document.querySelector('[data-property-form]');
                if (!form) {
                    return;
                }

                const propertyTypeSelect = form.querySelector('[data-property-type]');
                const conditionalSections = Array.from(form.querySelectorAll('[data-conditional-section]'));
                const areaLabel = form.querySelector('[data-area-label]');
                const areaHelp = form.querySelector('[data-area-help]');
                const imageInput = form.querySelector('input[type="file"][name="images[]"]');
                const imagePreview = form.querySelector('[data-image-preview]');
                const propertyTypeGroupMap = @json($propertyTypeGroupMap);

                const normalizeType = (value) => (value || 'house').toLowerCase().replaceAll('-', '_');
                const getPropertyType = () => normalizeType(propertyTypeSelect?.value);
                const getPropertyGroup = () => propertyTypeGroupMap[getPropertyType()] || 'residential';

                const matchesSection = (section, propertyType, propertyGroup) => {
                    const allowedGroups = (section.dataset.propertyGroups || '').split(',').map((value) => value.trim()).filter(Boolean);
                    const allowedTypes = (section.dataset.propertyTypes || '').split(',').map((value) => normalizeType(value.trim())).filter(Boolean);

                    return (allowedGroups.length > 0 && allowedGroups.includes(propertyGroup))
                        || (allowedTypes.length > 0 && allowedTypes.includes(propertyType))
                        || (allowedGroups.length === 0 && allowedTypes.length === 0);
                };

                const setSectionEnabled = (section, enabled) => {
                    section.hidden = !enabled;
                    section.setAttribute('aria-hidden', String(!enabled));

                    section.querySelectorAll('input, select, textarea').forEach((field) => {
                        field.disabled = !enabled;
                    });
                };

                const refreshConditionalSections = () => {
                    const propertyType = getPropertyType();
                    const propertyGroup = getPropertyGroup();

                    conditionalSections.forEach((section) => {
                        setSectionEnabled(section, matchesSection(section, propertyType, propertyGroup));
                    });

                    if (propertyGroup === 'land') {
                        areaLabel.textContent = 'Plot size (sq.m)';
                        areaHelp.textContent = 'Use the total plot or parcel size for the land listing.';
                    } else if (propertyGroup === 'commercial') {
                        areaLabel.textContent = 'Usable area (sq.m)';
                        areaHelp.textContent = 'Use lettable or operational area for the commercial listing.';
                    } else {
                        areaLabel.textContent = 'Property size (sq.m)';
                        areaHelp.textContent = 'Use the total internal or usable size for the residential listing.';
                    }
                };

                const renderImagePreview = () => {
                    if (!imagePreview || !imageInput) {
                        return;
                    }

                    imagePreview.innerHTML = '';
                    Array.from(imageInput.files || []).forEach((file, index) => {
                        const url = URL.createObjectURL(file);
                        const item = document.createElement('div');
                        item.className = 'admin-property-image';
                        item.innerHTML = `
                            ${index === 0 ? '<span class="admin-property-cover-badge">Cover</span>' : ''}
                            <img class="admin-property-preview-thumb" src="${url}" alt="">
                        `;
                        imagePreview.appendChild(item);
                    });
                };

                propertyTypeSelect?.addEventListener('change', refreshConditionalSections);
                imageInput?.addEventListener('change', renderImagePreview);
                refreshConditionalSections();
            });
        </script>
    @endpush
@endonce
