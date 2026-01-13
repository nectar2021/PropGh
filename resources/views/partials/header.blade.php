<header
    class="navbar navbar-expand-lg bg-body fixed-top z-fixed px-0"
>
    <div class="container-fluid">
        {{-- Brand / Logo --}}
        <a
            class="navbar-brand d-flex align-items-center p-0 me-3 me-lg-4 brand-shift-left"
            href="{{ route('home') }}"
        >
            <img
                class="nav-profile-icon"
                src="{{ asset('assets/img/francee.jpeg') }}"
                alt="Propsgh"
            >
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
                <h5 class="offcanvas-title" id="navbarNavLabel">Browse Finder</h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="offcanvas"
                    aria-label="Close"
                ></button>
            </div>

            <div class="offcanvas-body pt-2 pb-4 py-lg-0 mx-lg-auto">
                <ul class="navbar-nav position-relative nav-icon-bar">
                    {{-- Home --}}
                    <li class="nav-item py-lg-2 me-lg-n1 me-xl-0 nav-icon-item">
                        <a
                            class="nav-link nav-icon-link {{ request()->routeIs('home') ? 'active' : '' }}"
                            aria-current="page"
                            href="{{ route('home') }}"
                        >
                            <span class="nav-icon">
                                <img src="{{ asset('assets/img/nav-icons/house.png') }}" alt="Home">
                            </span>
                            <span class="nav-text">Home</span>
                        </a>
                    </li>

                    <li class="nav-item py-lg-2 me-lg-n1 me-xl-0 nav-icon-item">
                        <a
                            class="nav-link nav-icon-link {{ request()->routeIs('properties.index') ? 'active' : '' }}"
                            href="{{ route('properties.index') }}"
                        >
                            <span class="nav-icon">
                                <img src="{{ asset('assets/img/nav-icons/3d-house.png') }}" alt="Properties">
                            </span>
                            <span class="nav-text">Properties</span>
                        </a>
                    </li>

                    {{-- Contact --}}
                    <li class="nav-item py-lg-2 me-lg-n1 me-xl-0 nav-icon-item">
                        <a
                            class="nav-link nav-icon-link {{ request()->routeIs('contact') ? 'active' : '' }}"
                            href="{{ route('contact') }}"
                        >
                            <span class="nav-icon">
                                <img src="{{ asset('assets/img/nav-icons/3d-contact.png') }}" alt="Contact">
                            </span>
                            <span class="nav-text">Contact</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        {{-- Right controls --}}
        <div class="d-flex gap-sm-1">
            {{-- Theme switcher --}}
            <div class="dropdown me-2">
                <button
                    type="button"
                    class="theme-switcher btn btn-icon btn-outline-secondary fs-lg border-0 animate-scale"
                    data-bs-toggle="dropdown"
                    data-bs-display="dynamic"
                    aria-expanded="false"
                    aria-label="Toggle theme (light)"
                >
                    <span class="theme-icon-active d-flex animate-target">
                        <i class="fi-sun"></i>
                    </span>
                </button>
                <ul class="dropdown-menu start-50 translate-middle-x" style="--fn-dropdown-min-width: 9rem; --fn-dropdown-spacer: .5rem">
                    <li>
                        <button type="button" class="dropdown-item active" data-bs-theme-value="light" aria-pressed="true">
                            <span class="theme-icon d-flex fs-base me-2">
                                <i class="fi-sun"></i>
                            </span>
                            <span class="theme-label">Light</span>
                            <i class="item-active-indicator fi-check ms-auto"></i>
                        </button>
                    </li>
                    <li>
                        <button type="button" class="dropdown-item" data-bs-theme-value="dark" aria-pressed="false">
                            <span class="theme-icon d-flex fs-base me-2">
                                <i class="fi-moon"></i>
                            </span>
                            <span class="theme-label">Dark</span>
                            <i class="item-active-indicator fi-check ms-auto"></i>
                        </button>
                    </li>
                    <li>
                        <button type="button" class="dropdown-item" data-bs-theme-value="auto" aria-pressed="false">
                            <span class="theme-icon d-flex fs-base me-2">
                                <i class="fi-auto"></i>
                            </span>
                            <span class="theme-label">Auto</span>
                            <i class="item-active-indicator fi-check ms-auto"></i>
                        </button>
                    </li>
                </ul>
            </div>

            {{-- Login icon --}}
            <a
                class="btn btn-icon btn-outline-secondary fs-lg border-0 animate-scale me-1"
                href="{{ route('login') }}"
                aria-label="Login"
            >
                <i class="fi-user"></i>
            </a>

            {{-- Add property button --}}
            <a class="btn btn-sm btn-primary animate-scale" href="#">
                <i class="fi-plus fs-sm animate-target ms-n2 me-1 me-sm-2"></i>
                Add<span class="d-none d-xl-inline ms-1">property</span>
            </a>
        </div>
    </div>
</header>
