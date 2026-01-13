@extends('layouts.admin')

@section('title', 'Propsgh | Edit Property')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
    <div>
        <h1 class="h3 mb-1">Edit property</h1>
        <p class="text-body-secondary mb-0">Update listing details, pricing, and visibility.</p>
    </div>
    <a class="btn btn-outline-secondary btn-sm" href="{{ route('admin.properties.index') }}">
        <i class="fi-chevron-left fs-sm me-1"></i>
        Back to properties
    </a>
</div>

<form class="row g-4" method="POST" action="{{ route('admin.properties.update', $property) }}">
    @csrf
    @method('PUT')
    @include('admin.properties.partials.form', ['submitLabel' => 'Update property'])
</form>
@endsection
