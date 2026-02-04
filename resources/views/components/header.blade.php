<header class="site-header">
    <div class="header-top bg-dark text-white">
        <div class="container d-flex align-items-center justify-content-between">
            <div class="top-left">
                <a href="{{ route('home') }}" class="navbar-brand"><img src="{{ asset('images/logoAdaKamar.png') }}"
                        alt="AdaKamar"></a>
            </div>

            <div class="top-right d-flex align-items-center">
                @auth
                    @if(auth()->user()->role === 'admin')


                        <div class="dropdown d-inline me-3">
                            <a class="text-white dropdown-toggle" href="#" role="button" id="adminMenu"
                                data-bs-toggle="dropdown">Manage</a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminMenu">
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.articles.index') }}">Articles</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.article-categories.index') }}">Article
                                        Categories</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.categories.index') }}">Categories</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.kamar.index') }}">Kamar</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.users.index') }}">Users</a></li>
                            </ul>
                        </div>
                    @endif
                    @if(auth()->user()->role === 'owner')
                        <a href="{{ route('owner.dashboard') }}" class="text-white me-3">Dashboard</a>
                    @endif

                    <div class="dropdown">
                        <a class="text-white dropdown-toggle" href="#" role="button" id="userTopMenu"
                            data-bs-toggle="dropdown">{{ auth()->user()->name }}</a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userTopMenu">
                            @if(auth()->user()->role === 'customer')
                                @php
                                    $activeBookings = auth()->user()->bookings()->whereIn('status', ['pending', 'paid', 'confirmed'])->count();
                                @endphp
                                @if($activeBookings > 0)
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center justify-content-between"
                                            href="{{ route('booking.my_rooms') }}">
                                            <span>Kamar Saya</span>
                                            <span class="badge bg-danger ms-2">{{ $activeBookings }}</span>
                                        </a>
                                    </li>
                                @endif
                            @endif
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <div class="auth-buttons">
                        <a href="{{ route('login') }}" class="btn-login">Masuk</a>
                        <a href="{{ route('register') }}" class="btn-register">Daftar</a>
                    </div>
                @endauth
            </div>
        </div>
    </div>

    <div class="header-inner bg-primary bg-dark">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container" style="max-width: 1200px; padding-left: 20px; padding-right: 20px;">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="mainNav">
                    <ul class="navbar-nav align-items-lg-center main-menu me-auto text-uppercase fw-semibold">
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                                href="{{ route('home') }}">Home</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('kamar.*') ? 'active' : '' }}"
                                href="{{ route('kamar.index') }}">Explore Kost!</a>
                        </li>
                        <li class="nav-item"><a
                                class="nav-link {{ (request()->routeIs('artikel.*') || request()->is('artikel*')) ? 'active' : '' }}"
                                href="{{ route('artikel.index') }}">Artikel</a></li>
                    </ul>

                    <div class="d-flex align-items-center">
                        <form action="{{ route('kamar.index') }}" method="GET"
                            class="d-flex navbar-search-form d-none d-lg-flex ms-3" role="search">
                            <input class="form-control navbar-search-input" type="search" name="search"
                                placeholder="Cari kamar atau lokasi...">
                            <!-- Desktop submit button -->
                            <button class="btn btn-search-nav d-none d-lg-inline-block ms-2" type="submit">Cari</button>
                            <!-- Mobile search icon (keeps the overlay behavior) -->
                            <button class="btn btn-search-icon d-lg-none text-white ms-3" id="mobileSearchBtn"
                                aria-label="Search"><i class="fas fa-search"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>
    </div>

    <!-- Mobile search overlay -->
    <div id="mobileSearchOverlay" class="mobile-search-overlay d-none">
        <div class="overlay-inner position-relative">
            <button class="overlay-close" id="mobileSearchClose" aria-label="Close">&times;</button>
            <form action="{{ route('kamar.index') }}" method="GET" class="d-flex w-100 overlay-search-form">
                <input type="search" name="search" class="form-control me-2" placeholder="Cari kamar atau lokasi..."
                    autocomplete="off">
                <button class="btn btn-search-nav" type="submit">Cari</button>
            </form>
        </div>
    </div>
</header>