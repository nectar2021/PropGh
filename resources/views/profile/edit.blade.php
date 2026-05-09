@extends('layouts.app')

@section('title', 'Propsgh | My Profile')
@section('meta_description', 'Manage your Propsgh profile details, password, and profile picture.')

@section('content')
@php
    $avatarUrl = $user->avatar_path ? asset($user->avatar_path) : null;
    $roleLabel = $user->isAdmin() ? 'Administrator' : ($user->isAgent() ? 'Agent account' : 'Client account');
@endphp

<section class="container py-5 mt-5 mb-4">
    <div class="d-flex flex-column flex-lg-row align-items-lg-end justify-content-between gap-3 mb-4">
        <div>
            <span class="badge text-bg-secondary-subtle text-secondary-emphasis rounded-pill px-3 py-2 mb-3">Account settings</span>
            <h1 class="h2 mb-2">Manage your profile</h1>
            <p class="text-body-secondary mb-0">Update your details, keep your login secure, and add a profile picture for your listings and account menu.</p>
        </div>
        <a href="{{ route('properties.index') }}" class="btn btn-outline-secondary d-inline-flex align-items-center gap-2">
            <i class="fi-search fs-sm"></i> Browse properties
        </a>
    </div>

    @if (session('status'))
        <div class="alert alert-success d-flex align-items-center gap-2 mb-4">
            <i class="fi-check-circle"></i>{{ session('status') }}
        </div>
    @endif

    @if (session('password_status'))
        <div class="alert alert-success d-flex align-items-center gap-2 mb-4">
            <i class="fi-check-circle"></i>{{ session('password_status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger mb-4">
            <div class="fw-semibold mb-2">Please fix the following issues:</div>
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-4 align-items-start">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm sticky-lg-top" style="top: 110px;">
                <div class="card-body p-4 text-center">
                    <div class="mx-auto mb-3 rounded-circle overflow-hidden bg-body-secondary" style="width: 132px; height: 132px;">
                        @if ($avatarUrl)
                            <img src="{{ $avatarUrl }}" alt="{{ $user->name }}" class="w-100 h-100" style="object-fit: cover;">
                        @else
                            <div class="d-flex align-items-center justify-content-center w-100 h-100 text-body-tertiary">
                                <i class="fi-user" style="font-size: 2.5rem;"></i>
                            </div>
                        @endif
                    </div>
                    <h2 class="h4 mb-1">{{ $user->name }}</h2>
                    <p class="text-body-secondary mb-3">{{ $user->email }}</p>
                    <div class="d-inline-flex align-items-center gap-2 rounded-pill bg-body-secondary px-3 py-2 fs-sm mb-3">
                        <i class="fi-shield fs-xs"></i>
                        <span>{{ $roleLabel }}</span>
                    </div>
                    @if ($user->isAgent() && $user->company_name)
                        <p class="fs-sm text-body-secondary mb-0">{{ $user->company_name }}</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2 mb-4">
                        <div>
                            <h2 class="h4 mb-1">Profile details</h2>
                            <p class="text-body-secondary mb-0">These details appear across your account and agent listings.</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-medium">Full name</label>
                                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label fw-medium">Email address</label>
                                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="phone" class="form-label fw-medium">Phone number</label>
                                <input type="text" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}" placeholder="+233...">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            @if ($user->isAgent())
                                <div class="col-md-6">
                                    <label for="company_name" class="form-label fw-medium">Company / Agency name</label>
                                    <input type="text" id="company_name" name="company_name" class="form-control @error('company_name') is-invalid @enderror" value="{{ old('company_name', $user->company_name) }}" placeholder="Your agency name">
                                    @error('company_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif

                            <div class="col-12">
                                <label for="avatar" class="form-label fw-medium">Profile picture</label>
                                <input type="file" id="avatar" name="avatar" class="form-control @error('avatar') is-invalid @enderror" accept="image/png,image/jpeg,image/webp,image/gif,image/bmp">
                                <div class="form-text">Leave this empty to keep your current photo. JPG, PNG, GIF, BMP, and WebP are supported up to 5 MB.</div>
                                @error('avatar')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary d-inline-flex align-items-center gap-2">
                                <i class="fi-check fs-sm"></i> Save changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card border-0 shadow-sm" id="password">
                <div class="card-body p-4 p-md-5">
                    <div class="mb-4">
                        <h2 class="h4 mb-1">Change password</h2>
                        <p class="text-body-secondary mb-0">Use a strong password you do not reuse anywhere else.</p>
                    </div>

                    <form method="POST" action="{{ route('profile.password') }}">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-12">
                                <label for="current_password" class="form-label fw-medium">Current password</label>
                                <input type="password" id="current_password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password" class="form-label fw-medium">New password</label>
                                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label fw-medium">Confirm new password</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-outline-secondary d-inline-flex align-items-center gap-2">
                                <i class="fi-lock fs-sm"></i> Update password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection