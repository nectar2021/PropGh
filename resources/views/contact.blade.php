<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover">
  <title>Propsgh | Contact</title>
  <meta name="description" content="Get in touch with Propsgh for bookings, listings, and support.">

  <link rel="icon" type="image/png" href="{{ asset('assets/app-icons/icon-32x32.png') }}" sizes="32x32">
  <script src="{{ asset('assets/js/theme-switcher.js') }}"></script>
  <link rel="preload" href="{{ asset('assets/fonts/inter-variable-latin.woff2') }}" as="font" type="font/woff2" crossorigin>
  <link rel="stylesheet" href="{{ asset('assets/icons/finder-icons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/theme.min.css') }}">

  <style>
    :root {
      --pg-shell-bg: #f3f4f6;
      --pg-border-subtle: #e5e7eb;
      --pg-border-strong: #d1d5db;
      --pg-card-radius: 1.25rem;
      --pg-soft-shadow: 0 16px 40px rgba(15,23,42,.06);
      --pg-soft-shadow-sm: 0 12px 28px rgba(15,23,42,.06);
      --pg-muted: #6b7280;
      --pg-muted-soft: #9ca3af;
      --pg-heading: #111827;
    }

    body {
      background: var(--pg-shell-bg);
    }

    .page-shell {
      padding-top: 2.5rem;
      padding-bottom: 3.5rem;
    }

    .page-head {
      border-radius: 1.5rem;
      padding: 1.6rem 1.8rem;
      margin-bottom: 1.9rem;
      background:
        radial-gradient(140% 180% at 0% -40%, rgba(37,99,235,.08), transparent 60%),
        radial-gradient(120% 220% at 110% -60%, rgba(248,250,252,1), transparent 60%),
        #ffffff;
      border: 1px solid rgba(229,231,235,.9);
      box-shadow: 0 18px 40px rgba(15,23,42,.04);
    }

    .page-head h1 {
      letter-spacing: -0.03em;
      color: var(--pg-heading);
    }

    .page-sub {
      font-size: .94rem;
      color: var(--pg-muted);
    }

    .page-chips {
      display: flex;
      flex-wrap: wrap;
      gap: .45rem;
      margin-top: .75rem;
    }

    .page-chip {
      border-radius: 999px;
      border: 1px solid rgba(209,213,219,.9);
      background: rgba(249,250,251,.96);
      padding: .18rem .7rem;
      font-size: .78rem;
      color: #4b5563;
      display: inline-flex;
      align-items: center;
      gap: .35rem;
    }

    .page-chip i {
      font-size: .85rem;
    }

    .page-meta {
      font-size: .86rem;
      color: var(--pg-muted);
    }

    .page-meta span + span {
      position: relative;
      padding-left: 1rem;
      margin-left: .6rem;
    }

    .page-meta span + span::before {
      content: '';
      position: absolute;
      left: 0;
      top: 50%;
      width: 4px;
      height: 4px;
      border-radius: 999px;
      background: #d1d5db;
      transform: translateY(-50%);
    }

    .contact-card,
    .contact-side-card {
      border-radius: var(--pg-card-radius);
      background: #ffffff;
      border: 1px solid var(--pg-border-subtle);
      box-shadow: var(--pg-soft-shadow);
    }

    .contact-side-card {
      box-shadow: var(--pg-soft-shadow-sm);
    }

    .contact-pill {
      border-radius: 1rem;
      padding: .15rem .7rem;
      background: #eff6ff;
      color: #1d4ed8;
      font-size: .78rem;
      display: inline-flex;
      align-items: center;
      gap: .25rem;
    }

    .contact-pill i {
      font-size: .9rem;
    }

    .contact-highlight {
      display: flex;
      flex-direction: column;
      gap: .4rem;
    }

    .contact-highlight-label {
      font-size: .8rem;
      text-transform: uppercase;
      letter-spacing: .08em;
      color: var(--pg-muted-soft);
    }

    .contact-highlight-value {
      font-weight: 600;
      color: var(--pg-heading);
    }

    .contact-map {
      border-radius: 1.1rem;
      overflow: hidden;
      box-shadow: 0 14px 34px rgba(15,23,42,.12);
    }

    .support-list li {
      font-size: .88rem;
      padding-block: .2rem;
      color: #374151;
    }

    .support-list li span:first-child {
      color: var(--pg-muted);
    }

    .support-badge {
      border-radius: 999px;
      background: #ecfdf5;
      color: #166534;
      font-size: .74rem;
      padding: .18rem .6rem;
    }

    .quick-link {
      font-size: .9rem;
    }

    .quick-link i {
      font-size: .95rem;
    }

    .form-control-lg,
    .form-select-lg {
      border-radius: .8rem;
      font-size: .9rem;
    }

    .form-control-lg:focus,
    .form-select-lg:focus {
      box-shadow: 0 0 0 .15rem rgba(37,99,235,.15);
    }

    .btn-primary.btn-lg {
      border-radius: .9rem;
      padding-inline: 1.7rem;
    }

    .contact-footnote {
      font-size: .78rem;
      color: var(--pg-muted-soft);
    }

    @media (max-width: 991.98px) {
      .page-shell {
        padding-top: 1.8rem;
      }
      .page-head {
        padding: 1.25rem 1.4rem;
        margin-bottom: 1.5rem;
      }
    }
  </style>
