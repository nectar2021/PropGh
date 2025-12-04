<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, viewport-fit=cover">
    <title>@yield('title', 'Propsgh | Find your next stay')</title>
    <meta name="description" content="@yield('meta_description', 'Discover premium apartments, houses, and shortlets across Ghana with Propsgh.')">

    <link rel="icon" type="image/png" href="{{ asset('assets/app-icons/icon-32x32.png') }}" sizes="32x32">
    <link rel="apple-touch-icon" href="{{ asset('assets/app-icons/icon-180x180.png') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">

    <script src="{{ asset('assets/js/theme-switcher.js') }}" defer></script>
    <link rel="preload" href="{{ asset('assets/fonts/inter-variable-latin.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="stylesheet" href="{{ asset('assets/icons/finder-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/theme.min.css') }}" id="theme-styles">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('styles')
</head>
<body class="bg-body text-body">
    <div id="app">
        @include('partials.header')

        <main class="content-wrapper">
            @yield('content')
        </main>

        @include('partials.footer')
    </div>

    @livewireScripts
    @stack('scripts')
    <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/theme.min.js') }}"></script>
</body>
</html>
