

<?php $__env->startSection('title', 'Beranda'); ?>

<?php $__env->startSection('content'); ?>
    <div class="hero-section">
        <div class="container">
            <div class="hero-row">
                <div class="hero-left">
                    <h1>Selamat Datang di AdaKamar</h1>
                    <p>Temukan dan sewa kamar terbaik di Indonesia</p>

                    <div class="hero-search">
                        <form action="<?php echo e(route('kamar.index')); ?>" method="GET" class="search-box">
                            <input type="text" name="search" class="form-control search-input"
                                placeholder="Cari kamar, lokasi, atau fasilitas..." value="<?php echo e(request('search')); ?>" required>

                            <select name="location_id" class="form-select search-select">
                                <option value="">Semua Lokasi</option>
                                <?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($loc->id); ?>" <?php echo e(request('location_id') == $loc->id ? 'selected' : ''); ?>>
                                        <?php echo e($loc->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>

                            <button type="submit" class="btn btn-search">Cari</button>
                        </form>
                    </div>
                </div>

                <div class="hero-right d-none d-md-block">
                    <div class="hero-visual" aria-hidden="true">
                        <img src="<?php echo e(asset('images/homestays/placeholder.svg')); ?>" alt="Ilustrasi homestay">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="featured-kamar">
        <div class="container">
            <div class="card-slider-header">
                <h2>Kamar Pilihan</h2>
                <p class="text-muted">Pilihan kamar yang dipilih oleh admin untuk rekomendasi terbaik.</p>
            </div>
        </div>

        <div class="container">
            <div class="kamar-grid">
                <?php $__empty_1 = true; $__currentLoopData = $featuredHomestays->take(6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $homestay): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="kamar-card card-item h-100 shadow-sm">
                        <a class="card-link" href="<?php echo e(route('kamar.show', ['id' => $homestay->id, 'slug' => $homestay->slug ?? ''])); ?>">
                            <div class="kamar-image card-image">
                                <?php if(!empty($homestay->image_url) && \Illuminate\Support\Facades\Storage::disk('public')->exists($homestay->image_url)): ?>
                                    <img loading="lazy" src="<?php echo e(asset('storage/' . $homestay->image_url)); ?>" alt="<?php echo e($homestay->name); ?>">
                                <?php else: ?>
                                    <img loading="lazy" src="<?php echo e(asset('images/homestays/placeholder.svg')); ?>" alt="placeholder">
                                <?php endif; ?>
                                <div class="pin-badge" aria-hidden="true"><i class="fa fa-map-marker-alt"></i></div>
                            </div>

                            <div class="kamar-body card-body">
                                <div class="kamar-title-row">
                                    <h3 title="<?php echo e($homestay->name); ?>"><?php echo e(\Illuminate\Support\Str::limit($homestay->name, 36)); ?></h3>
                                </div>

                                <p class="excerpt"><?php echo e(\Illuminate\Support\Str::limit($homestay->description ?? 'Homestay nyaman dan bersih.', 90)); ?></p>

                                <div class="dotted-divider" aria-hidden="true"></div>

                                <div class="card-meta d-flex align-items-center justify-content-center gap-4">
                                    <?php if($homestay->price_per_month): ?>
                                        <div class="price-pill">Rp <?php echo e(number_format($homestay->price_per_month, 0, ',', '.')); ?> / bulan</div>
                                    <?php elseif($homestay->price_per_year): ?>
                                        <div class="price-pill">Rp <?php echo e(number_format($homestay->price_per_year, 0, ',', '.')); ?> / tahun</div>
                                    <?php else: ?>
                                        <div class="price-pill text-muted">Harga belum tersedia</div>
                                    <?php endif; ?>
                                    <div class="badge-rating">★ <?php echo e(number_format($homestay->rating ?? 0, 2)); ?></div>
                                </div>
                            </div>
                        </a>

                        <div class="kamar-actions p-3 d-flex gap-2 justify-content-center">
                            <a href="<?php echo e(route('kamar.show', ['id' => $homestay->id, 'slug' => $homestay->slug ?? ''])); ?>" class="btn btn-detail">Lihat Detail</a>
                            <?php if(auth()->guard()->check()): ?>
                                <a href="<?php echo e(route('booking.create', $homestay->id)); ?>" class="btn btn-pesan">Pesan</a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-muted">Belum ada kamar pilihan saat ini</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="container">
            <div class="center-cta">
                <a href="<?php echo e(route('kamar.index')); ?>" class="btn btn-primary">Lihat Lainnya <span class="btn-icon"><i class="fa fa-arrow-right"></i></span></a>
            </div>
        </div>
    </div>

    <div class="card-slider-section">
        <div class="container">
            <div class="card-slider-header">
                <div class="section-stars">★ ★ ★</div>
                <h2>Homestay Jogja Terbaik</h2>
                <p>Nikmati Keseruan Bersama Rombongan Dengan Memilih Homestay Jogja Terbaik</p>
            </div>
        </div>

        <!-- Full-bleed slider wrapper -->
        <div class="card-slider-bleed">
            <div class="card-slider" data-slider-type="homestay" data-autoplay="4500" role="region"
                aria-label="Slider Homestay Terbaik">
                <div class="slider-nav prev"><button class="slider-button prev" aria-label="Sebelumnya"><i
                            class="fa fa-chevron-left"></i></button></div>
                <div class="slider-nav next"><button class="slider-button next" aria-label="Selanjutnya"><i
                            class="fa fa-chevron-right"></i></button></div>

                <div class="cards-track" role="list">
                    <?php $__empty_1 = true; $__currentLoopData = $jogjaTopHomestays; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <a class="card-item" href="<?php echo e(route('kamar.show', ['id' => $h->id, 'slug' => $h->slug ?? ''])); ?>">
                            <div class="card-image">
                                <?php if(!empty($h->image_url) && \Illuminate\Support\Facades\Storage::disk('public')->exists($h->image_url)): ?>
                                    <img loading="lazy" src="<?php echo e(asset('storage/' . $h->image_url)); ?>" alt="<?php echo e($h->name); ?>">
                                <?php else: ?>
                                    <img loading="lazy" src="<?php echo e(asset('images/homestays/placeholder.svg')); ?>" alt="placeholder">
                                <?php endif; ?>
                            </div>

                            <div class="card-body">
                                <h3 title="<?php echo e($h->name); ?>"><?php echo e(\Illuminate\Support\Str::limit($h->name, 36)); ?></h3>
                                <div class="meta">
                                    <span class="location"><i class="fa fa-map-marker-alt icon-highlight"></i><?php echo e($h->location); ?></span>
                                    <span class="meta-rooms"><?php echo e($h->rooms ?? '—'); ?> kamar</span>
                                </div>
                                <p class="excerpt">
                                    <?php echo e(\Illuminate\Support\Str::limit($h->description ?? 'Homestay nyaman dan bersih, cocok untuk keluarga dan rombongan.', 110)); ?>

                                </p>

                                <div class="card-footer">
                                        <?php if($h->price_per_month): ?>
                                            <div class="price-pill">Rp <?php echo e(number_format($h->price_per_month, 0, ',', '.')); ?> / bulan</div>
                                        <?php elseif($h->price_per_year): ?>
                                            <div class="price-pill">Rp <?php echo e(number_format($h->price_per_year, 0, ',', '.')); ?> / tahun</div>
                                        <?php else: ?>
                                            <div class="price-pill text-muted">Harga belum tersedia</div>
                                        <?php endif; ?>
                                        <div class="badge-rating">★ <?php echo e(number_format($h->rating ?? 0, 2)); ?></div>
                                    </div>
                            </div>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p>Tidak ada homestay yang ditampilkan.</p>
                    <?php endif; ?>
                </div>

                <div class="slider-dots" aria-hidden="false"></div>

            </div>
        </div>

        <div class="container">
            <div class="center-cta">
                <a href="<?php echo e(route('kamar.index', ['search' => 'Yogyakarta'])); ?>" class="btn btn-primary">Lihat Lainnya <span class="btn-icon"><i
                            class="fa fa-arrow-right"></i></span></a>
            </div>
        </div>
    </div>

    <!-- Kamar Murah (cheapest) -->
    <div class="cheap-kamar mt-5">
        <div class="container">
            <div class="card-slider-header">
                <h2>Kamar Murah</h2>
                <p class="text-muted">Kamar dengan harga termurah — cocok untuk anggaran terbatas.</p>
            </div>
        </div>

        <div class="container">
            <div class="kamar-grid">
                <?php if(isset($cheapestHomestays) && $cheapestHomestays->count()): ?>
                    <?php $__currentLoopData = $cheapestHomestays->take(6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $homestay): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="kamar-card card-item h-100 shadow-sm">
                            <a class="card-link" href="<?php echo e(route('kamar.show', ['id' => $homestay->id, 'slug' => $homestay->slug ?? ''])); ?>">
                                <div class="kamar-image card-image">
                                    <?php if(!empty($homestay->image_url) && \Illuminate\Support\Facades\Storage::disk('public')->exists($homestay->image_url)): ?>
                                        <img loading="lazy" src="<?php echo e(asset('storage/' . $homestay->image_url)); ?>" alt="<?php echo e($homestay->name); ?>">
                                    <?php else: ?>
                                        <img loading="lazy" src="<?php echo e(asset('images/homestays/placeholder.svg')); ?>" alt="placeholder">
                                    <?php endif; ?>
                                    <div class="pin-badge" aria-hidden="true"><i class="fa fa-map-marker-alt"></i></div>
                                    <div class="cheap-badge" aria-hidden="true">Termurah</div>
                                </div>

                                <div class="kamar-body card-body">
                                    <div class="kamar-title-row">
                                        <h3 title="<?php echo e($homestay->name); ?>"><?php echo e(\Illuminate\Support\Str::limit($homestay->name, 36)); ?></h3>
                                    </div>

                                    <p class="excerpt"><?php echo e(\Illuminate\Support\Str::limit($homestay->description ?? 'Homestay nyaman dan bersih.', 90)); ?></p>

                                    <div class="dotted-divider" aria-hidden="true"></div>

                                    <div class="card-meta d-flex align-items-center justify-content-center gap-4">
                                        <?php if($homestay->price_per_month): ?>
                                            <div class="price-pill">Rp <?php echo e(number_format($homestay->price_per_month, 0, ',', '.')); ?> / bulan</div>
                                        <?php elseif($homestay->price_per_year): ?>
                                            <div class="price-pill">Rp <?php echo e(number_format($homestay->price_per_year, 0, ',', '.')); ?> / tahun</div>
                                        <?php else: ?>
                                            <div class="price-pill text-muted">Harga belum tersedia</div>
                                        <?php endif; ?>
                                        <div class="badge-rating">★ <?php echo e(number_format($homestay->rating ?? 0, 2)); ?></div>
                                    </div>
                                </div>
                            </a>

                            <div class="kamar-actions p-3 d-flex gap-2 justify-content-center">
                                <a href="<?php echo e(route('kamar.show', ['id' => $homestay->id, 'slug' => $homestay->slug ?? ''])); ?>" class="btn btn-detail">Lihat Detail</a>
                                <?php if(auth()->guard()->check()): ?>
                                    <a href="<?php echo e(route('booking.create', $homestay->id)); ?>" class="btn btn-pesan">Pesan</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <p class="text-muted">Belum ada data kamar murah untuk saat ini.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="container">
            <div class="center-cta">
                <a href="<?php echo e(route('kamar.index')); ?>" class="btn btn-primary">Lihat Semua Kamar <span class="btn-icon"><i class="fa fa-arrow-right"></i></span></a>
            </div>
        </div>
    </div>


    


    <!-- Testimonials Slider -->
    <div class="testimonials-section">
        <div class="container">
            <div class="card-slider-header centered">
                <h2>Apa Kata Penghuni Kost</h2>
                <p class="text-muted">Testimoni tamu kami memberikan gambaran nyata tentang pengalaman menginap mereka.</p>
            </div>

            <div class="card-slider testimonials-slider" data-slider-type="testimonial" data-autoplay="6000" role="region"
                aria-label="Slider Testimoni Pengunjung">
                <div class="slider-nav prev"><button class="slider-button prev" aria-label="Sebelumnya"><i
                            class="fa fa-chevron-left"></i></button></div>
                <div class="slider-nav next"><button class="slider-button next" aria-label="Selanjutnya"><i
                            class="fa fa-chevron-right"></i></button></div>

                <div class="cards-track" role="list">
                    <?php $__empty_1 = true; $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="card-item testimonial-item">
                            <div class="card-body">
                                <p class="excerpt">
                                    "<?php echo e(\Illuminate\Support\Str::limit($t->comment ?? 'Pengalaman menginap yang menyenangkan.', 160)); ?>"
                                </p>
                                <div class="testimonial-meta">
                                    <div class="owner-avatar large"><?php echo e(strtoupper(substr($t->user->name ?? 'G', 0, 1))); ?></div>
                                    <div>
                                        <div class="owner-name"><?php echo e($t->user->name ?? 'Tamu'); ?>

                                        </div>
                                        <div class="text-muted muted-small">di
                                            <?php echo e($t->homestay->name ?? 'Homestay'); ?> • ★ <?php echo e(number_format($t->rating, 1)); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p>Tidak ada testimoni tersedia.</p>
                    <?php endif; ?>
                </div>

                <div class="slider-dots" aria-hidden="false"></div>
            </div>
        </div>
    </div>


    <!-- Become Owner CTA -->
    <div class="become-owner-section py-5 bg-light">
        <div class="container text-center">
            <h2>Ingin Jadi Owner?!</h2>
            <p class="text-muted mb-3">Daftarkan kamar Anda dan dapatkan tamu dari seluruh Indonesia. Hubungi kami melalui WhatsApp untuk bantuan pendaftaran cepat.</p>
            <?php
                $waNumber = env('WHATSAPP_NUMBER', '628123456789');
                $waMessage = urlencode('Halo AdaKamar, saya ingin mendaftarkan kamar sebagai owner. Bisa dibantu?');
            ?>
            <a class="btn btn-success btn-lg" href="https://wa.me/<?php echo e($waNumber); ?>?text=<?php echo e($waMessage); ?>" target="_blank" rel="noopener">
                <i class="fab fa-whatsapp"></i> Hubungi via WhatsApp
            </a>
        </div>
    </div>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/home.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script src="<?php echo e(asset('js/card-slider.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\adakamar\resources\views/pages/home.blade.php ENDPATH**/ ?>