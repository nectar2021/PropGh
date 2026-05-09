@extends('layouts.app')

@section('title', 'Propsgh | Properties')
@section('meta_description', 'Browse available properties and shortlets on Propsgh.')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/vendor/leaflet/leaflet.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/choices.js/choices.min.css') }}">
@endpush

@section('content')
@php
  $selectedListingType = $filters['listing_type'] ?? '';
  $selectedPropertyType = $filters['property_type'] ?? '';
  $selectedLocation = $filters['location'] ?? '';
  $selectedMaxPrice = $filters['max_price'] ?? null;
  $selectedSort = $sort ?? 'updated';
  $selectedSortLabel = $sortOptions[$selectedSort] ?? 'Updated';
  $activeFilterCount = count(array_filter([
    $selectedListingType,
    $selectedPropertyType,
    $selectedLocation,
    $selectedMaxPrice,
  ], static fn ($value) => $value !== null && $value !== ''));
  $defaultCurrencySymbol = \App\Models\Property::defaultCurrencySymbol();
  $activeStatePills = array_filter([
    $selectedLocation !== '' ? ['label' => $selectedLocation, 'tone' => 'neutral'] : null,
    $selectedListingType !== '' ? ['label' => $listingTypeOptions[$selectedListingType] ?? $selectedListingType, 'tone' => 'neutral'] : null,
    $selectedPropertyType !== '' ? ['label' => $propertyTypeOptions[$selectedPropertyType] ?? $selectedPropertyType, 'tone' => 'neutral'] : null,
    $selectedMaxPrice ? ['label' => 'Up to '.$defaultCurrencySymbol.number_format((float) $selectedMaxPrice), 'tone' => 'neutral'] : null,
    $selectedSort !== 'updated' ? ['label' => 'Sorted: '.$selectedSortLabel, 'tone' => 'accent'] : null,
  ]);
  $mapPopupTemplate = $isLandSearch
    ? '<div class="card bg-transparent border-0" data-bs-theme="light"><div class="card-img-top position-relative bg-body-tertiary overflow-hidden"><div class="ratio d-block" style="--fn-aspect-ratio: calc(248 / 362 * 100%)"><img src="@{{image}}" alt="Image"></div></div><div class="card-body p-3"><div class="h5 mb-2">@{{formattedPrice}}</div><h3 class="fs-sm fw-normal text-body mb-2"><a class="stretched-link text-body" href="@{{url}}">@{{address}}</a></h3><div class="h6 fs-sm mb-0">@{{area}} sq.m</div></div><div class="card-footer border-0 bg-transparent pt-0 pb-3 px-3 mt-n1"><div class="d-flex align-items-center fs-sm gap-1"><i class="fi-map-pin fs-base text-secondary-emphasis"></i>@{{location}}</div></div></div>'
    : '<div class="card bg-transparent border-0" data-bs-theme="light"><div class="card-img-top position-relative bg-body-tertiary overflow-hidden"><div class="ratio d-block" style="--fn-aspect-ratio: calc(248 / 362 * 100%)"><img src="@{{image}}" alt="Image"></div></div><div class="card-body p-3"><div class="h5 mb-2">@{{formattedPrice}}</div><h3 class="fs-sm fw-normal text-body mb-2"><a class="stretched-link text-body" href="@{{url}}">@{{address}}</a></h3><div class="h6 fs-sm mb-0">@{{area}} sq.m</div></div><div class="card-footer d-flex gap-2 border-0 bg-transparent pt-0 pb-3 px-3 mt-n1"><div class="d-flex align-items-center fs-sm gap-1 me-1">@{{bedrooms}}<i class="fi-bed-single fs-base text-secondary-emphasis"></i></div><div class="d-flex align-items-center fs-sm gap-1 me-1">@{{bathrooms}}<i class="fi-shower fs-base text-secondary-emphasis"></i></div><div class="d-flex align-items-center fs-sm gap-1 me-1">@{{garage}}<i class="fi-car-garage fs-base text-secondary-emphasis"></i></div></div></div>';
  $mapConfig = [
    'tileLayer' => 'https://tile.openstreetmap.org/{z}/{x}/{y}.png',
    'attribution' => '© OpenStreetMap contributors',
    'zoom' => 12,
    'tileSize' => 256,
    'zoomOffset' => 0,
    'templates' => [
      'marker' => '<div class="map-marker"><i class="fi-map-pin-filled text-primary fs-4"></i><span class="map-marker-price">@{{formattedPrice}}</span></div>',
      'popup' => $mapPopupTemplate,
    ],
  ];
