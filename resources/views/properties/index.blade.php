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
  $activeFilterCount = count(array_filter([
    $selectedListingType,
    $selectedPropertyType,
    $selectedLocation,
    $selectedMaxPrice,
  ], static fn ($value) => $value !== null && $value !== ''));
  $mapFilters = array_filter([
    'listing_type' => $selectedListingType,
    'property_type' => $selectedPropertyType,
    'location' => $selectedLocation,
    'max_price' => $selectedMaxPrice,
  ], static fn ($value) => $value !== null && $value !== '');
  $defaultCurrencySymbol = \App\Models\Property::defaultCurrencySymbol();
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
              <div class="position-absolute top-0 start-0 w-100 h-100 bg-body-tertiary" data-map='@json($mapConfig)' data-map-markers="{{ route('properties.map', $mapFilters) }}"></div>
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


          <!-- Sort selector -->
          <div class="d-flex align-items-center gap-2 gap-sm-3 mb-3">
            <div class="fs-sm text-nowrap">Showing {{ number_format($properties->count()) }} results</div>
            <div class="position-relative ms-auto" style="width: 150px">
              <i class="fi-sort position-absolute top-50 start-0 translate-middle-y z-2"></i>
              <select class="form-select border-0 rounded-0 ps-4 pe-1" data-select="{
                &quot;removeItemButton&quot;: false,
                &quot;classNames&quot;: {
                  &quot;containerInner&quot;: [&quot;form-select&quot;, &quot;border-0&quot;, &quot;rounded-0&quot;, &quot;ps-4&quot;, &quot;pe-1&quot;]
                }
              }">
              <option value="Price Asc">Price Asc</option>
              <option value="Price Desc">Price Desc</option>
              <option value="Updated">Updated</option>
              <option value="Video">Video</option>
              <option value="3D Tour">3D Tour</option>
              </select>
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
                              <img src="{{ asset($image->path) }}" alt="{{ $property->title }}">
                              <span class="position-absolute top-0 start-0 w-100 h-100 z-1" style="background: linear-gradient(180deg, rgba(0,0,0, 0) 0%, rgba(0,0,0, .11) 100%)"></span>
                            </div>
                          </div>
                        @empty
                          <div class="swiper-slide">
                            <div class="ratio d-block" style="--fn-aspect-ratio: calc(248 / 362 * 100%)">
                              <img src="{{ asset('assets/img/listings/real-estate/01.jpg') }}" alt="{{ $property->title }}">
                              <span class="position-absolute top-0 start-0 w-100 h-100 z-1" style="background: linear-gradient(180deg, rgba(0,0,0, 0) 0%, rgba(0,0,0, .11) 100%)"></span>
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
          <nav class="pt-3 mt-3" aria-label="Listings pagination">
            <ul class="pagination pagination-lg justify-content-center">
              <li class="page-item active" aria-current="page">
                <span class="page-link">
                  1
                  <span class="visually-hidden">(current)</span>
                </span>
              </li>
              <li class="page-item">
                <a class="page-link" href="#!">2</a>
              </li>
              <li class="page-item">
                <a class="page-link" href="#!">3</a>
              </li>
              <li class="page-item">
                <a class="page-link" href="#!">4</a>
              </li>
              <li class="page-item">
                <a class="page-link" href="#!">5</a>
              </li>
              <li class="page-item">
                <span class="page-link px-2 pe-none">...</span>
              </li>
              <li class="page-item">
                <a class="page-link" href="#!">16</a>
              </li>
            </ul>
          </nav>

          <!-- Footer -->
          <footer class="text-center pt-4 pt-md-5">
            <hr class="pb-4">
            <a class="d-inline-flex align-items-center text-dark-emphasis text-decoration-none mb-4" href="#">
              <span class="shrink-0 text-primary rtl-flip me-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="34"><path d="M34.5 16.894v10.731c0 3.506-2.869 6.375-6.375 6.375H17.5h-.85C7.725 33.575.5 26.138.5 17c0-9.35 7.65-17 17-17s17 7.544 17 16.894z" fill="currentColor"></path><g fill-rule="evenodd"><path d="M17.5 13.258c-3.101 0-5.655 2.554-5.655 5.655s2.554 5.655 5.655 5.655 5.655-2.554 5.655-5.655-2.554-5.655-5.655-5.655zm-9.433 5.655c0-5.187 4.246-9.433 9.433-9.433s9.433 4.246 9.433 9.433a9.36 9.36 0 0 1-1.569 5.192l2.397 2.397a1.89 1.89 0 0 1 0 2.671 1.89 1.89 0 0 1-2.671 0l-2.397-2.397a9.36 9.36 0 0 1-5.192 1.569c-5.187 0-9.433-4.246-9.433-9.433z" fill="#000" fill-opacity=".05"></path><g fill="#fff"><path d="M17.394 10.153c-3.723 0-6.741 3.018-6.741 6.741s3.018 6.741 6.741 6.741 6.741-3.018 6.741-6.741-3.018-6.741-6.741-6.741zM7.347 16.894A10.05 10.05 0 0 1 17.394 6.847 10.05 10.05 0 0 1 27.44 16.894 10.05 10.05 0 0 1 17.394 26.94 10.05 10.05 0 0 1 7.347 16.894z"></path><path d="M23.025 22.525c.645-.645 1.692-.645 2.337 0l3.188 3.188c.645.645.645 1.692 0 2.337s-1.692.645-2.337 0l-3.187-3.187c-.645-.646-.645-1.692 0-2.337z"></path></g></g><path d="M23.662 14.663c2.112 0 3.825-1.713 3.825-3.825s-1.713-3.825-3.825-3.825-3.825 1.713-3.825 3.825 1.713 3.825 3.825 3.825z" fill="#fff"></path><path fill-rule="evenodd" d="M23.663 8.429a2.41 2.41 0 0 0-2.408 2.408 2.41 2.41 0 0 0 2.408 2.408 2.41 2.41 0 0 0 2.408-2.408 2.41 2.41 0 0 0-2.408-2.408zm-5.242 2.408c0-2.895 2.347-5.242 5.242-5.242s5.242 2.347 5.242 5.242-2.347 5.242-5.242 5.242-5.242-2.347-5.242-5.242z" fill="currentColor"></path></svg>
              </span>
              <span class="fs-4 fw-semibold">Finder</span>
            </a>
            <ul class="list-inline justify-content-center gap-2">
              <li class="me-3">
                <div class="position-relative d-flex align-items-center">
                  <i class="fi-mail fs-lg text-body me-2"></i>
                  <a class="text-dark-emphasis text-decoration-none hover-effect-underline stretched-link" href="mailto:contact@example.com">contact@example.com</a>
                </div>
              </li>
              <li>
                <div class="position-relative d-flex align-items-center">
                  <i class="fi-phone-call fs-lg text-body me-2"></i>
                  <a class="text-dark-emphasis text-decoration-none hover-effect-underline stretched-link" href="tel:+15053753082">+1&nbsp;50&nbsp;537&nbsp;53&nbsp;082</a>
                </div>
              </li>
            </ul>
            <div class="d-flex justify-content-center pt-2 mt-3">
              <a class="btn btn-icon fs-base btn-outline-secondary border-0" href="#!" data-bs-toggle="tooltip" data-bs-template="<div class=&quot;tooltip fs-xs mb-n2&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-transparent text-body opacity-75 p-0&quot;></div></div>" title="Instagram" aria-label="Follow us on Instagram">
                <i class="fi-instagram"></i>
              </a>
              <a class="btn btn-icon fs-base btn-outline-secondary border-0" href="#!" data-bs-toggle="tooltip" data-bs-template="<div class=&quot;tooltip fs-xs mb-n2&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-transparent text-body opacity-75 p-0&quot;></div></div>" title="Facebook" aria-label="Follow us on Facebook">
                <i class="fi-facebook"></i>
              </a>
              <a class="btn btn-icon fs-base btn-outline-secondary border-0" href="#!" data-bs-toggle="tooltip" data-bs-template="<div class=&quot;tooltip fs-xs mb-n2&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-transparent text-body opacity-75 p-0&quot;></div></div>" title="X (Twitter)" aria-label="Follow us on X (Twitter)">
                <i class="fi-x"></i>
              </a>
            </div>
            <div class="py-4">
              <p class="text-body-secondary fs-sm mb-0 mb-sm-2">© All rights reserved. Made by <a class="text-body fw-medium text-decoration-none hover-effect-underline" href="https://createx.studio/" target="_blank" rel="noreferrer">Createx Studio</a></p>
            </div>
          </footer>
        </div>
      </div>
    </div>


    
@endsection

@push('scripts')
<script src="{{ asset('assets/vendor/leaflet/leaflet.js') }}"></script>
<script src="{{ asset('assets/vendor/choices.js/choices.min.js') }}"></script>
@endpush
