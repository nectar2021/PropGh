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

<form class="row g-4" method="POST" action="{{ route('admin.properties.update', $property) }}">
    @csrf
    @method('PUT')
    @include('admin.properties.partials.form', ['submitLabel' => 'Update property'])
</form>
@endsection