</head>
<body>
  @include('partials.header')

  <main class="content-wrapper">
    <section class="container page-shell">

      {{-- Hero / page head --}}
      <div class="page-head">
        <div class="row g-4 align-items-center">
          <div class="col-lg-7">
            <nav aria-label="breadcrumb" class="mb-2">
              <ol class="breadcrumb mb-1">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Contact</li>
              </ol>
            </nav>
            <h1 class="h3 h-lg-2 fw-bold mb-2">Let’s talk about your next stay or listing.</h1>
            <p class="page-sub mb-3">
              Our team is on hand to help with bookings, listings, corporate stays and anything property related.
            </p>

            <div class="page-chips">
              <span class="page-chip">
                <i class="fi-hotel"></i> Booking support
              </span>
              <span class="page-chip">
                <i class="fi-home"></i> List my property
              </span>
              <span class="page-chip">
                <i class="fi-briefcase"></i> Corporate &amp; partnerships
              </span>
            </div>
          </div>

          <div class="col-lg-5">
            <div class="row gy-3 gx-4 justify-content-lg-end">
              <div class="col-6 col-lg-7">
                <div class="contact-highlight">
                  <div class="contact-highlight-label">Call us</div>
                  <div class="contact-highlight-value d-flex flex-column">
                    <a class="text-body fw-semibold text-decoration-none" href="tel:+233200000000">
                      +233 20 000 0000
                    </a>
                    <span class="contact-footnote">Average response &lt; 5 minutes</span>
                  </div>
                </div>
              </div>
              <div class="col-6 col-lg-5">
                <div class="contact-highlight">
                  <div class="contact-highlight-label">Email</div>
                  <div class="contact-highlight-value d-flex flex-column">
                    <a class="text-body fw-semibold text-decoration-none" href="mailto:hello@propsgh.com">
                      hello@propsgh.com
                    </a>
                    <span class="contact-footnote">We reply within 1 business day</span>
                  </div>
                </div>
              </div>
              <div class="col-12 mt-1">
                <div class="d-flex align-items-center gap-2 flex-wrap">
                  <span class="contact-pill">
                    <i class="fi-whatsapp"></i> WhatsApp support
                  </span>
                  <span class="page-meta">
                    <span>Airport City, Accra, Ghana</span>
                    <span>Open 7 days</span>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- Main content --}}
      <div class="row g-4 g-xl-5 align-items-start">
        {{-- Form --}}
        <div class="col-lg-7">
          <livewire:contact-form />
        </div>

        {{-- Side info --}}
        <div class="col-lg-5">
          <div class="contact-side-card p-4 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h3 class="h5 fw-semibold mb-0">Support hours</h3>
              <span class="support-badge">
                <i class="fi-headset me-1"></i> Live support
              </span>
            </div>

            <ul class="list-unstyled support-list mb-4">
              <li class="d-flex justify-content-between">
                <span>Mon – Fri</span><span>08:00 – 20:00 GMT</span>
              </li>
              <li class="d-flex justify-content-between">
                <span>Sat</span><span>09:00 – 18:00 GMT</span>
              </li>
              <li class="d-flex justify-content-between">
                <span>Sun</span><span>10:00 – 16:00 GMT</span>
              </li>
            </ul>

            <h3 class="h6 fw-semibold mb-2">Quick links</h3>
            <div class="d-flex flex-column gap-2 mb-3">
              <a class="text-body text-decoration-none quick-link" href="{{ route('properties.index') }}">
                <i class="fi-search me-2 text-primary"></i>Browse properties
              </a>
              <a class="text-body text-decoration-none quick-link" href="{{ route('properties.index') }}">
                <i class="fi-plus me-2 text-primary"></i>List a property with Propsgh
              </a>
              <a class="text-body text-decoration-none quick-link" href="{{ route('login') }}">
                <i class="fi-user me-2 text-primary"></i>Sign in to your account
              </a>
            </div>

            <h3 class="h6 fw-semibold mb-2">Prefer WhatsApp?</h3>
            <p class="text-body-secondary mb-0">
              Message us directly on <span class="fw-semibold">+233 20 000 0000</span> and our team will share available options, photos and rates in real time.
            </p>
          </div>

          <div class="contact-side-card p-4">
            <h3 class="h6 fw-semibold mb-3">Our Accra office</h3>
            <p class="text-body mb-2">
              Airport City, Accra, Ghana<br>
              <span class="text-body-secondary">By appointment only</span>
            </p>
            <div class="contact-map mt-2">
              <img src="{{ asset('assets/img/home/real-estate/cities/03.jpg') }}"
                   alt="Propsgh office map"
                   class="w-100 h-100"
                   style="object-fit: cover;">
            </div>
          </div>
        </div>
      </div>

    </section>
  </main>

  @include('partials.footer')

  <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('assets/js/theme.min.js') }}"></script>
</body>
</html>
