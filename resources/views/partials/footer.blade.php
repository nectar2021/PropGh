<!-- Page footer -->
<footer class="footer footer-propsgh bg-body border-top pt-5" data-bs-theme="dark">
  <div class="container pt-sm-2 pt-md-3 pt-lg-4 pb-4 position-relative">

    <!-- Footer hero -->
    <div class="footer-hero rounded-4 p-4 p-lg-5 mb-4 position-relative">
      <div class="row g-4 align-items-center position-relative">
        <div class="col-lg-7">
          <span class="badge bg-primary-subtle text-primary-emphasis footer-hero-badge mb-2">Propsgh Insider</span>
          <h3 class="h4 text-body-emphasis mb-2">Get curated stays and investment alerts.</h3>
          <p class="text-body-secondary mb-0">Weekly drops of verified listings, pricing trends, and shortlet openings across Ghana.</p>
        </div>
        <div class="col-lg-5">
          <form class="footer-subscribe d-flex flex-column flex-sm-row gap-2" novalidate>
            <div class="position-relative flex-grow-1">
              <i class="fi-mail footer-subscribe-icon"></i>
              <input type="email" class="form-control form-control-lg" placeholder="Email address" required>
            </div>
            <button type="submit" class="btn btn-primary btn-lg">Subscribe</button>
          </form>
          <div class="text-body-tertiary fs-xs mt-2">No spam. Unsubscribe anytime.</div>
        </div>
      </div>
    </div>

    <div class="row gy-4 gy-lg-4 align-items-start">

      <!-- Brand + contacts -->
      <div class="col-lg-4 col-md-6">
        <a class="d-inline-flex align-items-center text-decoration-none mb-3" href="{{ route('home') }}">
          <span class="footer-logo-wrap">
            <img
              src="{{ asset('assets/img/francee.jpeg') }}"
              alt="Propsgh"
              class="footer-logo"
            >
          </span>
          <span class="ms-3">
            <span class="d-block fs-4 fw-semibold text-body-emphasis">Propsgh</span>
            <small class="text-body-secondary">Discover | Book | Host</small>
          </span>
        </a>
        <p class="text-body-secondary mb-3" style="max-width: 320px;">
          Premium stays and investments across Ghana — curated, verified, and supported by local experts.
        </p>
        <ul class="list-unstyled mt-2 mb-0 text-body">
          <li class="d-flex align-items-center mb-2">
            <i class="fi-mail fs-lg text-body-secondary me-2"></i>
            <a class="text-body-emphasis text-decoration-none hover-effect-underline" href="mailto:hello@propsgh.com">hello@propsgh.com</a>
          </li>
          <li class="d-flex align-items-center">
            <i class="fi-phone-call fs-lg text-body-secondary me-2"></i>
            <a class="text-body-emphasis text-decoration-none hover-effect-underline" href="tel:+233200000000">+233 20 000 0000</a>
          </li>
        </ul>
        <div class="d-flex gap-2 mt-3">
          <a class="btn btn-icon btn-outline-secondary border-0 rounded-circle" href="#!" aria-label="Instagram"><i class="fi-instagram"></i></a>
          <a class="btn btn-icon btn-outline-secondary border-0 rounded-circle" href="#!" aria-label="Facebook"><i class="fi-facebook"></i></a>
          <a class="btn btn-icon btn-outline-secondary border-0 rounded-circle" href="#!" aria-label="Twitter"><i class="fi-x"></i></a>
        </div>
        <div class="footer-metrics mt-4">
          <div>
            <div class="h6 mb-1">4.9/5</div>
            <div class="text-body-secondary fs-xs">Guest rating</div>
          </div>
          <div>
            <div class="h6 mb-1">1,200+</div>
            <div class="text-body-secondary fs-xs">Verified homes</div>
          </div>
          <div>
            <div class="h6 mb-1">24/7</div>
            <div class="text-body-secondary fs-xs">Support</div>
          </div>
        </div>
      </div>

      <!-- Explore -->
      <div class="col-6 col-md-3 col-lg-2">
        <h6 class="text-body-emphasis mb-3">Explore</h6>
        <ul class="nav flex-column gap-2">
          <li><a class="nav-link p-0 text-body hover-effect-underline" href="{{ route('home') }}">Home</a></li>
          <li><a class="nav-link p-0 text-body hover-effect-underline" href="{{ route('properties.index') }}">Browse properties</a></li>
          <li><a class="nav-link p-0 text-body hover-effect-underline" href="{{ route('contact') }}">Contact</a></li>
        </ul>
      </div>

      <!-- Stays -->
      <div class="col-6 col-md-3 col-lg-2">
        <h6 class="text-body-emphasis mb-3">Stays</h6>
        <ul class="nav flex-column gap-2">
          <li><a class="nav-link p-0 text-body hover-effect-underline" href="#!">Apartments</a></li>
          <li><a class="nav-link p-0 text-body hover-effect-underline" href="#!">Houses</a></li>
          <li><a class="nav-link p-0 text-body hover-effect-underline" href="#!">Shortlets</a></li>
          <li><a class="nav-link p-0 text-body hover-effect-underline" href="#!">Commercial</a></li>
          <li><a class="nav-link p-0 text-body hover-effect-underline" href="#!">Land</a></li>
        </ul>
      </div>

      <!-- Support -->
      <div class="col-6 col-md-3 col-lg-2">
        <h6 class="text-body-emphasis mb-3">Support</h6>
        <ul class="nav flex-column gap-2">
          <li><a class="nav-link p-0 text-body hover-effect-underline" href="#!">Help center</a></li>
          <li><a class="nav-link p-0 text-body hover-effect-underline" href="#!">FAQs</a></li>
          <li><a class="nav-link p-0 text-body hover-effect-underline" href="#!">Terms</a></li>
          <li><a class="nav-link p-0 text-body hover-effect-underline" href="#!">Privacy</a></li>
          <li><a class="nav-link p-0 text-body hover-effect-underline" href="#!">Report a listing</a></li>
        </ul>
      </div>

      <!-- Hosting -->
      <div class="col-6 col-md-3 col-lg-2">
        <h6 class="text-body-emphasis mb-3">Hosting</h6>
        <p class="text-body-secondary fs-sm mb-3">Earn more from verified tenants and shortlet guests.</p>
        <div class="d-flex flex-column gap-2">
          <a class="btn btn-primary btn-sm" href="{{ route('properties.index') }}">
            <i class="fi-plus me-2"></i>
            List a property
          </a>
          <a class="btn btn-outline-secondary btn-sm" href="{{ route('contact') }}">Talk to us</a>
        </div>
      </div>
    </div>

    <!-- Copyright -->
    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-2 pt-4 pb-md-2 mt-3">
      <p class="text-body-secondary fs-sm mb-0">
        © {{ now()->year }} Propsgh. All rights reserved.
      </p>
      <div class="d-flex gap-3 fs-sm">
        <a class="text-body-secondary text-decoration-none hover-effect-underline" href="#!">Terms</a>
        <a class="text-body-secondary text-decoration-none hover-effect-underline" href="#!">Privacy</a>
        <a class="text-body-secondary text-decoration-none hover-effect-underline" href="#!">Sitemap</a>
      </div>
    </div>
  </div>
</footer>
