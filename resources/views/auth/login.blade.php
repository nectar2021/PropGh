@extends('layouts.auth')

@section('title', 'Propsgh | Sign In')
@section('meta-description', 'Sign in to manage your Propsgh properties, rentals, and shortlet bookings.')
@section('meta-keywords', 'propsgh, login, rentals, apartments, real estate, booking')

@push('styles')
<style>
    .auth-shell {
        --auth-accent: #f97316;
        --auth-accent-strong: #ea580c;
        --auth-cool: #0ea5e9;
        --auth-ink: #0f172a;
        --auth-muted: #475569;
    }
    .auth-shell .auth-left {
        max-width: 520px;
    }
    .auth-shell .auth-intro {
        max-width: 28rem;
    }
    .auth-shell .auth-chip {
        background: #ffffff;
        border: 1px solid rgba(148, 163, 184, 0.35);
        color: var(--auth-ink);
    }
    .auth-shell .auth-panel {
        position: relative;
        padding: 1.6rem;
        border-radius: 1.6rem;
        background: rgba(255, 255, 255, 0.98);
        border: 1px solid rgba(226, 232, 240, 0.9);
        box-shadow: 0 30px 60px rgba(15, 23, 42, 0.12);
    }
    .auth-shell .auth-panel .form-control {
        border-radius: 0.95rem;
        border-color: rgba(148, 163, 184, 0.55);
        background: #fbfdff;
        box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.6);
        transition: border-color 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
    }
    .auth-shell .auth-panel .form-control:focus {
        border-color: rgba(14, 165, 233, 0.55);
        background: #ffffff;
        box-shadow: 0 0 0 0.2rem rgba(14, 165, 233, 0.12);
    }
    .auth-shell .auth-meta {
        border-top: 1px dashed rgba(226, 232, 240, 0.8);
        margin-top: 1.25rem;
        padding-top: 1rem;
    }
    .auth-shell .auth-trust-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.8rem 0.9rem;
        background: rgba(255, 255, 255, 0.92);
        border-radius: 1rem;
        border: 1px solid rgba(226, 232, 240, 0.9);
        color: var(--auth-muted);
        font-size: 0.86rem;
    }
    .auth-shell .auth-trust-icon {
        height: 34px;
        width: 34px;
        border-radius: 0.85rem;
        background: rgba(14, 165, 233, 0.12);
        color: #0284c7;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .auth-shell .auth-hero {
        position: relative;
        height: 100%;
        min-height: 640px;
        border-radius: 2.4rem;
        overflow: hidden;
        background: #0f172a;
        box-shadow: 0 35px 80px rgba(15, 23, 42, 0.35);
    }
    .auth-shell .auth-hero-img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        filter: saturate(1.05);
    }
    .auth-shell .auth-hero-sheen {
        position: absolute;
        inset: 0;
        background: linear-gradient(125deg, rgba(15, 23, 42, 0.88) 0%, rgba(15, 23, 42, 0.35) 45%, rgba(14, 165, 233, 0.25) 100%);
    }
    .auth-shell .auth-hero-content {
        position: absolute;
        inset: 0;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        gap: 2rem;
        padding: 2.75rem;
        color: #ffffff;
    }
    .auth-shell .auth-hero-badge {
        background: rgba(255, 255, 255, 0.16);
        border: 1px solid rgba(255, 255, 255, 0.35);
        color: #ffffff;
    }
    .auth-shell .auth-hero-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 1rem;
    }
    .auth-shell .auth-hero-card {
        background: rgba(248, 242, 232, 0.92);
        border: 1px solid rgba(201, 163, 106, 0.45);
        border-radius: 1.2rem;
        padding: 1rem;
        color: #3b2f1e;
        box-shadow: 0 18px 45px rgba(15, 23, 42, 0.25);
        backdrop-filter: blur(6px);
    }
    .auth-shell .auth-hero-card-icon {
        height: 36px;
        width: 36px;
        border-radius: 0.85rem;
        background: rgba(201, 163, 106, 0.2);
        color: #b7772b;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .auth-shell .auth-hero-card .text-body-secondary {
        color: #6b553d;
    }
    @media (prefers-reduced-motion: no-preference) {
        .auth-shell .auth-reveal {
            opacity: 0;
            transform: translateY(10px);
            animation: authFade 0.7s ease forwards;
        }
    }
    .auth-shell .auth-reveal[data-delay="1"] { animation-delay: 0.08s; }
    .auth-shell .auth-reveal[data-delay="2"] { animation-delay: 0.16s; }
    .auth-shell .auth-reveal[data-delay="3"] { animation-delay: 0.24s; }
    .auth-shell .auth-reveal[data-delay="4"] { animation-delay: 0.32s; }
    .auth-shell .auth-reveal[data-delay="5"] { animation-delay: 0.4s; }
    @keyframes authFade {
        to { opacity: 1; transform: translateY(0); }
    }
    @media (max-width: 575.98px) {
        .auth-shell .auth-panel {
            padding: 1.25rem;
        }
    }
</style>
@endpush