@endphp

<!-- Filters offcanvas -->
    <div class="offcanvas offcanvas-end" id="filters" tabindex="-1" style="width: 820px">

      <!-- Header -->
      <div class="offcanvas-header px-sm-5">
        <h4 class="h5 offcanvas-title">All filters</h4>
        <button class="btn-close" type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>

      <!-- Body (Filter inputs) -->
      <div class="offcanvas-body pt-2 pb-3 px-sm-5">
        <form action="{{ route('properties.index') }}" method="GET" class="h-100 d-flex flex-column">
          <div class="row row-cols-1 row-cols-md-2 g-4 pb-3 mb-3">
            <div class="col">
              <label class="form-label">Looking for</label>
              <select class="form-select" name="listing_type" aria-label="Looking for">
                @foreach ($listingTypeOptions as $value => $label)
                  <option value="{{ $value }}" @selected($selectedListingType === $value)>{{ $label }}</option>
                @endforeach
              </select>
            </div>
            <div class="col">
              <label class="form-label">Property type</label>
              <select class="form-select" name="property_type" aria-label="Property type">
                @foreach ($propertyTypeOptions as $value => $label)
                  <option value="{{ $value }}" @selected($selectedPropertyType === $value)>{{ $label }}</option>
                @endforeach
              </select>
            </div>
            <div class="col">
              <label class="form-label">Location</label>
              <select class="form-select" name="location" aria-label="Location">
                <option value="">Any city / area</option>
                @foreach ($locationOptions as $locationOption)
                  <option value="{{ $locationOption }}" @selected($selectedLocation === $locationOption)>{{ $locationOption }}</option>
                @endforeach
              </select>
            </div>
            <div class="col">
              <label class="form-label">Budget</label>
              <div class="input-group">
                <span class="input-group-text">{{ $defaultCurrencySymbol }}</span>
                <input
                  type="number"
                  class="form-control"
                  name="max_price"
                  min="0"
                  step="100"
                  value="{{ $selectedMaxPrice }}"
                  placeholder="Max price"
                >
              </div>
            </div>
          </div>

          <div class="rounded-4 bg-body-tertiary p-3 mb-4">
            <div class="fw-semibold mb-1">Focused search</div>
            <div class="fs-sm text-body-secondary mb-0">
              Listing type and property type stay separate here, so shortlet remains a market mode and land stays a true property class.
              @if ($isLandSearch)
                Land searches now suppress residential bedroom and bathroom details automatically while keeping the same filter URL shape.
              @endif
            </div>
          </div>

          <div class="mt-auto d-flex justify-content-between align-items-center gap-3 pt-3 border-top">
            <a class="nav-link fs-xs text-decoration-underline text-nowrap p-0" href="{{ route('properties.index') }}">Clear all</a>
            <button type="submit" class="btn btn-primary">Apply filters</button>
          </div>
        </form>
      </div>
    </div>


    <!-- Page content -->
    <div class="d-lg-flex">
      <div class="d-lg-flex grow">

        <!-- Interactive map that turns into offcanvas on screens < 992px wide (lg breakpoint) -->
        <div class="map-section">
          <div class="offcanvas-lg offcanvas-start d-flex flex-column w-100 h-100" id="map">
            <div class="offcanvas-body position-relative h-100 p-0">
              <button type="button" class="btn btn-icon btn-outline-secondary bg-body shadow position-absolute top-0 z-5 mt-2 d-lg-none" style="right: 0; margin-right: 8px; z-index: 500" data-bs-dismiss="offcanvas" data-bs-target="#map" aria-label="Close">
                <i class="fi-close fs-lg"></i>
              </button>
              <div class="position-absolute top-0 start-0 w-100 h-100 bg-body-tertiary" data-map='@json($mapConfig)' data-map-markers='@json($mapMarkers)'></div>
            </div>
          </div>
        </div>


        <!-- Listings with filters -->
        <div class="listings-section px-3 px-lg-4 pe-xxl-5">

          <!-- Sticky filters -->
          <div class="sticky-top bg-body mb-2 mb-sm-1">
            <div class="propsgh-sticky-spacer"></div>
            <form action="{{ route('properties.index') }}" method="GET" class="d-flex gap-2 gap-sm-3 py-2 py-sm-3 w-100">
              <div class="position-relative w-100">
                <i class="fi-map-pin position-absolute top-50 start-0 translate-middle-y z-1 ms-3"></i>
                <select class="form-select form-icon-start" name="location" aria-label="Location">
                  <option value="">Any city / area</option>
                  @foreach ($locationOptions as $locationOption)
                    <option value="{{ $locationOption }}" @selected($selectedLocation === $locationOption)>{{ $locationOption }}</option>
                  @endforeach
                </select>
              </div>
              <div class="shrink-0 d-none d-md-block" style="width: 160px">
                <select class="form-select" name="listing_type" data-select="{&quot;removeItemButton&quot;: false}" aria-label="Looking for">
                  @foreach ($listingTypeOptions as $value => $label)
                    <option value="{{ $value }}" @selected($selectedListingType === $value)>{{ $label }}</option>
                  @endforeach
                </select>
              </div>
              <div class="shrink-0 d-none d-xxl-block" style="width: 200px">
                <select class="form-select" name="property_type" data-select="{&quot;removeItemButton&quot;: false}" aria-label="Property type">
                  @foreach ($propertyTypeOptions as $value => $label)
                    <option value="{{ $value }}" @selected($selectedPropertyType === $value)>{{ $label }}</option>
                  @endforeach
                </select>
              </div>
              @if ($selectedMaxPrice)
                <input type="hidden" name="max_price" value="{{ $selectedMaxPrice }}">
              @endif
              <input type="hidden" name="sort" value="{{ $selectedSort }}">
              <button type="submit" class="btn btn-primary d-none d-sm-inline-flex px-3">
                Update
              </button>

              <!-- Map offcanvas toggle button visible on screens < 992px wide (lg breakpoint) -->
              <button type="button" class="btn btn-outline-dark pe-3 d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#map" aria-controls="map">
                <i class="fi-map fs-base me-2 ms-n1"></i>
                <span class="d-none d-sm-inline">Show on map</span>
                <span class="d-sm-none">Map</span>
              </button>

              <!-- Filters offcanvas toggle button -->
              <div class="position-relative">
                @if ($activeFilterCount > 0)
                  <span class="badge text-bg-primary rounded-pill position-absolute top-0 start-100 translate-middle mt-1 ms-n1">{{ $activeFilterCount }}</span>
                @endif
                <button type="button" class="btn btn-icon btn-dark" data-bs-toggle="offcanvas" data-bs-target="#filters" aria-controls="filters" aria-label="Toogle filters">
                  <i class="fi-sliders fs-base"></i>
                </button>
              </div>
            </form>
          </div>
          <div class="pg-results-toolbar mb-4">
            <div class="pg-results-copy">
              <div class="pg-results-kicker">List view</div>
              <div class="pg-results-summary">
                Showing {{ number_format($properties->firstItem() ?? 0) }}-{{ number_format($properties->lastItem() ?? 0) }} of {{ number_format($properties->total()) }} results
              </div>
              <div class="pg-results-note">
                Map markers stay synced with your current filters and {{ strtolower($selectedSortLabel) }} ordering.
              </div>
              @if ($activeStatePills)
                <div class="pg-results-pills">
                  @foreach ($activeStatePills as $pill)
                    <span class="pg-results-pill {{ $pill['tone'] === 'accent' ? 'is-accent' : '' }}">{{ $pill['label'] }}</span>
                  @endforeach
                  <a href="{{ route('properties.index') }}" class="pg-results-clear">Clear all</a>
                </div>
              @endif
            </div>
            <div class="pg-results-actions">
              <div class="pg-map-sync d-none d-lg-inline-flex">
                <i class="fi-map me-2"></i>
                <span>Map synced</span>
              </div>
              <form action="{{ route('properties.index') }}" method="GET" class="pg-sort-panel">
                @if ($selectedLocation !== '')
                  <input type="hidden" name="location" value="{{ $selectedLocation }}">
                @endif
                @if ($selectedListingType !== '')
                  <input type="hidden" name="listing_type" value="{{ $selectedListingType }}">
                @endif
                @if ($selectedPropertyType !== '')
                  <input type="hidden" name="property_type" value="{{ $selectedPropertyType }}">
                @endif
                @if ($selectedMaxPrice)
                  <input type="hidden" name="max_price" value="{{ $selectedMaxPrice }}">
                @endif
                <label class="pg-sort-label" for="propertiesSort">Sort listings</label>
                <div class="position-relative">
                  <i class="fi-sort position-absolute top-50 start-0 translate-middle-y z-2 ms-3"></i>
                  <select
                    id="propertiesSort"
                    class="form-select pg-sort-select ps-5"
                    name="sort"
                    aria-label="Sort listings"
                    onchange="this.form.submit()"
                  >
                    @foreach ($sortOptions as $value => $label)
                      <option value="{{ $value }}" @selected($selectedSort === $value)>{{ $label }}</option>
                    @endforeach
                  </select>
                </div>
              </form>
            </div>
          </div>


          <!-- Listings grid -->
          <div class="row row-cols-1 row-cols-sm-2 g-4">
            @php $mapMarkerIndex = 0; @endphp
            @forelse ($properties as $property)
              @php
                $images = $property->images->count() ? $property->images : collect();
                $detailsUrl = route('properties.show', $property);
                $hasCoordinates = filled($property->latitude) && filled($property->longitude);
                $landLocation = collect([$property->city, $property->region])->filter()->implode(', ');

                if ($hasCoordinates) {
                  $mapMarkerIndex++;
                }
              @endphp
              <div class="col">
                <article class="card hover-effect-opacity h-100" @if ($hasCoordinates) data-map-bind-to-marker="{{ $mapMarkerIndex }}" @endif>
                  <div class="card-img-top position-relative bg-body-tertiary overflow-hidden">
                    <div class="swiper z-2" data-swiper="{
                      &quot;pagination&quot;: {
                        &quot;el&quot;: &quot;.swiper-pagination&quot;
                      },
                      &quot;navigation&quot;: {
                        &quot;prevEl&quot;: &quot;.btn-prev&quot;,
                        &quot;nextEl&quot;: &quot;.btn-next&quot;
                      },
                      &quot;breakpoints&quot;: {
                        &quot;991&quot;: {
                          &quot;allowTouchMove&quot;: false
                        }
                      }
                    }">
                      <a class="swiper-wrapper" href="{{ $detailsUrl }}">
                        @forelse ($images->take(3) as $image)
                          <div class="swiper-slide">
                            <div class="ratio d-block" style="--fn-aspect-ratio: calc(248 / 362 * 100%)">
                              <img src="{{ asset($image->path) }}" alt="{{ $property->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                              <span class="position-absolute top-0 start-0 w-100 h-100 z-1" style="background: linear-gradient(180deg, rgba(0,0,0, 0) 0%, rgba(0,0,0, .11) 100%)"></span>
                            </div>
                          </div>
                        @empty
                          <div class="swiper-slide">
                            <div class="ratio d-block bg-body-tertiary" style="--fn-aspect-ratio: calc(248 / 362 * 100%)">
                              <div class="d-flex h-100 w-100 align-items-center justify-content-center text-body-secondary">
                                <div class="px-3 text-center">
                                  <i class="fi-image d-block fs-1 mb-2"></i>
                                  <span class="fw-medium fs-sm">No image uploaded</span>
                                </div>
                              </div>
                            </div>
                          </div>
                        @endforelse
                      </a>
                      <div class="d-flex flex-column gap-2 align-items-start position-absolute top-0 start-0 z-1 pt-1 pt-sm-0 ps-1 ps-sm-0 mt-2 mt-sm-3 ms-2 ms-sm-3">
                        @if ($property->is_verified)
                          <span class="badge text-bg-info d-inline-flex align-items-center">
                            Verified
                            <i class="fi-shield ms-1"></i>
                          </span>
                        @endif
                        @if ($property->is_featured)
                          <span class="badge text-bg-info">Featured</span>
                        @endif
                        @if ($property->is_new)
                          <span class="badge text-bg-primary">New</span>
                        @endif
                      </div>
                      <div class="position-absolute top-0 end-0 z-1 hover-effect-target opacity-0 pt-1 pt-sm-0 pe-1 pe-sm-0 mt-2 mt-sm-3 me-2 me-sm-3">
                        <button type="button" class="btn btn-sm btn-icon btn-light bg-light border-0 rounded-circle animate-pulse" aria-label="Add to wishlist">
                          <i class="fi-heart animate-target fs-sm"></i>
                        </button>
                      </div>
                      <div class="position-absolute top-50 start-0 z-1 translate-middle-y d-none d-lg-block hover-effect-target opacity-0 ms-3">
                        <button type="button" class="btn btn-sm btn-prev btn-icon btn-light bg-light rounded-circle animate-slide-start" aria-label="Prev">
                          <i class="fi-chevron-left fs-lg animate-target"></i>
                        </button>
                      </div>
                      <div class="position-absolute top-50 end-0 z-1 translate-middle-y d-none d-lg-block hover-effect-target opacity-0 me-3">
                        <button type="button" class="btn btn-sm btn-next btn-icon btn-light bg-light rounded-circle animate-slide-end" aria-label="Next">
                          <i class="fi-chevron-right fs-lg animate-target"></i>
                        </button>
                      </div>
                      <div class="swiper-pagination bottom-0 mb-2" data-bs-theme="light"></div>
                    </div>
                  </div>
                  <div class="card-body p-3">
                    <div class="h5 mb-2">{{ $property->formatted_price }}</div>
                    <h3 class="fs-sm fw-normal text-body mb-2">
                      <a class="stretched-link text-body" href="{{ $detailsUrl }}">{{ $property->title }}</a>
                    </h3>
                    <div class="h6 fs-sm mb-0">{{ $property->area ?? 0 }} sq.m</div>
                  </div>
                  @if ($isLandSearch)
                    <div class="card-footer border-0 bg-transparent pt-0 pb-3 px-3 mt-n1">
                      <div class="d-flex align-items-center fs-sm gap-1 text-body-secondary">
                        <i class="fi-map-pin fs-base text-secondary-emphasis"></i>
                        <span>{{ $landLocation !== '' ? $landLocation : 'Land listing' }}</span>
                      </div>
                    </div>
                  @else
                    <div class="card-footer d-flex gap-2 border-0 bg-transparent pt-0 pb-3 px-3 mt-n1">
                      <div class="d-flex align-items-center fs-sm gap-1 me-1">
                        {{ $property->bedrooms }}<i class="fi-bed-single fs-base text-secondary-emphasis"></i>
                      </div>
                      <div class="d-flex align-items-center fs-sm gap-1 me-1">
                        {{ $property->bathrooms }}<i class="fi-shower fs-base text-secondary-emphasis"></i>
                      </div>
                      <div class="d-flex align-items-center fs-sm gap-1 me-1">
                        {{ $property->garage_spaces }}<i class="fi-car-garage fs-base text-secondary-emphasis"></i>
                      </div>
                    </div>
                  @endif
                </article>
              </div>
            @empty
              <div class="col-12">
                <div class="text-center text-body-secondary py-5">No properties found.</div>
              </div>
            @endforelse
          </div>

          <!-- Pagination -->
          @if ($properties->hasPages())
            <div class="pt-4 mt-4 pg-listings-pagination">
              {{ $properties->onEachSide(1)->links('pagination::bootstrap-5') }}
            </div>
          @endif
        </div>
      </div>
    </div>

@endsection

@push('scripts')
<script src="{{ asset('assets/vendor/leaflet/leaflet.js') }}"></script>
<script src="{{ asset('assets/vendor/choices.js/choices.min.js') }}"></script>
@endpush
