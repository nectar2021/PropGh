@extends('layouts.admin-auth')

@section('title', 'Propsgh | Access denied')

@section('content')
<main class="min-vh-100 d-flex align-items-center justify-content-center py-5">
    <div class="container px-3">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card border-0 admin-auth-card">
                    <div class="card-body p-4 p-md-5 text-center">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-body-tertiary mb-3" style="width: 72px; height: 72px;">
                            <i class="fi-alert-octagon fs-2 text-danger"></i>
                        </div>
                        <h1 class="h4 mb-2">Access denied</h1>
                        <p class="text-body-secondary mb-4">
                            This area is for Propsgh administrators only. If you believe this is a mistake, contact support.
                        </p>
                        <div class="d-flex flex-column flex-sm-row justify-content-center gap-2">
                            <a class="btn btn-primary" href="{{ route('admin.login') }}">Admin login</a>
                            <a class="btn btn-outline-secondary" href="{{ route('home') }}">Back to site</a>
                            <a class="btn btn-outline-secondary" href="{{ route('contact') }}">Contact support</a>
                        </div>
                    </div>
                </div>
                <p class="text-center text-body-secondary fs-xs mt-3 mb-0">Error 403 · Unauthorized</p>
            </div>
        </div>
    </div>
</main>
@endsection
