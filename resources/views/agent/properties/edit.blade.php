@extends('layouts.app')

@section('title', 'Propsgh | Edit Property')

@push('styles')
<style>
    .pf-shell {
        --pf-dark: #0c1220;
        --pf-slate: #1e293b;
        --pf-muted: #64748b;
        --pf-sky: #0ea5e9;
        --pf-emerald: #10b981;
        --pf-surface: #ffffff;
        --pf-border: rgba(226, 232, 240, 0.78);
        min-height: 100vh;
        padding: 6rem 0 4rem;
        background:
            radial-gradient(ellipse at 10% 0%, rgba(16, 185, 129, 0.05), transparent 45%),
            radial-gradient(ellipse at 90% 100%, rgba(14, 165, 233, 0.05), transparent 45%),
            #f8fafc;
    }

    .pf-container { max-width: 920px; }
    .pf-header { margin-bottom: 1.75rem; }
    .pf-breadcrumb { display: flex; align-items: center; gap: .45rem; margin-bottom: 1rem; color: var(--pf-muted); font-size: .8rem; }
    .pf-breadcrumb a { color: inherit; text-decoration: none; }
    .pf-title-row { display: flex; justify-content: space-between; align-items: flex-start; gap: 1rem; flex-wrap: wrap; }
    .pf-title-row h1 { margin: 0 0 .25rem; color: var(--pf-dark); font-size: 1.65rem; font-weight: 800; letter-spacing: -.035em; }
    .pf-title-row p { margin: 0; color: var(--pf-muted); font-size: .9rem; }
    .pf-badge { display: inline-flex; align-items: center; gap: .35rem; border-radius: 999px; padding: .35rem .8rem; font-size: .72rem; font-weight: 700; letter-spacing: .06em; text-transform: uppercase; }
    .pf-badge-live { background: rgba(16, 185, 129, .1); color: var(--pf-emerald); }
    .pf-badge-review { background: rgba(245, 158, 11, .12); color: #d97706; }
    .pf-badge-draft { background: rgba(100, 116, 139, .12); color: var(--pf-muted); }
    .pf-steps { display: grid; grid-template-columns: repeat(5, minmax(0, 1fr)); gap: .35rem; margin-bottom: 1.5rem; }
    .pf-step { border: 1px solid var(--pf-border); border-radius: .9rem; background: var(--pf-surface); color: var(--pf-muted); padding: .75rem .55rem; font-size: .78rem; font-weight: 700; }
    .pf-step.active { border-color: rgba(16, 185, 129, .28); background: linear-gradient(135deg, rgba(16, 185, 129, .1), rgba(14, 165, 233, .08)); color: var(--pf-dark); }
    .pf-card { position: relative; overflow: hidden; margin-bottom: 1rem; border: 1px solid var(--pf-border); border-radius: 1.15rem; background: var(--pf-surface); box-shadow: 0 10px 28px rgba(15, 23, 42, .05); padding: 1.5rem; }
    .pf-card::before { content: ''; position: absolute; inset: 0 0 auto; height: 3px; background: linear-gradient(90deg, var(--pf-emerald), var(--pf-sky)); }
    .pf-section-head { display: flex; gap: .75rem; align-items: center; margin-bottom: 1.25rem; }
    .pf-section-icon { display: inline-flex; width: 42px; height: 42px; align-items: center; justify-content: center; border-radius: .9rem; background: rgba(14, 165, 233, .08); color: var(--pf-sky); }
    .pf-section-head h2 { margin: 0 0 .1rem; font-size: 1.05rem; font-weight: 800; color: var(--pf-dark); }
    .pf-section-head p, .pf-note { margin: 0; color: var(--pf-muted); font-size: .78rem; }
    .pf-panel { display: none; }
    .pf-panel.active { display: block; }
    .pf-shell .form-label { color: var(--pf-slate); font-size: .8rem; font-weight: 700; }
    .pf-shell .form-control, .pf-shell .form-select { border-radius: .8rem; border-color: rgba(148, 163, 184, .38); background: #f8fafc; min-height: 2.9rem; }
    .pf-helper { border-radius: .9rem; background: rgba(14, 165, 233, .07); color: var(--pf-slate); padding: .85rem 1rem; font-size: .82rem; }
    .pf-chip-grid, .pf-pet-grid { display: flex; flex-wrap: wrap; gap: .6rem; }
    .pf-chip, .pf-pet { position: relative; }
    .pf-chip input, .pf-pet input { position: absolute; opacity: 0; pointer-events: none; }
    .pf-chip-label, .pf-pet-label { display: inline-flex; align-items: center; gap: .45rem; border: 1.5px solid rgba(148, 163, 184, .32); border-radius: 999px; background: #f8fafc; color: var(--pf-slate); cursor: pointer; font-size: .82rem; font-weight: 700; padding: .55rem .9rem; }
    .pf-chip input:checked + .pf-chip-label, .pf-pet input:checked + .pf-pet-label { border-color: rgba(16, 185, 129, .55); background: rgba(16, 185, 129, .1); color: #047857; }
    .pf-upload { border: 2px dashed rgba(148, 163, 184, .38); border-radius: 1rem; background: rgba(248, 250, 252, .72); padding: 1.25rem; }
    .pf-media-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(110px, 1fr)); gap: .75rem; margin-top: 1rem; }
    .pf-media-card { position: relative; overflow: hidden; aspect-ratio: 4 / 3; border-radius: .9rem; background: #e2e8f0; }
    .pf-media-card img { width: 100%; height: 100%; object-fit: cover; }
    .pf-cover-badge { position: absolute; top: .45rem; left: .45rem; z-index: 1; border-radius: 999px; background: rgba(12, 18, 32, .84); color: #fff; font-size: .65rem; font-weight: 800; padding: .16rem .45rem; }
    .pf-nav { display: flex; justify-content: space-between; gap: .75rem; margin-top: .75rem; }
    [data-conditional-section][hidden] { display: none !important; }
    @media (max-width: 767.98px) { .pf-steps { grid-template-columns: repeat(2, minmax(0, 1fr)); } .pf-card { padding: 1.2rem; } }
</style>
@endpush

@section('content')
@php
    $selectedAmenities = old('amenities', $property->amenities ?? []);
    $selectedPets = old('pets_allowed', $property->pets_allowed ?? []);
    $currentListingType = \Illuminate\Support\Str::lower((string) old('listing_type', $property->listing_type));
    $currentPropertyType = \App\Support\PropertyCatalog::normalizePropertyType(old('property_type', $property->property_type ?: 'house'));
    $currentCurrency = strtoupper((string) old('currency', $property->currency ?: \App\Models\Property::defaultCurrency()));
    $existingImages = $property->images->sortBy('sort_order');
@endphp

<div class="pf-shell">
    <div class="container pf-container">
        <div class="pf-header">
            <div class="pf-breadcrumb">
                <a href="{{ route('agent.properties.index') }}">My Properties</a>
                <i class="fi-chevron-right fs-xs"></i>
                <span>Edit listing</span>
            </div>
            <div class="pf-title-row">
                <div>
                    <h1>Edit property</h1>
                    <p>Update the listing with the same type-aware rules used when creating a property.</p>
                </div>
                <span class="pf-badge pf-badge-{{ $property->status === 'live' ? 'live' : ($property->status === 'review' ? 'review' : 'draft') }}">
                    {{ $property->status === 'review' ? 'Under review' : ucfirst($property->status) }}
                </span>
            </div>
        </div>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <div class="fw-semibold mb-2">Please fix the following:</div>
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="pf-steps">
            <button type="button" class="pf-step active" data-step="1">1. Core Details</button>
            <button type="button" class="pf-step" data-step="2">2. Type Details</button>
            <button type="button" class="pf-step" data-step="3">3. Location</button>
            <button type="button" class="pf-step" data-step="4">4. Pricing</button>
            <button type="button" class="pf-step" data-step="5">5. Media</button>
        </div>

        <form method="POST" action="{{ route('agent.properties.update', $property) }}" id="propertyEditForm" enctype="multipart/form-data" data-agent-property-form>
            @csrf
            @method('PUT')

            <section class="pf-panel active" data-panel="1">
                <div class="pf-card">
                    <div class="pf-section-head">
                        <div class="pf-section-icon"><i class="fi-home"></i></div>
                        <div>
                            <h2>Core details</h2>
                            <p>Choose listing mode, property class, title, and description.</p>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Listing type</label>
                            <select class="form-select" name="listing_type" required>
                                @foreach ($listingTypes as $value => $label)
                                    <option value="{{ $value }}" @selected($currentListingType === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Property type</label>
                            <select class="form-select" name="property_type" data-property-type required>
                                @foreach ($propertyTypes as $value => $label)
                                    <option value="{{ $value }}" @selected($currentPropertyType === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Property title</label>
                            <input type="text" class="form-control" name="title" value="{{ old('title', $property->title) }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" rows="5" name="description" required>{{ old('description', $property->description) }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="pf-nav">
                    <a href="{{ route('agent.properties.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="button" class="btn btn-primary" data-next="2">Type-Specific Details</button>
                </div>
            </section>

            <section class="pf-panel" data-panel="2">
                <div class="pf-card">
                    <div class="pf-section-head">
                        <div class="pf-section-icon"><i class="fi-grid"></i></div>
                        <div>
                            <h2>Type-specific details</h2>
                            <p>Land, residential, and commercial listings use different field sets.</p>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label" data-area-label>Property size (sq.m)</label>
                            <input type="number" class="form-control" name="area" min="0" step="0.01" value="{{ old('area', $property->area) }}" required>
                            <div class="pf-note" data-area-help>Use the relevant usable size for this listing.</div>
                        </div>
                    </div>

                    <div class="pf-helper mt-3" data-conditional-section data-property-groups="land">
                        Land mode hides room, parking, floor, year-built, and pet fields. Use amenities to describe title, access, fencing, servicing, and utilities.
                    </div>

                    <div class="row g-3 mt-1" data-conditional-section data-property-groups="residential">
                        <div class="col-6 col-md-3">
                            <label class="form-label">Bedrooms</label>
                            <input type="number" class="form-control" name="bedrooms" min="0" value="{{ old('bedrooms', $property->bedrooms) }}">
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="form-label">Bathrooms</label>
                            <input type="number" class="form-control" name="bathrooms" min="0" value="{{ old('bathrooms', $property->bathrooms) }}">
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="form-label">Garage / parking</label>
                            <input type="number" class="form-control" name="garage_spaces" min="0" value="{{ old('garage_spaces', $property->garage_spaces) }}">
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="form-label">Total rooms</label>
                            <input type="number" class="form-control" name="total_rooms" min="0" value="{{ old('total_rooms', $property->total_rooms) }}">
                        </div>
                    </div>

                    <div class="row g-3 mt-1" data-conditional-section data-property-groups="residential,commercial">
                        <div class="col-md-6">
                            <label class="form-label">Floor</label>
                            <input type="number" class="form-control" name="floor" min="0" value="{{ old('floor', $property->floor) }}">
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
                        </div>
                    </div>
                </div>
                <div class="pf-nav">
                    <button type="button" class="btn btn-outline-secondary" data-prev="1">Core Details</button>
                    <button type="button" class="btn btn-primary" data-next="3">Location</button>
                </div>
            </section>

            <section class="pf-panel" data-panel="3">
                <div class="pf-card">
                    <div class="pf-section-head">
                        <div class="pf-section-icon"><i class="fi-map-pin"></i></div>
                        <div>
                            <h2>Location</h2>
                            <p>Location data powers search, cards, and map previews.</p>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Street address</label>
                            <input type="text" class="form-control" name="address" value="{{ old('address', $property->address) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">City</label>
                            <input type="text" class="form-control" name="city" value="{{ old('city', $property->city) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Region</label>
                            <input type="text" class="form-control" name="region" value="{{ old('region', $property->region) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Postal code</label>
                            <input type="text" class="form-control" name="postal_code" value="{{ old('postal_code', $property->postal_code) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Country</label>
                            <input type="text" class="form-control" name="country" value="{{ old('country', $property->country ?: 'Ghana') }}" required>
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
                            <input type="url" class="form-control" name="map_embed_url" value="{{ old('map_embed_url', $property->map_embed_url) }}">
                        </div>
                    </div>
                </div>
                <div class="pf-nav">
                    <button type="button" class="btn btn-outline-secondary" data-prev="2">Type-Specific Details</button>
                    <button type="button" class="btn btn-primary" data-next="4">Pricing & Amenities</button>
                </div>
            </section>

            <section class="pf-panel" data-panel="4">
                <div class="pf-card">
                    <div class="pf-section-head">
                        <div class="pf-section-icon"><i class="fi-dollar-sign"></i></div>
                        <div>
                            <h2>Pricing</h2>
                            <p>Currency, period, and deposit are stored per property.</p>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Price</label>
                            <input type="number" class="form-control" name="price" min="0" value="{{ old('price', $property->price) }}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Currency</label>
                            <select class="form-select" name="currency" required>
                                @foreach ($currencyOptions as $value => $currency)
                                    <option value="{{ $value }}" @selected($currentCurrency === $value)>{{ $value }} — {{ $currency['label'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Period</label>
                            <select class="form-select" name="price_period" required>
                                @foreach ($pricePeriods as $value => $label)
                                    <option value="{{ $value }}" @selected(old('price_period', $property->price_period) === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Deposit</label>
                            <input type="number" class="form-control" name="deposit" min="0" value="{{ old('deposit', $property->deposit) }}">
                        </div>
                    </div>
                </div>

                <div class="pf-card">
                    <div class="pf-section-head">
                        <div class="pf-section-icon"><i class="fi-star"></i></div>
                        <div>
                            <h2>Type-specific amenities</h2>
                            <p>Only amenities for the selected property type are submitted.</p>
                        </div>
                    </div>
                    @foreach ($amenityOptionSets as $scope => $set)
                        <div class="mb-3" data-conditional-section data-property-types="{{ implode(',', $set['property_types']) }}">
                            <div class="fw-semibold mb-2">{{ $set['title'] }}</div>
                            <div class="pf-chip-grid">
                                @foreach ($set['options'] as $optionKey => $optionLabel)
                                    <div class="pf-chip">
                                        <input id="amenity-{{ $scope }}-{{ $optionKey }}" name="amenities[]" type="checkbox" value="{{ $optionLabel }}" @checked(in_array($optionLabel, $selectedAmenities, true))>
                                        <label class="pf-chip-label" for="amenity-{{ $scope }}-{{ $optionKey }}">
                                            <i class="{{ $amenityIcons[$optionKey] ?? 'fi-check' }}"></i>{{ $optionLabel }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="pf-card" data-conditional-section data-property-groups="residential">
                    <div class="pf-section-head">
                        <div class="pf-section-icon"><i class="fi-heart"></i></div>
                        <div>
                            <h2>Pets allowed</h2>
                            <p>Hidden automatically for land and commercial listings.</p>
                        </div>
                    </div>
                    <div class="pf-pet-grid">
                        @foreach ($petChoices as $petKey => $petLabel)
                            <div class="pf-pet">
                                <input id="pet-{{ $petKey }}" name="pets_allowed[]" type="checkbox" value="{{ $petLabel }}" @checked(in_array($petLabel, $selectedPets, true))>
                                <label class="pf-pet-label" for="pet-{{ $petKey }}">{{ $petEmojis[$petKey] ?? '🐾' }} {{ $petLabel }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="pf-nav">
                    <button type="button" class="btn btn-outline-secondary" data-prev="3">Location</button>
                    <button type="button" class="btn btn-primary" data-next="5">Media</button>
                </div>
            </section>

            <section class="pf-panel" data-panel="5">
                <div class="pf-card">
                    <div class="pf-section-head">
                        <div class="pf-section-icon"><i class="fi-image"></i></div>
                        <div>
                            <h2>Property images</h2>
                            <p>Upload new files to replace the current gallery. The first uploaded image becomes the cover.</p>
                        </div>
                    </div>
                    <div class="pf-upload">
                        <label class="form-label">Upload images</label>
                        <input type="file" class="form-control" name="images[]" multiple accept="image/*">
                        <div class="pf-note mt-2">Leave blank to keep the current images.</div>

                        @if ($existingImages->isNotEmpty())
                            <div class="fw-semibold fs-sm mt-3 mb-2">Current gallery</div>
                            <div class="pf-media-grid">
                                @foreach ($existingImages as $image)
                                    <div class="pf-media-card">
                                        @if ($image->is_cover)
                                            <span class="pf-cover-badge">Cover</span>
                                        @endif
                                        <img src="{{ asset($image->path) }}" alt="{{ $property->title }}">
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <div class="pf-media-grid" data-image-preview></div>
                    </div>
                </div>
                <div class="pf-nav">
                    <button type="button" class="btn btn-outline-secondary" data-prev="4">Pricing & Amenities</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </section>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('[data-agent-property-form]');
    if (!form) {
        return;
    }

    const steps = Array.from(document.querySelectorAll('.pf-step'));
    const panels = Array.from(document.querySelectorAll('.pf-panel'));
    const propertyTypeSelect = form.querySelector('[data-property-type]');
    const conditionalSections = Array.from(form.querySelectorAll('[data-conditional-section]'));
    const areaLabel = form.querySelector('[data-area-label]');
    const areaHelp = form.querySelector('[data-area-help]');
    const imageInput = form.querySelector('input[type="file"][name="images[]"]');
    const imagePreview = form.querySelector('[data-image-preview]');
    const propertyTypeGroupMap = @json($propertyTypeGroupMap);
    const fieldStepMap = {
        1: ['listing_type', 'property_type', 'title', 'description'],
        2: ['area', 'bedrooms', 'bathrooms', 'garage_spaces', 'total_rooms', 'floor', 'year_built'],
        3: ['address', 'city', 'region', 'postal_code', 'country', 'latitude', 'longitude', 'map_embed_url'],
        4: ['price', 'currency', 'price_period', 'deposit', 'amenities', 'pets_allowed'],
        5: ['images'],
    };

    const normalizeType = (value) => (value || 'house').toLowerCase().replaceAll('-', '_');
    const getPropertyType = () => normalizeType(propertyTypeSelect?.value);
    const getPropertyGroup = () => propertyTypeGroupMap[getPropertyType()] || 'residential';

    const setStep = (step) => {
        steps.forEach((button) => button.classList.toggle('active', Number(button.dataset.step) === step));
        panels.forEach((panel) => panel.classList.toggle('active', Number(panel.dataset.panel) === step));
        document.querySelector('.pf-steps')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
    };

    const matchesSection = (section, propertyType, propertyGroup) => {
        const allowedGroups = (section.dataset.propertyGroups || '').split(',').map((value) => value.trim()).filter(Boolean);
        const allowedTypes = (section.dataset.propertyTypes || '').split(',').map((value) => normalizeType(value.trim())).filter(Boolean);

        return (allowedGroups.length > 0 && allowedGroups.includes(propertyGroup))
            || (allowedTypes.length > 0 && allowedTypes.includes(propertyType))
            || (allowedGroups.length === 0 && allowedTypes.length === 0);
    };

    const refreshConditionalSections = () => {
        const propertyType = getPropertyType();
        const propertyGroup = getPropertyGroup();

        conditionalSections.forEach((section) => {
            const enabled = matchesSection(section, propertyType, propertyGroup);
            section.hidden = !enabled;
            section.setAttribute('aria-hidden', String(!enabled));
            section.querySelectorAll('input, select, textarea').forEach((field) => {
                field.disabled = !enabled;
            });
        });

        if (propertyGroup === 'land') {
            areaLabel.textContent = 'Plot size (sq.m)';
            areaHelp.textContent = 'Use the total plot or parcel size for the land listing.';
        } else if (propertyGroup === 'commercial') {
            areaLabel.textContent = 'Usable area (sq.m)';
            areaHelp.textContent = 'Use lettable or operational area for the business listing.';
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
            const card = document.createElement('div');
            card.className = 'pf-media-card';
            card.innerHTML = `
                ${index === 0 ? '<span class="pf-cover-badge">Cover</span>' : ''}
                <img src="${url}" alt="">
            `;
            imagePreview.appendChild(card);
        });
    };

    const resolveStepFromErrors = () => {
        const errorKeys = @json($errors->keys());
        if (errorKeys.length === 0) {
            return 1;
        }

        for (const [step, fields] of Object.entries(fieldStepMap)) {
            if (errorKeys.some((errorKey) => fields.some((field) => errorKey === field || errorKey.startsWith(`${field}.`)))) {
                return Number(step);
            }
        }

        return 1;
    };

    steps.forEach((button) => button.addEventListener('click', () => setStep(Number(button.dataset.step))));
    form.querySelectorAll('[data-next]').forEach((button) => button.addEventListener('click', () => setStep(Number(button.dataset.next))));
    form.querySelectorAll('[data-prev]').forEach((button) => button.addEventListener('click', () => setStep(Number(button.dataset.prev))));
    propertyTypeSelect?.addEventListener('change', refreshConditionalSections);
    imageInput?.addEventListener('change', renderImagePreview);

    refreshConditionalSections();
    setStep(resolveStepFromErrors());
});
</script>
@endpush
