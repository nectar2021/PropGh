<!-- Page footer -->
<footer class="footer bg-body border-top pt-5" data-bs-theme="dark">
  <div class="container pt-sm-2 pt-md-3 pt-lg-4 pb-4">
    <div class="row gy-4 gy-lg-4 align-items-start">

      <!-- Brand + contacts -->
      <div class="col-lg-3 col-md-6">
        <a class="d-inline-flex align-items-center text-decoration-none mb-3" href="{{ route('home') }}">
          <span
            class="d-inline-flex align-items-center justify-content-center bg-body rounded-4 shadow-sm border border-light-subtle"
            style="height: 68px; width: 68px;"
          >
            <img
              src="{{ asset('assets/img/props.jpeg') }}"
              alt="Propsgh"
              class="img-fluid"
              style="height: 56px; width: 56px; border-radius: 1.25rem; object-fit: cover;"
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
      </div>

      <!-- Explore -->
      <div class="col-6 col-md-4 col-lg-2">
        <h6 class="text-body-emphasis mb-3">Explore</h6>
        <ul class="nav flex-column gap-2">
          <li><a class="nav-link p-0 text-body hover-effect-underline" href="{{ route('home') }}">Home</a></li>
          <li><a class="nav-link p-0 text-body hover-effect-underline" href="{{ route('properties.index') }}">Browse properties</a></li>
          <li><a class="nav-link p-0 text-body hover-effect-underline" href="#contact">Contact</a></li>
          <li><a class="nav-link p-0 text-body hover-effect-underline" href="#!">Blog &amp; guides</a></li>
        </ul>
      </div>

      <!-- Stays -->
      <div class="col-6 col-md-4 col-lg-2">
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
      <div class="col-12 col-md-4 col-lg-2">
        <h6 class="text-body-emphasis mb-3">Support</h6>
        <ul class="nav flex-column gap-2">
          <li><a class="nav-link p-0 text-body hover-effect-underline" href="#!">Help center</a></li>
          <li><a class="nav-link p-0 text-body hover-effect-underline" href="#!">FAQs</a></li>
          <li><a class="nav-link p-0 text-body hover-effect-underline" href="#!">Terms</a></li>
          <li><a class="nav-link p-0 text-body hover-effect-underline" href="#!">Privacy</a></li>
        </ul>
      </div>

      <!-- CTA -->
      <div class="col-12 col-lg-3">
        <div class="bg-body-tertiary rounded-4 p-4 h-100 d-flex flex-column justify-content-center shadow-sm" style="min-height: 200px;">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <h5 class="text-body-emphasis mb-0">List your property</h5>
            <span class="badge bg-primary-subtle text-primary-emphasis rounded-pill">Hosts</span>
          </div>
          <p class="text-body-secondary mb-3">Reach renters and buyers looking for verified stays across Ghana.</p>
          <div class="d-flex flex-wrap gap-2">
            <a class="btn btn-primary" href="{{ route('properties.index') }}">
              <i class="fi-plus me-2"></i>
              Start listing
            </a>
            <a class="btn btn-outline-secondary" href="#contact">Talk to us</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Copyright -->
    <div class="text-center pt-4 pb-md-2 mt-3">
      <p class="text-body-secondary fs-sm mb-0">
        © {{ now()->year }} Propsgh. All rights reserved.
      </p>
    </div>
  </div>
</footer>
