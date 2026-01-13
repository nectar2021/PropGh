@extends('layouts.admin-auth')

@section('title', 'Propsgh | Admin Sign In')

@section('content')
<main class="min-vh-100 d-flex align-items-center justify-content-center py-5">
    <div class="container px-3">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="card border-0 admin-auth-card">
                    <div class="card-body p-4 p-md-5">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <img src="{{ asset('assets/img/francee.jpeg') }}" alt="Propsgh" class="admin-auth-logo">
                            <div>
                                <div class="admin-auth-badge mb-2">Admin Access</div>
                            </div>
                        </div>

                        <h1 class="h4 mb-1">Sign into the admin</h1>
                        <p class="text-body-secondary mb-4">Use your Propsgh account to manage listings and inquiries.</p>

                        <form method="POST" action="{{ route('admin.login.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="email">Email address</label>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}"
                                    autocomplete="email"
                                    required
                                >
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="password">Password</label>
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    autocomplete="current-password"
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
                                <span class="text-body-secondary fs-sm">Admins only</span>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                Sign in
                            </button>
                        </form>

                        <div class="d-flex justify-content-between align-items-center mt-4 fs-sm">
                            <a class="text-decoration-none" href="{{ route('login') }}">User login</a>
                            <a class="text-decoration-none" href="{{ route('home') }}">Back to site</a>
                        </div>
                    </div>
                </div>
                <p class="text-center text-body-secondary fs-xs mt-3 mb-0">
                    © {{ now()->year }} Propsgh. Secure admin access.
                </p>
            </div>
        </div>
    </div>
</main>
@endsection
