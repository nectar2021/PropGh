@extends('layouts.admin')

@section('title', 'Propsgh | Edit ' . $page->title)

@section('content')
<div class="admin-page-header d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
    <div>
        <a href="{{ route('admin.legal-pages.index') }}" class="text-body-secondary text-decoration-none fs-sm d-inline-flex align-items-center gap-1 mb-1">
            <i class="fi-arrow-left fs-xs"></i> Back to legal pages
        </a>
        <h1 class="h3 mb-1">Edit {{ $page->title }}</h1>
        <p class="text-body-secondary mb-0">Update the sections below. Changes go live immediately.</p>
    </div>
    <a href="{{ route($page->slug === 'terms' ? 'terms' : 'privacy') }}" target="_blank" class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center gap-1">
        <i class="fi-external-link fs-xs"></i> Preview
    </a>
</div>

@if (session('status'))
    <div class="alert alert-success d-flex align-items-center gap-2">
        <i class="fi-check-circle"></i>{{ session('status') }}
    </div>
@endif

<form method="POST" action="{{ route('admin.legal-pages.update', $page) }}" id="legalPageForm">
    @csrf
    @method('PUT')

    {{-- Page meta --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <h2 class="h5 mb-3">Page details</h2>
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="title" class="form-label">Page title</label>
                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $page->title) }}">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="meta_description" class="form-label">Meta description</label>
                    <input type="text" name="meta_description" id="meta_description" class="form-control @error('meta_description') is-invalid @enderror" value="{{ old('meta_description', $page->meta_description) }}">
                    @error('meta_description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    {{-- Sections --}}
    <div id="sectionsContainer">
        @foreach (old('sections', $page->sections ?? []) as $i => $section)
            <div class="card border-0 shadow-sm mb-4 legal-section-card" data-index="{{ $i }}">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h2 class="h5 mb-0 d-flex align-items-center gap-2">
                            <span class="d-inline-flex align-items-center justify-content-center rounded-2" style="width: 28px; height: 28px; background: rgba(var(--ad-accent), 0.1); color: rgb(var(--ad-accent)); font-size: 0.75rem; font-weight: 800;">{{ $i + 1 }}</span>
                            <span class="section-title-preview">{{ $section['title'] ?? 'Untitled' }}</span>
                        </h2>
                        <div class="d-flex align-items-center gap-2">
                            <button type="button" class="btn btn-sm btn-icon btn-outline-secondary move-up-btn" title="Move up" {{ $i === 0 ? 'disabled' : '' }}>
                                <i class="fi-chevron-up fs-xs"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-icon btn-outline-secondary move-down-btn" title="Move down">
                                <i class="fi-chevron-down fs-xs"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-icon btn-outline-danger remove-section-btn" title="Remove section">
                                <i class="fi-trash-2 fs-xs"></i>
                            </button>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Section title</label>
                            <input type="text" name="sections[{{ $i }}][title]" class="form-control section-title-input @error("sections.{$i}.title") is-invalid @enderror" value="{{ $section['title'] ?? '' }}">
                            @error("sections.{$i}.title")
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Anchor ID</label>
                            <div class="input-group">
                                <span class="input-group-text">#</span>
                                <input type="text" name="sections[{{ $i }}][anchor]" class="form-control @error("sections.{$i}.anchor") is-invalid @enderror" value="{{ $section['anchor'] ?? '' }}">
                            </div>
                            @error("sections.{$i}.anchor")
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-3">
                        <label class="form-label">Content <span class="text-body-secondary fw-normal">(HTML allowed)</span></label>
                        <textarea name="sections[{{ $i }}][content]" class="form-control @error("sections.{$i}.content") is-invalid @enderror" rows="8" style="font-family: SFMono-Regular, Menlo, Monaco, Consolas, monospace; font-size: 0.82rem; line-height: 1.6;">{{ $section['content'] ?? '' }}</textarea>
                        @error("sections.{$i}.content")
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Add section button --}}
    <div class="text-center mb-4">
        <button type="button" id="addSectionBtn" class="btn btn-outline-secondary d-inline-flex align-items-center gap-2">
            <i class="fi-plus fs-sm"></i> Add section
        </button>
    </div>

    {{-- Submit --}}
    <div class="d-flex justify-content-end gap-2">
        <a href="{{ route('admin.legal-pages.index') }}" class="btn btn-outline-secondary">Cancel</a>
        <button type="submit" class="btn btn-primary d-inline-flex align-items-center gap-1">
            <i class="fi-check fs-sm"></i> Save changes
        </button>
    </div>
