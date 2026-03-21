@extends('layouts.admin')

@section('title', 'Propsgh | Legal Pages')

@section('content')
<div class="admin-page-header d-flex flex-wrap align-items-center justify-content-between gap-3">
    <div>
        <h1 class="h3 mb-1">Legal pages</h1>
        <p class="text-body-secondary mb-0">Edit your Terms &amp; Conditions and Privacy Policy content.</p>
    </div>
</div>

@if (session('status'))
    <div class="alert alert-success d-flex align-items-center gap-2">
        <i class="fi-check-circle"></i>{{ session('status') }}
    </div>
@endif

<div class="row g-4">
    @foreach ($pages as $page)
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex align-items-start gap-3 mb-3">
                        <span class="d-inline-flex align-items-center justify-content-center rounded-3" style="width: 44px; height: 44px; background: rgba(var(--ad-accent), 0.1); color: rgb(var(--ad-accent)); flex-shrink: 0;">
                            <i class="{{ $page->slug === 'terms' ? 'fi-file-text' : 'fi-shield' }} fs-5"></i>
                        </span>
                        <div>
                            <h2 class="h5 mb-1">{{ $page->title }}</h2>
                            <p class="text-body-secondary fs-sm mb-0">{{ count($page->sections ?? []) }} sections</p>
                        </div>
                    </div>

                    <p class="text-body-secondary fs-sm flex-grow-1">{{ $page->meta_description }}</p>

                    <div class="d-flex align-items-center justify-content-between mt-3 pt-3 border-top">
                        <span class="text-body-secondary fs-xs">
                            Updated {{ $page->updated_at->diffForHumans() }}
                        </span>
                        <a href="{{ route('admin.legal-pages.edit', $page) }}" class="btn btn-sm btn-outline-primary d-inline-flex align-items-center gap-1">
                            <i class="fi-edit-2 fs-xs"></i> Edit
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
