@extends('layouts.admin')

@section('title', 'Propsgh | Admin Dashboard')

@section('content')
<div class="card border-0 shadow-sm admin-hero mb-4">
    <div class="card-body d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div>
            <span class="admin-hero-badge mb-2 d-inline-flex align-items-center gap-2">
                <i class="fi-activity"></i>
                Admin overview
            </span>
            <h1 class="h3 mb-1">Welcome back, {{ auth()->user()->name ?? 'Admin' }}</h1>
            <p class="text-body-secondary mb-0">Track listings, inquiries, and performance at a glance.</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a class="btn btn-primary btn-sm" href="{{ route('admin.properties.create') }}">
                <i class="fi-plus fs-sm me-1"></i>
                Add property
            </a>
            <a class="btn btn-outline-secondary btn-sm" href="{{ route('admin.properties.index') }}">Manage listings</a>
            <button type="button" class="btn btn-outline-secondary btn-sm">
                <i class="fi-bar-chart-2 fs-sm me-1"></i>
                View reports
            </button>
        </div>
    </div>
    <div class="admin-hero-meta d-flex flex-wrap gap-2 px-4 pb-3">
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

<div class="row g-3 g-lg-4 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100 admin-metric-card" data-accent="primary">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="text-body-secondary fs-sm">Active listings</span>
                    <span class="admin-metric-icon">
                        <i class="fi-grid fs-base"></i>
                    </span>
                </div>
                <div class="h3 mb-1">{{ $liveProperties }}</div>
                <div class="fs-xs text-success">+{{ $newThisWeek }} this week</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100 admin-metric-card" data-accent="warning">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="text-body-secondary fs-sm">New listings</span>
                    <span class="admin-metric-icon">
                        <i class="fi-message-circle fs-base"></i>
                    </span>
                </div>
                <div class="h3 mb-1">{{ $newThisWeek }}</div>
                <div class="fs-xs text-body-secondary">Last 7 days</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100 admin-metric-card" data-accent="info">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="text-body-secondary fs-sm">Pending reviews</span>
                    <span class="admin-metric-icon">
                        <i class="fi-star fs-base"></i>
                    </span>
                </div>
                <div class="h3 mb-1">{{ $reviewProperties }}</div>
                <div class="fs-xs text-body-secondary">{{ $draftProperties }} drafts saved</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100 admin-metric-card" data-accent="success">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="text-body-secondary fs-sm">Average price</span>
                    <span class="admin-metric-icon">
                        <i class="fi-clock fs-base"></i>
                    </span>
                </div>
                <div class="h3 mb-1">${{ number_format($averagePrice) }}</div>
                <div class="fs-xs text-body-secondary">{{ $totalProperties }} listings total</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h2 class="h5 mb-0">Recent listings</h2>
                    <a class="fs-sm text-decoration-none" href="{{ route('admin.properties.index') }}">View all</a>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
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
                                @endphp
                                <tr>
                                    <td>{{ $property->title }}</td>
                                    <td>{{ $property->owner?->name ?? 'Unassigned' }}</td>
                                    <td>
                                        <span class="badge {{ $statusClasses[$property->status] ?? 'text-bg-secondary' }}">
                                            {{ ucfirst($property->status) }}
                                        </span>
                                    </td>
                                    <td class="text-end text-body-secondary fs-sm">{{ $property->created_at?->format('M d, Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-body-secondary">No listings yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h2 class="h5 mb-3">Performance highlights</h2>
                <div class="admin-soft-card d-flex align-items-start gap-3 mb-3" data-accent="primary">
                    <span class="admin-soft-icon">
                        <i class="fi-trending-up fs-base"></i>
                    </span>
                    <div>
                        <div class="fw-semibold">{{ number_format($totalViews) }} total listing views</div>
                        <div class="fs-sm text-body-secondary">Measure demand across all active listings.</div>
                    </div>
                </div>
                <div class="admin-soft-card d-flex align-items-start gap-3 mb-3" data-accent="success">
                    <span class="admin-soft-icon">
                        <i class="fi-check-circle fs-base"></i>
                    </span>
                    <div>
                        <div class="fw-semibold">{{ $featuredCount }} featured listings</div>
                        <div class="fs-sm text-body-secondary">Highlight premium properties to boost engagement.</div>
                    </div>
                </div>
                <div class="admin-soft-card d-flex align-items-start gap-3" data-accent="warning">
                    <span class="admin-soft-icon">
                        <i class="fi-award fs-base"></i>
                    </span>
                    <div>
                        <div class="fw-semibold">{{ $draftProperties }} listings in draft</div>
                        <div class="fs-sm text-body-secondary">Finish details before publishing.</div>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="button" class="btn btn-outline-secondary w-100">View weekly report</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
