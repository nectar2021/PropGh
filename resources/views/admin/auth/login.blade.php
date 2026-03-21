@extends('layouts.admin-auth')

@section('title', 'Propsgh | Admin Sign In')

@section('content')
<div class="admin-auth-shell">
    {{-- Left visual panel --}}
    <div class="admin-auth-visual">
        <div class="aal-brand">
            <img src="{{ asset('assets/img/francee.jpeg') }}" alt="Propsgh">
            <span class="aal-brand-text">Propsgh</span>
        </div>
        <h2 class="aal-visual-title">Manage your<br>properties with ease</h2>
        <p class="aal-visual-sub">Your command center for listings, inquiries, and real estate performance tracking.</p>
        <div class="aal-features">
            <div class="aal-feature">
                <span class="aal-feature-icon"><i class="fi-grid"></i></span>
                <span class="aal-feature-text">Manage all listings in one place</span>
            </div>
            <div class="aal-feature">
                <span class="aal-feature-icon"><i class="fi-bar-chart-2"></i></span>
                <span class="aal-feature-text">Track views and performance metrics</span>
            </div>
            <div class="aal-feature">
                <span class="aal-feature-icon"><i class="fi-mail"></i></span>
                <span class="aal-feature-text">Respond to customer inquiries</span>
            </div>
        </div>
    </div>

    {{-- Right form panel --}}
    <div class="admin-auth-form-side">
        <div class="admin-auth-form-container">
            <div class="card border-0 admin-auth-card">
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <img src="{{ asset('assets/img/francee.jpeg') }}" alt="Propsgh" class="admin-auth-logo d-lg-none">
                        <div>
                            <span class="admin-auth-badge">Admin Access</span>
                        </div>
                    </div>

                    <h1 class="h4 mb-1 fw-bold">Sign into the admin</h1>
                    <p class="text-body-secondary mb-4" style="font-size: 0.88rem;">Use your Propsgh credentials to manage listings and inquiries.</p>

                    <form method="POST" action="{{ route('admin.login.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-medium" for="email">Email address</label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}"
                                autocomplete="email"
                                placeholder="admin@propsgh.com"
                                required
                            >
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-medium" for="password">Password</label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                autocomplete="current-password"
                                placeholder="Enter your password"
                                required
                            >
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                <label class="form-check-label" for="remember">Remember me</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                            Sign in
                        </button>
                    </form>

                    <div class="d-flex justify-content-between align-items-center mt-4 fs-sm">
                        <a class="text-decoration-none" href="{{ route('login') }}">
                            <i class="fi-arrow-left fs-xs me-1"></i> User login
                        </a>
                        <a class="text-decoration-none" href="{{ route('home') }}">Back to site</a>
                    </div>
                </div>
            </div>
            <p class="text-center text-body-secondary mt-3 mb-0" style="font-size: 0.72rem;">
                &copy; {{ now()->year }} Propsgh. Secure admin access.
            </p>
        </div>
    </div>
</div>
@endsection
