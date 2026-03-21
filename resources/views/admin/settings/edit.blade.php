@extends('layouts.admin')

@section('title', 'Propsgh | Site Settings')

@section('content')
<div class="admin-page-header d-flex flex-wrap align-items-center justify-content-between gap-3">
    <div>
        <h1 class="h3 mb-1">Site settings</h1>
        <p class="text-body-secondary mb-0">Manage footer content, contact info, and social media links.</p>
    </div>
</div>

@if (session('status'))
    <div class="alert alert-success d-flex align-items-center gap-2">
        <i class="fi-check-circle"></i>{{ session('status') }}
    </div>
@endif

<form method="POST" action="{{ route('admin.settings.update') }}">
    @csrf
    @method('PUT')

    {{-- Contact info --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <h2 class="h5 mb-3">Contact information</h2>
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="contact_email" class="form-label">Email address</label>
                    <input type="email" name="contact_email" id="contact_email" class="form-control @error('contact_email') is-invalid @enderror" value="{{ old('contact_email', $settings['contact_email']) }}" placeholder="hello@propsgh.com">
                    @error('contact_email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="contact_phone" class="form-label">Phone number</label>
                    <input type="text" name="contact_phone" id="contact_phone" class="form-control @error('contact_phone') is-invalid @enderror" value="{{ old('contact_phone', $settings['contact_phone']) }}" placeholder="+233 20 000 0000">
                    @error('contact_phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="brand_description" class="form-label">Brand description</label>
                    <textarea name="brand_description" id="brand_description" class="form-control @error('brand_description') is-invalid @enderror" rows="2" placeholder="Short description for the footer">{{ old('brand_description', $settings['brand_description']) }}</textarea>
                    @error('brand_description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    {{-- Social links --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <h2 class="h5 mb-3">Social media links</h2>
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="social_instagram" class="form-label">Instagram URL</label>
                    <input type="url" name="social_instagram" id="social_instagram" class="form-control @error('social_instagram') is-invalid @enderror" value="{{ old('social_instagram', $settings['social_instagram']) }}" placeholder="https://instagram.com/propsgh">
                    @error('social_instagram')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="social_facebook" class="form-label">Facebook URL</label>
                    <input type="url" name="social_facebook" id="social_facebook" class="form-control @error('social_facebook') is-invalid @enderror" value="{{ old('social_facebook', $settings['social_facebook']) }}" placeholder="https://facebook.com/propsgh">
                    @error('social_facebook')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="social_twitter" class="form-label">Twitter / X URL</label>
                    <input type="url" name="social_twitter" id="social_twitter" class="form-control @error('social_twitter') is-invalid @enderror" value="{{ old('social_twitter', $settings['social_twitter']) }}" placeholder="https://x.com/propsgh">
                    @error('social_twitter')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="social_youtube" class="form-label">YouTube URL</label>
                    <input type="url" name="social_youtube" id="social_youtube" class="form-control @error('social_youtube') is-invalid @enderror" value="{{ old('social_youtube', $settings['social_youtube']) }}" placeholder="https://youtube.com/@propsgh">
                    @error('social_youtube')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    {{-- Footer stats --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <h2 class="h5 mb-3">Footer statistics</h2>
            <p class="text-body-secondary fs-sm mb-3">The verified homes count is automatically pulled from your live listings. Configure the other stats below.</p>
            <div class="row g-3">
                <div class="col-md-3">
                    <label for="stat_rating" class="form-label">Rating value</label>
                    <input type="text" name="stat_rating" id="stat_rating" class="form-control" value="{{ old('stat_rating', $settings['stat_rating']) }}" placeholder="4.9/5">
                </div>
                <div class="col-md-3">
                    <label for="stat_rating_label" class="form-label">Rating label</label>
                    <input type="text" name="stat_rating_label" id="stat_rating_label" class="form-control" value="{{ old('stat_rating_label', $settings['stat_rating_label']) }}" placeholder="Guest rating">
                </div>
                <div class="col-md-3">
                    <label for="stat_support" class="form-label">Support value</label>
                    <input type="text" name="stat_support" id="stat_support" class="form-control" value="{{ old('stat_support', $settings['stat_support']) }}" placeholder="24/7">
                </div>
                <div class="col-md-3">
                    <label for="stat_support_label" class="form-label">Support label</label>
                    <input type="text" name="stat_support_label" id="stat_support_label" class="form-control" value="{{ old('stat_support_label', $settings['stat_support_label']) }}" placeholder="Support">
                </div>
                <div class="col-md-3">
                    <label for="stat_satisfaction" class="form-label">Satisfaction value</label>
                    <input type="text" name="stat_satisfaction" id="stat_satisfaction" class="form-control" value="{{ old('stat_satisfaction', $settings['stat_satisfaction']) }}" placeholder="98%">
                </div>
                <div class="col-md-3">
                    <label for="stat_satisfaction_label" class="form-label">Satisfaction label</label>
                    <input type="text" name="stat_satisfaction_label" id="stat_satisfaction_label" class="form-control" value="{{ old('stat_satisfaction_label', $settings['stat_satisfaction_label']) }}" placeholder="Satisfaction">
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">
            <i class="fi-check fs-sm me-1"></i> Save settings
        </button>
    </div>
</form>
@endsection
