<header
    class="navbar navbar-expand-lg fixed-top z-fixed px-0 propsgh-nav"
>
    <div class="container-fluid">
        {{-- Brand / Logo --}}
        <a
            class="navbar-brand d-flex align-items-center p-0 me-3 me-lg-4 brand-shift-left"
            href="{{ route('home') }}"
        >
            <span class="brand-mark">
                <img
                    class="nav-profile-icon"
                    src="{{ asset('assets/img/francee.jpeg') }}"
                    alt="Propsgh"
                >
            </span>
        </a>

        {{-- Mobile toggler --}}
        <button
            type="button"
            class="navbar-toggler me-3 me-lg-0"
            data-bs-toggle="offcanvas"
            data-bs-target="#navbarNav"
            aria-controls="navbarNav"
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Main navigation / offcanvas --}}
        <nav
            class="offcanvas offcanvas-start"
            id="navbarNav"
            tabindex="-1"
            aria-labelledby="navbarNavLabel"
        >
            <div class="offcanvas-header py-3">
                <h5 class="offcanvas-title" id="navbarNavLabel">Menu</h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="offcanvas"
                    aria-label="Close"
                ></button>
            </div>

            <div class="offcanvas-body pt-2 pb-4 py-lg-0 mx-lg-auto">
                <ul class="navbar-nav position-relative pg-nav-links">
                    <li class="nav-item">
                        <a
                            class="nav-link pg-nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                            href="{{ route('home') }}"
                        >
                            <i class="fi-home pg-nav-icon"></i>
                            <span class="pg-nav-label">Home</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a
                            class="nav-link pg-nav-link {{ request()->routeIs('properties.index') ? 'active' : '' }}"
                            href="{{ route('properties.index') }}"
                        >
                            <i class="fi-key pg-nav-icon"></i>
                            <span class="pg-nav-label">Properties</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a
                            class="nav-link pg-nav-link {{ request()->routeIs('contact') ? 'active' : '' }}"
                            href="{{ route('contact') }}"
                        >
                            <i class="fi-send pg-nav-icon"></i>
                            <span class="pg-nav-label">Contact</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        {{-- Right controls --}}
        <div class="d-flex align-items-center gap-2">
            {{-- Theme switcher --}}
            <div class="dropdown">
                <button
                    type="button"
                    class="theme-switcher pg-icon-btn"
                    data-bs-toggle="dropdown"
                    data-bs-display="dynamic"
                    aria-expanded="false"
                    aria-label="Toggle theme"
                >
                    <span class="theme-icon-active d-flex animate-target">
                        <i class="fi-sun"></i>
                    </span>
                </button>
                <ul class="dropdown-menu start-50 translate-middle-x" style="--fn-dropdown-min-width: 9rem; --fn-dropdown-spacer: .5rem">
                    <li>
                        <button type="button" class="dropdown-item active" data-bs-theme-value="light" aria-pressed="true">
                            <span class="theme-icon d-flex fs-base me-2"><i class="fi-sun"></i></span>
                            <span class="theme-label">Light</span>
                            <i class="item-active-indicator fi-check ms-auto"></i>
                        </button>
                    </li>
                    <li>
                        <button type="button" class="dropdown-item" data-bs-theme-value="dark" aria-pressed="false">
                            <span class="theme-icon d-flex fs-base me-2"><i class="fi-moon"></i></span>
                            <span class="theme-label">Dark</span>
                            <i class="item-active-indicator fi-check ms-auto"></i>
                        </button>
                    </li>
                    <li>
                        <button type="button" class="dropdown-item" data-bs-theme-value="auto" aria-pressed="false">
                            <span class="theme-icon d-flex fs-base me-2"><i class="fi-auto"></i></span>
                            <span class="theme-label">Auto</span>
                            <i class="item-active-indicator fi-check ms-auto"></i>
                        </button>
                    </li>
                </ul>
            </div>

            {{-- User / Login --}}
            @auth
                <div class="dropdown">
                    <button class="pg-icon-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Account menu">
                        <i class="fi-user"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" style="min-width: 200px;">
                        <li class="px-3 py-2 border-bottom">
                            <div class="fw-semibold text-truncate">{{ Auth::user()->name }}</div>
                            <div class="text-body-secondary fs-xs text-truncate">{{ Auth::user()->email }}</div>
                        </li>
                        @if(Auth::user()->isAdmin())
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                    <i class="fi-bar-chart-2 fs-sm me-2"></i>Admin panel
                                </a>
                            </li>
                        @endif
                        @if(Auth::user()->isAgent() || Auth::user()->isAdmin())
                            <li>
                                <a class="dropdown-item" href="{{ route('agent.properties.index') }}">
                                    <i class="fi-grid fs-sm me-2"></i>My Properties
                                </a>
                            </li>
                        @endif
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fi-log-out fs-sm me-2"></i>Sign out
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <a class="pg-icon-btn" href="{{ route('login') }}" aria-label="Login">
                    <i class="fi-user"></i>
                </a>
            @endauth

            {{-- Add property button (agents & admins only) --}}
            @auth
                @if(Auth::user()->isAgent() || Auth::user()->isAdmin())
                    <a class="pg-cta-btn" href="{{ route('agent.properties.create') }}">
                        <i class="fi-plus pg-cta-icon"></i>
                        <span>Add<span class="d-none d-sm-inline">&nbsp;property</span></span>
                    </a>
                @endif
            @endauth
        </div>
    </div>
</header>
