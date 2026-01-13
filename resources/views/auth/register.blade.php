@extends('layouts.auth')

@section('title', 'Propsgh | Create Account')
@section('meta-description', 'Create your Propsgh account to list or book properties and shortlets.')
@section('meta-keywords', 'propsgh, signup, register, rentals, apartments, real estate, booking')

@push('styles')
<style>
    .auth-register {
        --auth-accent: #f97316;
        --auth-accent-strong: #ea580c;
        --auth-cool: #0ea5e9;
        --auth-ink: #0f172a;
        --auth-muted: #475569;
    }
    .auth-register .auth-left {
        max-width: 520px;
    }
    .auth-register .auth-intro {
        max-width: 28rem;
    }
    .auth-register .benefits-wrap {
        max-width: 1034px;
    }
    .auth-register .auth-panel {
        position: relative;
        padding: 1.75rem;
        border-radius: 1.6rem;
        background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
        border: 1px solid rgba(226, 232, 240, 0.9);
        box-shadow: 0 30px 60px rgba(15, 23, 42, 0.12);
    }
    .auth-register .auth-panel::after {
        content: "";
        position: absolute;
        top: -45%;
        right: -25%;
        width: 260px;
        height: 260px;
        border-radius: 999px;
        background: radial-gradient(circle, rgba(14, 165, 233, 0.18), transparent 65%);
        pointer-events: none;
    }
    .auth-register .auth-panel > * {
        position: relative;
        z-index: 1;
    }
    .auth-register .auth-panel .form-control {
        border-radius: 0.95rem;
        border-color: rgba(148, 163, 184, 0.55);
        background: #fbfdff;
        box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.6);
        transition: border-color 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
    }
    .auth-register .auth-panel .form-control:focus {
        border-color: rgba(14, 165, 233, 0.55);
        background: #ffffff;
        box-shadow: 0 0 0 0.2rem rgba(14, 165, 233, 0.12);
    }
    .auth-register .auth-chip {
        background: #ffffff;
        border: 1px solid rgba(148, 163, 184, 0.35);
        color: var(--auth-ink);
    }
    .auth-register .benefits-shell {
        position: relative;
        border-radius: 2.2rem;
        padding: 2.6rem;
        background:
            radial-gradient(circle at top right, rgba(14, 165, 233, 0.18), transparent 55%),
            radial-gradient(circle at bottom left, rgba(249, 115, 22, 0.16), transparent 50%),
            linear-gradient(160deg, #f8fbff 0%, #f2f6ff 45%, #f7f3ff 100%);
        border: 1px solid rgba(226, 232, 240, 0.85);
        box-shadow: 0 35px 80px rgba(15, 23, 42, 0.14);
        overflow: hidden;
    }
    .auth-register .benefits-shell::before,
    .auth-register .benefits-shell::after {
        content: "";
        position: absolute;
        width: 240px;
        height: 240px;
        border-radius: 999px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.7), transparent 65%);
        opacity: 0.85;
        pointer-events: none;
    }
    .auth-register .benefits-shell::before {
        top: -120px;
        right: -80px;
    }
    .auth-register .benefits-shell::after {
        bottom: -140px;
        left: -90px;
    }
    .auth-register .benefits-shell > * {
        position: relative;
        z-index: 1;
    }
    .auth-register .benefits-badge {
        background: rgba(14, 165, 233, 0.14);
        color: #0369a1;
        border: 1px solid rgba(14, 165, 233, 0.28);
    }
    .auth-register .benefits-title {
        letter-spacing: -0.02em;
    }
    .auth-register .benefit-card {
        background: rgba(255, 255, 255, 0.95);
        border: 1px solid rgba(148, 163, 184, 0.35);
        border-radius: 1.35rem;
        padding: 1.15rem 1.25rem;
        box-shadow: 0 20px 40px rgba(15, 23, 42, 0.08);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        height: 100%;
    }
    .auth-register .benefit-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 25px 50px rgba(15, 23, 42, 0.12);
    }
    .auth-register .benefit-icon {
        width: 46px;
        height: 46px;
        border-radius: 1rem;
        background: rgba(14, 165, 233, 0.12);
        color: #0284c7;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .auth-register .benefit-stats {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 0.6rem;
    }
    .auth-register .benefit-stat {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.35rem 0.9rem;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.92);
        border: 1px solid rgba(148, 163, 184, 0.28);
        color: var(--auth-ink);
        font-size: 0.78rem;
    }
    @media (max-width: 575.98px) {
        .auth-register .auth-panel {
            padding: 1.25rem;
        }
    }
    @media (max-width: 991.98px) {
        .auth-register .benefits-shell {
            padding: 1.6rem;
            border-radius: 1.6rem;
        }
    }
