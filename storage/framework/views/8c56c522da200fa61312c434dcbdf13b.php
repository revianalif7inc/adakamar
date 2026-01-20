

<?php $__env->startSection('title', 'Daftar Kamar'); ?>

<?php $__env->startSection('content'); ?>
    <div class="kamar-page">
        <div class="kamar-header">
            <div class="container">
                <h1>Daftar Kamar</h1>
            </div>
        </div>

        <div class="kamar-layout">
            <aside class="kamar-sidebar">
                    <div class="filters">
                        <h3>Filter</h3>
                        <form method="GET" action="<?php echo e(route('kamar.index')); ?>" class="filter-form">
                            <input type="text" name="search" placeholder="Cari kamar..." value="<?php echo e(request('search')); ?>">

                            <select name="location_id">
                                <option value="">Semua Lokasi</option>
                                <?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($loc->id); ?>" <?php echo e(request('location_id') == $loc->id ? 'selected' : ''); ?>>
                                        <?php echo e($loc->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>

                            <input type="number" name="min_price" placeholder="Min harga" value="<?php echo e(request('min_price')); ?>">
                            <input type="number" name="max_price" placeholder="Max harga" value="<?php echo e(request('max_price')); ?>">

                            <select name="sort">
                                <option value="">Urutkan</option>
                                <option value="price_asc" <?php echo e(request('sort') == 'price_asc' ? 'selected' : ''); ?>>Harga Terendah
                                </option>
                                <option value="price_desc" <?php echo e(request('sort') == 'price_desc' ? 'selected' : ''); ?>>Harga Tertinggi
                                </option>
                                <option value="rating" <?php echo e(request('sort') == 'rating' ? 'selected' : ''); ?>>Rating Tertinggi</option>
                                <option value="newest" <?php echo e(request('sort') == 'newest' ? 'selected' : ''); ?>>Terbaru</option>
                            </select>
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </form>
                    </div>

                    <?php if(isset($categories) && $categories->count()): ?>
                        <div class="categories-section">
                            <div class="section-header">
                                <div>
                                    <h3>Kategori</h3>
                                </div>
                                <div class="section-actions">
                                    <?php if(request('category')): ?>
                                        <a href="<?php echo e(route('kamar.index', request()->except(['page', 'category']))); ?>"
                                            class="btn btn-outline">Hapus Filter</a>
                                    <?php endif; ?>
                                    <a href="<?php echo e(route('categories.index')); ?>" class="btn btn-outline">Semua Kategori</a>
                                </div>
                            </div>

                            <div class="categories-chips" role="tablist" aria-label="Filter Kategori">
                                <a href="<?php echo e(route('kamar.index', request()->except(['page', 'category']))); ?>"
                                    class="category-chip <?php echo e(!request('category') ? 'active' : ''); ?>"
                                    aria-pressed="<?php echo e(!request('category') ? 'true' : 'false'); ?>">Semua <span
                                        class="cat-count"><?php echo e($homestays->total()); ?></span></a>

                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a href="<?php echo e(route('kamar.index', array_merge(request()->except(['page', 'category']), ['category' => $category->slug]))); ?>"
                                        class="category-chip <?php echo e(request('category') == $category->slug ? 'active' : ''); ?>"
                                        aria-pressed="<?php echo e(request('category') == $category->slug ? 'true' : 'false'); ?>">
                                        <span class="chip-icon"><?php echo e(strtoupper(substr($category->name, 0, 1))); ?></span>
                                        <span class="chip-name"><?php echo e($category->name); ?></span>
                                        <span class="chip-count"><?php echo e($category->homestays_count); ?></span>
                                    </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>

                            <div class="categories-grid">
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a href="<?php echo e(route('kamar.index', array_merge(request()->except(['page', 'category']), ['category' => $category->slug]))); ?>"
                                        class="category-card <?php echo e(request('category') == $category->slug ? 'active' : ''); ?>" role="link"
                                        aria-label="Kategori <?php echo e($category->name); ?>">
                                        <div class="cat-icon"><?php echo e(strtoupper(substr($category->name, 0, 1))); ?></div>

                                        <div class="cat-body">
                                            <h4><?php echo e($category->name); ?></h4>
                                            <?php if(!empty($category->description)): ?>
                                                <p class="cat-desc"><?php echo e(\Illuminate\Support\Str::limit($category->description, 80)); ?></p>
                                            <?php endif; ?>
                                        </div>

                                        <div class="category-meta">
                                            <span class="category-count" aria-hidden="true"><?php echo e($category->homestays_count); ?> unit</span>
                                        </div>

                                        <div class="card-arrow" aria-hidden="true"><i class="fa fa-angle-right"></i></div>
                                    </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </aside>

                <main class="kamar-main">

            <div class="kamar-grid">
                <?php $__empty_1 = true; $__currentLoopData = $homestays; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $homestay): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="kamar-card">
                        <?php if(!empty($homestay->image_url) && \Illuminate\Support\Facades\Storage::disk('public')->exists($homestay->image_url)): ?>
                            <img src="<?php echo e(asset('storage/' . $homestay->image_url)); ?>" alt="<?php echo e($homestay->name); ?>">
                        <?php else: ?>
                            <img src="<?php echo e(asset('images/homestays/placeholder.svg')); ?>" alt="placeholder">
                        <?php endif; ?>

                        <h3 title="<?php echo e($homestay->name); ?>"><?php echo e(\Illuminate\Support\Str::limit($homestay->name, 36)); ?></h3>
                        <p class="location">📍 <?php echo e($homestay->location); ?></p>
                        <p class="description"><?php echo e(\Illuminate\Support\Str::limit($homestay->description, 100)); ?></p>
                        <div class="kamar-info">
                            <span>🛏️ <?php echo e($homestay->bedrooms); ?> Kamar</span>
                            <span>🚿 <?php echo e($homestay->bathrooms); ?> Kamar Mandi</span>
                            <span>👥 Maks <?php echo e($homestay->max_guests); ?> Tamu</span>
                        </div>
                        <div class="card-meta">
                            <?php if($homestay->price_per_month): ?>
                                <div class="price-pill">Rp <?php echo e(number_format($homestay->price_per_month, 0, ',', '.')); ?> / bulan</div>
                            <?php elseif($homestay->price_per_year): ?>
                                <div class="price-pill">Rp <?php echo e(number_format($homestay->price_per_year, 0, ',', '.')); ?> / tahun</div>
                            <?php else: ?>
                                <div class="price-pill text-muted">Harga belum tersedia</div>
                            <?php endif; ?>
                            <div class="badge-rating">★ <?php echo e(number_format($homestay->rating ?? 0, 1)); ?></div>
                        </div>

                        <div class="owner-meta">
                            <div class="owner-avatar"><?php echo e(strtoupper(substr($homestay->owner->name ?? 'A', 0, 1))); ?></div>
                            <div class="owner-info">
                                <p class="owner-name" title="<?php echo e($homestay->owner->name ?? 'AdaKamar'); ?>">
                                    <?php echo e(\Illuminate\Support\Str::limit($homestay->owner->name ?? 'AdaKamar', 22)); ?>

                                </p>
                            </div>
                        </div>

                        <div class="kamar-card-actions">
                            <a href="<?php echo e(route('kamar.show', ['id' => $homestay->id, 'slug' => $homestay->slug ?? ''])); ?>"
                                class="btn btn-detail">
                                <i class="fa fa-eye"></i> Lihat Detail
                            </a>
                            <?php if(auth()->guard()->check()): ?>
                                <a href="<?php echo e(route('booking.create', $homestay->id)); ?>" class="btn btn-pesan">
                                    <i class="fa fa-envelope"></i> Pesan
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="no-results">Tidak ada kamar yang ditemukan</p>
                <?php endif; ?>
            </div>

            <?php echo e($homestays->links()); ?>

        </main>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/kamar.css')); ?>">
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\adakamar\resources\views/pages/kamar.blade.php ENDPATH**/ ?>