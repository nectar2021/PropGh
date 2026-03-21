@extends('layouts.app')

@section('title', 'Propsgh | Edit Property')

@push('styles')
<style>
    /* ── Property form shell ── */
    .pf-shell {
        --pf-dark: #0c1220;
        --pf-slate: #1e293b;
        --pf-muted: #64748b;
        --pf-sky: #0ea5e9;
        --pf-sky-glow: rgba(14, 165, 233, 0.15);
        --pf-emerald: #10b981;
        --pf-amber: #f59e0b;
        --pf-surface: #ffffff;
        --pf-border: rgba(226, 232, 240, 0.7);
        --pf-radius: 1.1rem;
        --pf-ease: cubic-bezier(0.16, 1, 0.3, 1);
        min-height: 100vh;
        padding-top: 6rem;
        padding-bottom: 4rem;
        background:
            radial-gradient(ellipse at 10% 0%, rgba(16, 185, 129, 0.04) 0%, transparent 50%),
            radial-gradient(ellipse at 90% 100%, rgba(14, 165, 233, 0.04) 0%, transparent 50%),
            #f8fafc;
    }

    .pf-header { margin-bottom: 2rem; }
    .pf-breadcrumb {
        display: flex; align-items: center; gap: 0.4rem;
        font-size: 0.78rem; color: var(--pf-muted); margin-bottom: 1rem;
    }
    .pf-breadcrumb a { color: var(--pf-muted); text-decoration: none; transition: color 0.2s; }
    .pf-breadcrumb a:hover { color: var(--pf-sky); }
    .pf-breadcrumb .pf-bc-sep { font-size: 0.65rem; opacity: 0.5; }
    .pf-breadcrumb .pf-bc-current { color: var(--pf-slate); font-weight: 600; }
    .pf-title-row {
        display: flex; align-items: flex-start; justify-content: space-between;
        gap: 1rem; flex-wrap: wrap;
    }
    .pf-title-row h1 {
        font-size: 1.55rem; font-weight: 700; color: var(--pf-dark);
        letter-spacing: -0.03em; margin-bottom: 0.2rem;
    }
    .pf-title-row p { font-size: 0.86rem; color: var(--pf-muted); margin: 0; }
    .pf-status-badges { display: flex; gap: 0.4rem; flex-wrap: wrap; }
    .pf-badge {
        display: inline-flex; align-items: center; gap: 0.35rem;
        padding: 0.3rem 0.8rem; border-radius: 999px;
        font-size: 0.72rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.06em;
    }
    .pf-badge-live { background: rgba(16, 185, 129, 0.1); color: var(--pf-emerald); border: 1px solid rgba(16, 185, 129, 0.2); }
    .pf-badge-review { background: rgba(245, 158, 11, 0.1); color: var(--pf-amber); border: 1px solid rgba(245, 158, 11, 0.2); }
    .pf-badge-draft { background: rgba(148, 163, 184, 0.1); color: var(--pf-muted); border: 1px solid rgba(148, 163, 184, 0.2); }
    .pf-badge-verified { background: rgba(14, 165, 233, 0.1); color: var(--pf-sky); border: 1px solid rgba(14, 165, 233, 0.2); }

    /* ── Steps ── */
    .pf-steps {
        display: flex; gap: 0; margin-bottom: 2rem;
        background: var(--pf-surface); border: 1px solid var(--pf-border);
        border-radius: var(--pf-radius); overflow: hidden;
        box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
    }
    .pf-step-btn {
        flex: 1; display: flex; align-items: center; justify-content: center;
        gap: 0.55rem; padding: 0.85rem 1rem; border: none; background: transparent;
        font-size: 0.82rem; font-weight: 500; color: var(--pf-muted);
        cursor: pointer; transition: all 0.3s var(--pf-ease); position: relative;
    }
    .pf-step-btn:not(:last-child)::after {
        content: ''; position: absolute; right: 0; top: 20%; height: 60%;
        width: 1px; background: var(--pf-border);
    }
    .pf-step-btn .pf-step-num {
        width: 24px; height: 24px; border-radius: 50%;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 0.7rem; font-weight: 700;
        background: rgba(148, 163, 184, 0.15); color: var(--pf-muted);
        transition: all 0.3s var(--pf-ease);
    }
    .pf-step-btn.active { color: var(--pf-dark); font-weight: 600; background: rgba(16, 185, 129, 0.04); }
    .pf-step-btn.active .pf-step-num { background: linear-gradient(135deg, var(--pf-emerald), var(--pf-sky)); color: #fff; box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3); }
    .pf-step-btn.completed .pf-step-num { background: var(--pf-emerald); color: #fff; }
    .pf-step-btn:hover:not(.active) { color: var(--pf-slate); background: rgba(148, 163, 184, 0.05); }
    .pf-step-label { display: none; }
    @media (min-width: 576px) { .pf-step-label { display: inline; } }

    /* ── Cards ── */
    .pf-card {
        background: var(--pf-surface); border: 1px solid var(--pf-border);
        border-radius: var(--pf-radius); padding: 2rem;
        box-shadow: 0 1px 2px rgba(15, 23, 42, 0.03), 0 8px 24px rgba(15, 23, 42, 0.05);
        position: relative; overflow: hidden; margin-bottom: 1.25rem;
    }
    .pf-card::before {
        content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
        background: linear-gradient(90deg, var(--pf-emerald), var(--pf-sky));
        border-radius: var(--pf-radius) var(--pf-radius) 0 0;
    }
    .pf-section-head { display: flex; align-items: center; gap: 0.65rem; margin-bottom: 1.5rem; }
    .pf-section-icon {
        width: 40px; height: 40px; border-radius: 0.75rem;
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(14, 165, 233, 0.08));
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 1rem; color: var(--pf-emerald); flex-shrink: 0;
    }
    .pf-section-head h2 { font-size: 1.05rem; font-weight: 700; color: var(--pf-dark); letter-spacing: -0.02em; margin: 0 0 0.1rem; }
    .pf-section-head p { font-size: 0.76rem; color: var(--pf-muted); margin: 0; }

    /* ── Inputs ── */
    .pf-shell .form-label { font-size: 0.78rem; font-weight: 600; color: var(--pf-slate); letter-spacing: 0.015em; margin-bottom: 0.35rem; }
    .pf-shell .form-control, .pf-shell .form-select {
        border-radius: 0.75rem; border: 1.5px solid rgba(148, 163, 184, 0.35);
        background: #f8fafc; padding: 0.65rem 0.9rem; font-size: 0.88rem;
        color: var(--pf-dark); transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .pf-shell .form-control::placeholder { color: rgba(100, 116, 139, 0.45); }
    .pf-shell .form-control:hover, .pf-shell .form-select:hover { border-color: rgba(148, 163, 184, 0.6); background: #fafbfe; }
    .pf-shell .form-control:focus, .pf-shell .form-select:focus { border-color: var(--pf-sky); background: #ffffff; box-shadow: 0 0 0 3.5px var(--pf-sky-glow); }

    /* Number cards */
    .pf-num-card {
        background: #f8fafc; border: 1.5px solid rgba(148, 163, 184, 0.25);
        border-radius: 0.75rem; padding: 0.75rem; text-align: center; transition: all 0.25s ease;
    }
    .pf-num-card:focus-within { border-color: var(--pf-sky); background: #fff; box-shadow: 0 0 0 3px var(--pf-sky-glow); }
    .pf-num-card .pf-num-icon { font-size: 1.15rem; color: var(--pf-muted); margin-bottom: 0.35rem; display: block; }
    .pf-num-card label { font-size: 0.68rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.06em; color: var(--pf-muted); display: block; margin-bottom: 0.35rem; }
    .pf-num-card input { width: 100%; border: none; background: transparent; text-align: center; font-size: 1.15rem; font-weight: 700; color: var(--pf-dark); padding: 0; outline: none; }
    .pf-num-card input::-webkit-inner-spin-button { opacity: 1; }

    /* Chips */
    .pf-chip-grid { display: flex; flex-wrap: wrap; gap: 0.5rem; }
    .pf-chip { position: relative; }
    .pf-chip input[type="checkbox"] { position: absolute; opacity: 0; pointer-events: none; }
    .pf-chip-label {
        display: inline-flex; align-items: center; gap: 0.4rem;
        padding: 0.45rem 0.95rem; border-radius: 999px;
        border: 1.5px solid rgba(148, 163, 184, 0.3); background: #f8fafc;
        font-size: 0.8rem; font-weight: 500; color: var(--pf-muted);
        cursor: pointer; transition: all 0.25s var(--pf-ease); user-select: none;
    }
    .pf-chip-label i { font-size: 0.85rem; }
    .pf-chip input:checked + .pf-chip-label {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(14, 165, 233, 0.08));
        border-color: var(--pf-emerald); color: var(--pf-emerald); font-weight: 600;
    }
    .pf-chip-label:hover { border-color: rgba(148, 163, 184, 0.55); background: #f1f5f9; }

    /* Pets */
    .pf-pet-grid { display: flex; gap: 0.65rem; flex-wrap: wrap; }
    .pf-pet { position: relative; }
    .pf-pet input[type="checkbox"] { position: absolute; opacity: 0; pointer-events: none; }
    .pf-pet-label {
        display: flex; flex-direction: column; align-items: center; gap: 0.3rem;
        padding: 0.75rem 1.2rem; border-radius: 0.85rem;
        border: 1.5px solid rgba(148, 163, 184, 0.3); background: #f8fafc;
        font-size: 0.78rem; font-weight: 500; color: var(--pf-muted);
        cursor: pointer; transition: all 0.25s var(--pf-ease); min-width: 85px; text-align: center;
    }
    .pf-pet-label .pf-pet-emoji { font-size: 1.4rem; line-height: 1; }
    .pf-pet input:checked + .pf-pet-label {
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.08), rgba(245, 158, 11, 0.04));
        border-color: var(--pf-amber); color: var(--pf-amber); font-weight: 600;
    }

    /* Image area */
    .pf-image-area {
        border: 2px dashed rgba(148, 163, 184, 0.35); border-radius: 0.85rem;
        padding: 1.5rem; background: rgba(248, 250, 252, 0.6); transition: all 0.25s ease;
    }
    .pf-image-area:focus-within { border-color: var(--pf-sky); background: rgba(14, 165, 233, 0.02); }
    .pf-image-hint { display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem; }
    .pf-image-hint-icon {
        width: 44px; height: 44px; border-radius: 0.75rem;
        background: linear-gradient(135deg, rgba(14, 165, 233, 0.1), rgba(16, 185, 129, 0.08));
        display: flex; align-items: center; justify-content: center; font-size: 1.15rem; color: var(--pf-sky); flex-shrink: 0;
    }
    .pf-image-hint h6 { font-size: 0.82rem; font-weight: 600; color: var(--pf-dark); margin: 0 0 0.1rem; }
    .pf-image-hint p { font-size: 0.72rem; color: var(--pf-muted); margin: 0; }
    .pf-image-area textarea {
        border: none !important; background: transparent !important; box-shadow: none !important;
        padding: 0 !important; resize: vertical; font-size: 0.82rem;
        font-family: ui-monospace, SFMono-Regular, 'SF Mono', Menlo, monospace; color: var(--pf-slate);
    }

    /* Panels */
    .pf-panel { display: none; }
    .pf-panel.active { display: block; animation: pfSlideIn 0.35s var(--pf-ease); }

    /* Nav bar */
    .pf-nav-bar { display: flex; align-items: center; justify-content: space-between; gap: 1rem; margin-top: 0.5rem; }
    .pf-btn-secondary {
        display: inline-flex; align-items: center; gap: 0.4rem;
        padding: 0.7rem 1.4rem; border: 1.5px solid var(--pf-border);
        border-radius: 0.75rem; background: var(--pf-surface); font-size: 0.85rem;
        font-weight: 600; color: var(--pf-slate); cursor: pointer; text-decoration: none; transition: all 0.25s ease;
    }
    .pf-btn-secondary:hover { border-color: rgba(148, 163, 184, 0.6); background: #f1f5f9; color: var(--pf-dark); }
    .pf-btn-primary {
        display: inline-flex; align-items: center; gap: 0.45rem;
        padding: 0.7rem 1.6rem; border: none; border-radius: 0.75rem;
        font-size: 0.85rem; font-weight: 600; color: #fff;
        background: linear-gradient(135deg, var(--pf-dark), var(--pf-slate));
        cursor: pointer; transition: all 0.3s var(--pf-ease); position: relative; overflow: hidden;
    }
    .pf-btn-primary::before {
        content: ''; position: absolute; top: 0; left: -100%; width: 100%; height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.08), transparent); transition: left 0.5s ease;
    }
    .pf-btn-primary:hover { transform: translateY(-1px); box-shadow: 0 8px 24px rgba(12, 18, 32, 0.22); color: #fff; }
    .pf-btn-primary:hover::before { left: 100%; }
    .pf-btn-submit { background: linear-gradient(135deg, var(--pf-emerald), var(--pf-sky)); }
    .pf-btn-submit:hover { box-shadow: 0 8px 24px rgba(16, 185, 129, 0.3); }

    /* Alerts */
    .pf-alert-error { background: rgba(239, 68, 68, 0.06); border: 1px solid rgba(239, 68, 68, 0.2); border-radius: var(--pf-radius); padding: 1rem 1.25rem; margin-bottom: 1.5rem; }
    .pf-alert-error .pf-alert-title { font-size: 0.82rem; font-weight: 700; color: #dc2626; margin-bottom: 0.4rem; }
    .pf-alert-error ul { margin: 0; padding-left: 1.1rem; font-size: 0.8rem; color: #b91c1c; }
    .pf-alert-success {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.06), rgba(14, 165, 233, 0.04));
        border: 1px solid rgba(16, 185, 129, 0.2); border-radius: var(--pf-radius);
        padding: 1rem 1.25rem; margin-bottom: 1.5rem;
        display: flex; align-items: center; gap: 0.6rem; font-size: 0.85rem; font-weight: 500; color: var(--pf-emerald);
    }

    @keyframes pfSlideIn { from { opacity: 0; transform: translateX(12px); } to { opacity: 1; transform: translateX(0); } }
    @media (prefers-reduced-motion: reduce) { .pf-panel.active { animation: none; } }
    @media (max-width: 767.98px) {
        .pf-card { padding: 1.35rem; }
        .pf-title-row h1 { font-size: 1.3rem; }
        .pf-step-btn { padding: 0.7rem 0.5rem; font-size: 0.75rem; }
    }
</style>
@endpush

@section('content')
<div class="pf-shell">
    <div class="container" style="max-width: 820px;">

        {{-- Header --}}
        <div class="pf-header">
            <div class="pf-breadcrumb">
                <a href="{{ route('agent.properties.index') }}">My Properties</a>
                <span class="pf-bc-sep"><i class="fi-chevron-right"></i></span>
                <span class="pf-bc-current">Edit listing</span>
            </div>
            <div class="pf-title-row">
                <div>
                    <h1>Edit property</h1>
                    <p>Update your listing details below.</p>
                </div>
                <div class="pf-status-badges">
                    @if ($property->status === 'live')
                        <span class="pf-badge pf-badge-live"><i class="fi-check-circle"></i> Live</span>
                    @elseif ($property->status === 'review')
                        <span class="pf-badge pf-badge-review"><i class="fi-clock"></i> Under review</span>
                    @else
                        <span class="pf-badge pf-badge-draft"><i class="fi-edit"></i> Draft</span>
                    @endif
                    @if ($property->is_verified)
                        <span class="pf-badge pf-badge-verified"><i class="fi-shield"></i> Verified</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Alerts --}}
        @if (session('status'))
            <div class="pf-alert-success">
                <i class="fi-check-circle"></i>{{ session('status') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="pf-alert-error">
                <div class="pf-alert-title"><i class="fi-alert-circle me-1"></i>Please fix the following:</div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Steps --}}
        <div class="pf-steps">
            <button type="button" class="pf-step-btn active" data-step="1">
                <span class="pf-step-num">1</span>
                <span class="pf-step-label">Details</span>
            </button>
            <button type="button" class="pf-step-btn" data-step="2">
                <span class="pf-step-num">2</span>
                <span class="pf-step-label">Location</span>
            </button>
            <button type="button" class="pf-step-btn" data-step="3">
                <span class="pf-step-num">3</span>
                <span class="pf-step-label">Pricing</span>
            </button>
            <button type="button" class="pf-step-btn" data-step="4">
                <span class="pf-step-num">4</span>
                <span class="pf-step-label">Media</span>
            </button>
        </div>

        @php
            $selectedAmenities = old('amenities', $property->amenities ?? []);
            $selectedPets = old('pets_allowed', $property->pets_allowed ?? []);
            $currentListingType = old('listing_type', $property->listing_type);
            $currentPropertyType = old('property_type', $property->property_type);

            $petEmojis = ['Cats' => '🐱', 'Dogs' => '🐶', 'Small pets' => '🐹'];
            $amenityIcons = [
                'WiFi' => 'fi-wifi', 'Dishwasher' => 'fi-dish', 'Air conditioning' => 'fi-wind',
                'Parking' => 'fi-car', 'Laundry' => 'fi-droplet', 'Security cameras' => 'fi-lock',
                'Pool' => 'fi-droplet', 'Gym' => 'fi-zap', 'Balcony' => 'fi-sun',
            ];
        @endphp

        <form method="POST" action="{{ route('agent.properties.update', $property) }}" id="propertyForm">
            @csrf
            @method('PUT')

            {{-- Step 1: Details --}}
            <div class="pf-panel active" data-panel="1">
                <div class="pf-card">
                    <div class="pf-section-head">
                        <div class="pf-section-icon"><i class="fi-home"></i></div>
                        <div>
                            <h2>Property details</h2>
                            <p>Update the type, size, and key features.</p>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label class="form-label">Listing type</label>
                            <select class="form-select" name="listing_type" required>
                                @foreach ($listingTypes as $value => $label)
                                    <option value="{{ $value }}" @selected(\Illuminate\Support\Str::lower((string) $currentListingType) === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Property type</label>
                            <select class="form-select" name="property_type" required>
                                @foreach ($propertyTypes as $value => $label)
                                    <option value="{{ $value }}" @selected(\Illuminate\Support\Str::lower((string) $currentPropertyType) === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Property title</label>
                            <input type="text" class="form-control" name="title" value="{{ old('title', $property->title) }}" required>
                        </div>
                    </div>
                </div>

                <div class="pf-card">
                    <div class="pf-section-head">
                        <div class="pf-section-icon"><i class="fi-grid"></i></div>
                        <div>
                            <h2>Rooms &amp; dimensions</h2>
                            <p>How many rooms and what size is the property?</p>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-6 col-sm-3">
                            <div class="pf-num-card">
                                <span class="pf-num-icon"><i class="fi-bed-single"></i></span>
                                <label>Beds</label>
                                <input type="number" name="bedrooms" min="0" value="{{ old('bedrooms', $property->bedrooms) }}">
                            </div>
                        </div>
                        <div class="col-6 col-sm-3">
                            <div class="pf-num-card">
                                <span class="pf-num-icon"><i class="fi-shower"></i></span>
                                <label>Baths</label>
                                <input type="number" name="bathrooms" min="0" value="{{ old('bathrooms', $property->bathrooms) }}">
                            </div>
                        </div>
                        <div class="col-6 col-sm-3">
                            <div class="pf-num-card">
                                <span class="pf-num-icon"><i class="fi-car"></i></span>
                                <label>Garage</label>
                                <input type="number" name="garage_spaces" min="0" value="{{ old('garage_spaces', $property->garage_spaces) }}">
                            </div>
                        </div>
                        <div class="col-6 col-sm-3">
                            <div class="pf-num-card">
                                <span class="pf-num-icon"><i class="fi-layers"></i></span>
                                <label>Rooms</label>
                                <input type="number" name="total_rooms" min="0" value="{{ old('total_rooms', $property->total_rooms) }}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label class="form-label">Floor</label>
                            <input type="number" class="form-control" name="floor" min="0" value="{{ old('floor', $property->floor) }}">
                        </div>
                        <div class="col-sm-4">
                            <label class="form-label">Year built</label>
                            <input type="number" class="form-control" name="year_built" min="1800" value="{{ old('year_built', $property->year_built) }}">
                        </div>
                        <div class="col-sm-4">
                            <label class="form-label">Size (sq.m)</label>
                            <input type="number" class="form-control" name="area" min="0" step="0.1" value="{{ old('area', $property->area) }}">
                        </div>
                    </div>
                </div>

                <div class="pf-card">
                    <div class="pf-section-head">
                        <div class="pf-section-icon"><i class="fi-file-text"></i></div>
                        <div>
                            <h2>Description</h2>
                            <p>Highlight what makes this property special.</p>
                        </div>
                    </div>
                    <textarea class="form-control" rows="5" name="description" required>{{ old('description', $property->description) }}</textarea>
                </div>

                <div class="pf-nav-bar">
                    <a href="{{ route('agent.properties.index') }}" class="pf-btn-secondary">
                        <i class="fi-arrow-left fs-sm"></i> Cancel
                    </a>
                    <button type="button" class="pf-btn-primary" data-next="2">
                        Location <i class="fi-arrow-right fs-sm"></i>
                    </button>
                </div>
            </div>

            {{-- Step 2: Location --}}
            <div class="pf-panel" data-panel="2">
                <div class="pf-card">
                    <div class="pf-section-head">
                        <div class="pf-section-icon"><i class="fi-map-pin"></i></div>
                        <div>
                            <h2>Location</h2>
                            <p>Where is the property located?</p>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Street address</label>
                            <input type="text" class="form-control" name="address" value="{{ old('address', $property->address) }}">
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">City</label>
                            <input type="text" class="form-control" name="city" value="{{ old('city', $property->city) }}">
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Region</label>
                            <input type="text" class="form-control" name="region" value="{{ old('region', $property->region) }}">
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Postal code</label>
                            <input type="text" class="form-control" name="postal_code" value="{{ old('postal_code', $property->postal_code) }}">
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Country</label>
                            <input type="text" class="form-control" name="country" value="{{ old('country', $property->country) }}">
                        </div>
                    </div>
                </div>

                <div class="pf-card">
                    <div class="pf-section-head">
                        <div class="pf-section-icon"><i class="fi-map"></i></div>
                        <div>
                            <h2>Map coordinates</h2>
                            <p>Optional — helps display the property on maps.</p>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label class="form-label">Latitude</label>
                            <input type="number" class="form-control" name="latitude" step="0.000001" value="{{ old('latitude', $property->latitude) }}">
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Longitude</label>
                            <input type="number" class="form-control" name="longitude" step="0.000001" value="{{ old('longitude', $property->longitude) }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Map embed URL</label>
                            <input type="url" class="form-control" name="map_embed_url" value="{{ old('map_embed_url', $property->map_embed_url) }}">
                        </div>
                    </div>
                </div>

                <div class="pf-nav-bar">
                    <button type="button" class="pf-btn-secondary" data-prev="1">
                        <i class="fi-arrow-left fs-sm"></i> Details
                    </button>
                    <button type="button" class="pf-btn-primary" data-next="3">
                        Pricing <i class="fi-arrow-right fs-sm"></i>
                    </button>
                </div>
            </div>

            {{-- Step 3: Pricing & Amenities --}}
            <div class="pf-panel" data-panel="3">
                <div class="pf-card">
                    <div class="pf-section-head">
                        <div class="pf-section-icon"><i class="fi-dollar-sign"></i></div>
                        <div>
                            <h2>Pricing</h2>
                            <p>Set the price and billing frequency.</p>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-sm-5">
                            <label class="form-label">Price</label>
                            <input type="number" class="form-control" name="price" min="0" value="{{ old('price', $property->price) }}" required>
                        </div>
                        <div class="col-sm-4">
                            <label class="form-label">Period</label>
                            <select class="form-select" name="price_period" required>
                                @foreach ($pricePeriods as $value => $label)
                                    <option value="{{ $value }}" @selected(old('price_period', $property->price_period) === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label class="form-label">Deposit</label>
                            <input type="number" class="form-control" name="deposit" min="0" value="{{ old('deposit', $property->deposit) }}">
                        </div>
                    </div>
                </div>

                <div class="pf-card">
                    <div class="pf-section-head">
                        <div class="pf-section-icon"><i class="fi-star"></i></div>
                        <div>
                            <h2>Amenities</h2>
                            <p>Select what's available at this property.</p>
                        </div>
                    </div>
                    <div class="pf-chip-grid">
                        @foreach ($amenityOptions as $amenity)
                            <div class="pf-chip">
                                <input type="checkbox" name="amenities[]" id="amenity-{{ \Illuminate\Support\Str::slug($amenity) }}" value="{{ $amenity }}" @checked(in_array($amenity, $selectedAmenities, true))>
                                <label class="pf-chip-label" for="amenity-{{ \Illuminate\Support\Str::slug($amenity) }}">
                                    <i class="{{ $amenityIcons[$amenity] ?? 'fi-check' }}"></i>
                                    {{ $amenity }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="pf-card">
                    <div class="pf-section-head">
                        <div class="pf-section-icon"><i class="fi-heart"></i></div>
                        <div>
                            <h2>Pets allowed</h2>
                            <p>Which pets are welcome?</p>
                        </div>
                    </div>
                    <div class="pf-pet-grid">
                        @foreach ($petOptions as $pet)
                            <div class="pf-pet">
                                <input type="checkbox" name="pets_allowed[]" id="pet-{{ \Illuminate\Support\Str::slug($pet) }}" value="{{ $pet }}" @checked(in_array($pet, $selectedPets, true))>
                                <label class="pf-pet-label" for="pet-{{ \Illuminate\Support\Str::slug($pet) }}">
                                    <span class="pf-pet-emoji">{{ $petEmojis[$pet] ?? '🐾' }}</span>
                                    {{ $pet }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="pf-nav-bar">
                    <button type="button" class="pf-btn-secondary" data-prev="2">
                        <i class="fi-arrow-left fs-sm"></i> Location
                    </button>
                    <button type="button" class="pf-btn-primary" data-next="4">
                        Media <i class="fi-arrow-right fs-sm"></i>
                    </button>
                </div>
            </div>

            {{-- Step 4: Media --}}
            <div class="pf-panel" data-panel="4">
                <div class="pf-card">
                    <div class="pf-section-head">
                        <div class="pf-section-icon"><i class="fi-image"></i></div>
                        <div>
                            <h2>Property images</h2>
                            <p>Update image paths — one per line. The first image becomes the cover.</p>
                        </div>
                    </div>
                    <div class="pf-image-area">
                        <div class="pf-image-hint">
                            <div class="pf-image-hint-icon"><i class="fi-camera"></i></div>
                            <div>
                                <h6>Image paths</h6>
                                <p>Enter one path per line, e.g. <code style="font-size: 0.72rem; color: var(--pf-sky);">assets/img/listings/real-estate/01.jpg</code></p>
                            </div>
                        </div>
                        <textarea class="form-control" rows="6" name="images" placeholder="assets/img/listings/real-estate/01.jpg">{{ old('images', $imagesText) }}</textarea>
                    </div>
                </div>

                <div class="pf-nav-bar">
                    <button type="button" class="pf-btn-secondary" data-prev="3">
                        <i class="fi-arrow-left fs-sm"></i> Pricing
                    </button>
                    <button type="submit" class="pf-btn-primary pf-btn-submit">
                        <i class="fi-check fs-sm"></i> Save changes
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const stepBtns = document.querySelectorAll('.pf-step-btn');
    const panels = document.querySelectorAll('.pf-panel');

    function goToStep(num) {
        stepBtns.forEach(btn => {
            const s = parseInt(btn.dataset.step);
            btn.classList.remove('active', 'completed');
            if (s === num) btn.classList.add('active');
            else if (s < num) btn.classList.add('completed');
        });
        panels.forEach(p => {
            p.classList.toggle('active', parseInt(p.dataset.panel) === num);
        });
        document.querySelector('.pf-steps').scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    stepBtns.forEach(btn => {
        btn.addEventListener('click', () => goToStep(parseInt(btn.dataset.step)));
    });
    document.querySelectorAll('[data-next]').forEach(btn => {
        btn.addEventListener('click', () => goToStep(parseInt(btn.dataset.next)));
    });
    document.querySelectorAll('[data-prev]').forEach(btn => {
        btn.addEventListener('click', () => goToStep(parseInt(btn.dataset.prev)));
    });

    @if ($errors->any())
        const errorFields = @json($errors->keys());
        const step1 = ['title','listing_type','property_type','bedrooms','bathrooms','garage_spaces','total_rooms','floor','year_built','area','description'];
        const step2 = ['address','city','region','postal_code','country','latitude','longitude','map_embed_url'];
        const step3 = ['price','price_period','deposit','amenities','pets_allowed'];

        if (errorFields.some(f => step2.includes(f))) goToStep(2);
        else if (errorFields.some(f => step3.includes(f))) goToStep(3);
        else if (errorFields.some(f => f === 'images')) goToStep(4);
    @endif
});
</script>
@endpush
