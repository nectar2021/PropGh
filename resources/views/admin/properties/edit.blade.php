@extends('layouts.admin')

@section('title', 'Propsgh | Edit Property')

@section('content')
<div class="admin-page-header d-flex flex-wrap align-items-center justify-content-between gap-3">
    <div>
        <h1 class="h3 mb-1">Edit property</h1>
        <p class="text-body-secondary mb-0">PR-{{ str_pad($property->id, 3, '0', STR_PAD_LEFT) }} &middot; {{ $property->title }}</p>
    </div>
    <div class="d-flex flex-wrap gap-2">
        <a class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center gap-1" href="{{ route('admin.properties.index') }}">
            <i class="fi-chevron-left fs-sm"></i> Back to properties
        </a>
        <a class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center gap-1" href="{{ route('properties.show', $property) }}">
            <i class="fi-eye fs-sm"></i> View live
        </a>
    </div>
</div>

<div class="row g-3 mt-1 mb-4">
    <div class="col-sm-6 col-xl-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body py-3 d-flex align-items-center gap-3">
                <span class="d-inline-flex align-items-center justify-content-center rounded-3" style="width: 40px; height: 40px; background: rgba(var(--ad-accent), 0.1); color: rgb(var(--ad-accent));">
                    <i class="fi-hash fs-5"></i>
                </span>
                <div>
                    <div class="fw-bold fs-5">PR-{{ str_pad($property->id, 3, '0', STR_PAD_LEFT) }}</div>
                    <div class="text-body-secondary fs-xs">{{ $property->property_type_label ?? 'Property' }} &middot; {{ ucfirst($property->listing_type ?? 'listing') }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body py-3 d-flex align-items-center gap-3">
                <span class="d-inline-flex align-items-center justify-content-center rounded-3" style="width: 40px; height: 40px; background: rgba(16, 185, 129, 0.1); color: #10b981;">
                    <i class="fi-user fs-5"></i>
                </span>
                <div>
                    <div class="fw-bold fs-5">{{ $property->owner?->name ?? 'Unassigned' }}</div>
                    <div class="text-body-secondary fs-xs">Owner and listing details can be updated here.</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body py-3 d-flex align-items-center gap-3">
                <span class="d-inline-flex align-items-center justify-content-center rounded-3" style="width: 40px; height: 40px; background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                    <i class="fi-clock fs-5"></i>
                </span>
                <div>
                    <div class="fw-bold fs-5">{{ ucfirst($property->status ?? 'draft') }}</div>
                    <div class="text-body-secondary fs-xs">Updated {{ optional($property->updated_at)->format('M d, Y') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<form class="row g-4" method="POST" action="{{ route('admin.properties.update', $property) }}" enctype="multipart/form-data" data-property-form>
    @csrf
    @method('PUT')
    @include('admin.properties.partials.form', ['submitLabel' => 'Update property'])
</form>
@endsection
