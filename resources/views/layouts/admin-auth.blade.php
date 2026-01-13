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
        body {
            min-height: 100vh;
            background: radial-gradient(circle at top left, #f8fafc 0, #eef2ff 45%, #f8fafc 100%);
        }
        .admin-auth-card {
            border-radius: 1.5rem;
            /* box-shadow removed */
        }
        .admin-auth-logo {
            height: 72px;
            width: auto;
            object-fit: contain;
        }
        .admin-auth-badge {
            background: rgba(216, 81, 81, 0.12);
            color: #d85151;
            border-radius: 999px;
            padding: 0.25rem 0.75rem;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-weight: 600;
        }
    </style>
</head>
<body class="text-body">
@yield('content')

<script src="{{ asset('assets/js/theme.min.js') }}"></script>
@stack('scripts')
</body>
</html>
