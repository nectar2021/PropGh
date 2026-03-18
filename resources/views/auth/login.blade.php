@extends('layouts.auth')

@section('title', 'Propsgh | Sign In')
@section('meta-description', 'Sign in to manage your Propsgh properties, rentals, and shortlet bookings.')
@section('meta-keywords', 'propsgh, login, rentals, apartments, real estate, booking')

@push('styles')
<style>
    /* ── Login page shell ── */
    .login-shell {
        --ls-dark: #0c1220;
        --ls-slate: #1e293b;
        --ls-muted: #64748b;
        --ls-accent: #f59e0b;
        --ls-accent-hover: #d97706;
        --ls-sky: #0ea5e9;
        --ls-sky-glow: rgba(14, 165, 233, 0.15);
        --ls-surface: #ffffff;
        --ls-border: rgba(226, 232, 240, 0.7);
        min-height: 100vh;
        display: flex;
    }

    /* ── Left: cinematic image panel ── */
    .login-shell .ls-visual {
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        width: 50%;
        background: var(--ls-dark);
        overflow: hidden;
        z-index: 1;
    }
    .login-shell .ls-visual-img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        filter: saturate(1.1) brightness(0.85);
    }
    .login-shell .ls-visual-overlay {
        position: absolute;
        inset: 0;
        background:
            linear-gradient(180deg, rgba(12, 18, 32, 0.45) 0%, rgba(12, 18, 32, 0.15) 40%, rgba(12, 18, 32, 0.72) 100%),
            linear-gradient(135deg, rgba(14, 165, 233, 0.12) 0%, transparent 60%);
    }
    .login-shell .ls-visual-inner {
        position: absolute;
        inset: 0;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 2.5rem 2.75rem;
        color: #ffffff;
        z-index: 2;
    }

    /* Floating stat cards on image panel */
    .login-shell .ls-stat-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.85rem;
    }
    .login-shell .ls-stat-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 1.1rem;
        padding: 1.1rem 1rem;
        text-align: center;
        transition: transform 0.3s ease, background 0.3s ease;
    }
    .login-shell .ls-stat-card:hover {
        transform: translateY(-3px);
        background: rgba(255, 255, 255, 0.16);
    }
    .login-shell .ls-stat-value {
        font-size: 1.65rem;
        font-weight: 700;
        letter-spacing: -0.03em;
        line-height: 1.15;
        color: #ffffff;
    }
    .login-shell .ls-stat-label {
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: rgba(255, 255, 255, 0.65);
        margin-top: 0.3rem;
    }

    /* Testimonial card */
    .login-shell .ls-testimonial {
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 1.25rem;
        padding: 1.35rem 1.5rem;
        margin-top: 1.5rem;
    }
    .login-shell .ls-testimonial-quote {
        font-size: 0.92rem;
        line-height: 1.6;
        color: rgba(255, 255, 255, 0.9);
        font-style: italic;
    }
    .login-shell .ls-testimonial-author {
        display: flex;
        align-items: center;
        gap: 0.65rem;
        margin-top: 0.85rem;
    }
    .login-shell .ls-testimonial-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--ls-accent), var(--ls-sky));
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.8rem;
        color: #fff;
        flex-shrink: 0;
    }
    .login-shell .ls-testimonial-name {
        font-size: 0.82rem;
        font-weight: 600;
        color: #fff;
    }
    .login-shell .ls-testimonial-role {
        font-size: 0.72rem;
        color: rgba(255, 255, 255, 0.55);
    }

    /* ── Right: form panel ── */
    .login-shell .ls-form-side {
        margin-left: 50%;
        width: 50%;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2.5rem 2rem;
        background:
            radial-gradient(ellipse at 20% 0%, rgba(14, 165, 233, 0.04) 0%, transparent 50%),
            radial-gradient(ellipse at 80% 100%, rgba(245, 158, 11, 0.03) 0%, transparent 50%),
            #fafbfc;
        position: relative;
        z-index: 2;
    }
    .login-shell .ls-form-container {
        width: 100%;
        max-width: 440px;
    }

    /* Brand header */
    .login-shell .ls-brand {
        display: flex;
        align-items: center;
        gap: 0.85rem;
        margin-bottom: 2.25rem;
    }
    .login-shell .ls-brand-logo {
        width: 52px;
        height: 52px;
        border-radius: 1rem;
        object-fit: contain;
        background: #fff;
        box-shadow: 0 4px 20px rgba(15, 23, 42, 0.1);
        border: 1px solid var(--ls-border);
        padding: 4px;
    }
    .login-shell .ls-brand-name {
        font-size: 1.35rem;
        font-weight: 700;
        color: var(--ls-dark);
        letter-spacing: -0.02em;
    }
    .login-shell .ls-brand-tagline {
        font-size: 0.75rem;
        color: var(--ls-muted);
    }

    /* Heading area */
    .login-shell .ls-heading-tag {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        background: linear-gradient(135deg, rgba(14, 165, 233, 0.08), rgba(245, 158, 11, 0.06));
        border: 1px solid rgba(14, 165, 233, 0.15);
        border-radius: 999px;
        padding: 0.3rem 0.85rem;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: var(--ls-sky);
        margin-bottom: 0.85rem;
    }
    .login-shell .ls-heading-tag .ls-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--ls-sky);
        animation: lsDotPulse 2s ease-in-out infinite;
    }
    .login-shell .ls-heading h1 {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--ls-dark);
        letter-spacing: -0.03em;
        margin-bottom: 0.35rem;
    }
    .login-shell .ls-heading p {
        font-size: 0.88rem;
        color: var(--ls-muted);
        margin-bottom: 0;
    }

    /* Form card */
    .login-shell .ls-card {
        background: var(--ls-surface);
        border: 1px solid var(--ls-border);
        border-radius: 1.35rem;
        padding: 1.75rem;
        box-shadow:
            0 1px 3px rgba(15, 23, 42, 0.04),
            0 12px 40px rgba(15, 23, 42, 0.06);
        margin-top: 1.5rem;
    }

    /* Input styling */
    .login-shell .ls-input-group {
        margin-bottom: 1.25rem;
    }
    .login-shell .ls-input-group label {
        display: block;
        font-size: 0.78rem;
        font-weight: 600;
        color: var(--ls-slate);
        margin-bottom: 0.4rem;
        letter-spacing: 0.02em;
    }
    .login-shell .ls-card .form-control {
        border-radius: 0.85rem;
        border: 1.5px solid rgba(148, 163, 184, 0.4);
        background: #f8fafc;
        padding: 0.7rem 1rem;
        font-size: 0.92rem;
        color: var(--ls-dark);
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .login-shell .ls-card .form-control:hover {
        border-color: rgba(148, 163, 184, 0.7);
    }
    .login-shell .ls-card .form-control:focus {
        border-color: var(--ls-sky);
        background: #ffffff;
        box-shadow: 0 0 0 3px var(--ls-sky-glow);
    }

    /* Submit button */
    .login-shell .ls-submit {
        width: 100%;
        padding: 0.78rem 1.5rem;
        border: none;
        border-radius: 0.85rem;
        font-size: 0.95rem;
        font-weight: 600;
        letter-spacing: 0.01em;
        color: #ffffff;
        background: linear-gradient(135deg, var(--ls-dark) 0%, var(--ls-slate) 100%);
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }
    .login-shell .ls-submit::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.08), transparent);
        transition: left 0.5s ease;
    }
    .login-shell .ls-submit:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 25px rgba(12, 18, 32, 0.25);
    }
    .login-shell .ls-submit:hover::before {
        left: 100%;
    }
    .login-shell .ls-submit:active {
        transform: translateY(0);
    }

    /* Divider */
    .login-shell .ls-divider {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin: 1.25rem 0;
        color: var(--ls-muted);
        font-size: 0.75rem;
    }
    .login-shell .ls-divider::before,
    .login-shell .ls-divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: var(--ls-border);
    }

    /* Meta row */
    .login-shell .ls-meta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    .login-shell .ls-meta a {
        font-size: 0.82rem;
        color: var(--ls-sky);
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s ease;
    }
    .login-shell .ls-meta a:hover {
        color: var(--ls-accent-hover);
    }

    /* Trust row */
    .login-shell .ls-trust {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1.5rem;
        margin-top: 1.75rem;
        padding-top: 1.25rem;
        border-top: 1px solid var(--ls-border);
    }
    .login-shell .ls-trust-item {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.74rem;
        color: var(--ls-muted);
    }
    .login-shell .ls-trust-item i {
        font-size: 0.85rem;
        color: var(--ls-sky);
    }

    /* Footer */
    .login-shell .ls-footer {
        text-align: center;
        margin-top: 1.5rem;
        font-size: 0.78rem;
        color: var(--ls-muted);
    }
    .login-shell .ls-footer a {
        color: var(--ls-dark);
        font-weight: 600;
        text-decoration: none;
        transition: color 0.2s ease;
    }
    .login-shell .ls-footer a:hover {
        color: var(--ls-sky);
    }

    /* ── Animations ── */
    @media (prefers-reduced-motion: no-preference) {
        .login-shell .ls-fade {
            opacity: 0;
            transform: translateY(14px);
            animation: lsFadeUp 0.65s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        .login-shell .ls-fade[data-d="1"] { animation-delay: 0.05s; }
        .login-shell .ls-fade[data-d="2"] { animation-delay: 0.12s; }
        .login-shell .ls-fade[data-d="3"] { animation-delay: 0.2s; }
        .login-shell .ls-fade[data-d="4"] { animation-delay: 0.28s; }
        .login-shell .ls-fade[data-d="5"] { animation-delay: 0.36s; }
        .login-shell .ls-fade[data-d="6"] { animation-delay: 0.44s; }
        .login-shell .ls-fade[data-d="7"] { animation-delay: 0.52s; }

        .login-shell .ls-slide-left {
            opacity: 0;
            transform: translateX(-30px);
            animation: lsSlideLeft 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        .login-shell .ls-slide-left[data-d="2"] { animation-delay: 0.15s; }
        .login-shell .ls-slide-left[data-d="3"] { animation-delay: 0.3s; }
    }

    @keyframes lsFadeUp {
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes lsSlideLeft {
        to { opacity: 1; transform: translateX(0); }
    }
    @keyframes lsDotPulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.35; }
    }

    /* ── Responsive ── */
    @media (max-width: 991.98px) {
        .login-shell .ls-visual { display: none; }
        .login-shell .ls-form-side {
            margin-left: 0;
            width: 100%;
        }
    }
    @media (max-width: 575.98px) {
        .login-shell .ls-form-side {
            padding: 1.5rem 1rem;
        }
        .login-shell .ls-card {
            padding: 1.25rem;
        }
        .login-shell .ls-trust {
            flex-direction: column;
            gap: 0.5rem;
        }
    }
</style>
@endpush

@section('content')
<div class="login-shell">

    {{-- Left: cinematic image panel (desktop only) --}}
    <aside class="ls-visual" aria-hidden="true">
        <img src="{{ asset('assets/img/jane.jpg') }}" alt="" class="ls-visual-img">
        <div class="ls-visual-overlay"></div>
        <div class="ls-visual-inner">
            {{-- Top --}}
            <div class="ls-slide-left">
                <a href="{{ url('/') }}" class="d-inline-flex align-items-center gap-2 text-decoration-none mb-4">
                    <img src="{{ asset('assets/img/francee.jpeg') }}" alt="Propsgh" style="height:36px; width:36px; border-radius:0.65rem; object-fit:contain; background:#fff; padding:2px;">
                    <span style="font-weight:700; font-size:1.05rem; color:#fff; letter-spacing:-0.01em;">Propsgh</span>
                </a>
                <h2 class="fw-bold mb-2" style="font-size:1.85rem; letter-spacing:-0.03em; line-height:1.2;">
                    Find the right<br>property, faster.
                </h2>
                <p style="font-size:0.88rem; color:rgba(255,255,255,0.7); max-width:340px;">
                    Browse houses, apartments, rentals, and shortlet stays across Ghana — all in one place.
                </p>
            </div>

            {{-- Bottom --}}
            <div>
                {{-- Stats --}}
                <div class="ls-stat-grid ls-slide-left" data-d="2">
                    <div class="ls-stat-card">
                        <div class="ls-stat-value">2k+</div>
                        <div class="ls-stat-label">Properties</div>
                    </div>
                    <div class="ls-stat-card">
                        <div class="ls-stat-value">850+</div>
                        <div class="ls-stat-label">Happy Tenants</div>
                    </div>
                    <div class="ls-stat-card">
                        <div class="ls-stat-value">15+</div>
                        <div class="ls-stat-label">Cities</div>
                    </div>
                </div>

                {{-- Testimonial --}}
                <div class="ls-testimonial ls-slide-left" data-d="3">
                    <div class="ls-testimonial-quote">
                        "Propsgh made finding my apartment incredibly easy. Signed the lease within a week!"
                    </div>
                    <div class="ls-testimonial-author">
                        <div class="ls-testimonial-avatar">AK</div>
                        <div>
                            <div class="ls-testimonial-name">Ama Kofi</div>
                            <div class="ls-testimonial-role">Tenant in Accra</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </aside>

    {{-- Right: form panel --}}
    <div class="ls-form-side">
        <div class="ls-form-container">

            {{-- Brand (visible on mobile when image panel is hidden) --}}
            <div class="ls-brand ls-fade d-lg-none" data-d="1">
                <img src="{{ asset('assets/img/francee.jpeg') }}" alt="Propsgh" class="ls-brand-logo">
                <div>
                    <div class="ls-brand-name">Propsgh</div>
                    <div class="ls-brand-tagline">Properties &amp; shortlet stays</div>
                </div>
            </div>

            {{-- Heading --}}
            <div class="ls-heading ls-fade" data-d="2">
                <div class="ls-heading-tag">
                    <span class="ls-dot"></span>
                    Welcome back
                </div>
                <h1>Sign in to your account</h1>
                <p>Access your listings, bookings, and rental inquiries.</p>
            </div>

            {{-- Form card --}}
            <div class="ls-card ls-fade" data-d="3">
                <form class="needs-validation" novalidate method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Email --}}
                    <div class="ls-input-group">
                        <label for="email">Email address</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            placeholder="you@example.com"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            inputmode="email"
                            autocapitalize="none"
                            spellcheck="false"
                            autocomplete="email"
                        >
                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="ls-input-group">
                        <label for="password">Password</label>
                        <div class="password-toggle">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Enter your password"
                                required
                                autocomplete="current-password"
                            >
                            <label class="password-toggle-button fs-lg" aria-label="Show/hide password">
                                <input type="checkbox" class="btn-check">
                            </label>
                        </div>
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Remember + help --}}
                    <div class="ls-meta mb-4">
                        <div class="form-check mb-0">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label for="remember" class="form-check-label" style="font-size:0.82rem;">Remember me</label>
                        </div>
                        <a href="{{ route('contact') }}">Need help?</a>
                    </div>

                    {{-- Submit --}}
                    <button type="submit" class="ls-submit">
                        Sign In
                    </button>
                </form>

                <div class="ls-divider">or</div>

                <div class="text-center">
                    <a href="{{ route('home') }}" style="font-size:0.85rem; color:var(--ls-muted); text-decoration:none; transition:color .2s;"
                       onmouseover="this.style.color='var(--ls-sky)'" onmouseout="this.style.color='var(--ls-muted)'">
                        <i class="fi-search me-1" style="font-size:0.8rem;"></i>
                        Browse properties without signing in
                    </a>
                </div>
            </div>

            {{-- Trust indicators --}}
            <div class="ls-trust ls-fade" data-d="5">
                <div class="ls-trust-item">
                    <i class="fi-shield"></i>
                    <span>Secure login</span>
                </div>
                <div class="ls-trust-item">
                    <i class="fi-clock"></i>
                    <span>Instant access</span>
                </div>
                <div class="ls-trust-item">
                    <i class="fi-check-circle"></i>
                    <span>Verified listings</span>
                </div>
            </div>

            {{-- Footer --}}
            <div class="ls-footer ls-fade" data-d="6">
                Don't have an account?
                <a href="{{ route('register') }}">Create one now</a>
            </div>

            <div class="ls-fade" data-d="7" style="text-align:center; margin-top:1rem;">
                <span style="font-size:0.7rem; color:var(--ls-muted);">
                    &copy; {{ now()->year }} Propsgh. All rights reserved.
                </span>
            </div>
        </div>
    </div>
</div>
@endsection
