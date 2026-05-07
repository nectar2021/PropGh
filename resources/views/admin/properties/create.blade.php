@extends('layouts.admin')

@section('title', 'Propsgh | Add Property')

@section('content')
<div class="admin-page-header d-flex flex-wrap align-items-center justify-content-between gap-3">
    <div>
        <h1 class="h3 mb-1">Add property</h1>
        <p class="text-body-secondary mb-0">Create a new listing for houses, apartments, or short stays.</p>
    </div>
    <a class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center gap-1" href="{{ route('admin.properties.index') }}">
        <i class="fi-chevron-left fs-sm"></i> Back to properties
    </a>
</div>

<div class="row g-3 mt-1 mb-4">
    <div class="col-sm-6 col-xl-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body py-3 d-flex align-items-center gap-3">
                <span class="d-inline-flex align-items-center justify-content-center rounded-3" style="width: 40px; height: 40px; background: rgba(100, 116, 139, 0.1); color: #64748b;">
                    <i class="fi-edit-2 fs-5"></i>
                </span>
                <div>
                    <div class="fw-bold fs-5">Draft first</div>
                    <div class="text-body-secondary fs-xs">New listings can be saved before going live.</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body py-3 d-flex align-items-center gap-3">
                <span class="d-inline-flex align-items-center justify-content-center rounded-3" style="width: 40px; height: 40px; background: rgba(var(--ad-accent), 0.1); color: rgb(var(--ad-accent));">
                    <i class="fi-image fs-5"></i>
                </span>
                <div>
                    <div class="fw-bold fs-5">Media ready</div>
                    <div class="text-body-secondary fs-xs">The first uploaded image becomes the cover.</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body py-3 d-flex align-items-center gap-3">
                <span class="d-inline-flex align-items-center justify-content-center rounded-3" style="width: 40px; height: 40px; background: rgba(16, 185, 129, 0.1); color: #10b981;">
                    <i class="fi-check-circle fs-5"></i>
                </span>
                <div>
                    <div class="fw-bold fs-5">Admin controlled</div>
                    <div class="text-body-secondary fs-xs">Owner, pricing, visibility, and verification are set here.</div>
                </div>
            </div>
        </div>
    </div>
</div>

<form class="row g-4" method="POST" action="{{ route('admin.properties.store') }}" enctype="multipart/form-data" data-property-form>
    @csrf
    @include('admin.properties.partials.form', ['submitLabel' => 'Save property'])
</form>
@endsection
