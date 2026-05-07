@extends('layouts.admin')

@section('title', 'Propsgh | Homepage Content')

@section('content')
<div class="admin-page-header d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
    <div>
        <h1 class="h3 mb-1">Homepage content</h1>
        <p class="text-body-secondary mb-0">Manage the public homepage copy, section labels, and artwork.</p>
    </div>
    <a href="{{ route('home') }}" target="_blank" class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center gap-1">
        <i class="fi-external-link fs-xs"></i> Preview homepage
    </a>
</div>

@if (session('status'))
    <div class="alert alert-success d-flex align-items-center gap-2">
        <i class="fi-check-circle"></i>{{ session('status') }}
    </div>
@endif

<form method="POST" action="{{ route('admin.homepage.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <h2 class="h5 mb-3">Meta & hero copy</h2>
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="home_meta_title" class="form-label">Homepage meta title</label>
                    <input type="text" name="home_meta_title" id="home_meta_title" class="form-control @error('home_meta_title') is-invalid @enderror" value="{{ old('home_meta_title', $settings['home_meta_title']) }}">
                    @error('home_meta_title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="home_meta_description" class="form-label">Homepage meta description</label>
                    <textarea name="home_meta_description" id="home_meta_description" class="form-control @error('home_meta_description') is-invalid @enderror" rows="2">{{ old('home_meta_description', $settings['home_meta_description']) }}</textarea>
                    @error('home_meta_description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="home_hero_title" class="form-label">Hero title</label>
                    <input type="text" name="home_hero_title" id="home_hero_title" class="form-control @error('home_hero_title') is-invalid @enderror" value="{{ old('home_hero_title', $settings['home_hero_title']) }}">
                    @error('home_hero_title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="home_hero_subtitle" class="form-label">Hero subtitle</label>
                    <textarea name="home_hero_subtitle" id="home_hero_subtitle" class="form-control @error('home_hero_subtitle') is-invalid @enderror" rows="2">{{ old('home_hero_subtitle', $settings['home_hero_subtitle']) }}</textarea>
                    @error('home_hero_subtitle')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="home_hero_primary_label" class="form-label">Hero label 1</label>
                    <input type="text" name="home_hero_primary_label" id="home_hero_primary_label" class="form-control @error('home_hero_primary_label') is-invalid @enderror" value="{{ old('home_hero_primary_label', $settings['home_hero_primary_label']) }}">
                    @error('home_hero_primary_label')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="home_hero_secondary_label" class="form-label">Hero label 2</label>
                    <input type="text" name="home_hero_secondary_label" id="home_hero_secondary_label" class="form-control @error('home_hero_secondary_label') is-invalid @enderror" value="{{ old('home_hero_secondary_label', $settings['home_hero_secondary_label']) }}">
                    @error('home_hero_secondary_label')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="home_hero_tertiary_label" class="form-label">Hero label 3</label>
                    <input type="text" name="home_hero_tertiary_label" id="home_hero_tertiary_label" class="form-control @error('home_hero_tertiary_label') is-invalid @enderror" value="{{ old('home_hero_tertiary_label', $settings['home_hero_tertiary_label']) }}">
                    @error('home_hero_tertiary_label')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <h2 class="h5 mb-3">Search form labels</h2>
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="home_search_listing_type_label" class="form-label">Listing type label</label>
                    <input type="text" name="home_search_listing_type_label" id="home_search_listing_type_label" class="form-control @error('home_search_listing_type_label') is-invalid @enderror" value="{{ old('home_search_listing_type_label', $settings['home_search_listing_type_label']) }}">
                    @error('home_search_listing_type_label')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="home_search_property_type_label" class="form-label">Property type label</label>
                    <input type="text" name="home_search_property_type_label" id="home_search_property_type_label" class="form-control @error('home_search_property_type_label') is-invalid @enderror" value="{{ old('home_search_property_type_label', $settings['home_search_property_type_label']) }}">
                    @error('home_search_property_type_label')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="home_search_location_label" class="form-label">Location label</label>
                    <input type="text" name="home_search_location_label" id="home_search_location_label" class="form-control @error('home_search_location_label') is-invalid @enderror" value="{{ old('home_search_location_label', $settings['home_search_location_label']) }}">
                    @error('home_search_location_label')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="home_search_location_placeholder" class="form-label">Location placeholder</label>
                    <input type="text" name="home_search_location_placeholder" id="home_search_location_placeholder" class="form-control @error('home_search_location_placeholder') is-invalid @enderror" value="{{ old('home_search_location_placeholder', $settings['home_search_location_placeholder']) }}">
                    @error('home_search_location_placeholder')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="home_search_budget_label" class="form-label">Budget label</label>
                    <input type="text" name="home_search_budget_label" id="home_search_budget_label" class="form-control @error('home_search_budget_label') is-invalid @enderror" value="{{ old('home_search_budget_label', $settings['home_search_budget_label']) }}">
                    @error('home_search_budget_label')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="home_search_submit_label" class="form-label">Search button label</label>
                    <input type="text" name="home_search_submit_label" id="home_search_submit_label" class="form-control @error('home_search_submit_label') is-invalid @enderror" value="{{ old('home_search_submit_label', $settings['home_search_submit_label']) }}">
                    @error('home_search_submit_label')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <h2 class="h5 mb-3">Category & section labels</h2>
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="home_category_land_label" class="form-label">Land label</label>
                    <input type="text" name="home_category_land_label" id="home_category_land_label" class="form-control @error('home_category_land_label') is-invalid @enderror" value="{{ old('home_category_land_label', $settings['home_category_land_label']) }}">
                    @error('home_category_land_label')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="home_category_house_label" class="form-label">House label</label>
                    <input type="text" name="home_category_house_label" id="home_category_house_label" class="form-control @error('home_category_house_label') is-invalid @enderror" value="{{ old('home_category_house_label', $settings['home_category_house_label']) }}">
                    @error('home_category_house_label')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="home_category_apartment_label" class="form-label">Apartment label</label>
                    <input type="text" name="home_category_apartment_label" id="home_category_apartment_label" class="form-control @error('home_category_apartment_label') is-invalid @enderror" value="{{ old('home_category_apartment_label', $settings['home_category_apartment_label']) }}">
                    @error('home_category_apartment_label')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="home_category_townhouse_label" class="form-label">Townhouse label</label>
                    <input type="text" name="home_category_townhouse_label" id="home_category_townhouse_label" class="form-control @error('home_category_townhouse_label') is-invalid @enderror" value="{{ old('home_category_townhouse_label', $settings['home_category_townhouse_label']) }}">
                    @error('home_category_townhouse_label')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="home_category_office_label" class="form-label">Office label</label>
                    <input type="text" name="home_category_office_label" id="home_category_office_label" class="form-control @error('home_category_office_label') is-invalid @enderror" value="{{ old('home_category_office_label', $settings['home_category_office_label']) }}">
                    @error('home_category_office_label')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="home_category_more_label" class="form-label">More label</label>
                    <input type="text" name="home_category_more_label" id="home_category_more_label" class="form-control @error('home_category_more_label') is-invalid @enderror" value="{{ old('home_category_more_label', $settings['home_category_more_label']) }}">
                    @error('home_category_more_label')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="home_category_offers_suffix" class="form-label">Offers suffix</label>
                    <input type="text" name="home_category_offers_suffix" id="home_category_offers_suffix" class="form-control @error('home_category_offers_suffix') is-invalid @enderror" value="{{ old('home_category_offers_suffix', $settings['home_category_offers_suffix']) }}">
                    @error('home_category_offers_suffix')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="home_top_offers_heading" class="form-label">Top offers heading</label>
                    <input type="text" name="home_top_offers_heading" id="home_top_offers_heading" class="form-control @error('home_top_offers_heading') is-invalid @enderror" value="{{ old('home_top_offers_heading', $settings['home_top_offers_heading']) }}">
                    @error('home_top_offers_heading')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="home_top_offers_empty_state" class="form-label">Top offers empty state</label>
                    <input type="text" name="home_top_offers_empty_state" id="home_top_offers_empty_state" class="form-control @error('home_top_offers_empty_state') is-invalid @enderror" value="{{ old('home_top_offers_empty_state', $settings['home_top_offers_empty_state']) }}">
                    @error('home_top_offers_empty_state')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="home_city_heading" class="form-label">City section heading</label>
                    <input type="text" name="home_city_heading" id="home_city_heading" class="form-control @error('home_city_heading') is-invalid @enderror" value="{{ old('home_city_heading', $settings['home_city_heading']) }}">
                    @error('home_city_heading')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="home_city_sale_label" class="form-label">City sale label</label>
                    <input type="text" name="home_city_sale_label" id="home_city_sale_label" class="form-control @error('home_city_sale_label') is-invalid @enderror" value="{{ old('home_city_sale_label', $settings['home_city_sale_label']) }}">
                    @error('home_city_sale_label')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="home_city_rent_label" class="form-label">City rent label</label>
                    <input type="text" name="home_city_rent_label" id="home_city_rent_label" class="form-control @error('home_city_rent_label') is-invalid @enderror" value="{{ old('home_city_rent_label', $settings['home_city_rent_label']) }}">
                    @error('home_city_rent_label')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="home_city_empty_state" class="form-label">City empty state</label>
                    <input type="text" name="home_city_empty_state" id="home_city_empty_state" class="form-control @error('home_city_empty_state') is-invalid @enderror" value="{{ old('home_city_empty_state', $settings['home_city_empty_state']) }}">
                    @error('home_city_empty_state')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <h2 class="h5 mb-3">Hero images</h2>
            <div class="row g-3">
                @foreach ($heroImageFields as $field)
                    <div class="col-lg-4">
                        <div class="border rounded-3 p-3 h-100">
                            <label for="{{ $field['input'] }}" class="form-label">{{ $field['label'] }}</label>
                            @if (!empty($settings[$field['setting']]))
                                <div class="mb-3">
                                    <img src="{{ asset('storage/'.$settings[$field['setting']]) }}" alt="{{ $field['label'] }} preview" class="img-fluid rounded" style="max-height: 140px; width: 100%; object-fit: cover;">
                                </div>
                            @endif
                            <input type="file" name="{{ $field['input'] }}" id="{{ $field['input'] }}" class="form-control{{ $errors->has($field['input']) ? ' is-invalid' : '' }}" accept="image/*">
                            @if ($errors->has($field['input']))
                                <div class="invalid-feedback">{{ $errors->first($field['input']) }}</div>
                            @endif
                            @if (!empty($settings[$field['setting']]))
                                <div class="form-check mt-3">
                                    <input class="form-check-input" type="checkbox" name="{{ $field['remove'] }}" id="{{ $field['remove'] }}" value="1">
                                    <label class="form-check-label" for="{{ $field['remove'] }}">Remove image</label>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <h2 class="h5 mb-3">City images</h2>
            <div class="row g-3">
                @foreach ($cityImageFields as $field)
                    <div class="col-md-6 col-xl-4">
                        <div class="border rounded-3 p-3 h-100">
                            <label for="{{ $field['input'] }}" class="form-label">{{ $field['label'] }}</label>
                            @if (!empty($settings[$field['setting']]))
                                <div class="mb-3">
                                    <img src="{{ asset('storage/'.$settings[$field['setting']]) }}" alt="{{ $field['label'] }} preview" class="img-fluid rounded" style="max-height: 140px; width: 100%; object-fit: cover;">
                                </div>
                            @endif
                            <input type="file" name="{{ $field['input'] }}" id="{{ $field['input'] }}" class="form-control{{ $errors->has($field['input']) ? ' is-invalid' : '' }}" accept="image/*">
                            @if ($errors->has($field['input']))
                                <div class="invalid-feedback">{{ $errors->first($field['input']) }}</div>
                            @endif
                            @if (!empty($settings[$field['setting']]))
                                <div class="form-check mt-3">
                                    <input class="form-check-input" type="checkbox" name="{{ $field['remove'] }}" id="{{ $field['remove'] }}" value="1">
                                    <label class="form-check-label" for="{{ $field['remove'] }}">Remove image</label>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <h2 class="h5 mb-3">Action cards</h2>
            <div class="row g-3">
                @foreach ($actionCardFields as $card)
                    <div class="col-lg-4">
                        <div class="border rounded-3 p-3 h-100">
                            <div class="fw-semibold mb-3">{{ $card['title'] }}</div>
                            <div class="mb-3">
                                <label for="{{ $card['title_key'] }}" class="form-label">Card title</label>
                                <input type="text" name="{{ $card['title_key'] }}" id="{{ $card['title_key'] }}" class="form-control{{ $errors->has($card['title_key']) ? ' is-invalid' : '' }}" value="{{ old($card['title_key'], $settings[$card['title_key']]) }}">
                                @if ($errors->has($card['title_key']))
                                    <div class="invalid-feedback">{{ $errors->first($card['title_key']) }}</div>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label for="{{ $card['button_label_key'] }}" class="form-label">Button label</label>
                                <input type="text" name="{{ $card['button_label_key'] }}" id="{{ $card['button_label_key'] }}" class="form-control{{ $errors->has($card['button_label_key']) ? ' is-invalid' : '' }}" value="{{ old($card['button_label_key'], $settings[$card['button_label_key']]) }}">
                                @if ($errors->has($card['button_label_key']))
                                    <div class="invalid-feedback">{{ $errors->first($card['button_label_key']) }}</div>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label for="{{ $card['button_url_key'] }}" class="form-label">Button URL</label>
                                <input type="text" name="{{ $card['button_url_key'] }}" id="{{ $card['button_url_key'] }}" class="form-control{{ $errors->has($card['button_url_key']) ? ' is-invalid' : '' }}" value="{{ old($card['button_url_key'], $settings[$card['button_url_key']]) }}" placeholder="{{ $card['placeholder_url'] }}">
                                @if ($errors->has($card['button_url_key']))
                                    <div class="invalid-feedback">{{ $errors->first($card['button_url_key']) }}</div>
                                @endif
                            </div>
                            @if (!empty($settings[$card['image_setting']]))
                                <div class="mb-3">
                                    <img src="{{ asset('storage/'.$settings[$card['image_setting']]) }}" alt="{{ $card['title'] }} preview" class="img-fluid rounded" style="max-height: 140px; width: 100%; object-fit: cover;">
                                </div>
                            @endif
                            <div>
                                <label for="{{ $card['image_input'] }}" class="form-label">Card image</label>
                                <input type="file" name="{{ $card['image_input'] }}" id="{{ $card['image_input'] }}" class="form-control{{ $errors->has($card['image_input']) ? ' is-invalid' : '' }}" accept="image/*">
                                @if ($errors->has($card['image_input']))
                                    <div class="invalid-feedback">{{ $errors->first($card['image_input']) }}</div>
                                @endif
                            </div>
                            @if (!empty($settings[$card['image_setting']]))
                                <div class="form-check mt-3">
                                    <input class="form-check-input" type="checkbox" name="{{ $card['remove_key'] }}" id="{{ $card['remove_key'] }}" value="1">
                                    <label class="form-check-label" for="{{ $card['remove_key'] }}">Remove image</label>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">Cancel</a>
        <button type="submit" class="btn btn-primary">
            <i class="fi-check fs-sm me-1"></i> Save homepage content
        </button>
    </div>
</form>
@endsection