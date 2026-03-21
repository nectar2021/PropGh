<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, viewport-fit=cover">
    <title>@yield('title', 'Propsgh | Admin')</title>
    <meta name="description" content="@yield('meta_description', 'Propsgh admin console')">

    <link rel="icon" type="image/png" href="{{ asset('assets/app-icons/icon-32x32.png') }}" sizes="32x32">
    <link rel="apple-touch-icon" href="{{ asset('assets/app-icons/icon-180x180.png') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">

    <script src="{{ asset('assets/js/theme-switcher.js') }}" defer></script>
    <link rel="preload" href="{{ asset('assets/fonts/inter-variable-latin.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="stylesheet" href="{{ asset('assets/icons/finder-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/theme.min.css') }}" id="theme-styles">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-body text-body">
    <div class="admin-shell d-flex flex-column flex-lg-row">
        <aside class="admin-sidebar offcanvas-lg offcanvas-start" tabindex="-1" id="adminSidebar">
            <div class="offcanvas-header d-lg-none">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body d-flex flex-column p-3">
                {{-- Brand --}}
                <div class="admin-brand-row">
                    <a href="{{ route('home') }}" class="d-inline-flex align-items-center text-decoration-none">
                        <img class="admin-logo" src="{{ asset('assets/img/francee.jpeg') }}" alt="Propsgh">
                    </a>
                    <div>
                        <div class="admin-brand-label">Propsgh</div>
                        <div class="admin-brand-sub">Admin Console</div>
                    </div>
                </div>

                {{-- Main navigation --}}
                <span class="admin-nav-label">Main</span>
                <nav class="nav flex-column gap-1 px-1">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="fi-bar-chart-2 fs-base"></i>
                        Dashboard
                    </a>
                    <a class="nav-link {{ request()->routeIs('admin.properties.*') ? 'active' : '' }}" href="{{ route('admin.properties.index') }}">
                        <i class="fi-grid fs-base"></i>
                        Properties
                    </a>
                    <a class="nav-link {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}" href="{{ route('admin.messages.index') }}">
                        <i class="fi-mail fs-base"></i>
                        Messages
                        @php $unreadCount = \App\Models\ContactMessage::where('created_at', '>=', now()->subDays(7))->count(); @endphp
                        @if($unreadCount > 0)
                            <span class="admin-nav-badge">{{ $unreadCount }}</span>
                        @endif
                    </a>
                    <a class="nav-link {{ request()->routeIs('admin.subscribers.*') ? 'active' : '' }}" href="{{ route('admin.subscribers.index') }}">
                        <i class="fi-users fs-base"></i>
                        Subscribers
                        @php $subCount = \App\Models\Subscriber::count(); @endphp
                        @if($subCount > 0)
                            <span class="admin-nav-badge">{{ $subCount }}</span>
                        @endif
                    </a>
                </nav>

                {{-- Account section --}}
                <span class="admin-nav-label">Account</span>
                <nav class="nav flex-column gap-1 px-1">
                    <a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" href="{{ route('admin.settings.edit') }}">
                        <i class="fi-sliders fs-base"></i>
                        Site settings
                    </a>
                    <a class="nav-link {{ request()->routeIs('admin.profile') ? 'active' : '' }}" href="{{ route('admin.profile') }}">
                        <i class="fi-settings fs-base"></i>
                        My profile
                    </a>
                    <a class="nav-link" href="{{ route('properties.index') }}">
                        <i class="fi-external-link fs-base"></i>
                        View site
                    </a>
                </nav>

                {{-- Help card --}}
                <div class="mt-auto pt-4 px-1">
                    <div class="admin-help-card">
                        <div class="fw-semibold mb-1">Need help?</div>
                        <div class="fs-xs mb-3">Reach the support team for quick answers.</div>
                        <a class="btn btn-sm btn-outline-secondary w-100" href="{{ route('contact') }}">Contact support</a>
                    </div>
                </div>
            </div>
        </aside>

        <div class="flex-grow-1 d-flex flex-column" style="min-width: 0;">
            <header class="admin-topbar px-3 px-lg-4 py-3">
                <div class="d-flex align-items-center justify-content-between gap-3">
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn btn-icon btn-outline-secondary d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#adminSidebar" aria-controls="adminSidebar" aria-label="Toggle navigation">
                            <i class="fi-menu"></i>
                        </button>
                        @php
                            $searchPlaceholder = match (true) {
                                request()->routeIs('admin.properties.*') => 'Search properties, owners, or cities',
                                request()->routeIs('admin.messages.*') => 'Search messages, names, or emails',
                                default => 'Search listings, owners, or agents',
                            };
                            $searchAction = request()->routeIs('admin.messages.*')
                                ? route('admin.messages.index')
                                : route('admin.properties.index');
                        @endphp
                        <form class="admin-search-bar d-none d-md-flex" method="GET" action="{{ $searchAction }}">
                            <i class="fi-search text-body-secondary"></i>
                            <input
                                type="search"
                                name="search"
                                placeholder="{{ $searchPlaceholder }}"
                                value="{{ request('search') }}"
                                aria-label="Search"
                            >
                        </form>
                    </div>

                    <div class="d-flex align-items-center gap-2 gap-sm-3">
                        <a href="{{ route('admin.properties.create') }}" class="btn btn-primary btn-sm d-none d-sm-inline-flex align-items-center gap-1">
                            <i class="fi-plus fs-sm"></i>
                            <span>Add property</span>
                        </a>
                        <div class="dropdown">
                            <button type="button" class="btn btn-outline-secondary btn-sm border-0 shadow-none d-flex align-items-center gap-2" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 34px; height: 34px; background: rgba(var(--ad-accent), 0.12); color: rgb(var(--ad-accent));">
                                    <i class="fi-user fs-base"></i>
                                </span>
                                <span class="d-none d-sm-inline fw-semibold" style="font-size: 0.85rem;">{{ auth()->user()->name ?? 'Admin' }}</span>
                                <i class="fi-chevron-down fs-xs"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="{{ route('admin.profile') }}">
                                    <i class="fi-user fs-sm me-2"></i>My account
                                </a>
                                <a class="dropdown-item" href="{{ route('admin.profile') }}#password">
                                    <i class="fi-lock fs-sm me-2"></i>Change password
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('properties.index') }}">
                                    <i class="fi-external-link fs-sm me-2"></i>Open public site
                                </a>
                                <div class="dropdown-divider"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fi-log-out fs-sm me-2"></i>Sign out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-grow-1 p-3 p-lg-4">
                @yield('content')
            </main>

            <footer class="admin-footer px-3 px-lg-4 py-3">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <p class="mb-0 text-body-secondary fs-xs">&copy; {{ now()->year }} Propsgh. All rights reserved.</p>
                    <div class="d-flex align-items-center gap-3 fs-xs">
                        <a href="{{ route('home') }}" class="text-body-secondary text-decoration-none">Home</a>
                        <a href="{{ route('contact') }}" class="text-body-secondary text-decoration-none">Support</a>
                        <a href="{{ route('properties.index') }}" class="text-body-secondary text-decoration-none">View site</a>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="{{ asset('assets/js/theme.min.js') }}"></script>
    @stack('scripts')
</body>
</html>