</style>
@endpush

@section('content')
<main class="content-wrapper w-100 px-3 ps-lg-5 pe-lg-4 mx-auto auth-wrapper auth-register" style="max-width: 1920px">
    <div class="row g-4 g-lg-5 align-items-stretch">
        <!-- Left: Form -->
        <div class="col-lg-5">
            <div class="d-flex flex-column min-vh-100 py-4 auth-left">
                <header class="px-0 pb-4 mb-2 mb-md-3 mb-lg-4">
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

                <div class="auth-intro">
                    <span class="badge-soft mb-2">Create account</span>
                    <h1 class="display-6 fw-semibold text-dark-emphasis mb-2">Join Propsgh</h1>
                    <p class="text-body-secondary mb-3">
                        Save listings, schedule tours, and book shortlets faster.
                    </p>
                    <div class="d-flex flex-wrap gap-2">
                        <span class="badge auth-chip rounded-pill px-3 py-2">Houses</span>
                        <span class="badge auth-chip rounded-pill px-3 py-2">Apartments</span>
                        <span class="badge auth-chip rounded-pill px-3 py-2">Shortlets</span>
                    </div>
                    <div class="nav fs-sm">
                        I already have an account
                        <a class="nav-link text-decoration-underline p-0 ms-2" href="{{ route('login') }}">Sign in</a>
                    </div>
                    <div class="nav fs-sm mt-3 d-lg-none">
                        <span class="me-2">Want to see benefits?</span>
                        <a class="nav-link text-decoration-underline p-0" href="#benefits" data-bs-toggle="offcanvas" aria-controls="benefits">
                            Explore benefits
                        </a>
                    </div>
                </div>

                <div class="auth-panel mt-4">
                    <form class="needs-validation" novalidate method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="position-relative mb-4">
                            <label for="name" class="form-label fs-sm text-body-secondary mb-1">Full name</label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                class="form-control form-control-lg @error('name') is-invalid @enderror"
                                placeholder="Your full name"
                                value="{{ old('name') }}"
                                required
                                autocomplete="name"
                                autofocus
                            >
                            <div class="invalid-tooltip bg-transparent py-0">Please enter your name.</div>
                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

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
                                inputmode="email"
                                autocapitalize="none"
                                spellcheck="false"
                                autocomplete="email"
                            >
                            <div class="invalid-tooltip bg-transparent py-0">Enter a valid email address.</div>
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
                                    placeholder="Minimum 8 characters"
                                    required
                                    autocomplete="new-password"
                                >
                                <div class="invalid-tooltip bg-transparent py-0">Password must be at least 8 characters.</div>
                                <label class="password-toggle-button fs-lg" aria-label="Show/hide password">
                                    <input type="checkbox" class="btn-check">
                                </label>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label fs-sm text-body-secondary mb-1">Confirm password</label>
                            <div class="password-toggle">
                                <input
                                    type="password"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    class="form-control form-control-lg @error('password_confirmation') is-invalid @enderror"
                                    placeholder="Retype your password"
                                    required
                                    autocomplete="new-password"
                                >
                                <div class="invalid-tooltip bg-transparent py-0">Passwords should match.</div>
                                <label class="password-toggle-button fs-lg" aria-label="Show/hide password">
                                    <input type="checkbox" class="btn-check">
                                </label>
                            </div>
                            @error('password_confirmation')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex flex-column gap-2 mb-4">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="save-pass">
                                <label for="save-pass" class="form-check-label">Remember this device</label>
                            </div>
                            <div class="form-check">
                                <input
                                    type="checkbox"
                                    class="form-check-input @error('terms') is-invalid @enderror"
                                    id="terms"
                                    name="terms"
                                    value="1"
                                    {{ old('terms') ? 'checked' : '' }}
                                    required
                                >
                                <label for="terms" class="form-check-label">
                                    I accept the
                                    <a class="text-dark-emphasis" href="{{ url('/terms') }}">Terms</a>
                                    &amp;
                                    <a class="text-dark-emphasis" href="{{ url('/privacy') }}">Privacy Policy</a>
                                </label>
                                @error('terms')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @else
                                    <div class="invalid-feedback">You must accept the Terms &amp; Privacy to continue.</div>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-lg btn-primary w-100">
                            Create an account
                            <i class="fi-chevron-right fs-lg ms-1 me-n1"></i>
                        </button>

                        <div class="d-flex flex-wrap gap-2 mt-3">
                            <span class="badge auth-chip d-inline-flex align-items-center gap-2 rounded-pill px-3 py-2">
                                <i class="fi-shield fs-sm"></i>
                                Secure signup
                            </span>
                            <span class="badge auth-chip d-inline-flex align-items-center gap-2 rounded-pill px-3 py-2">
                                <i class="fi-clock fs-sm"></i>
                                2 min setup
                            </span>
                        </div>
                    </form>
                </div>

                <footer class="mt-auto pt-4">
                    <div class="nav mb-3">
                        <a class="nav-link text-decoration-underline p-0" href="{{ route('contact') }}">Need help?</a>
                    </div>
                    <p class="fs-xs mb-0">© {{ now()->year }} Propsgh. All rights reserved.</p>
                </footer>
            </div>
        </div>

        <!-- Right: Benefits -->
        <div class="col-lg-7 d-lg-flex align-items-center">
            <div class="offcanvas-lg offcanvas-end w-100 py-lg-4 ms-auto benefits-wrap" id="benefits" style="max-width: 1034px">
                <div class="offcanvas-header justify-content-end position-relative z-2 p-3 d-lg-none">
                    <button type="button" class="btn btn-icon btn-outline-dark text-dark border-dark bg-transparent rounded-circle"
                            data-bs-dismiss="offcanvas" data-bs-target="#benefits" aria-label="Close">
                        <i class="fi-close fs-lg"></i>
                    </button>
                </div>

                <div class="offcanvas-body position-relative z-2 d-lg-flex flex-column align-items-center justify-content-center h-100 pt-2 px-3 p-lg-0">
                    <div class="benefits-shell w-100">
                        <div class="text-center mb-4">
                            <span class="badge benefits-badge rounded-pill px-3 py-2 mb-3">Propsgh membership</span>
                            <h2 class="benefits-title display-6 fw-semibold text-dark-emphasis mb-2">Move faster, book smarter</h2>
                            <p class="text-secondary mb-0">One account to track homes, rentals, and shortlets.</p>
                        </div>

                        <div class="benefit-stats mb-4">
                            <span class="benefit-stat"><i class="fi-shield fs-sm"></i> Verified listings</span>
                            <span class="benefit-stat"><i class="fi-mail fs-sm"></i> Instant alerts</span>
                            <span class="benefit-stat"><i class="fi-clock fs-sm"></i> Flexible stays</span>
                        </div>

                        <div class="mx-auto" style="max-width: 820px">
                            <div class="row row-cols-1 row-cols-sm-2 g-3 g-md-4">
                                @php
                                    $benefits = [
                                        ['icon' => 'fi-bookmark', 'title' => 'Save favorite listings'],
                                        ['icon' => 'fi-mail',     'title' => 'Get new listing alerts'],
                                        ['icon' => 'fi-home',     'title' => 'Schedule property tours'],
                                        ['icon' => 'fi-clock',    'title' => 'Track shortlet dates'],
                                        ['icon' => 'fi-tag',      'title' => 'Exclusive member offers'],
                                        ['icon' => 'fi-heart',    'title' => 'Create wishlists fast'],
                                    ];
                                @endphp

                                @foreach ($benefits as $b)
                                    <div class="col">
                                        <div class="benefit-card">
                                            <div class="benefit-icon mb-3">
                                                <i class="{{ $b['icon'] }} fs-4"></i>
                                            </div>
                                            <h3 class="h6 mb-0 text-dark-emphasis">{{ $b['title'] }}</h3>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
