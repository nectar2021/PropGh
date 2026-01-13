<!DOCTYPE html>
<html lang="en" data-bs-theme="light" data-pwa="true">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover">

    <title>@yield('title', 'Propsgh')</title>
    @hasSection('meta-description')
        <meta name="description" content="@yield('meta-description')">
    @endif
    @hasSection('meta-keywords')
        <meta name="keywords" content="@yield('meta-keywords')">
    @endif
    <meta name="author" content="Propsgh">

    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/app-icons/icon-32x32.png') }}" sizes="32x32">
    <link rel="apple-touch-icon" href="{{ asset('assets/app-icons/icon-180x180.png') }}">

    <script src="{{ asset('assets/js/theme-switcher.js') }}"></script>
    <link rel="preload" href="{{ asset('assets/fonts/inter-variable-latin.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="{{ asset('assets/icons/finder-icons.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="stylesheet" href="{{ asset('assets/icons/finder-icons.min.css') }}">
    <link rel="preload" href="{{ asset('assets/css/theme.min.css') }}" as="style">
    <link rel="stylesheet" href="{{ asset('assets/css/theme.min.css') }}" id="theme-styles">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        body {
            background: radial-gradient(circle at top left, #fff4f2 0, #fdf7ff 35%, #f4f8ff 70%, #ffffff 100%);
        }
        .auth-wrapper { max-width: 1920px; }
        .auth-left { max-width: 480px; }
        .brand-logo-wrapper {
            height: 120px; width: 120px; border-radius: 2.25rem;
            background: #ffffff;
            box-shadow: 0 22px 55px rgba(15, 23, 42, 0.18);
            border: 1px solid rgba(226, 232, 240, 0.9);
        }
        .brand-logo-wrapper img { max-height: 95px; width: auto; object-fit: contain; }
        .auth-card {
            border-radius: 1.6rem;
            box-shadow: 0 22px 55px rgba(15, 23, 42, 0.14);
            background: rgba(255, 255, 255, 0.98);
            border: 1px solid rgba(226, 232, 240, 0.8);
        }
        .auth-heading h1 { letter-spacing: -0.03em; }
        .badge-soft {
            border-radius: 999px;
            background: rgba(216, 81, 81, 0.06);
            color: #d85151;
            padding: 0.2rem 0.75rem;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-weight: 600;
        }
        @media (max-width: 575.98px) {
            .auth-heading { text-align: center; }
            .auth-heading p { max-width: 100%; }
        }
    </style>

    @stack('styles')
</head>
<body>
@yield('content')

<script src="{{ asset('assets/js/theme.min.js') }}"></script>
@livewireScripts
@stack('scripts')
</body>
</html>