@section('content')
<main class="content-wrapper w-100 px-3 ps-lg-5 pe-lg-4 mx-auto auth-wrapper auth-shell">
    <div class="row g-4 g-lg-5 align-items-stretch">
        <!-- Left column -->
        <div class="col-lg-5">
            <div class="d-flex flex-column min-vh-100 py-4 auth-left">
                <header class="px-0 pb-4 mb-2 mb-md-3 mb-lg-4 auth-reveal" data-delay="1">
                    <a href="{{ url('/') }}"
                       class="d-flex flex-column flex-sm-row align-items-center justify-content-center justify-content-sm-start text-decoration-none gap-3">
                        <div class="brand-logo-wrapper d-flex align-items-center justify-content-center">
                            <img src="{{ asset('assets/img/francee.jpeg') }}" alt="Propsgh Logo">
                        </div>
                        <div class="text-center text-sm-start">
                            <span class="d-block fs-3 fw-semibold text-dark-emphasis">Propsgh</span>
                            <span class="d-none d-sm-block text-body-secondary fs-sm">
                            Properties &amp; shortlet stays made simple.
                            </span>
                        </div>
                    </a>
                </header>

                <div class="auth-intro auth-reveal" data-delay="1">
                    <span class="badge-soft mb-2">Welcome back</span>
                    <h1 class="display-6 fw-semibold text-dark-emphasis mb-2">Sign in to Propsgh</h1>
                    <p class="text-body-secondary mb-3">
                        Manage property listings, rental inquiries, and shortlet bookings in one place.
                    </p>
                    <div class="d-flex flex-wrap gap-2">
                        <span class="badge auth-chip rounded-pill px-3 py-2">Houses</span>
                        <span class="badge auth-chip rounded-pill px-3 py-2">Apartments</span>
                        <span class="badge auth-chip rounded-pill px-3 py-2">Shortlets</span>
                    </div>
                    <div class="nav fs-sm mt-3">
                        New to Propsgh?
                        <a class="nav-link text-decoration-underline p-0 ms-2" href="{{ route('register') }}">Create an account</a>
                    </div>
                </div>

                <div class="auth-panel mt-4 auth-reveal" data-delay="2">
                    <form class="needs-validation" novalidate method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="position-relative mb-4">
                            <label for="email" class="form-label fs-sm text-body-secondary mb-1">Email address</label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="form-control form-control-lg @error('email') is-invalid @enderror"
                                placeholder="you@example.com"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                inputmode="email"
                                autocapitalize="none"
                                spellcheck="false"
                                autocomplete="email"
                            >
                            <div class="invalid-tooltip bg-transparent py-0">Enter a valid email address!</div>
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label fs-sm text-body-secondary mb-1">Password</label>
                            <div class="password-toggle">
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    class="form-control form-control-lg @error('password') is-invalid @enderror"
                                    placeholder="Enter your password"
                                    required
                                    autocomplete="current-password"
                                >
                                <div class="invalid-tooltip bg-transparent py-0">Password is incorrect!</div>
                                <label class="password-toggle-button fs-lg" aria-label="Show/hide password">
                                    <input type="checkbox" class="btn-check">
                                </label>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-2 mb-4">
                            <div class="form-check me-2">
                                <input type="checkbox" class="form-check-input" id="remember-30" name="remember">
                                <label for="remember-30" class="form-check-label">Remember for 30 days</label>
                            </div>
                            <div class="nav">
                                <a class="nav-link animate-underline p-0" href="{{ route('contact') }}">
                                    <span class="animate-target">Need help? Contact support</span>
                                </a>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-lg btn-primary w-100">Sign In</button>
                    </form>

                    <div class="auth-meta d-flex flex-wrap align-items-center justify-content-between gap-2">
                        <span class="fs-sm text-body-secondary">Prefer to browse first?</span>
                        <a class="fs-sm text-decoration-underline" href="{{ route('home') }}">Explore properties</a>
                    </div>
                </div>

                <div class="auth-trust mt-4 auth-reveal" data-delay="3">
                    <div class="row g-3">
                        <div class="col-12 col-sm-6">
                            <div class="auth-trust-item">
                                <span class="auth-trust-icon"><i class="fi-shield fs-sm"></i></span>
                                <span>Property listings with clear details</span>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="auth-trust-item">
                                <span class="auth-trust-icon"><i class="fi-clock fs-sm"></i></span>
                                <span>Flexible rental options</span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="auth-trust-item">
                                <span class="auth-trust-icon"><i class="fi-headset fs-sm"></i></span>
                                <span>Responsive help when you need it</span>
                            </div>
                        </div>
                    </div>
                </div>

                <footer class="mt-auto pt-4">
                    <p class="fs-xs mb-0 text-body-secondary">
                        © {{ now()->year }} Propsgh. All rights reserved.
                    </p>
                </footer>
            </div>
        </div>

        <!-- Right side -->
        <div class="col-lg-7 d-none d-lg-block">
            <div class="h-100 py-4">
                <div class="auth-hero auth-reveal" data-delay="2">
                    <img src="{{ asset('assets/img/jane.jpg') }}" alt="Propsgh properties" class="auth-hero-img">
                    <div class="auth-hero-sheen"></div>
                    <div class="auth-hero-content">
                        <div>
                            <span class="badge auth-hero-badge rounded-pill px-3 py-2">Propsgh properties</span>
                            <h2 class="display-6 fw-semibold mt-3 mb-2 text-white">Find the right property faster</h2>
                            <p class="text-white mb-0">
                                Browse houses, apartments, rentals, and shortlets in one place.
                            </p>
                        </div>
                        <div class="auth-hero-grid">
                            <div class="auth-hero-card">
                                <div class="d-flex align-items-start gap-3">
                                    <span class="auth-hero-card-icon"><i class="fi-search fs-base"></i></span>
                                    <div>
                                        <div class="fw-semibold">Find your next rental</div>
                                        <div class="fs-sm text-body-secondary">Browse houses and apartments with clear pricing and amenities.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="auth-hero-card">
                                <div class="d-flex align-items-start gap-3">
                                    <span class="auth-hero-card-icon"><i class="fi-plus fs-base"></i></span>
                                    <div>
                                        <div class="fw-semibold">List a property</div>
                                        <div class="fs-sm text-body-secondary">Manage listings, inquiries, and availability in minutes.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
