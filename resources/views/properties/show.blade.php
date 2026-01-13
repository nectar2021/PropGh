@extends('layouts.app')

@section('title', 'Propsgh | ' . $property->title)
@section('meta_description', \Illuminate\Support\Str::limit($property->description ?? 'View property details on Propsgh.', 150))

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/vendor/glightbox/glightbox.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/flatpickr/flatpickr.min.css') }}">
@endpush

@section('content')
  <!-- Tour booking form modal -->
  <div class="modal fade" id="tourBooking" tabindex="-1" aria-labelledby="tourBookingLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 400px">
      <form class="modal-content needs-validation" novalidate>
        <div class="modal-header border-0">
          <h5 class="modal-title" id="tourBookingLabel">Schedule a tour</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body pb-4 pt-0">
          <ul class="nav nav-pills nav-justified mb-4">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">In-person</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Video chat</a>
            </li>
          </ul>
          <div class="vstack gap-3">
            <div class="position-relative">
              <i class="fi-calendar position-absolute top-50 start-0 translate-middle-y ms-3"></i>
              <input type="text" class="form-control form-icon-start bg-transparent" data-datepicker='{"dateFormat":"M j, Y"}' placeholder="Choose date *" required>
            </div>
            <div class="position-relative">
              <i class="fi-clock position-absolute top-50 start-0 translate-middle-y ms-3"></i>
              <input type="text" class="form-control form-icon-start" id="time-12" data-datepicker='{"enableTime":true,"noCalendar":true,"dateFormat":"h:i K"}' placeholder="Choose time *" required>
            </div>
            <input type="text" class="form-control" placeholder="Name *" required>
            <input type="email" class="form-control" placeholder="Email *" required>
            <input type="tel" class="form-control" data-input-format='{"numericOnly":true,"delimiters":["+1 "," "," "],"blocks":[0,3,3,2]}' placeholder="Phone number">
          </div>
        </div>
        <div class="modal-footer border-0 pt-0 pb-4 px-4">
          <button type="submit" class="btn btn-lg btn-primary w-100 m-0 mb-3">Schedule a tour</button>
          <p class="fs-xs m-0">This site is protected by reCAPTCHA and the Google <a class="hover-effect-underline text-decoration-none" href="#!">Privacy Policy</a> and <a class="hover-effect-underline text-decoration-none" href="#!">Terms of Service</a> apply.</p>
        </div>
      </form>
    </div>
  </div>

  <!-- Contact form modal -->
  <div class="modal fade" id="contactForm" tabindex="-1" aria-labelledby="contactFormLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 400px">
      <form class="modal-content needs-validation" novalidate>
        <div class="modal-header border-0">
          <h5 class="modal-title" id="contactFormLabel">Learn more about this property</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body pb-4 pt-0">
          <p class="fs-sm">Complete this form so we can get in touch</p>
          <div class="vstack gap-3">
            <input type="text" class="form-control" placeholder="Name *" required>
            <input type="email" class="form-control" placeholder="Email *" required>
            <input type="tel" class="form-control" data-input-format='{"numericOnly":true,"delimiters":["+1 "," "," "],"blocks":[0,3,3,2]}' placeholder="Phone number">
            <textarea class="form-control" rows="5" placeholder="Write your message" required></textarea>
          </div>
        </div>
        <div class="modal-footer border-0 pt-0 pb-4 px-4">
          <button type="submit" class="btn btn-lg btn-primary w-100 m-0 mb-3">Send message</button>
          <p class="fs-xs m-0">This site is protected by reCAPTCHA and the Google <a class="hover-effect-underline text-decoration-none" href="#!">Privacy Policy</a> and <a class="hover-effect-underline text-decoration-none" href="#!">Terms of Service</a> apply.</p>
        </div>
      </form>
    </div>
  </div>

  <div class="container pt-4 pb-5 mb-xxl-3">
    <!-- Breadcrumb -->
    @php
      $listingTypeLabel = match (strtolower($property->listing_type ?? '')) {
          'rent' => 'Property for rent',
          'sale' => 'Property for sale',
          'shortlet' => 'Shortlet stay',
          default => 'Properties',
      };
    @endphp
    <nav class="pb-2 pb-md-3" aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('properties.index') }}">{{ $listingTypeLabel }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $property->title }}</li>
      </ol>
    </nav>

    <!-- Image gallery -->
    @php
      $images = $property->images->count() ? $property->images : collect();
      $primaryImage = $images->first();
      $secondaryImages = $images->skip(1)->take(2)->values();
      $primarySrc = $primaryImage?->path ? asset($primaryImage->path) : asset('assets/img/listings/real-estate/single/01.jpg');
      $secondaryFallbacks = [
          asset('assets/img/listings/real-estate/single/02.jpg'),
          asset('assets/img/listings/real-estate/single/03.jpg'),
      ];
      $galleryCount = $images->count();
    @endphp
    <div class="row g-3 g-lg-4">
      <div class="col-md-8">
        <a class="hover-effect-scale hover-effect-opacity position-relative d-flex rounded overflow-hidden" href="{{ $primarySrc }}" data-glightbox data-gallery="image-gallery">
          <i class="fi-zoom-in hover-effect-target fs-3 text-white position-absolute top-50 start-50 translate-middle opacity-0 z-2"></i>
          <span class="hover-effect-target position-absolute top-0 start-0 w-100 h-100 bg-black bg-opacity-25 opacity-0 z-1"></span>
          <div class="ratio hover-effect-target bg-body-tertiary rounded" style="--fn-aspect-ratio: calc(450 / 856 * 100%)">
            <img src="{{ $primarySrc }}" alt="{{ $property->title }}">
          </div>
        </a>
      </div>
      <div class="col-md-4 vstack gap-3 gap-lg-4">
        @for ($index = 0; $index < 2; $index++)
          @php
            $image = $secondaryImages[$index] ?? null;
            $src = $image?->path ? asset($image->path) : $secondaryFallbacks[$index];
          @endphp
          <a class="hover-effect-scale hover-effect-opacity position-relative d-flex rounded overflow-hidden" href="{{ $src }}" data-glightbox data-gallery="image-gallery">
            <i class="fi-zoom-in hover-effect-target fs-3 text-white position-absolute top-50 start-50 translate-middle opacity-0 z-2"></i>
            <span class="hover-effect-target position-absolute top-0 start-0 w-100 h-100 bg-black bg-opacity-25 opacity-0 z-1"></span>
            <div class="ratio hover-effect-target bg-body-tertiary rounded" style="--fn-aspect-ratio: calc(213 / 416 * 100%)">
              <img src="{{ $src }}" alt="{{ $property->title }}">
            </div>
            @if ($index === 1 && $galleryCount > 2)
              <div class="btn btn-sm btn-light pe-none position-absolute end-0 bottom-0 z-2 mb-3 me-3">
                <i class="fi-camera fs-sm me-1 ms-n1"></i>
                {{ $galleryCount }}
              </div>
            @endif
          </a>
        @endfor
      </div>
    </div>

    <!-- Listing details -->
    <div class="row pt-4 pb-2 pb-sm-3 pb-md-4 py-lg-5 mt-sm-2 mt-lg-0">
      <div class="col-lg-8 col-xl-7 pb-3 pb-sm-0 mb-4 mb-sm-5 mb-lg-0">
        @php
          $addressLine = collect([
              $property->address,
              $property->city,
              $property->region,
              $property->postal_code,
          ])->filter()->implode(', ');
          $priceLabel = '$' . number_format((float) $property->price);
          $periodLabel = $property->price_period ? 'per ' . $property->price_period : null;
        @endphp
        <div class="d-flex align-items-center justify-content-between gap-4 mb-3">
          <div class="d-flex gap-2">
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
          <div class="d-flex gap-2">
            <div class="dropdown" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-sm" title="Share">
              <button type="button" class="btn btn-icon btn-secondary bg-transparent border-0 animate-scale" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" aria-label="Share">
                <i class="fi-share-2 animate-target fs-base"></i>
              </button>
              <ul class="dropdown-menu dropdown-menu-end" style="--fn-dropdown-min-width: 9.5rem">
                <li>
                  <a class="dropdown-item" href="#!">
                    <i class="fi-facebook fs-base me-2"></i>
                    Facebook
                  </a>
                </li>
                <li>
                  <a class="dropdown-item" href="#!">
                    <i class="fi-instagram fs-base me-2"></i>
                    Instagram
                  </a>
                </li>
                <li>
                  <a class="dropdown-item" href="#">
                    <i class="fi-linkedin fs-base me-2"></i>
                    LinkedIn
                  </a>
                </li>
              </ul>
            </div>
            <button type="button" class="btn btn-icon btn-secondary bg-transparent border-0 animate-pulse" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-sm" title="Wishlist" aria-label="Wishlist">
              <i class="fi-heart animate-target fs-base"></i>
            </button>
          </div>
        </div>

        <div class="h3 pb-1 mb-2">
          {{ $priceLabel }}
          @if ($periodLabel)
            <span class="fs-sm text-body-secondary ms-2">{{ $periodLabel }}</span>
          @endif
        </div>
        <p class="fs-sm pb-1 mb-2">{{ $addressLine ?: $property->title }}</p>
        <div class="d-flex gap-2 mb-4">
          <div class="d-flex align-items-center fs-sm gap-1 me-2">
            {{ $property->bedrooms ?? 0 }}<i class="fi-bed-single fs-base text-secondary-emphasis"></i>
          </div>
          <div class="d-flex align-items-center fs-sm gap-1 me-2">
            {{ $property->bathrooms ?? 0 }}<i class="fi-shower fs-base text-secondary-emphasis"></i>
          </div>
          <div class="d-flex align-items-center fs-sm gap-1 me-2">
            {{ $property->garage_spaces ?? 0 }}<i class="fi-car-garage fs-base text-secondary-emphasis"></i>
          </div>
          <div class="fs-sm">{{ $property->area ?? 0 }} sq.m</div>
        </div>

        <div class="alert d-flex alert-secondary fs-sm m-0" role="alert">
          <i class="fi-info fs-lg pe-1 me-2"></i>
          <div>We estimate this home will sell faster than 94% nearby.</div>
        </div>

        <h2 class="h5 pt-4 pt-sm-5 mt-3 mt-sm-0">About</h2>
        <p class="fs-sm">{{ $property->description }}</p>

        <h2 class="h5 pt-4 pt-sm-5 mt-3 mt-sm-0">General information</h2>
            <table class="table table-borderless w-auto fs-sm">
              <tbody>
                <tr>
                  <th scope="row" class="py-2 ps-0 pe-3">Property type</th>
                  <td class="text-body py-2">{{ $property->property_type ? \Illuminate\Support\Str::title($property->property_type) : '—' }}</td>
                </tr>
                <tr>
                  <th scope="row" class="py-2 ps-0 pe-3">Listing type</th>
                  <td class="text-body py-2">{{ $property->listing_type ? ucfirst($property->listing_type) : '—' }}</td>
                </tr>
                <tr>
                  <th scope="row" class="py-2 ps-0 pe-3">Year built</th>
                  <td class="text-body py-2">{{ $property->year_built ?? '—' }}</td>
                </tr>
                <tr>
                  <th scope="row" class="py-2 ps-0 pe-3">Living area</th>
                  <td class="text-body py-2">{{ $property->area ?? '—' }} sq.m</td>
                </tr>
                <tr>
                  <th scope="row" class="py-2 ps-0 pe-3">Deposit</th>
                  <td class="text-body py-2">{{ $property->deposit ? '$' . number_format((float) $property->deposit) : '—' }}</td>
                </tr>
                <tr>
                  <th scope="row" class="py-2 ps-0 pe-3">Floor</th>
                  <td class="text-body py-2">{{ $property->floor ?? '—' }}</td>
                </tr>
                <tr>
                  <th scope="row" class="py-2 ps-0 pe-3">Total rooms</th>
                  <td class="text-body py-2">{{ $property->total_rooms ?? '—' }}</td>
                </tr>
                <tr>
                  <th scope="row" class="py-2 ps-0 pe-3">Bedrooms</th>
                  <td class="text-body py-2">{{ $property->bedrooms ?? '—' }}</td>
                </tr>
                <tr>
                  <th scope="row" class="py-2 ps-0 pe-3">Bathrooms</th>
                  <td class="text-body py-2">{{ $property->bathrooms ?? '—' }}</td>
                </tr>
              </tbody>
            </table>

        <h2 class="h5 pt-4 pt-sm-5 mt-3 mt-sm-0">Amenities</h2>
        @if (!empty($property->amenities))
          <div class="row row-cols-2 row-cols-sm-3 fs-sm gy-3">
            @foreach ($property->amenities as $amenity)
              <div class="col d-flex align-items-center">
                <i class="fi-check-circle fs-lg me-2"></i>
                {{ $amenity }}
              </div>
            @endforeach
          </div>
        @else
          <p class="fs-sm text-body-secondary mb-0">No amenities listed for this property.</p>
        @endif
        @if (!empty($property->pets_allowed))
          <p class="fs-sm text-body-secondary mt-3 mb-0">
            Pets allowed: {{ implode(', ', $property->pets_allowed) }}
          </p>
        @endif

        <h2 class="h5 pt-4 pt-sm-5 mt-3 mt-sm-0">Transportation</h2>
        <div class="row row-cols-2 row-cols-sm-3 fs-sm gy-3">
          <div class="col d-flex align-items-center">
            <i class="fi-footprints fs-lg me-2"></i>
            <span><span class="fw-semibold">73/100</span> Walkable</span>
          </div>
          <div class="col d-flex align-items-center">
            <i class="fi-car fs-lg me-2"></i>
            <span><span class="fw-semibold">97%</span> Driveable</span>
          </div>
          <div class="col d-flex align-items-center">
            <i class="fi-bicycle fs-lg me-2"></i>
            <span><span class="fw-semibold">59/100%</span> Bikeable</span>
          </div>
        </div>

        <h2 class="h5 pt-4 pt-sm-5 mt-3 mt-sm-0">Location</h2>
        <div class="overflow-x-auto pb-3 mb-2">
          <ul class="nav nav-pills nav-justified flex-nowrap gap-2">
            <li class="nav-item me-1">
              <a class="nav-link text-nowrap active" aria-current="page" href="#!">
                <i class="fi-tram fs-base me-2 ms-n1"></i>
                Transport
              </a>
            </li>
            <li class="nav-item me-1">
              <a class="nav-link text-nowrap" href="#!">
                <i class="fi-graduation-cap fs-base me-2 ms-n1"></i>
                Education
              </a>
            </li>
            <li class="nav-item me-1">
              <a class="nav-link text-nowrap" href="#!">
                <i class="fi-shopping-bag fs-base me-2 ms-n1"></i>
                Shopping
              </a>
            </li>
            <li class="nav-item me-1">
              <a class="nav-link text-nowrap" href="#!">
                <i class="fi-bowl-food fs-base me-2 ms-n1"></i>
                Food
              </a>
            </li>
            <li class="nav-item me-1">
              <a class="nav-link text-nowrap" href="#!">
                <i class="fi-tree fs-base me-2 ms-n1"></i>
                Parks
              </a>
            </li>
          </ul>
        </div>

        @php
          $mapUrl = $property->map_embed_url;
          if (! $mapUrl && $property->latitude && $property->longitude) {
              $mapUrl = 'https://www.google.com/maps?q=' . $property->latitude . ',' . $property->longitude . '&output=embed';
          }
        @endphp
        @if ($mapUrl)
          <iframe class="border rounded" src="{{ $mapUrl }}" width="600" height="350" style="border: 0" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Map"></iframe>
        @else
          <div class="border rounded d-flex align-items-center justify-content-center text-body-secondary" style="height: 350px;">Map unavailable</div>
        @endif

        <div class="d-flex align-items-center justify-content-between gap-3 pt-4">
          <div class="d-flex gap-3 fs-sm">
            <div>Published: <span class="fw-medium text-dark-emphasis">{{ ($property->published_at ?? $property->created_at)->format('M d, Y') }}</span></div>
            <div>Views: <span class="fw-medium text-dark-emphasis">{{ number_format($property->views ?? 0) }}</span></div>
          </div>
          <div class="d-flex gap-2">
            <div class="dropdown" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-sm" title="Share">
              <button type="button" class="btn btn-icon btn-secondary bg-transparent border-0 animate-scale" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" aria-label="Share">
                <i class="fi-share-2 animate-target fs-base"></i>
              </button>
              <ul class="dropdown-menu dropdown-menu-end" style="--fn-dropdown-min-width: 9.5rem">
                <li>
                  <a class="dropdown-item" href="#!">
                    <i class="fi-facebook fs-base me-2"></i>
                    Facebook
                  </a>
                </li>
                <li>
                  <a class="dropdown-item" href="#!">
                    <i class="fi-instagram fs-base me-2"></i>
                    Instagram
                  </a>
                </li>
                <li>
                  <a class="dropdown-item" href="#">
                    <i class="fi-linkedin fs-base me-2"></i>
                    LinkedIn
                  </a>
                </li>
              </ul>
            </div>
            <button type="button" class="btn btn-icon btn-secondary bg-transparent border-0 animate-pulse" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-sm" title="Wishlist" aria-label="Wishlist">
              <i class="fi-heart animate-target fs-base"></i>
            </button>
          </div>
        </div>
      </div>

      <aside class="col-lg-4 offset-xl-1">
        <div class="d-none d-lg-block" style="margin-top: -105px"></div>
        <div class="sticky-lg-top">
          <div class="d-none d-lg-block" style="height: 105px"></div>
          <div class="bg-body-tertiary rounded p-4">
            <div class="p-sm-2 p-lg-0 p-xl-2">
              @php
                $owner = $property->owner;
                $ownerName = $owner?->name ?? 'Propsgh Team';
                $ownerRole = $owner?->role ? ucfirst($owner->role) : 'Host';
                $ownerEmail = $owner?->email;
                $ownerPhone = $owner?->phone;
                $ownerAvatar = $owner?->avatar_path ? asset($owner->avatar_path) : asset('assets/img/listings/real-estate/single/avatar.jpg');
              @endphp
              <div class="d-flex align-items-center position-relative mb-4">
                <div class="ratio ratio-1x1 flex-shrink-0 bg-body-secondary rounded-circle overflow-hidden" style="width: 80px">
                  <img src="{{ $ownerAvatar }}" alt="{{ $ownerName }}">
                </div>
                <div class="ps-4">
                  <h5 class="mb-1">
                    <a class="hover-effect-underline stretched-link" href="#">{{ $ownerName }}</a>
                  </h5>
                  <p class="fs-sm mb-0">{{ $ownerRole }}</p>
                </div>
              </div>
              <ul class="nav flex-column gap-2 mb-4">
                @if ($ownerEmail)
                  <li class="nav-item d-flex align-items-center position-relative">
                    <i class="fi-mail me-2"></i>
                    <a class="nav-link hover-effect-underline stretched-link fw-normal text-body p-0" href="mailto:{{ $ownerEmail }}">{{ $ownerEmail }}</a>
                  </li>
                @endif
                @if ($ownerPhone)
                  <li class="nav-item d-flex align-items-center position-relative">
                    <i class="fi-phone me-2"></i>
                    <a class="nav-link hover-effect-underline stretched-link fw-normal text-body p-0" href="tel:{{ $ownerPhone }}">{{ $ownerPhone }}</a>
                  </li>
                @endif
              </ul>
              <button type="button" class="btn btn-lg btn-primary w-100" data-bs-toggle="modal" data-bs-target="#tourBooking">Schedule a tour</button>
              <div class="fs-xs text-center pt-1 pb-2 my-2">It's free, cancel anytime</div>
              <div class="d-flex align-items-center mb-3">
                <hr class="w-100 m-0">
                <div class="mt-n1 px-3">or</div>
                <hr class="w-100 m-0">
              </div>
              <button type="button" class="btn btn-lg btn-outline-dark w-100" data-bs-toggle="modal" data-bs-target="#contactForm">Send message</button>
            </div>
          </div>
        </div>
      </aside>
    </div>
  </div>
@endsection

@push('scripts')
<script src="{{ asset('assets/vendor/glightbox/glightbox.min.js') }}"></script>
<script src="{{ asset('assets/vendor/flatpickr/flatpickr.min.js') }}"></script>
<script src="{{ asset('assets/vendor/cleave.js/cleave.min.js') }}"></script>
@endpush
