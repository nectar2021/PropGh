@extends('layouts.admin')

@section('title', 'Propsgh | Admin Dashboard')

@section('content')
{{-- ── Hero banner ── --}}
<div class="card border-0 shadow-sm admin-hero mb-4">
    <div class="card-body d-flex flex-wrap align-items-center justify-content-between gap-3 py-4">
        <div>
            <span class="admin-hero-badge mb-2 d-inline-flex align-items-center gap-2">
                <i class="fi-activity"></i>
                Admin overview
            </span>
            <h1 class="h3 mb-1">Welcome back, {{ auth()->user()->name ?? 'Admin' }}</h1>
            <p class="text-body-secondary mb-0">Track listings, inquiries, and performance at a glance.</p>
        </div>
        <a class="btn btn-outline-secondary btn-sm" href="{{ route('admin.properties.index') }}">Manage listings</a>
    </div>
    <div class="admin-hero-meta d-flex flex-wrap gap-2 px-4 pb-3 pt-2">
        <span class="admin-hero-chip">
            <i class="fi-calendar"></i>
            {{ now()->format('M d, Y') }}
        </span>
        <span class="admin-hero-chip">
            <i class="fi-plus-circle"></i>
            {{ $newThisWeek }} new listings this week
        </span>
        <span class="admin-hero-chip">
            <i class="fi-check-circle"></i>
            {{ $reviewProperties }} listings to review
        </span>
    </div>
</div>

{{-- ── Metric cards ── --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100 admin-metric-card" data-accent="primary">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="text-body-secondary fs-sm fw-medium">Active listings</span>
                    <span class="admin-metric-icon">
                        <i class="fi-grid fs-base"></i>
                    </span>
                </div>
                <div class="h3 mb-1">{{ $liveProperties }}</div>
                <div class="fs-xs text-success fw-medium">+{{ $newThisWeek }} this week</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100 admin-metric-card" data-accent="warning">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="text-body-secondary fs-sm fw-medium">New listings</span>
                    <span class="admin-metric-icon">
                        <i class="fi-trending-up fs-base"></i>
                    </span>
                </div>
                <div class="h3 mb-1">{{ $newThisWeek }}</div>
                <div class="fs-xs text-body-secondary">Last 7 days</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100 admin-metric-card" data-accent="info">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="text-body-secondary fs-sm fw-medium">Pending reviews</span>
                    <span class="admin-metric-icon">
                        <i class="fi-clock fs-base"></i>
                    </span>
                </div>
                <div class="h3 mb-1">{{ $reviewProperties }}</div>
                <div class="fs-xs text-body-secondary">{{ $draftProperties }} drafts saved</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100 admin-metric-card" data-accent="success">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="text-body-secondary fs-sm fw-medium">Average price</span>
                    <span class="admin-metric-icon">
                        <i class="fi-dollar-sign fs-base"></i>
                    </span>
                </div>
                <div class="h3 mb-1">${{ number_format($averagePrice) }}</div>
                <div class="fs-xs text-body-secondary">{{ $totalProperties }} listings total</div>
            </div>
        </div>
    </div>
</div>

{{-- ── Content row ── --}}
<div class="row g-4">
    {{-- Recent listings table --}}
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h2 class="h5 mb-0">Recent listings</h2>
                    <a class="fs-sm text-decoration-none fw-medium" href="{{ route('admin.properties.index') }}">
                        View all <i class="fi-chevron-right fs-xs ms-1"></i>
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th scope="col">Property</th>
                                <th scope="col">Owner</th>
                                <th scope="col">Status</th>
                                <th scope="col" class="text-end">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentProperties as $property)
                                @php
                                    $statusClasses = [
                                        'live' => 'text-bg-success',
                                        'review' => 'text-bg-warning',
                                        'draft' => 'text-bg-secondary',
                                    ];
                                    $coverImage = $property->cover_image?->path ?? 'assets/img/listings/real-estate/01.jpg';
                                @endphp
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <img src="{{ asset($coverImage) }}" class="rounded-3 flex-shrink-0" style="width: 44px; height: 34px; object-fit: cover;" alt="">
                                            <span class="fw-semibold">{{ \Illuminate\Support\Str::limit($property->title, 28) }}</span>
                                        </div>
                                    </td>
                                    <td class="text-body-secondary">{{ $property->owner?->name ?? 'Unassigned' }}</td>
                                    <td>
                                        <span class="badge {{ $statusClasses[$property->status] ?? 'text-bg-secondary' }}">
                                            {{ ucfirst($property->status) }}
                                        </span>
                                    </td>
                                    <td class="text-end text-body-secondary fs-sm">{{ $property->created_at?->format('M d') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-body-secondary py-4">No listings yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Performance highlights --}}
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h2 class="h5 mb-3">Performance highlights</h2>
                <div class="d-flex flex-column gap-3">
                    <div class="admin-soft-card d-flex align-items-start gap-3" data-accent="primary">
                        <span class="admin-soft-icon">
                            <i class="fi-trending-up fs-base"></i>
                        </span>
                        <div>
                            <div class="fw-semibold">{{ number_format($totalViews) }} total views</div>
                            <div class="fs-sm text-body-secondary">Demand across active listings.</div>
                        </div>
                    </div>
                    <div class="admin-soft-card d-flex align-items-start gap-3" data-accent="success">
                        <span class="admin-soft-icon">
                            <i class="fi-star fs-base"></i>
                        </span>
                        <div>
                            <div class="fw-semibold">{{ $featuredCount }} featured listings</div>
                            <div class="fs-sm text-body-secondary">Premium properties for top engagement.</div>
                        </div>
                    </div>
                    <div class="admin-soft-card d-flex align-items-start gap-3" data-accent="warning">
                        <span class="admin-soft-icon">
                            <i class="fi-edit-2 fs-base"></i>
                        </span>
                        <div>
                            <div class="fw-semibold">{{ $draftProperties }} drafts pending</div>
                            <div class="fs-sm text-body-secondary">Complete details to go live.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