</form>

{{-- Section template for JS --}}
<template id="sectionTemplate">
    <div class="card border-0 shadow-sm mb-4 legal-section-card" data-index="__INDEX__">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h2 class="h5 mb-0 d-flex align-items-center gap-2">
                    <span class="d-inline-flex align-items-center justify-content-center rounded-2" style="width: 28px; height: 28px; background: rgba(var(--ad-accent), 0.1); color: rgb(var(--ad-accent)); font-size: 0.75rem; font-weight: 800;">__NUM__</span>
                    <span class="section-title-preview">New section</span>
                </h2>
                <div class="d-flex align-items-center gap-2">
                    <button type="button" class="btn btn-sm btn-icon btn-outline-secondary move-up-btn" title="Move up">
                        <i class="fi-chevron-up fs-xs"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-icon btn-outline-secondary move-down-btn" title="Move down">
                        <i class="fi-chevron-down fs-xs"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-icon btn-outline-danger remove-section-btn" title="Remove section">
                        <i class="fi-trash-2 fs-xs"></i>
                    </button>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Section title</label>
                    <input type="text" name="sections[__INDEX__][title]" class="form-control section-title-input" value="">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Anchor ID</label>
                    <div class="input-group">
                        <span class="input-group-text">#</span>
                        <input type="text" name="sections[__INDEX__][anchor]" class="form-control" value="">
                    </div>
                </div>
            </div>

            <div class="mt-3">
                <label class="form-label">Content <span class="text-body-secondary fw-normal">(HTML allowed)</span></label>
                <textarea name="sections[__INDEX__][content]" class="form-control" rows="8" style="font-family: SFMono-Regular, Menlo, Monaco, Consolas, monospace; font-size: 0.82rem; line-height: 1.6;"></textarea>
            </div>
        </div>
    </div>
</template>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('sectionsContainer');
    const addBtn = document.getElementById('addSectionBtn');
    const template = document.getElementById('sectionTemplate');

    function reindex() {
        const cards = container.querySelectorAll('.legal-section-card');
        cards.forEach(function (card, i) {
            card.dataset.index = i;
            const badge = card.querySelector('.rounded-2');
            if (badge) { badge.textContent = i + 1; }
            card.querySelectorAll('[name]').forEach(function (input) {
                input.name = input.name.replace(/sections\[\d+\]/, 'sections[' + i + ']');
            });
            const upBtn = card.querySelector('.move-up-btn');
            if (upBtn) { upBtn.disabled = i === 0; }
            const downBtn = card.querySelector('.move-down-btn');
            if (downBtn) { downBtn.disabled = i === cards.length - 1; }
        });
    }

    addBtn.addEventListener('click', function () {
        const cards = container.querySelectorAll('.legal-section-card');
        const idx = cards.length;
        let html = template.innerHTML.replace(/__INDEX__/g, idx).replace(/__NUM__/g, idx + 1);
        container.insertAdjacentHTML('beforeend', html);
        reindex();
        const newCard = container.lastElementChild;
        newCard.querySelector('.section-title-input').focus();
    });

    container.addEventListener('click', function (e) {
        const removeBtn = e.target.closest('.remove-section-btn');
        if (removeBtn) {
            const cards = container.querySelectorAll('.legal-section-card');
            if (cards.length <= 1) {
                alert('You must have at least one section.');
                return;
            }
            removeBtn.closest('.legal-section-card').remove();
            reindex();
            return;
        }

        const upBtn = e.target.closest('.move-up-btn');
        if (upBtn) {
            const card = upBtn.closest('.legal-section-card');
            const prev = card.previousElementSibling;
            if (prev) { container.insertBefore(card, prev); }
            reindex();
            return;
        }

        const downBtn = e.target.closest('.move-down-btn');
        if (downBtn) {
            const card = downBtn.closest('.legal-section-card');
            const next = card.nextElementSibling;
            if (next) { container.insertBefore(next, card); }
            reindex();
            return;
        }
    });

    container.addEventListener('input', function (e) {
        if (e.target.classList.contains('section-title-input')) {
            const preview = e.target.closest('.legal-section-card').querySelector('.section-title-preview');
            preview.textContent = e.target.value || 'Untitled';
        }
    });

    reindex();
});
</script>
@endpush
