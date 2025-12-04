<!-- Navigation bar -->
<header class="navbar navbar-expand-lg bg-body navbar-sticky sticky-top z-fixed px-0 shadow-sm" data-sticky-element>
  <div class="container-fluid d-flex align-items-center px-3 px-lg-3">

    <!-- Brand: far left -->
    <a
      class="navbar-brand d-flex align-items-center gap-2 py-1 me-2 me-lg-3 text-body-emphasis"
      href="{{ route('home') }}"
    >
      <span
        class="d-inline-flex align-items-center justify-content-center bg-body rounded-4 shadow-sm border border-light-subtle"
        style="height: 60px; width: 60px;"
      >
        <img
          src="{{ asset('assets/img/props.jpeg') }}"
          alt="Propsgh"
          class="img-fluid"
          style="height: 52px; width: 52px; border-radius: 1.25rem; object-fit: cover;"
        >
      </span>
      <span class="d-none d-sm-flex flex-column">
        <span class="fw-semibold text-body-emphasis">Propsgh</span>
        <span class="small text-body-secondary">Discover &amp; manage properties</span>
      </span>
    </a>

    <!-- Mobile toggler (moved right) -->
    <button
      class="navbar-toggler ms-auto d-lg-none"
      type="button"
      data-bs-toggle="offcanvas"
      data-bs-target="#navbarNav"
      aria-controls="navbarNav"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Nav -->
    <nav class="offcanvas offcanvas-start" id="navbarNav" tabindex="-1" aria-labelledby="navbarNavLabel">
      <div class="offcanvas-header py-3 border-bottom d-lg-none">
        <div class="d-flex align-items-center gap-2">
          <span
            class="d-inline-flex align-items-center justify-content-center bg-body rounded-4 shadow-sm border"
            style="height: 52px; width: 52px;"
          >
            <img
              src="{{ asset('assets/img/props.jpeg') }}"
              alt="Propsgh"
              class="img-fluid"
              style="max-height: 44px; width: auto; object-fit: contain;"
            >
          </span>
          <div>
            <h5 class="offcanvas-title mb-0" id="navbarNavLabel">Propsgh</h5>
            <small class="text-muted">Properties in Ghana</small>
          </div>
        </div>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="offcanvas"
          aria-label="Close"
        ></button>
      </div>

      <div class="offcanvas-body pt-2 pb-4 py-lg-0 flex-lg-row flex-lg-grow-1 align-items-lg-center justify-content-lg-center px-lg-3">
        <ul class="navbar-nav flex-lg-row align-items-lg-center gap-lg-2">

          <li class="nav-item">
            <a
              class="nav-link px-lg-3 py-2 fw-semibold text-body-emphasis rounded-pill @if(request()->routeIs('home')) active @endif"
              href="{{ route('home') }}"
            >
              Home
            </a>
          </li>

          <li class="nav-item">
            <a
              class="nav-link px-lg-3 py-2 fw-semibold text-body-emphasis rounded-pill @if(request()->routeIs('properties.index')) active @endif"
              href="{{ route('properties.index') }}"
            >
              Browse properties
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link px-lg-3 py-2 fw-semibold text-body-emphasis rounded-pill" href="{{ route('contact') }}">
              Contact
            </a>
          </li>

          {{-- Mobile-only Login inside offcanvas --}}
          @guest
          <li class="nav-item d-lg-none mt-2">
            <a
              class="nav-link @if(request()->routeIs('login')) active @endif"
              href="{{ route('login') }}"
            >
              Login
            </a>
          </li>
          @endguest
        </ul>
      </div>
    </nav>

       <div class="d-flex gap-sm-1">

          <!-- Theme switcher (light/dark/auto) -->
          <div class="dropdown">
            <button type="button" class="theme-switcher btn btn-icon btn-outline-secondary fs-lg border-0 animate-scale" data-bs-toggle="dropdown" data-bs-display="dynamic" aria-expanded="false" aria-label="Toggle theme (light)">
              <span class="theme-icon-active d-flex animate-target">
                <i class="fi-sun"></i>
              </span>
            </button>
            <ul class="dropdown-menu start-50 translate-middle-x" style="--fn-dropdown-min-width: 9rem; --fn-dropdown-spacer: .5rem">
              <li>
                <button type="button" class="dropdown-item active" data-bs-theme-value="light" aria-pressed="true">
                  <span class="theme-icon d-flex fs-base me-2">
                    <i class="fi-sun"></i>
                  </span>
                  <span class="theme-label">Light</span>
                  <i class="item-active-indicator fi-check ms-auto"></i>
                </button>
              </li>
              <li>
                <button type="button" class="dropdown-item" data-bs-theme-value="dark" aria-pressed="false">
                  <span class="theme-icon d-flex fs-base me-2">
                    <i class="fi-moon"></i>
                  </span>
                  <span class="theme-label">Dark</span>
                  <i class="item-active-indicator fi-check ms-auto"></i>
                </button>
              </li>
              <li>
                <button type="button" class="dropdown-item" data-bs-theme-value="auto" aria-pressed="false">
                  <span class="theme-icon d-flex fs-base me-2">
                    <i class="fi-auto"></i>
                  </span>
                  <span class="theme-label">Auto</span>
                  <i class="item-active-indicator fi-check ms-auto"></i>
                </button>
              </li>
            </ul>
          </div>

          <!-- Account button -->
          <a class="btn btn-icon btn-outline-secondary fs-lg border-0 animate-shake me-2"href="{{ route('login') }}"
 aria-label="Sign in to account">
            <i class="fi-user animate-target"></i>
          </a>

          <!-- Add property button  -->
          <a class="btn btn-primary animate-scale" href="add-property-type.html">
            <i class="fi-plus fs-lg animate-target ms-n2 me-1 me-sm-2"></i>
            Add<span class="d-none d-xl-inline ms-1">property</span>
          </a>
        </div>
   
  </div>
</header>
