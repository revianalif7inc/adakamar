

<?php $__env->startSection('title', 'Beranda'); ?>

<?php $__env->startSection('content'); ?>
    <div class="hero-section">
        <div class="container">
            <div class="hero-row">
                <div class="hero-left animate-on-scroll">
                    <h1>Selamat Datang di AdaKamar</h1>
                    <p>Temukan dan sewa kamar terbaik di Indonesia</p>

                    <div class="hero-search">
                        <form action="<?php echo e(route('kamar.index')); ?>" method="GET" class="search-box" id="homeSearchForm">
                            <input type="text" name="search" class="form-control search-input"
                                placeholder="Cari kamar, lokasi, atau fasilitas..." value="<?php echo e(request('search')); ?>">

                            <select name="location_id" class="form-select search-select" id="homeLocationSelect">
                                <option value="">Semua Lokasi</option>
                                <?php $__currentLoopData = $topLocations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                        <img src="<?php echo e(asset('images/homestays/placeholder.jpg')); ?>" alt="Ilustrasi homestay">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="featured-kamar">
        <div class="container">
                <div class="card-slider-header animate-on-scroll">
                <div class="section-divider"></div>
                <h2>Kamar Pilihan</h2>
                <p class="text-muted">Pilihan kamar yang dipilih oleh admin untuk rekomendasi terbaik.</p>
            </div>
        </div>

        <div class="container">
            <div class="kamar-grid">
                <?php $__empty_1 = true; $__currentLoopData = $featuredHomestays->take(6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $homestay): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="kamar-card card-item h-100 shadow-sm animate-on-scroll">
                        <a class="card-link" href="<?php echo e(route('kamar.show', $homestay)); ?>">
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
                            <a href="<?php echo e(route('kamar.show', $homestay)); ?>" class="btn btn-detail">Lihat Detail</a>
                            <?php if(auth()->guard()->check()): ?>
                                <a href="<?php echo e(route('booking.create', $homestay->slug)); ?>" class="btn btn-pesan">Pesan</a>
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
            <div class="card-slider-header animate-on-scroll">
                <div class="section-divider"></div>
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
                        <a class="card-item" href="<?php echo e(route('kamar.show', $h)); ?>">
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


    <!-- Testimonials Slider -->
    <div class="testimonials-section">
        <div class="container">
            <div class="card-slider-header centered animate-on-scroll">
                <div class="section-divider"></div>
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


    <!-- About Us Section -->
    <div class="about-us-section">
        <div class="container">
            <div class="about-wrapper">
                <div class="about-image animate-on-scroll">
                    <div class="about-image-container">
                        <img src="<?php echo e(asset('images/homestays/villaplaceholder.jpg')); ?>" alt="Villa Ada Kamar" class="about-main-image">
                        <div class="about-image-overlay"></div>
                    </div>
                </div>
                
                <div class="about-text-content animate-on-scroll">
                    <div class="about-heading">
                        <h2 class="about-title">Apa itu <span class="highlight-text">Ada Kamar</span>?</h2>
                    </div>
                    
                    <p class="about-description">
                        AdaKamar adalah perusahaan hospitality yang menawarkan pengalaman menginap dengan konsep bertamu ala Indonesia. 
                        Dengan tagline "Bertamu Ala Indonesia", di AdaKamar, Anda akan merasakan keramahtamahan khas Indonesia yang ditunjukkan 
                        oleh tuan rumah. Setiap unit pengingapan kami dilengkapi dengan fasilitas yang mencerminkan budaya lokal, memastikan 
                        kenyamanan dan suasana yang autentik selama Anda menginap.
                    </p>
                    
                    <a href="<?php echo e(route('about')); ?>" class="btn btn-primary btn-lg about-cta">
                        <span>Lebih lanjut</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Become Owner CTA -->
    <div class="become-owner-section">
        <div class="container">
            <div class="owner-wrapper">
                <div class="owner-image animate-on-scroll">
                    <div class="owner-image-container">
                        <img src="<?php echo e(asset('images/homestays/woman.jpg')); ?>" alt="Jadilah Owner AdaKamar" class="owner-main-image">
                    </div>
                </div>
                
                <div class="owner-text-content animate-on-scroll">
                    <div class="owner-heading">
                        <h2 class="owner-title">Yakin gamau sewa di Adakamar?</h2>
                    </div>
                    
                    <p class="owner-description">
                        Kami menawarkan fasilitas modern yang nyaman, keramahan khas Indonesia yang membuat Anda merasa seperti di rumah sendiri, lokasi strategis yang ideal untuk liburan atau perjalanan bisnis, harga terjangkau, sistem keamanan canggih untuk kenyamanan Anda, dan layanan profesional dari staf yang siap melayani dengan ramah.
                    </p>
                    
                    <a href="javascript:void(0)" class="btn btn-owner-cta owner-cta">
                        <span>Pesan Sekarang!</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/home.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script src="<?php echo e(asset('js/card-slider.js')); ?>"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const locationSelect = document.getElementById('homeLocationSelect');
            if (locationSelect) {
                // Set size to force dropdown to show all options and open downward
                locationSelect.addEventListener('mousedown', function(e) {
                    this.size = Math.min(6, this.options.length);
                });
                locationSelect.addEventListener('change', function() {
                    this.size = 0; // Reset to normal
                });
                locationSelect.addEventListener('blur', function() {
                    this.size = 0; // Reset to normal
                });
            }
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\adakamar\resources\views/pages/home.blade.php ENDPATH**/ ?>