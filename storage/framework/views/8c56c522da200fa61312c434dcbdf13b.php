

<?php $__env->startSection('title', 'Daftar Kamar - AdaKamar'); ?>

<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/home-kamar.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/kamar-list.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="kamar-page-wrapper">
        <!-- Header dengan Animasi -->
        <div class="kamar-page-header">
            <div class="header-animated-bg">
                <div class="particle particle-1"></div>
                <div class="particle particle-2"></div>
                <div class="particle particle-3"></div>
                <div class="particle particle-4"></div>
                <div class="particle particle-5"></div>
            </div>
            <div class="header-content-wrapper">
                <div class="header-content">
                    <h1 class="header-title">Temukan Kamar Impianmu</h1>
                    <p class="header-subtitle">Ribuan pilihan kamar, kost, dan homestay berkualitas dengan harga terjangkau</p>
                    <div class="header-stats">
                        <div class="stat-item">
                            <i class="fas fa-home"></i>
                            <span><?php echo e($homestays->total()); ?>+ Kamar</span>
                        </div>
                        <div class="stat-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span><?php echo e($locations->count()); ?>+ Lokasi</span>
                        </div>
                        <div class="stat-item">
                            <i class="fas fa-star"></i>
                            <span>Rating Terbaik</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="kamar-page-content">
            <div class="kamar-content-container">
                <div class="kamar-layout-grid">
                    <!-- SIDEBAR FILTERS -->
                    <div class="kamar-sidebar">
                        <div class="sidebar-sticky">
                            <!-- Filter Search Card -->
                            <div class="filter-widget filter-search-widget">
                                <div class="widget-header">
                                    <h3><i class="fas fa-search"></i> Pencarian</h3>
                                    <span class="widget-icon"><i class="fas fa-filter"></i></span>
                                </div>
                                <form method="GET" action="<?php echo e(route('kamar.index')); ?>" class="filter-form">
                                    <div class="filter-input-group">
                                        <input type="text" name="search" class="filter-input" placeholder="Cari nama kamar..." value="<?php echo e(request('search')); ?>" autocomplete="off">
                                        <span class="input-icon"><i class="fas fa-magnifying-glass"></i></span>
                                    </div>

                                    <div class="filter-input-group">
                                        <select name="location_id" class="filter-select">
                                            <option value="">📍 Semua Lokasi</option>
                                            <?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($loc->id); ?>" <?php echo e(request('location_id') == $loc->id ? 'selected' : ''); ?>>
                                                    📍 <?php echo e($loc->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>

                                    <div class="filter-price-group">
                                        <label class="filter-label center">Rentang Harga</label>
                                        <div class="price-inputs">
                                            <input type="number" name="min_price" class="price-input" placeholder="Min" value="<?php echo e(request('min_price')); ?>">
                                            <input type="number" name="max_price" class="price-input" placeholder="Max" value="<?php echo e(request('max_price')); ?>">
                                        </div>
                                    </div>

                                    <div class="filter-input-group">
                                        <select name="sort" class="filter-select">
                                            <option value="">⬇️ Default</option>
                                            <option value="price_asc" <?php echo e(request('sort') == 'price_asc' ? 'selected' : ''); ?>>💰 Harga Terendah</option>
                                            <option value="price_desc" <?php echo e(request('sort') == 'price_desc' ? 'selected' : ''); ?>>💸 Harga Tertinggi</option>
                                            <option value="rating" <?php echo e(request('sort') == 'rating' ? 'selected' : ''); ?>>⭐ Rating Tertinggi</option>
                                            <option value="newest" <?php echo e(request('sort') == 'newest' ? 'selected' : ''); ?>>✨ Terbaru</option>
                                        </select>
                                    </div>

                                    <button type="submit" class="btn-filter-submit">
                                        <i class="fas fa-check-circle"></i> Terapkan Filter
                                    </button>
                                    <?php if(request()->has('search') || request()->has('location_id') || request()->has('min_price') || request()->has('max_price') || request()->has('sort')): ?>
                                        <a href="<?php echo e(route('kamar.index')); ?>" class="btn-clear-filter">
                                            <i class="fas fa-redo"></i> Reset Filter
                                        </a>
                                    <?php endif; ?>
                                </form>
                            </div>

                            <!-- Categories Widget -->
                            <?php if(isset($categories) && $categories->count()): ?>
                                <div class="filter-widget filter-categories-widget">
                                    <div class="widget-header">
                                        <h3><i class="fas fa-tag"></i> Kategori</h3>
                                    </div>
                                    <div class="categories-list">
                                        <a href="<?php echo e(route('kamar.index', request()->except(['page', 'category']))); ?>"
                                            class="category-item <?php echo e(!request('category') ? 'active' : ''); ?>">
                                            <span class="cat-icon">🏠</span>
                                            <span class="cat-name">Semua</span>
                                            <span class="cat-count"><?php echo e($homestays->total()); ?></span>
                                        </a>
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <a href="<?php echo e(route('kamar.index', array_merge(request()->except(['page', 'category']), ['category' => $category->slug]))); ?>"
                                                class="category-item <?php echo e(request('category') == $category->slug ? 'active' : ''); ?>">
                                                <span class="cat-icon">📌</span>
                                                <span class="cat-name"><?php echo e($category->name); ?></span>
                                                <span class="cat-count"><?php echo e($category->homestays_count); ?></span>
                                            </a>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Info Widget -->
                            <div class="filter-widget filter-info-widget">
                                <div class="widget-header">
                                    <h3><i class="fas fa-lightbulb"></i> Tips</h3>
                                </div>
                                <div class="info-content">
                                    <p>💡 Gunakan filter untuk menemukan kamar yang sesuai dengan kebutuhan dan budget Anda.</p>
                                    <div class="info-stats">
                                        <div class="stat"><strong><?php echo e($homestays->total()); ?></strong> <small>Kamar Tersedia</small></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- MAIN CONTENT -->
                    <div class="kamar-main-content">
                        <div class="results-header">
                            <div class="results-title-section">
                                <h2 class="results-title">
                                    <i class="fas fa-list"></i> Daftar Kamar
                                    <span class="results-count"><?php echo e($homestays->total()); ?></span>
                                </h2>
                                <p class="results-subtitle">Temukan kamar terbaik sesuai preferensi Anda</p>
                            </div>
                            <?php if(request()->has('search') || request()->has('location_id') || request()->has('min_price') || request()->has('max_price') || request()->has('category')): ?>
                                
                            <?php endif; ?>
                        </div>

                        <div class="kamar-list-grid">
                            <?php $__empty_1 = true; $__currentLoopData = $homestays; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $homestay): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="kamar-card-wrapper">
                                    <div class="kamar-card">
                                        <!-- Card Image Section -->
                                        <div class="card-image-container">
                                            <?php if(!empty($homestay->image_url) && \Illuminate\Support\Facades\Storage::disk('public')->exists($homestay->image_url)): ?>
                                                <img src="<?php echo e(asset('storage/' . $homestay->image_url)); ?>" alt="<?php echo e($homestay->name); ?>" class="kamar-image">
                                            <?php else: ?>
                                                <img src="<?php echo e(asset('images/homestays/placeholder.svg')); ?>" alt="placeholder" class="kamar-image">
                                            <?php endif; ?>
                                            <div class="card-badge">
                                                <?php if($homestay->rating): ?>
                                                    <div class="rating-badge">
                                                        <i class="fas fa-star"></i>
                                                        <span><?php echo e(number_format($homestay->rating, 1)); ?></span>
                                                    </div>
                                                <?php else: ?>
                                                    <div class="new-badge">NEW</div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="card-overlay"></div>
                                        </div>

                                        <!-- Card Body -->
                                        <div class="kamar-body">
                                            <!-- Title & Location -->
                                            <div class="card-header-section">
                                                <h3 class="kamar-title" title="<?php echo e($homestay->name); ?>">
                                                    <?php echo e(\Illuminate\Support\Str::limit($homestay->name, 36)); ?>

                                                </h3>
                                                <p class="kamar-location">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                    <?php echo e($homestay->location); ?>

                                                </p>
                                            </div>

                                            <!-- Description -->
                                            <p class="kamar-description">
                                                <?php echo e(\Illuminate\Support\Str::limit($homestay->description ?? 'Kamar nyaman dan berkualitas', 80)); ?>

                                            </p>

                                            <!-- Features -->
                                            <div class="kamar-features">
                                                <span class="feature-item" title="Jumlah Kamar Tidur">
                                                    <i class="fas fa-bed"></i>
                                                    <?php echo e($homestay->bedrooms ?? '-'); ?> Kamar
                                                </span>
                                                <span class="feature-item" title="Jumlah Kamar Mandi">
                                                    <i class="fas fa-bath"></i>
                                                    <?php echo e($homestay->bathrooms ?? '-'); ?> Mandi
                                                </span>
                                                <span class="feature-item" title="Kapasitas Penghuni">
                                                    <i class="fas fa-users"></i>
                                                    <?php echo e($homestay->max_guests ?? '-'); ?> Tamu
                                                </span>
                                            </div>

                                            <!-- Price Section -->
                                            <div class="price-section">
                                                <?php if($homestay->price_per_month): ?>
                                                    <p class="price-label">Mulai dari</p>
                                                    <p class="price-amount">
                                                        <span class="currency">Rp</span>
                                                        <?php echo e(number_format($homestay->price_per_month, 0, ',', '.')); ?>

                                                        <span class="period">/bulan</span>
                                                    </p>
                                                <?php elseif($homestay->price_per_year): ?>
                                                    <p class="price-label">Mulai dari</p>
                                                    <p class="price-amount">
                                                        <span class="currency">Rp</span>
                                                        <?php echo e(number_format($homestay->price_per_year, 0, ',', '.')); ?>

                                                        <span class="period">/tahun</span>
                                                    </p>
                                                <?php else: ?>
                                                    <p class="price-amount text-muted">Hubungi Pemilik</p>
                                                <?php endif; ?>
                                            </div>

                                            <!-- Owner Info -->
                                            <div class="owner-section">
                                                <div class="owner-avatar" style="background: linear-gradient(135deg, #0077be, #f39c12);">
                                                    <?php echo e(strtoupper(substr($homestay->owner->name ?? 'A', 0, 1))); ?>

                                                </div>
                                                <div class="owner-details">
                                                    <p class="owner-name"><?php echo e(\Illuminate\Support\Str::limit($homestay->owner->name ?? 'AdaKamar', 20)); ?></p>
                                                    <p class="owner-role">Pemilik</p>
                                                </div>
                                            </div>

                                            <!-- Action Buttons -->
                                            <div class="card-actions">
                                                <a href="<?php echo e(route('kamar.show', ['id' => $homestay->id, 'slug' => $homestay->slug ?? ''])); ?>" class="btn-action btn-detail">
                                                    <i class="fas fa-eye"></i>
                                                    <span>Lihat Detail</span>
                                                </a>
                                                <?php if(auth()->guard()->check()): ?>
                                                    <a href="<?php echo e(route('booking.create', $homestay->id)); ?>" class="btn-action btn-pesan">
                                                        <i class="fas fa-envelope"></i>
                                                        <span>Pesan</span>
                                                    </a>
                                                <?php else: ?>
                                                    <a href="<?php echo e(route('login')); ?>" class="btn-action btn-pesan">
                                                        <i class="fas fa-sign-in-alt"></i>
                                                        <span>Login</span>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div class="no-results-container">
                                    <div class="no-results-content">
                                        <i class="fas fa-search"></i>
                                        <h3>Kamar Tidak Ditemukan</h3>
                                        <p>Kami tidak menemukan kamar yang sesuai dengan kriteria pencarian Anda</p>
                                        <div class="no-results-suggestions">
                                            <p>Coba:</p>
                                            <ul>
                                                <li>🔍 Ubah kata kunci pencarian</li>
                                                <li>📍 Pilih lokasi yang berbeda</li>
                                                <li>💰 Naikkan batas harga maksimal</li>
                                                <li>🔄 Reset semua filter</li>
                                            </ul>
                                        </div>
                                        <a href="<?php echo e(route('kamar.index')); ?>" class="btn-reset-search">
                                            <i class="fas fa-redo"></i> Lihat Semua Kamar
                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Pagination -->
                        <div class="pagination-section">
                            <?php echo e($homestays->links('pagination::bootstrap-5')); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\adakamar\resources\views/pages/kamar.blade.php ENDPATH**/ ?>