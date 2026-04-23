@extends('layouts.app')

@section('title', 'Propsgh | My Properties')

@section('content')
<div class="container py-5">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">My Properties</h1>
            <p class="text-body-secondary mb-0">Manage your property listings.</p>
        </div>
        <a class="btn btn-primary d-inline-flex align-items-center gap-2" href="{{ route('agent.properties.create') }}">
            <i class="fi-plus"></i> Add property
        </a>
    </div>

    @if (session('status'))
        <div class="alert alert-success d-flex align-items-center gap-2 mb-4">
            <i class="fi-check-circle"></i>{{ session('status') }}
        </div>
    @endif

    @if (!auth()->user()->is_verified)
        <div class="alert alert-warning d-flex align-items-center gap-2 mb-4">
            <i class="fi-info"></i>
            <div>Your account is pending verification. You can create listings, but they won't go live until your account is verified and the listing is approved.</div>
        </div>
    @endif

    @if ($properties->count())
        <div class="row g-4">
            @foreach ($properties as $property)
                <div class="col-sm-6 col-lg-4">
                    <div class="card border-0 shadow-sm h-100">
                        @php
                            $cover = $property->cover_image;
                            $coverSrc = $cover?->path ? asset($cover->path) : asset('assets/img/listings/real-estate/01.jpg');
                        @endphp
                        <div class="position-relative">
                            <img src="{{ $coverSrc }}" class="card-img-top" alt="{{ $property->title }}" style="height: 180px; object-fit: cover;">
                            <div class="position-absolute top-0 end-0 m-2 d-flex gap-1">
                                @if ($property->status === 'live')
                                    <span class="badge text-bg-success">Live</span>
                                @elseif ($property->status === 'review')
                                    <span class="badge text-bg-warning">Under review</span>
                                @else
                                    <span class="badge text-bg-secondary">Draft</span>
                                @endif
                                @if ($property->is_verified)
                                    <span class="badge text-bg-info">Verified</span>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <h6 class="card-title mb-1">{{ Str::limit($property->title, 40) }}</h6>
                            <p class="text-body-secondary fs-sm mb-2">{{ $property->city ? $property->city . ', ' : '' }}{{ $property->region }}</p>
                            <div class="fw-semibold text-primary">{{ $property->formatted_price }}
                                @if ($property->price_period)
                                    <span class="fw-normal text-body-secondary fs-xs">/ {{ $property->price_period }}</span>
                                @endif
                            </div>
                            <div class="d-flex gap-3 fs-xs text-body-secondary mt-2">
                                <span><i class="fi-bed-single me-1"></i>{{ $property->bedrooms ?? 0 }}</span>
                                <span><i class="fi-shower me-1"></i>{{ $property->bathrooms ?? 0 }}</span>
                                <span>{{ $property->area ?? 0 }} sq.m</span>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-top d-flex gap-2">
                            <a href="{{ route('agent.properties.edit', $property) }}" class="btn btn-sm btn-outline-primary flex-grow-1">
                                <i class="fi-edit fs-xs me-1"></i>Edit
                            </a>
                            <a href="{{ route('properties.show', $property) }}" class="btn btn-sm btn-outline-secondary" target="_blank">
                                <i class="fi-external-link fs-xs"></i>
                            </a>
                            <form method="POST" action="{{ route('agent.properties.destroy', $property) }}" onsubmit="return confirm('Delete this property?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fi-trash fs-xs"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if ($properties->hasPages())
            <div class="mt-4">{{ $properties->links() }}</div>
        @endif
    @else
        <div class="text-center py-5">
            <i class="fi-grid fs-1 text-body-secondary opacity-25 d-block mb-3"></i>
            <h5 class="text-body-secondary">No properties yet</h5>
            <p class="text-body-secondary mb-4">Start by adding your first property listing.</p>
            <a class="btn btn-primary" href="{{ route('agent.properties.create') }}">
                <i class="fi-plus me-1"></i> Add property
            </a>
        </div>
    @endif
</div>
@endsection
