@extends('layouts.app')

@section('title', 'Propsgh | Browse Properties')
@section('meta_description', 'Browse premium apartments, houses, shortlets, and commercial spaces across Ghana.')

@push('styles')
<style>
  .browse-hero {
    background: radial-gradient(140% 160% at 10% -20%, rgba(216,81,81,.03), transparent 45%), #f7f8fb;
  }
  .chip {
    border-radius: 999px;
    border: 1px solid var(--bs-border-color);
    padding: .35rem .9rem;
    font-weight: 600;
    color: var(--bs-body-color);
    background: var(--bs-body-bg);
    transition: all .18s ease;
  }
  .chip:hover {
    border-color: var(--bs-primary);
    color: var(--bs-primary);
    box-shadow: 0 10px 24px rgba(15,23,42,.08);
  }
  .property-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
</style>
@endpush

@section('content')
<div class="browse-hero">
  <section class="container-xxl py-4 py-lg-5">
    {{-- Page heading --}}
    <div class="row align-items-center mb-3 mb-lg-4">
      <div class="col-md-7">
        <nav class="mb-2" aria-label="breadcrumb">
          <ol class="breadcrumb mb-1">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Browse properties</li>
          </ol>
        </nav>
        <h1 class="h3 h-lg-2 fw-bold mb-1">Browse Properties</h1>
        <p class="text-body-secondary mb-0">
          25+ homes, apartments, shortlets and investments available across Ghana.
        </p>
      </div>
      <div class="col-md-5 text-md-end mt-3 mt-md-0">
        <div class="d-inline-flex align-items-center gap-2">
          <span class="fs-sm text-body-secondary">Sort by</span>
          <select class="form-select form-select-sm" style="min-width: 170px;">
            <option selected>Newest first</option>
            <option>Price: Low to High</option>
            <option>Price: High to Low</option>
            <option>Highest rated</option>
          </select>
        </div>
      </div>
    </div>

    <div class="row g-4">
      {{-- Filters on the right for more breathing room --}}
      <aside class="col-lg-4 col-xxl-3 order-lg-2">
        <div class="bg-body border rounded-4 shadow-sm p-3 p-lg-4 position-sticky" style="top: 92px;">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <h6 class="mb-0">Filters</h6>
            <button class="btn btn-sm btn-link px-0 fs-sm text-decoration-none">Reset</button>
          </div>

          <div class="mb-3">
            <label class="form-label fs-sm text-body-secondary">Search</label>
            <input type="search" class="form-control" placeholder="Search by area or title">
          </div>

          <div class="mb-3">
            <label class="form-label fs-sm text-body-secondary">Location</label>
            <select class="form-select">
              <option selected>Accra</option>
              <option>Kumasi</option>
              <option>Tema</option>
              <option>Takoradi</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label fs-sm text-body-secondary">Property type</label>
            @php $types = ['Apartments','Houses','Shortlets','Commercial']; @endphp
            @foreach($types as $index => $type)
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="type-{{ $index }}" @checked($index === 0)>
                <label class="form-check-label fs-sm" for="type-{{ $index }}">{{ $type }}</label>
              </div>
            @endforeach
          </div>

          <div class="mb-3">
            <label class="form-label fs-sm text-body-secondary">Price range (GHS)</label>
            <div class="row g-2">
              <div class="col-6"><input type="number" class="form-control form-control-sm" placeholder="Min"></div>
              <div class="col-6"><input type="number" class="form-control form-control-sm" placeholder="Max"></div>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label fs-sm text-body-secondary">Bedrooms</label>
            <select class="form-select form-select-sm">
              <option selected>Any</option>
              <option>1+</option>
              <option>2+</option>
              <option>3+</option>
              <option>4+</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label fs-sm text-body-secondary">Amenities</label>
            @php $amenities = ['Wi‑Fi','Pool','Backup power','Parking']; @endphp
            @foreach($amenities as $index => $amenity)
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="amenity-{{ $index }}" @checked($index === 0)>
                <label class="form-check-label fs-sm" for="amenity-{{ $index }}">{{ $amenity }}</label>
              </div>
            @endforeach
          </div>

          <button class="btn btn-primary w-100">
            <i class="fi-search me-2"></i>Apply filters
          </button>
        </div>
      </aside>

      {{-- Results --}}
      <div class="col-lg-8 col-xxl-9 order-lg-1">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
          <span class="fs-sm text-body-secondary">Showing <strong>12</strong> of <strong>148</strong> properties</span>
          <div class="d-flex gap-2">
            <span class="chip">Beachfront</span>
            <span class="chip">Serviced apartments</span>
            <span class="chip">Gated communities</span>
          </div>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 row-cols-xxl-4 g-4 g-xxl-5">
          @php
            $cards = [
              ['img' => 'assets/img/listings/real-estate/01.jpg', 'tag' => 'New', 'status' => 'Featured', 'badge' => 'For rent', 'title' => '$2,750', 'subtitle' => '929 Hart St, Brooklyn, NY 11237', 'area' => '108 sq.m', 'stats' => ['3','2','1']],
              ['img' => 'assets/img/listings/real-estate/featured/02.jpg', 'tag' => 'New', 'status' => 'Featured', 'badge' => 'For rent', 'title' => '$1,890', 'subtitle' => '3811 Ditmars Blvd Astoria, NY 11105', 'area' => '75 sq.m', 'stats' => ['2','1','1']],
              ['img' => 'assets/img/listings/real-estate/featured/01.jpg', 'tag' => 'Verified', 'status' => 'Featured', 'badge' => 'For rent', 'title' => '$1,250', 'subtitle' => '444 Park Ave, Brooklyn, NY 11205', 'area' => '54 sq.m', 'stats' => ['1','1','0']],
              ['img' => 'assets/img/listings/real-estate/featured/03.jpg', 'tag' => 'New', 'status' => 'Hot', 'badge' => 'For rent', 'title' => '$1,620', 'subtitle' => '40 S 9th St, Brooklyn, NY 11249', 'area' => '65 sq.m', 'stats' => ['2','1','1']],
              ['img' => 'assets/img/listings/real-estate/07.jpg', 'tag' => 'Verified', 'status' => 'New', 'badge' => 'For sale', 'title' => '$475,000', 'subtitle' => '929 Hart St, Brooklyn, NY 11237', 'area' => '108 sq.m', 'stats' => ['3','2','1']],
              ['img' => 'assets/img/listings/real-estate/02.jpg', 'tag' => 'New', 'status' => 'Good', 'badge' => 'For rent', 'title' => '$1,320', 'subtitle' => '517 82nd St, Brooklyn, NY 11209', 'area' => '45 sq.m', 'stats' => ['1','1','0']],
              ['img' => 'assets/img/listings/real-estate/06.jpg', 'tag' => 'Verified', 'status' => 'Prime', 'badge' => 'For rent', 'title' => '$1,490', 'subtitle' => '123 Bedford Avenue, Brooklyn, NY 11211', 'area' => '80 sq.m', 'stats' => ['2','1','1']],
              ['img' => 'assets/img/listings/real-estate/04.jpg', 'tag' => 'New', 'status' => 'Good', 'badge' => 'For rent', 'title' => '$3,860', 'subtitle' => '456 Court Street, Brooklyn, NY 11231', 'area' => '130 sq.m', 'stats' => ['3','2','2']],
            ];
          @endphp

          @foreach($cards as $card)
            <div class="col">
              <article class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden property-card">
                <div class="position-relative" style="aspect-ratio: 4/3;">
                  <img src="{{ asset($card['img']) }}" alt="Property">
                  <div class="position-absolute top-0 start-0 z-1 m-2 d-flex gap-2">
                    <span class="badge bg-body text-body-emphasis shadow-sm">{{ $card['tag'] }}</span>
                    <span class="badge bg-primary-subtle text-primary-emphasis shadow-sm">{{ $card['status'] }}</span>
                  </div>
                  <button type="button" class="btn btn-sm btn-icon btn-light border-0 rounded-circle position-absolute top-0 end-0 m-2" aria-label="Add to wishlist">
                    <i class="fi-heart fs-sm"></i>
                  </button>
                  <div class="position-absolute bottom-0 start-50 translate-middle-x d-flex gap-2 pb-2">
                    <span class="badge bg-body-secondary rounded-pill">•</span>
                    <span class="badge bg-body-secondary rounded-pill">•</span>
                    <span class="badge bg-body-secondary rounded-pill">•</span>
                  </div>
                </div>
                <div class="card-body p-3">
                  <span class="badge text-body-emphasis bg-body-secondary mb-2">{{ $card['badge'] }}</span>
                  <h3 class="fs-5 fw-semibold mb-1">{{ $card['title'] }}</h3>
                  <p class="fs-sm text-body-secondary mb-2">{{ $card['subtitle'] }}</p>
                  <div class="h6 fs-sm mb-3">{{ $card['area'] }}</div>
                  <div class="d-flex gap-3 fs-sm text-body-secondary">
                    <span class="d-inline-flex align-items-center gap-1">{{ $card['stats'][0] }}<i class="fi-bed-single text-secondary-emphasis"></i></span>
                    <span class="d-inline-flex align-items-center gap-1">{{ $card['stats'][1] }}<i class="fi-shower text-secondary-emphasis"></i></span>
                    <span class="d-inline-flex align-items-center gap-1">{{ $card['stats'][2] }}<i class="fi-car-garage text-secondary-emphasis"></i></span>
                  </div>
                </div>
              </article>
            </div>
          @endforeach
        </div>

        {{-- Pagination --}}
        <nav class="pt-4 mt-3" aria-label="Properties pagination">
          <ul class="pagination pagination-lg justify-content-center justify-content-lg-start">
            <li class="page-item disabled"><span class="page-link"><i class="fi-chevron-left"></i></span></li>
            <li class="page-item active" aria-current="page"><span class="page-link">1</span></li>
            <li class="page-item"><a class="page-link" href="#!">2</a></li>
            <li class="page-item"><a class="page-link" href="#!">3</a></li>
            <li class="page-item"><span class="page-link pe-none">...</span></li>
            <li class="page-item"><a class="page-link" href="#!">8</a></li>
            <li class="page-item"><a class="page-link" href="#!" aria-label="Next"><i class="fi-chevron-right"></i></a></li>
          </ul>
        </nav>
      </div>
    </div>
  </section>
</div>
@endsection
