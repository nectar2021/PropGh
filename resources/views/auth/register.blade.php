@extends('layouts.auth')

@section('title', 'Propsgh | Create Account')
@section('meta-description', 'Create your Propsgh account to list or book properties and shortlets.')
@section('meta-keywords', 'propsgh, signup, register, rentals, apartments, real estate, booking')

@section('content')
<main class="content-wrapper w-100 px-3 ps-lg-5 pe-lg-4 mx-auto auth-wrapper">
    <div class="d-lg-flex">

        <!-- Left column -->
        <div class="d-flex flex-column min-vh-100 w-100 py-4 mx-auto me-lg-5 auth-left">

            <!-- Brand -->
            <header class="px-0 pb-4 mb-2 mb-md-3 mb-lg-4">
                <a href="{{ url('/') }}"
                   class="d-flex flex-column flex-sm-row align-items-center justify-content-center justify-content-sm-start text-decoration-none gap-3">
                    <div class="brand-logo-wrapper d-flex align-items-center justify-content-center">
                        <img src="{{ asset('assets/img/props.jpeg') }}" alt="Propsgh Logo">
                    </div>
                    <div class="text-center text-sm-start">
                        <span class="d-block fs-3 fw-semibold text-dark-emphasis">Propsgh</span>
                        <span class="d-none d-sm-block text-body-secondary fs-sm">
                            Book, host, and manage your stays.
                        </span>
                    </div>
                </a>
            </header>

            <!-- Card -->
            <div class="auth-card p-4 p-md-5 mt-2 d-flex flex-column flex-grow-1">

                <div class="auth-heading mb-3">
                    <span class="badge-soft mb-2">Create account</span>
                    <h1 class="h2 mb-1">Join Propsgh</h1>
                    <p class="text-body-secondary mb-0">
                        Set up your profile and start listing or booking properties right away.
                    </p>
                </div>

                <div class="nav fs-sm mb-4">
                    Already have an account?
                    <a class="nav-link text-decoration-underline p-0 ms-2" href="{{ route('login') }}">Sign in</a>
                </div>

                <form class="needs-validation" novalidate method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="position-relative mb-4">
                        <label for="name" class="form-label fs-sm text-body-secondary mb-1">Full name</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="form-control form-control-lg @error('name') is-invalid @enderror"
                            placeholder="Your name"
                            value="{{ old('name') }}"
                            required
                            autocomplete="name"
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
                                class="form-control form-control-lg"
                                placeholder="Retype your password"
                                required
                                autocomplete="new-password"
                            >
                            <label class="password-toggle-button fs-lg" aria-label="Show/hide password">
                                <input type="checkbox" class="btn-check">
                            </label>
                        </div>
                    </div>

                    <div class="d-flex flex-column gap-2 mb-4">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                            <label for="terms" class="form-check-label">
                                I agree to the <a class="text-dark-emphasis" href="#!">Terms &amp; Privacy</a>
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-lg btn-primary w-100">Create account</button>
                </form>

                <footer class="mt-auto pt-4">
                    <p class="fs-xs mb-0 text-body-secondary">
                        © {{ now()->year }} Propsgh. Grow your stays with us.
                    </p>
                </footer>
            </div>
        </div>

        <!-- Right side -->
        <div class="d-none d-lg-block w-100 py-4 ms-auto" style="max-width: 1034px">
            <div class="d-flex flex-column justify-content-end h-100 bg-info-subtle rounded-5">
                <div class="ratio" style="--fn-aspect-ratio: calc(1030 / 1032 * 100%)">
                    <img src="{{ asset('assets/img/jane.jpg') }}" alt="Propsgh cover" class="w-100 h-100" style="object-fit: cover;">
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
