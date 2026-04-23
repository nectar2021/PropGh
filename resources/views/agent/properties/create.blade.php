@extends('layouts.app')

@section('title', 'Propsgh | Add Property')

@push('styles')
<style>
    .pw-shell {
        --pw-ink: #0f172a;
        --pw-slate: #334155;
        --pw-muted: #64748b;
        --pw-line: rgba(148, 163, 184, 0.22);
        --pw-surface: rgba(255, 255, 255, 0.92);
        --pw-surface-strong: #ffffff;
        --pw-teal: #0f766e;
        --pw-cyan: #0891b2;
        --pw-amber: #d97706;
        --pw-glow: rgba(8, 145, 178, 0.12);
        min-height: 100vh;
        padding: 6rem 0 4rem;
        background:
            radial-gradient(circle at top left, rgba(15, 118, 110, 0.08), transparent 36%),
            radial-gradient(circle at bottom right, rgba(8, 145, 178, 0.08), transparent 32%),
            linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
    }

    .pw-container {
        max-width: 1080px;
    }

    .pw-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1.5rem;
        margin-bottom: 1.75rem;
    }

    .pw-breadcrumb {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        margin-bottom: 0.95rem;
        font-size: 0.78rem;
        color: var(--pw-muted);
    }

    .pw-breadcrumb a {
        color: inherit;
        text-decoration: none;
    }

    .pw-breadcrumb a:hover {
        color: var(--pw-cyan);
    }

    .pw-header h1 {
        margin: 0 0 0.35rem;
        color: var(--pw-ink);
        font-size: clamp(1.7rem, 2.3vw, 2.4rem);
        font-weight: 700;
        letter-spacing: -0.04em;
    }

    .pw-header p {
        margin: 0;
        max-width: 42rem;
        color: var(--pw-muted);
        font-size: 0.96rem;
    }

    .pw-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.55rem;
        padding: 0.55rem 0.95rem;
        border-radius: 999px;
        border: 1px solid rgba(15, 118, 110, 0.16);
        background: linear-gradient(135deg, rgba(15, 118, 110, 0.1), rgba(8, 145, 178, 0.08));
        color: var(--pw-teal);
        font-size: 0.74rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .pw-badge-dot {
        width: 0.5rem;
        height: 0.5rem;
        border-radius: 50%;
        background: currentColor;
        animation: pwPulse 1.9s ease-in-out infinite;
    }

    .pw-alert {
        display: flex;
        align-items: flex-start;
        gap: 0.8rem;
        padding: 1rem 1.15rem;
        margin-bottom: 1.25rem;
        border-radius: 1rem;
        border: 1px solid rgba(148, 163, 184, 0.16);
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(12px);
    }

    .pw-alert i {
        margin-top: 0.15rem;
        font-size: 1rem;
    }

    .pw-alert-success {
        border-color: rgba(15, 118, 110, 0.16);
        color: var(--pw-teal);
    }

    .pw-alert-error {
        border-color: rgba(220, 38, 38, 0.18);
        background: rgba(254, 242, 242, 0.9);
        color: #b91c1c;
    }

    .pw-alert-error strong {
        display: block;
        margin-bottom: 0.3rem;
        font-size: 0.9rem;
    }

    .pw-alert-error ul {
        margin: 0;
        padding-left: 1.1rem;
        font-size: 0.84rem;
    }

    .pw-steps {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }

    .pw-step {
        display: flex;
        align-items: center;
        gap: 0.7rem;
        padding: 0.9rem 1rem;
        border: 1px solid var(--pw-line);
        border-radius: 1rem;
        background: var(--pw-surface);
        color: var(--pw-muted);
        cursor: pointer;
        transition: transform 0.25s ease, border-color 0.25s ease, box-shadow 0.25s ease, background 0.25s ease;
        backdrop-filter: blur(14px);
    }

    .pw-step:hover {
        transform: translateY(-1px);
        border-color: rgba(8, 145, 178, 0.2);
        box-shadow: 0 10px 24px rgba(15, 23, 42, 0.04);
    }

    .pw-step.is-active {
        border-color: rgba(8, 145, 178, 0.26);
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.98), rgba(240, 249, 255, 0.92));
        color: var(--pw-ink);
        box-shadow: 0 14px 34px rgba(8, 145, 178, 0.08);
    }

    .pw-step.is-complete .pw-step-index,
    .pw-step.is-active .pw-step-index {
        color: #fff;
        background: linear-gradient(135deg, var(--pw-teal), var(--pw-cyan));
    }

    .pw-step-index {
        width: 2rem;
        height: 2rem;
        flex-shrink: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: rgba(148, 163, 184, 0.14);
        font-size: 0.78rem;
        font-weight: 700;
        transition: inherit;
    }

    .pw-step span:last-child {
        display: block;
        font-size: 0.8rem;
        font-weight: 600;
        line-height: 1.2;
    }

    .pw-panel {
        display: none;
    }

    .pw-panel.is-active {
        display: block;
        animation: pwFadeIn 0.3s ease;
    }

    .pw-grid {
        display: grid;
        gap: 1.25rem;
    }

    .pw-card {
        position: relative;
        padding: 1.55rem;
        border: 1px solid var(--pw-line);
        border-radius: 1.35rem;
        background: var(--pw-surface);
        box-shadow: 0 16px 40px rgba(15, 23, 42, 0.05);
        backdrop-filter: blur(14px);
        overflow: hidden;
    }

    .pw-card::before {
        content: "";
        position: absolute;
        inset: 0 auto auto 0;
        width: 100%;
        height: 3px;
        background: linear-gradient(90deg, var(--pw-teal), var(--pw-cyan));
    }

    .pw-card-head {
        display: flex;
        align-items: flex-start;
        gap: 0.9rem;
        margin-bottom: 1.35rem;
    }

    .pw-card-icon {
        width: 2.6rem;
        height: 2.6rem;
        flex-shrink: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.95rem;
        background: linear-gradient(135deg, rgba(15, 118, 110, 0.1), rgba(8, 145, 178, 0.08));
        color: var(--pw-teal);
        font-size: 1rem;
    }

    .pw-card-head h2 {
        margin: 0 0 0.15rem;
        font-size: 1.04rem;
        font-weight: 700;
        color: var(--pw-ink);
        letter-spacing: -0.02em;
    }

    .pw-card-head p {
        margin: 0;
        color: var(--pw-muted);
        font-size: 0.82rem;
    }

    .pw-section-stack {
        display: grid;
        gap: 1rem;
    }

    .pw-helper {
        padding: 1rem 1.1rem;
        border: 1px solid rgba(15, 118, 110, 0.12);
        border-radius: 1rem;
        background: linear-gradient(135deg, rgba(15, 118, 110, 0.06), rgba(8, 145, 178, 0.05));
    }

    .pw-helper strong {
        display: block;
        margin-bottom: 0.2rem;
        font-size: 0.88rem;
        color: var(--pw-ink);
    }

    .pw-helper p {
        margin: 0;
        color: var(--pw-muted);
        font-size: 0.82rem;
    }

    .pw-shell .form-label {
        margin-bottom: 0.38rem;
        color: var(--pw-slate);
        font-size: 0.8rem;
        font-weight: 700;
        letter-spacing: 0.01em;
    }

    .pw-shell .form-control,
    .pw-shell .form-select,
    .pw-shell .form-control[type="file"] {
        min-height: 3rem;
        border: 1.5px solid rgba(148, 163, 184, 0.24);
        border-radius: 0.95rem;
        background: rgba(248, 250, 252, 0.84);
        color: var(--pw-ink);
        font-size: 0.9rem;
        padding: 0.78rem 0.95rem;
        transition: border-color 0.25s ease, box-shadow 0.25s ease, background 0.25s ease;
    }

    .pw-shell textarea.form-control {
        min-height: 9rem;
        resize: vertical;
    }

    .pw-shell .form-control:focus,
    .pw-shell .form-select:focus,
    .pw-shell .form-control[type="file"]:focus {
        border-color: rgba(8, 145, 178, 0.34);
        background: var(--pw-surface-strong);
        box-shadow: 0 0 0 0.3rem var(--pw-glow);
    }

    .pw-stat-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 0.85rem;
    }

    .pw-stat-card {
        padding: 0.95rem;
        border: 1px solid rgba(148, 163, 184, 0.18);
        border-radius: 1rem;
        background: linear-gradient(180deg, rgba(248, 250, 252, 0.96), rgba(255, 255, 255, 0.92));
    }

    .pw-stat-card i {
        display: inline-flex;
        margin-bottom: 0.45rem;
        color: var(--pw-cyan);
        font-size: 0.95rem;
    }

    .pw-stat-card label {
        display: block;
        margin-bottom: 0.35rem;
        color: var(--pw-muted);
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .pw-stat-card input {
        width: 100%;
        border: 0;
        background: transparent;
        padding: 0;
        color: var(--pw-ink);
        font-size: 1.05rem;
        font-weight: 700;
        outline: none;
    }

    .pw-dimension-card {
        display: grid;
        gap: 0.75rem;
        padding: 1rem;
        border: 1px solid rgba(148, 163, 184, 0.18);
        border-radius: 1rem;
        background: rgba(248, 250, 252, 0.86);
    }

    .pw-dimension-card small {
        color: var(--pw-muted);
        font-size: 0.78rem;
    }

    .pw-chip-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 0.65rem;
    }

    .pw-chip,
    .pw-pet {
        position: relative;
    }

    .pw-chip input,
    .pw-pet input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .pw-chip-label {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.68rem 0.95rem;
        border: 1.5px solid rgba(148, 163, 184, 0.24);
        border-radius: 999px;
        background: rgba(248, 250, 252, 0.92);
        color: var(--pw-slate);
        font-size: 0.83rem;
        font-weight: 600;
        cursor: pointer;
        transition: border-color 0.22s ease, background 0.22s ease, color 0.22s ease, transform 0.22s ease;
    }

    .pw-chip-label i {
        color: var(--pw-cyan);
        font-size: 0.86rem;
    }

    .pw-chip input:checked + .pw-chip-label {
        border-color: rgba(15, 118, 110, 0.32);
        background: linear-gradient(135deg, rgba(15, 118, 110, 0.12), rgba(8, 145, 178, 0.08));
        color: var(--pw-teal);
        transform: translateY(-1px);
    }

    .pw-pet-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 0.8rem;
    }

    .pw-pet-label {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.35rem;
        min-width: 7rem;
        padding: 0.95rem 1rem;
        border: 1.5px solid rgba(148, 163, 184, 0.24);
        border-radius: 1rem;
        background: rgba(248, 250, 252, 0.92);
        cursor: pointer;
        transition: border-color 0.22s ease, background 0.22s ease, color 0.22s ease, transform 0.22s ease;
    }

    .pw-pet-icon {
        font-size: 1.35rem;
        line-height: 1;
    }

    .pw-pet-label span:last-child {
        color: var(--pw-slate);
        font-size: 0.8rem;
        font-weight: 600;
    }

    .pw-pet input:checked + .pw-pet-label {
        border-color: rgba(217, 119, 6, 0.25);
        background: linear-gradient(135deg, rgba(251, 191, 36, 0.14), rgba(245, 158, 11, 0.08));
        transform: translateY(-1px);
    }

    .pw-upload {
        display: grid;
        gap: 1rem;
        padding: 1.1rem;
        border: 1.5px dashed rgba(8, 145, 178, 0.24);
        border-radius: 1.2rem;
        background: linear-gradient(135deg, rgba(240, 249, 255, 0.88), rgba(255, 255, 255, 0.94));
    }

    .pw-upload-meta {
        display: flex;
        align-items: center;
        gap: 0.9rem;
    }

    .pw-upload-icon {
        width: 3rem;
        height: 3rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 1rem;
        background: linear-gradient(135deg, rgba(15, 118, 110, 0.12), rgba(8, 145, 178, 0.1));
        color: var(--pw-cyan);
        font-size: 1.15rem;
    }

    .pw-upload-meta strong {
        display: block;
        margin-bottom: 0.2rem;
        color: var(--pw-ink);
        font-size: 0.92rem;
    }

    .pw-upload-meta p {
        margin: 0;
        color: var(--pw-muted);
        font-size: 0.8rem;
    }

    .pw-media-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 0.85rem;
    }

    .pw-media-card {
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(148, 163, 184, 0.16);
        border-radius: 1rem;
        background: rgba(255, 255, 255, 0.94);
    }

    .pw-media-preview {
        aspect-ratio: 1 / 0.78;
        background-size: cover;
        background-position: center;
        background-color: #e2e8f0;
    }

    .pw-media-body {
        display: grid;
        gap: 0.2rem;
        padding: 0.75rem;
    }

    .pw-media-body strong {
        color: var(--pw-ink);
        font-size: 0.78rem;
        font-weight: 700;
        line-height: 1.3;
        word-break: break-word;
    }

    .pw-media-body small {
        color: var(--pw-muted);
        font-size: 0.72rem;
    }

    .pw-cover-badge {
        position: absolute;
        top: 0.7rem;
        left: 0.7rem;
        padding: 0.35rem 0.5rem;
        border-radius: 999px;
        background: rgba(15, 23, 42, 0.82);
        color: #fff;
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
    }

    .pw-nav {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        margin-top: 0.35rem;
    }

    .pw-btn-secondary,
    .pw-btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        min-height: 3rem;
        padding: 0.78rem 1.35rem;
        border-radius: 999px;
        font-size: 0.85rem;
        font-weight: 700;
        text-decoration: none;
        transition: transform 0.22s ease, box-shadow 0.22s ease, border-color 0.22s ease, background 0.22s ease;
    }

    .pw-btn-secondary {
        border: 1px solid rgba(148, 163, 184, 0.24);
        background: rgba(255, 255, 255, 0.9);
        color: var(--pw-slate);
    }

    .pw-btn-primary {
        border: 0;
        background: linear-gradient(135deg, var(--pw-ink), #1e293b);
        color: #fff;
        box-shadow: 0 14px 34px rgba(15, 23, 42, 0.14);
    }

    .pw-btn-primary[data-submit],
    .pw-btn-primary.pw-submit {
        background: linear-gradient(135deg, var(--pw-teal), var(--pw-cyan));
        box-shadow: 0 14px 34px rgba(8, 145, 178, 0.18);
    }

    .pw-btn-secondary:hover,
    .pw-btn-primary:hover {
        transform: translateY(-1px);
    }

    [data-conditional-section][hidden] {
        display: none !important;
    }

    .pw-field-note {
        margin-top: 0.35rem;
        color: var(--pw-muted);
        font-size: 0.75rem;
    }

    @keyframes pwPulse {
        0%, 100% {
            opacity: 1;
            transform: scale(1);
        }

        50% {
            opacity: 0.45;
            transform: scale(0.9);
        }
    }

    @keyframes pwFadeIn {
        from {
            opacity: 0;
            transform: translateY(8px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 991.98px) {
        .pw-steps {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .pw-stat-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 767.98px) {
        .pw-shell {
            padding-top: 5rem;
        }

        .pw-header {
            flex-direction: column;
        }

        .pw-card {
            padding: 1.2rem;
        }

        .pw-steps {
            grid-template-columns: 1fr;
        }

        .pw-nav {
            flex-direction: column-reverse;
            align-items: stretch;
        }

        .pw-btn-secondary,
        .pw-btn-primary {
            justify-content: center;
            width: 100%;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .pw-badge-dot,
        .pw-panel.is-active {
            animation: none;
        }
    }
</style>
@endpush

@section('content')
    @php
        $selectedAmenities = old('amenities', $property->amenities ?? []);
        $selectedPets = old('pets_allowed', $property->pets_allowed ?? []);
        $currentListingType = \Illuminate\Support\Str::lower((string) old('listing_type', $property->listing_type));
        $currentPropertyType = \Illuminate\Support\Str::lower((string) old('property_type', $property->property_type ?: 'house'));
        $currentCurrency = strtoupper((string) old('currency', $property->currency ?: \App\Models\Property::defaultCurrency()));
        $currentPropertyType = str_replace('_', '-', $currentPropertyType);
        $currentPropertyGroup = $propertyTypeGroupMap[$currentPropertyType] ?? 'residential';
    @endphp

    <div class="pw-shell">
        <div class="container pw-container">
            <div class="pw-header">
                <div>
                    <div class="pw-breadcrumb">
                        <a href="{{ route('agent.properties.index') }}">My Properties</a>
                        <i class="fi-chevron-right fs-xs"></i>
                        <span>New listing</span>
                    </div>
                    <h1>Add a new property listing</h1>
                    <p>
                        Create a polished listing with type-aware fields, structured amenities, and real media uploads.
                        Residential, land, and commercial properties now follow different rules automatically.
                    </p>
                </div>
                <div class="pw-badge">
                    <span class="pw-badge-dot"></span>
                    Review Required
                </div>
            </div>

            @if (session('status'))
                <div class="pw-alert pw-alert-success">
                    <i class="fi-check-circle"></i>
                    <div>{{ session('status') }}</div>
                </div>
            @endif

            @if ($errors->any())
                <div class="pw-alert pw-alert-error">
                    <i class="fi-alert-circle"></i>
                    <div>
                        <strong>Please fix the following before submitting.</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <div class="pw-steps" id="wizardSteps">
                <button type="button" class="pw-step is-active" data-step="1">
                    <span class="pw-step-index">1</span>
                    <span>Core Details</span>
                </button>
                <button type="button" class="pw-step" data-step="2">
                    <span class="pw-step-index">2</span>
                    <span>Type-Specific Details</span>
                </button>
                <button type="button" class="pw-step" data-step="3">
                    <span class="pw-step-index">3</span>
                    <span>Location</span>
                </button>
                <button type="button" class="pw-step" data-step="4">
                    <span class="pw-step-index">4</span>
                    <span>Pricing &amp; Amenities</span>
                </button>
                <button type="button" class="pw-step" data-step="5">
                    <span class="pw-step-index">5</span>
                    <span>Media</span>
                </button>
            </div>

            <form
                id="propertyWizard"
                method="POST"
                action="{{ route('agent.properties.store') }}"
                enctype="multipart/form-data"
            >
                @csrf

                <section class="pw-panel is-active" data-panel="1">
                    <div class="pw-grid">
                        <div class="pw-card">
                            <div class="pw-card-head">
                                <div class="pw-card-icon"><i class="fi-home"></i></div>
                                <div>
                                    <h2>Listing foundation</h2>
                                    <p>Choose the listing and property type first. The rest of the wizard adapts from here.</p>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="listing_type">Listing type</label>
                                    <select class="form-select" id="listing_type" name="listing_type" required>
                                        @foreach ($listingTypes as $value => $label)
                                            <option value="{{ $value }}" @selected($currentListingType === $value)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    <div class="pw-field-note">Shortlet is handled as a listing type, not a property type.</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="property_type">Property type</label>
                                    <select class="form-select" id="property_type" name="property_type" required>
                                        @foreach ($propertyTypes as $value => $label)
                                            <option value="{{ $value }}" @selected($currentPropertyType === $value)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    <div class="pw-field-note" id="propertyTypeHint">
                                        Residential properties show room details. Land and commercial listings stay leaner.
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label" for="title">Property title</label>
                                    <input
                                        class="form-control"
                                        id="title"
                                        name="title"
                                        type="text"
                                        value="{{ old('title', $property->title) }}"
                                        placeholder="Modern 3-bedroom townhouse in East Legon"
                                        required
                                    >
                                </div>
                                <div class="col-12">
                                    <label class="form-label" for="description">Description</label>
                                    <textarea
                                        class="form-control"
                                        id="description"
                                        name="description"
                                        placeholder="Highlight the condition, standout features, nearby landmarks, buyer or tenant fit, and what makes this listing worth booking a viewing."
                                        required
                                    >{{ old('description', $property->description) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pw-nav">
                        <a class="pw-btn-secondary" href="{{ route('agent.properties.index') }}">
                            <i class="fi-arrow-left"></i>
                            Cancel
                        </a>
                        <button type="button" class="pw-btn-primary" data-next="2">
                            Type-Specific Details
                            <i class="fi-arrow-right"></i>
                        </button>
                    </div>
                </section>

                <section class="pw-panel" data-panel="2">
                    <div class="pw-grid">
                        <div class="pw-card">
                            <div class="pw-card-head">
                                <div class="pw-card-icon"><i class="fi-grid"></i></div>
                                <div>
                                    <h2>Type-aware property details</h2>
                                    <p>Land skips room-style inputs, residential captures living details, and commercial stays business-focused.</p>
                                </div>
                            </div>

                            <div class="pw-section-stack">
                                <div class="pw-dimension-card">
                                    <div>
                                        <label class="form-label" for="area" id="areaLabel">Property size (sq.m)</label>
                                        <input
                                            class="form-control"
                                            id="area"
                                            name="area"
                                            type="number"
                                            min="0"
                                            step="0.01"
                                            value="{{ old('area', $property->area) }}"
                                            placeholder="650"
                                            required
                                        >
                                    </div>
                                    <small id="areaHelp">Use the total internal or usable size for the listing.</small>
                                </div>

                                <div
                                    class="pw-helper"
                                    data-conditional-section
                                    data-property-groups="land"
                                >
                                    <strong>Land listing mode</strong>
                                    <p>Room-related fields are intentionally removed. Focus on plot size, title status, access, servicing, and accurate location data.</p>
                                </div>

                                <div
                                    class="pw-section-stack"
                                    data-conditional-section
                                    data-property-groups="residential"
                                >
                                    <div class="pw-helper">
                                        <strong>Residential listing mode</strong>
                                        <p>Capture the room count and practical living details buyers or renters care about first.</p>
                                    </div>

                                    <div class="pw-stat-grid">
                                        <div class="pw-stat-card">
                                            <i class="fi-bed-single"></i>
                                            <label for="bedrooms">Bedrooms</label>
                                            <input id="bedrooms" name="bedrooms" type="number" min="0" value="{{ old('bedrooms', $property->bedrooms) }}">
                                        </div>
                                        <div class="pw-stat-card">
                                            <i class="fi-shower"></i>
                                            <label for="bathrooms">Bathrooms</label>
                                            <input id="bathrooms" name="bathrooms" type="number" min="0" value="{{ old('bathrooms', $property->bathrooms) }}">
                                        </div>
                                        <div class="pw-stat-card">
                                            <i class="fi-car"></i>
                                            <label for="garage_spaces">Parking</label>
                                            <input id="garage_spaces" name="garage_spaces" type="number" min="0" value="{{ old('garage_spaces', $property->garage_spaces) }}">
                                        </div>
                                        <div class="pw-stat-card">
                                            <i class="fi-layers"></i>
                                            <label for="total_rooms">Total rooms</label>
                                            <input id="total_rooms" name="total_rooms" type="number" min="0" value="{{ old('total_rooms', $property->total_rooms) }}">
                                        </div>
                                    </div>
                                </div>

                                <div
                                    class="row g-3"
                                    data-conditional-section
                                    data-property-groups="residential,commercial"
                                >
                                    <div class="col-md-6">
                                        <label class="form-label" for="floor">Floor</label>
                                        <input
                                            class="form-control"
                                            id="floor"
                                            name="floor"
                                            type="number"
                                            min="0"
                                            value="{{ old('floor', $property->floor) }}"
                                            placeholder="3"
                                        >
                                        <div class="pw-field-note">Leave blank if the property is on ground level or the floor is not relevant.</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="year_built">Year built</label>
                                        <input
                                            class="form-control"
                                            id="year_built"
                                            name="year_built"
                                            type="number"
                                            min="1800"
                                            value="{{ old('year_built', $property->year_built) }}"
                                            placeholder="2021"
                                        >
                                        <div class="pw-field-note">Useful for both premium homes and business-ready commercial inventory.</div>
                                    </div>
                                </div>

                                <div
                                    class="pw-helper"
                                    data-conditional-section
                                    data-property-groups="commercial"
                                >
                                    <strong>Commercial listing mode</strong>
                                    <p>Bedrooms and pet settings are removed. Focus on usable area, parking, floor access, and commercial infrastructure.</p>
                                </div>

                                <div
                                    class="row g-3"
                                    data-conditional-section
                                    data-property-groups="commercial"
                                >
                                    <div class="col-md-6">
                                        <label class="form-label" for="commercial_garage_spaces">Parking / garage spaces</label>
                                        <input
                                            class="form-control"
                                            id="commercial_garage_spaces"
                                            name="garage_spaces"
                                            type="number"
                                            min="0"
                                            value="{{ old('garage_spaces', $property->garage_spaces) }}"
                                            placeholder="12"
                                        >
                                        <div class="pw-field-note">Use this for parking bays, dedicated slots, or loading-adjacent vehicle space.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pw-nav">
                        <button type="button" class="pw-btn-secondary" data-prev="1">
                            <i class="fi-arrow-left"></i>
                            Core Details
                        </button>
                        <button type="button" class="pw-btn-primary" data-next="3">
                            Location
                            <i class="fi-arrow-right"></i>
                        </button>
                    </div>
                </section>

                <section class="pw-panel" data-panel="3">
                    <div class="pw-grid">
                        <div class="pw-card">
                            <div class="pw-card-head">
                                <div class="pw-card-icon"><i class="fi-map-pin"></i></div>
                                <div>
                                    <h2>Address and location</h2>
                                    <p>Use a precise location so the listing displays properly in search, detail pages, and maps.</p>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label" for="address">Street address</label>
                                    <input
                                        class="form-control"
                                        id="address"
                                        name="address"
                                        type="text"
                                        value="{{ old('address', $property->address) }}"
                                        placeholder="No. 12 Liberation Road"
                                        required
                                    >
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="city">City</label>
                                    <input class="form-control" id="city" name="city" type="text" value="{{ old('city', $property->city) }}" placeholder="Accra" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="region">Region / State</label>
                                    <input class="form-control" id="region" name="region" type="text" value="{{ old('region', $property->region) }}" placeholder="Greater Accra" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="postal_code">Postal code</label>
                                    <input class="form-control" id="postal_code" name="postal_code" type="text" value="{{ old('postal_code', $property->postal_code) }}" placeholder="GA-123-4567">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="country">Country</label>
                                    <input class="form-control" id="country" name="country" type="text" value="{{ old('country', $property->country ?: 'Ghana') }}" placeholder="Ghana" required>
                                </div>
                            </div>
                        </div>

                        <div class="pw-card">
                            <div class="pw-card-head">
                                <div class="pw-card-icon"><i class="fi-map"></i></div>
                                <div>
                                    <h2>Coordinates and embed map</h2>
                                    <p>Coordinates are optional, but if you add one, add both. They improve map previews and listing accuracy.</p>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="latitude">Latitude</label>
                                    <input class="form-control" id="latitude" name="latitude" type="number" step="0.000001" value="{{ old('latitude', $property->latitude) }}" placeholder="5.603717">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="longitude">Longitude</label>
                                    <input class="form-control" id="longitude" name="longitude" type="number" step="0.000001" value="{{ old('longitude', $property->longitude) }}" placeholder="-0.186964">
                                </div>
                                <div class="col-12">
                                    <label class="form-label" for="map_embed_url">Map embed URL</label>
                                    <input
                                        class="form-control"
                                        id="map_embed_url"
                                        name="map_embed_url"
                                        type="url"
                                        value="{{ old('map_embed_url', $property->map_embed_url) }}"
                                        placeholder="https://www.google.com/maps/embed?..."
                                    >
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pw-nav">
                        <button type="button" class="pw-btn-secondary" data-prev="2">
                            <i class="fi-arrow-left"></i>
                            Type-Specific Details
                        </button>
                        <button type="button" class="pw-btn-primary" data-next="4">
                            Pricing &amp; Amenities
                            <i class="fi-arrow-right"></i>
                        </button>
                    </div>
                </section>

                <section class="pw-panel" data-panel="4">
                    <div class="pw-grid">
                        <div class="pw-card">
                            <div class="pw-card-head">
                                <div class="pw-card-icon"><i class="fi-dollar-sign"></i></div>
                                <div>
                                    <h2>Pricing setup</h2>
                                    <p>Capture the headline price, billing period, and any deposit expectations before publishing.</p>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label" for="price">Price</label>
                                    <input class="form-control" id="price" name="price" type="number" min="0" value="{{ old('price', $property->price) }}" placeholder="150000" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="currency">Currency</label>
                                    <select class="form-select" id="currency" name="currency" required>
                                        @foreach ($currencyOptions as $value => $currency)
                                            <option value="{{ $value }}" @selected($currentCurrency === $value)>{{ $value }} — {{ $currency['label'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="price_period">Price period</label>
                                    <select class="form-select" id="price_period" name="price_period" required>
                                        @foreach ($pricePeriods as $value => $label)
                                            <option value="{{ $value }}" @selected(old('price_period', $property->price_period) === $value)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="deposit">Deposit</label>
                                    <input class="form-control" id="deposit" name="deposit" type="number" min="0" value="{{ old('deposit', $property->deposit) }}" placeholder="0">
                                    <div class="pw-field-note">Optional. Leave blank if no deposit is required.</div>
                                </div>
                            </div>
                        </div>

                        <div class="pw-card">
                            <div class="pw-card-head">
                                <div class="pw-card-icon"><i class="fi-star"></i></div>
                                <div>
                                    <h2>Type-specific amenities</h2>
                                    <p>Only relevant amenity options are enabled and submitted for the chosen property type.</p>
                                </div>
                            </div>

                            <div class="pw-section-stack">
                                @foreach ($amenityOptionSets as $scope => $set)
                                    <div
                                        class="pw-section-stack"
                                        data-conditional-section
                                        data-property-types="{{ implode(',', $set['property_types']) }}"
                                    >
                                        <div class="pw-helper">
                                            <strong>{{ $set['title'] }}</strong>
                                            <p>{{ $set['description'] }}</p>
                                        </div>

                                        <div class="pw-chip-grid">
                                            @foreach ($set['options'] as $optionKey => $optionLabel)
                                                <div class="pw-chip">
                                                    <input
                                                        id="amenity-{{ $scope }}-{{ $optionKey }}"
                                                        name="amenities[]"
                                                        type="checkbox"
                                                        value="{{ $optionLabel }}"
                                                        @checked(in_array($optionLabel, $selectedAmenities, true))
                                                    >
                                                    <label class="pw-chip-label" for="amenity-{{ $scope }}-{{ $optionKey }}">
                                                        <i class="{{ $amenityIcons[$optionKey] ?? 'fi-check-circle' }}"></i>
                                                        {{ $optionLabel }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div
                            class="pw-card"
                            data-conditional-section
                            data-property-groups="residential"
                        >
                            <div class="pw-card-head">
                                <div class="pw-card-icon"><i class="fi-heart"></i></div>
                                <div>
                                    <h2>Pet policy</h2>
                                    <p>Residential listings can show which pets are welcome. This section is hidden for land and commercial inventory.</p>
                                </div>
                            </div>

                            <div class="pw-pet-grid">
                                @foreach ($petChoices as $petKey => $petLabel)
                                    <div class="pw-pet">
                                        <input
                                            id="pet-{{ $petKey }}"
                                            name="pets_allowed[]"
                                            type="checkbox"
                                            value="{{ $petLabel }}"
                                            @checked(in_array($petLabel, $selectedPets, true))
                                        >
                                        <label class="pw-pet-label" for="pet-{{ $petKey }}">
                                            <span class="pw-pet-icon">{{ $petEmojis[$petKey] ?? '🐾' }}</span>
                                            <span>{{ $petLabel }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="pw-nav">
                        <button type="button" class="pw-btn-secondary" data-prev="3">
                            <i class="fi-arrow-left"></i>
                            Location
                        </button>
                        <button type="button" class="pw-btn-primary" data-next="5">
                            Media
                            <i class="fi-arrow-right"></i>
                        </button>
                    </div>
                </section>

                <section class="pw-panel" data-panel="5">
                    <div class="pw-grid">
                        <div class="pw-card">
                            <div class="pw-card-head">
                                <div class="pw-card-icon"><i class="fi-image"></i></div>
                                <div>
                                    <h2>Upload property media</h2>
                                    <p>Upload real image files. The first image becomes the cover image across the platform.</p>
                                </div>
                            </div>

                            <div class="pw-upload">
                                <div class="pw-upload-meta">
                                    <div class="pw-upload-icon"><i class="fi-camera"></i></div>
                                    <div>
                                        <strong>Multiple image upload</strong>
                                        <p>Accepted formats: JPG, PNG, WEBP, GIF. Upload up to 10 images, 8MB each.</p>
                                    </div>
                                </div>

                                <div>
                                    <label class="form-label" for="images">Property images</label>
                                    <input class="form-control" id="images" name="images[]" type="file" multiple accept="image/*" required>
                                    <div class="pw-field-note">The first selected image is treated as the cover image after upload.</div>
                                </div>

                                <div class="pw-media-grid" id="imagePreviewGrid">
                                    <div class="pw-helper" id="imagePreviewEmpty">
                                        <strong>No files selected yet</strong>
                                        <p>Select one or more images to preview the upload order before submission.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pw-nav">
                        <button type="button" class="pw-btn-secondary" data-prev="4">
                            <i class="fi-arrow-left"></i>
                            Pricing &amp; Amenities
                        </button>
                        <button type="submit" class="pw-btn-primary pw-submit" data-submit>
                            <i class="fi-check"></i>
                            Submit for Review
                        </button>
                    </div>
                </section>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const wizard = document.getElementById('propertyWizard');
        const stepButtons = Array.from(document.querySelectorAll('.pw-step'));
        const panels = Array.from(document.querySelectorAll('.pw-panel'));
        const propertyTypeSelect = document.getElementById('property_type');
        const propertyTypeHint = document.getElementById('propertyTypeHint');
        const areaLabel = document.getElementById('areaLabel');
        const areaHelp = document.getElementById('areaHelp');
        const conditionalSections = Array.from(document.querySelectorAll('[data-conditional-section]'));
        const imageInput = document.getElementById('images');
        const imagePreviewGrid = document.getElementById('imagePreviewGrid');

        const propertyTypeGroupMap = @json($propertyTypeGroupMap);
        const fieldStepMap = {
            1: ['listing_type', 'property_type', 'title', 'description'],
            2: ['area', 'bedrooms', 'bathrooms', 'garage_spaces', 'total_rooms', 'floor', 'year_built'],
            3: ['address', 'city', 'region', 'postal_code', 'country', 'latitude', 'longitude', 'map_embed_url'],
            4: ['price', 'currency', 'price_period', 'deposit', 'amenities', 'pets_allowed'],
            5: ['images'],
        };

        let activeStep = 1;
        let previewUrls = [];

        const getPropertyType = () => (propertyTypeSelect?.value || 'house').toLowerCase().replaceAll('_', '-');
        const getPropertyGroup = () => propertyTypeGroupMap[getPropertyType()] || 'residential';

        const setStep = (step) => {
            activeStep = step;

            stepButtons.forEach((button) => {
                const buttonStep = Number(button.dataset.step);
                button.classList.toggle('is-active', buttonStep === step);
                button.classList.toggle('is-complete', buttonStep < step);
            });

            panels.forEach((panel) => {
                panel.classList.toggle('is-active', Number(panel.dataset.panel) === step);
            });

            document.getElementById('wizardSteps')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
        };

        const matchesSection = (section, propertyType, propertyGroup) => {
            const allowedGroups = (section.dataset.propertyGroups || '')
                .split(',')
                .map((value) => value.trim())
                .filter(Boolean);
            const allowedTypes = (section.dataset.propertyTypes || '')
                .split(',')
                .map((value) => value.trim())
                .filter(Boolean);

            if (allowedGroups.length > 0 && allowedGroups.includes(propertyGroup)) {
                return true;
            }

            if (allowedTypes.length > 0 && allowedTypes.includes(propertyType)) {
                return true;
            }

            return allowedGroups.length === 0 && allowedTypes.length === 0;
        };

        const toggleSectionInputs = (section, enabled) => {
            section.querySelectorAll('input, select, textarea, button').forEach((field) => {
                if (field === propertyTypeSelect || field.type === 'submit' || field.dataset.nav !== undefined) {
                    return;
                }

                field.disabled = !enabled;

                if (!enabled && (field.type === 'checkbox' || field.type === 'radio')) {
                    field.checked = false;
                }
            });
        };

        const refreshConditionalSections = () => {
            const propertyType = getPropertyType();
            const propertyGroup = getPropertyGroup();

            conditionalSections.forEach((section) => {
                const isVisible = matchesSection(section, propertyType, propertyGroup);
                section.hidden = !isVisible;
                section.setAttribute('aria-hidden', String(!isVisible));
                toggleSectionInputs(section, isVisible);
            });

            if (propertyGroup === 'land') {
                areaLabel.textContent = 'Plot size (sq.m)';
                areaHelp.textContent = 'Use the total plot or parcel size for the land listing.';
                propertyTypeHint.textContent = 'Land listings stay focused on plot size, title quality, access, and map accuracy.';
            } else if (propertyGroup === 'commercial') {
                areaLabel.textContent = 'Usable area (sq.m)';
                areaHelp.textContent = 'Use lettable or operational area for the commercial unit.';
                propertyTypeHint.textContent = 'Commercial listings show business-relevant fields and remove residential-only inputs.';
            } else {
                areaLabel.textContent = 'Property size (sq.m)';
                areaHelp.textContent = 'Use the total internal or usable size for the listing.';
                propertyTypeHint.textContent = 'Residential listings show room counts, pets, and home-oriented amenities.';
            }
        };

        const clearPreviewUrls = () => {
            previewUrls.forEach((url) => URL.revokeObjectURL(url));
            previewUrls = [];
        };

        const renderImagePreview = () => {
            clearPreviewUrls();

            const files = Array.from(imageInput?.files || []);
            imagePreviewGrid.innerHTML = '';

            if (files.length === 0) {
                imagePreviewGrid.innerHTML = `
                    <div class="pw-helper" id="imagePreviewEmpty">
                        <strong>No files selected yet</strong>
                        <p>Select one or more images to preview the upload order before submission.</p>
                    </div>
                `;

                return;
            }

            files.forEach((file, index) => {
                const previewUrl = URL.createObjectURL(file);
                previewUrls.push(previewUrl);

                const card = document.createElement('div');
                card.className = 'pw-media-card';
                card.innerHTML = `
                    ${index === 0 ? '<span class="pw-cover-badge">Cover</span>' : ''}
                    <div class="pw-media-preview" style="background-image: url('${previewUrl}')"></div>
                    <div class="pw-media-body">
                        <strong>${file.name}</strong>
                        <small>${(file.size / 1024 / 1024).toFixed(2)} MB</small>
                    </div>
                `;

                imagePreviewGrid.appendChild(card);
            });
        };

        const resolveStepFromErrors = () => {
            const errorKeys = @json($errors->keys());

            if (errorKeys.length === 0) {
                return 1;
            }

            for (const [step, fields] of Object.entries(fieldStepMap)) {
                const matchesStep = errorKeys.some((errorKey) => fields.some((field) => errorKey === field || errorKey.startsWith(`${field}.`)));

                if (matchesStep) {
                    return Number(step);
                }
            }

            return 1;
        };

        propertyTypeSelect?.addEventListener('change', refreshConditionalSections);
        imageInput?.addEventListener('change', renderImagePreview);

        stepButtons.forEach((button) => {
            button.addEventListener('click', () => {
                setStep(Number(button.dataset.step));
            });
        });

        wizard?.querySelectorAll('[data-next]').forEach((button) => {
            button.addEventListener('click', () => {
                setStep(Number(button.dataset.next));
            });
        });

        wizard?.querySelectorAll('[data-prev]').forEach((button) => {
            button.addEventListener('click', () => {
                setStep(Number(button.dataset.prev));
            });
        });

        refreshConditionalSections();
        renderImagePreview();
        setStep(resolveStepFromErrors());
    });
</script>
@endpush
