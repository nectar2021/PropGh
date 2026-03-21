<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, viewport-fit=cover">
    <title>@yield('title', 'Propsgh | Admin Sign In')</title>
    <meta name="description" content="@yield('meta_description', 'Propsgh admin sign in')">

    <link rel="icon" type="image/png" href="{{ asset('assets/app-icons/icon-32x32.png') }}" sizes="32x32">
    <link rel="apple-touch-icon" href="{{ asset('assets/app-icons/icon-180x180.png') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">

    <script src="{{ asset('assets/js/theme-switcher.js') }}" defer></script>
    <link rel="preload" href="{{ asset('assets/fonts/inter-variable-latin.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="stylesheet" href="{{ asset('assets/icons/finder-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/theme.min.css') }}" id="theme-styles">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    <style>
        :root {
            --aal-bg: #0b1120;
            --aal-accent: 216, 81, 81;
        }
        body {
            min-height: 100vh;
            margin: 0;
        }
        .admin-auth-shell {
            display: flex;
            min-height: 100vh;
        }
        /* Left decorative panel */
        .admin-auth-visual {
            width: 45%;
            background: var(--aal-bg);
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 3rem 2.5rem;
            overflow: hidden;
        }
        .admin-auth-visual::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 60% 50% at 20% 20%, rgba(var(--aal-accent), 0.12) 0%, transparent 60%),
                radial-gradient(ellipse 50% 50% at 80% 80%, rgba(45, 212, 191, 0.08) 0%, transparent 50%);
            pointer-events: none;
        }
        .admin-auth-visual::after {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, rgb(var(--aal-accent)), rgb(45, 212, 191), rgb(var(--aal-accent)));
        }
        .aal-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 3rem;
            position: relative;
        }
        .aal-brand img {
            height: 44px;
            width: auto;
            border-radius: 0.6rem;
        }
        .aal-brand-text {
            font-size: 1.15rem;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: -0.01em;
        }
        .aal-visual-title {
            font-size: 2rem;
            font-weight: 700;
            color: #ffffff;
            line-height: 1.2;
            letter-spacing: -0.02em;
            margin-bottom: 0.75rem;
            position: relative;
        }
        .aal-visual-sub {
            font-size: 0.92rem;
            color: rgba(255, 255, 255, 0.45);
            line-height: 1.6;
            max-width: 360px;
            position: relative;
        }
        .aal-features {
            display: flex;
            flex-direction: column;
            gap: 0.85rem;
            margin-top: 2.5rem;
            position: relative;
        }
        .aal-feature {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.65rem 0.85rem;
            border-radius: 0.75rem;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.06);
        }
        .aal-feature-icon {
            width: 34px;
            height: 34px;
            border-radius: 0.55rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(var(--aal-accent), 0.15);
            color: rgb(var(--aal-accent));
            font-size: 0.95rem;
            flex-shrink: 0;
        }
        .aal-feature-text {
            font-size: 0.82rem;
            color: rgba(255,255,255,0.6);
            font-weight: 500;
        }

        /* Right form panel */
        .admin-auth-form-side {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            background: #f8fafc;
        }
        .admin-auth-form-container {
            width: 100%;
            max-width: 420px;
        }
        .admin-auth-card {
            border-radius: 1.25rem;
            border: 1px solid rgba(226, 232, 240, 0.65);
            box-shadow: 0 4px 24px -6px rgba(15, 23, 42, 0.07);
            background: #ffffff;
        }
        .admin-auth-logo {
            height: 52px;
            width: auto;
            object-fit: contain;
            border-radius: 0.6rem;
        }
        .admin-auth-badge {
            background: rgba(var(--aal-accent), 0.1);
            color: rgb(var(--aal-accent));
            border-radius: 999px;
            padding: 0.2rem 0.65rem;
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-weight: 600;
            border: 1px solid rgba(var(--aal-accent), 0.15);
        }
        .admin-auth-form-side .form-control:focus {
            border-color: rgba(var(--aal-accent), 0.4);
            box-shadow: 0 0 0 3px rgba(var(--aal-accent), 0.08);
        }
        .admin-auth-form-side .btn-primary {
            background: rgb(var(--aal-accent));
            border-color: rgb(var(--aal-accent));
            box-shadow: 0 2px 10px -2px rgba(var(--aal-accent), 0.4);
        }
        .admin-auth-form-side .btn-primary:hover {
            box-shadow: 0 4px 16px -3px rgba(var(--aal-accent), 0.5);
            transform: translateY(-1px);
        }

        @media (max-width: 991.98px) {
            .admin-auth-visual { display: none; }
            .admin-auth-form-side { padding: 1.5rem; }
        }
        @media (max-width: 575.98px) {
            .admin-auth-form-side { padding: 1rem; }
            .admin-auth-card .card-body { padding: 1.5rem !important; }
        }
    </style>
</head>
<body class="text-body">
@yield('content')

<script src="{{ asset('assets/js/theme.min.js') }}"></script>
@stack('scripts')
</body>
</html>
