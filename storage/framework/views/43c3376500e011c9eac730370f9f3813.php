<header class="site-header sticky-top">
    <div class="header-top bg-dark text-white">
        <div class="container d-flex align-items-center justify-content-between">
            <div class="top-left">
                <a href="<?php echo e(route('home')); ?>" class="navbar-brand"><img src="<?php echo e(asset('images/logoAdaKamar.png')); ?>"
                        alt="AdaKamar"></a>
            </div>

            <div class="top-right d-flex align-items-center">
                <?php if(auth()->guard()->check()): ?>
                    <?php if(auth()->user()->role === 'admin'): ?>
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="text-white me-3">Dashboard</a>

                        <div class="dropdown d-inline me-3">
                            <a class="text-white dropdown-toggle" href="#" role="button" id="adminMenu"
                                data-bs-toggle="dropdown">Manage</a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminMenu">
                                <li><a class="dropdown-item" href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
                                <li><a class="dropdown-item" href="<?php echo e(route('admin.articles.index')); ?>">Articles</a></li>
                                <li><a class="dropdown-item" href="<?php echo e(route('admin.article-categories.index')); ?>">Article
                                        Categories</a></li>
                                <li><a class="dropdown-item" href="<?php echo e(route('admin.categories.index')); ?>">Categories</a></li>
                                <li><a class="dropdown-item" href="<?php echo e(route('admin.kamar.index')); ?>">Kamar</a></li>
                                <li><a class="dropdown-item" href="<?php echo e(route('admin.users.index')); ?>">Users</a></li>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <?php if(auth()->user()->role === 'owner'): ?>
                        <a href="<?php echo e(route('owner.dashboard')); ?>" class="text-white me-3">Dashboard</a>
                    <?php endif; ?>

                    <div class="dropdown">
                        <a class="text-white dropdown-toggle" href="#" role="button" id="userTopMenu"
                            data-bs-toggle="dropdown"><?php echo e(auth()->user()->name); ?></a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userTopMenu">
                            <?php if(auth()->user()->role === 'customer'): ?>
                                <?php
                                    $activeBookings = auth()->user()->bookings()->whereIn('status', ['pending','paid','confirmed'])->count();
                                ?>
                                <?php if($activeBookings > 0): ?>
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center justify-content-between"
                                           href="<?php echo e(route('booking.my_rooms')); ?>">
                                            <span>Kamar Saya</span>
                                            <span class="badge bg-danger ms-2"><?php echo e($activeBookings); ?></span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            <?php endif; ?>
                            <li>
                                <form action="<?php echo e(route('logout')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <button class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="text-white me-3">Masuk</a>
                    <a href="<?php echo e(route('register')); ?>" class="btn btn-host btn-sm">Jadi Host!</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="header-inner bg-primary bg-dark">
        <nav class="navbar navbar-expand-lg navbar-dark container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav align-items-lg-center main-menu me-auto text-uppercase fw-semibold">
                    <li class="nav-item"><a class="nav-link <?php echo e(request()->routeIs('home') ? 'active' : ''); ?>" href="<?php echo e(route('home')); ?>">Home</a></li>
                    <li class="nav-item"><a class="nav-link <?php echo e(request()->routeIs('kamar.*') ? 'active' : ''); ?>" href="<?php echo e(route('kamar.index')); ?>">Explore Kost!</a>
                    </li>
                    <li class="nav-item"><a class="nav-link <?php echo e((request()->routeIs('artikel.*') || request()->is('artikel*')) ? 'active' : ''); ?>" href="<?php echo e(route('artikel.index')); ?>">Artikel</a></li>
                </ul>

                <div class="d-flex align-items-center">
                    <form action="<?php echo e(route('kamar.index')); ?>" method="GET" class="d-flex navbar-search-form d-none d-lg-flex ms-3"
                        role="search">
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
        </nav>
    </div>

    <!-- Mobile search overlay -->
    <div id="mobileSearchOverlay" class="mobile-search-overlay d-none">
        <div class="overlay-inner position-relative">
            <button class="overlay-close" id="mobileSearchClose" aria-label="Close">&times;</button>
            <form action="<?php echo e(route('kamar.index')); ?>" method="GET" class="d-flex w-100 overlay-search-form">
                <input type="search" name="search" class="form-control me-2" placeholder="Cari kamar atau lokasi..."
                    autocomplete="off">
                <button class="btn btn-search-nav" type="submit">Cari</button>
            </form>
        </div>
    </div>
</header><?php /**PATH C:\xampp\htdocs\adakamar\resources\views/components/header.blade.php ENDPATH**/ ?>