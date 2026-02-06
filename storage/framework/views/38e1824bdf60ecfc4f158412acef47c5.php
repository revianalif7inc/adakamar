

<?php $__env->startSection('title', 'Detail Kamar'); ?>

<?php $__env->startSection('content'); ?>
    <div class="kamar-detail">
        <div class="container">
            <div class="detail-tabs">
                <a href="#gallery" class="tab-link active">Gallery</a>
                <a href="#detail" class="tab-link">Detail</a>
                <a href="#fasilitas" class="tab-link">Fasilitas</a>
                <a href="#reviews" class="tab-link">Reviews</a>
            </div>

            <div class="detail-grid">
                <div class="detail-left">
                    <section id="gallery" class="gallery-section">
                        <div class="image-slider-container">
                            <div class="image-slider-wrapper">
                                <div class="image-slider" id="imageSlider">
                                    <?php
                                        $images = $homestay->gallery ?? [];
                                        // DEBUG: Log gallery images
                                        \Illuminate\Support\Facades\Log::info('Gallery debug', [
                                            'homestay_id' => $homestay->id,
                                            'homestay_name' => $homestay->name,
                                            'images_count' => count($images),
                                            'images' => $images,
                                            'image_url' => $homestay->image_url,
                                            'raw_images_field' => $homestay->images,
                                        ]);
                                    ?>

                                    <?php $__empty_1 = true; $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <div class="image-slider-item">
                                            <?php
                                                $exists = \Illuminate\Support\Facades\Storage::disk('public')->exists($img);
                                                $asset_url = asset('storage/' . $img);
                                                \Illuminate\Support\Facades\Log::info('Image debug', [
                                                    'img_path' => $img,
                                                    'exists' => $exists,
                                                    'asset_url' => $asset_url,
                                                ]);
                                            ?>
                                            <?php if($exists): ?>
                                                <img src="<?php echo e($asset_url); ?>" alt="<?php echo e($homestay->name); ?>" loading="lazy" style="display: block;">
                                            <?php else: ?>
                                                <img src="<?php echo e(asset('images/homestays/placeholder.svg')); ?>" alt="placeholder" loading="lazy" style="display: block;">
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <div class="image-slider-item">
                                            <img src="<?php echo e(asset('images/homestays/placeholder.svg')); ?>" alt="placeholder" loading="lazy" style="display: block;">
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <button type="button" class="slider-nav-button prev" id="prevBtn" aria-label="Previous image">❮</button>
                                <button type="button" class="slider-nav-button next" id="nextBtn" aria-label="Next image">❯</button>
                            </div>

                            <div class="thumbnail-strip" id="thumbStrip">
                                <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="thumb-item" data-index="<?php echo e($idx); ?>" role="button" tabindex="0">
                                        <?php if(\Illuminate\Support\Facades\Storage::disk('public')->exists($img)): ?>
                                            <img src="<?php echo e(asset('storage/' . $img)); ?>" alt="thumb-<?php echo e($idx); ?>">
                                        <?php else: ?>
                                            <img src="<?php echo e(asset('images/homestays/placeholder.svg')); ?>" alt="thumb-placeholder">
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>

                        </div>
                    </section>

                    <section id="detail" class="content-section">
                        <h2><?php echo e($homestay->name); ?></h2>
                        <p class="location">📍 <?php echo e($homestay->location); ?></p>
                        <p class="rating">⭐ Rating: <?php echo e($homestay->rating ?? 'Belum dinilai'); ?></p>

                        <h3>Deskripsi</h3>
                        <p class="description-text"><?php echo e($homestay->description); ?></p>
                    </section>

                    <section id="fasilitas" class="content-section">
                        <h3>Fasilitas</h3>
                        <div class="facilities-grid">
                            <?php $__currentLoopData = $homestay->amenities ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $amenity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="facility-item">✓ <?php echo e($amenity); ?></div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        <h3 class="mt-4">Detail Kamar</h3>
                        <ul class="room-info">
                            <li>🛏️ Kamar Tidur: <?php echo e($homestay->bedrooms); ?></li>
                            <li>🚿 Kamar Mandi: <?php echo e($homestay->bathrooms); ?></li>
                            <li>👥 Kapasitas Maksimal: <?php echo e($homestay->max_guests); ?> Tamu</li>
                        </ul>

                        <h3 class="mt-4">Detail Lengkap</h3>
                        <div class="detail-full">
                            <?php echo nl2br(e($homestay->description)); ?>

                        </div>
                    </section>

                    <section id="reviews" class="content-section reviews-section">
                        <h3>Ulasan Tamu</h3>

                        
                        <?php if(auth()->guard()->check()): ?>
                            <?php
                                $canReview = auth()->user()->bookings()->where('homestay_id', $homestay->id)->whereIn('status', ['confirmed', 'completed'])->exists();
                            ?>

                            <?php if($canReview): ?>
                                <div class="review-form">
                                    <h4>Berikan Ulasan Anda</h4>

                                    <?php if(session('error')): ?>
                                        <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
                                    <?php endif; ?>

                                    <form action="<?php echo e(route('reviews.store', ['id' => $homestay->id])); ?>" method="POST" id="reviewForm">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="rating" id="reviewRating" value="<?php echo e($userReview->rating ?? 0); ?>">

                                        <div class="star-picker">
                                            <?php for($i=1; $i<=5; $i++): ?>
                                                <i class="fas fa-star rating-star star-toggle" data-value="<?php echo e($i); ?>"></i>
                                            <?php endfor; ?>
                                        </div>

                                        <div class="form-group mt-2">
                                            <textarea name="comment" class="form-control" placeholder="Tulis komentar (opsional)"><?php echo e($userReview->comment ?? ''); ?></textarea>
                                        </div>

                                        <div class="mt-2">
                                            <button class="btn btn-primary">Kirim Ulasan</button>
                                            <?php if($userReview): ?>
                                                <small class="text-muted ms-2">Anda dapat mengubah ulasan Anda kapan saja.</small>
                                            <?php endif; ?>
                                        </div>
                                    </form>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-info">Anda hanya dapat memberi ulasan setelah melakukan booking dan mendapatkan konfirmasi / selesai.</div>
                            <?php endif; ?>
                        <?php else: ?>
                            <p><a href="<?php echo e(route('login')); ?>">Masuk</a> untuk memberi ulasan.</p>
                        <?php endif; ?>

                        
                        <div class="mt-4">
                            <?php if($reviews->isEmpty()): ?>
                                <p>Belum ada ulasan untuk kamar ini</p>
                            <?php endif; ?>

                            <?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="review-card">
                                    <h4><?php echo e($review->user->name); ?></h4>
                                    <p class="rating"><?php for($s = 0; $s < 5; $s++): ?> <i class="fas fa-star rating-star" style="opacity: <?php echo e($s < $review->rating ? '1' : '0.25'); ?>"></i> <?php endfor; ?> <strong><?php echo e($review->rating); ?></strong> / 5</p>
                                    <p><?php echo e($review->comment); ?></p>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                    </section>
                </div>

                <aside class="detail-right">
                    <div class="aside-sticky" id="asideSticky">
                        <div class="booking-card" data-price-month="<?php echo e($homestay->price_per_month ?? ''); ?>" data-price-year="<?php echo e($homestay->price_per_year ?? ''); ?>" data-price-night="<?php echo e($homestay->price_per_night ?? ''); ?>">
                            <h4><?php echo e($homestay->name); ?></h4>
                            <?php if($homestay->price_per_month): ?>
                                <p class="price">Mulai <strong>Rp <?php echo e(number_format($homestay->price_per_month, 0, ',', '.')); ?></strong> / bulan</p>
                            <?php elseif($homestay->price_per_year): ?>
                                <p class="price">Mulai <strong>Rp <?php echo e(number_format($homestay->price_per_year, 0, ',', '.')); ?></strong> / tahun</p>
                            <?php elseif($homestay->price_per_night): ?>
                                <p class="price">Rp <?php echo e(number_format($homestay->price_per_night, 0, ',', '.')); ?> / malam</p>
                            <?php else: ?>
                                <p class="price text-muted">Harga belum tersedia — hubungi pemilik</p>
                            <?php endif; ?>

                            <div class="callout">Pilih tanggal dan durasi sewa untuk melihat total harga.</div>

                            <form method="POST" action="<?php echo e(route('booking.store')); ?>" id="inlineBookingForm">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="homestay_id" value="<?php echo e($homestay->id); ?>">

                                <div class="booking-form-row">
                                    <label for="booking_date">Tanggal Booking</label>
                                    <input type="date" name="booking_date" id="booking_date" required>
                                    <?php $__errorArgs = ['booking_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="field-error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="booking-form-row duration-row">
                                    <label for="duration">Durasi</label>
                                    <input type="number" name="duration" id="duration" min="1" value="1" required>
                                    <select name="duration_unit" id="duration_unit" class="duration-unit">
                                        <option value="month">Bulan</option>
                                        <option value="year">Tahun</option>
                                        <option value="night">Harian</option>
                                    </select>
                                    <?php $__errorArgs = ['duration'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="field-error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="booking-form-row">
                                    <label for="total_guests">Jumlah Tamu</label>
                                    <input type="number" name="total_guests" id="total_guests" min="1" value="1" required>
                                    <?php $__errorArgs = ['total_guests'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="field-error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="booking-summary">
                                    <p>Durasi: <span id="durationSummary">-</span></p>
                                    <p>Total: <strong id="totalPrice">Rp -</strong></p>
                                </div>

                                <button type="submit" class="btn btn-primary btn-block" id="inlineBookingSubmit">
                                    <i class="fa fa-check-circle"></i> Pesan Sekarang
                                </button>
                            </form>

                            <div class="booking-meta">
                                <p class="muted">Atau hubungi pemilik:</p>
                                <?php if($homestay->owner): ?>
                                    <div class="owner-box">
                                        <div class="owner-avatar"><?php echo e(strtoupper(substr($homestay->owner->name, 0, 1))); ?></div>
                                        <div class="owner-info">
                                            <p class="owner-name"><?php echo e($homestay->owner->name); ?></p>
                                            <p class="owner-contact"><?php echo e($homestay->owner->phone ?? $homestay->owner->email); ?>

                                            </p>
                                            <a href="<?php echo e(route('owner.profile', $homestay->owner->id)); ?>"
                                                class="btn btn-sm btn-outline">View Profile</a>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="nearby-card">
                            <h5>Homestay Terdekat</h5>
                            <ul class="nearby-list">
                                <?php $nearby = \App\Models\Homestay::where('location', $homestay->location)->where('id', '!=', $homestay->id)->limit(3)->get(); ?>
                                <?php $__currentLoopData = $nearby; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li>
                                        <a href="<?php echo e(route('kamar.show', ['id' => $n->id, 'slug' => $n->slug ?? ''])); ?>">
                                            <?php if(!empty($n->image_url) && \Illuminate\Support\Facades\Storage::disk('public')->exists($n->image_url)): ?>
                                                <img src="<?php echo e(asset('storage/' . $n->image_url)); ?>" alt="<?php echo e($n->name); ?>">
                                            <?php else: ?>
                                                <img src="<?php echo e(asset('images/homestays/placeholder.svg')); ?>" alt="placeholder">
                                            <?php endif; ?>
                                            <div class="nearby-text">
                                                <p class="n-name"><?php echo e(\Illuminate\Support\Str::limit($n->name, 36)); ?></p>
                                                <?php if($n->price_per_month): ?>
                                                    <p class="n-price">Rp <?php echo e(number_format($n->price_per_month, 0, ',', '.')); ?> / bulan</p>
                                                <?php elseif($n->price_per_year): ?>
                                                    <p class="n-price">Rp <?php echo e(number_format($n->price_per_year, 0, ',', '.')); ?> / tahun</p>
                                                <?php elseif($n->price_per_night): ?>
                                                    <p class="n-price">Rp <?php echo e(number_format($n->price_per_night, 0, ',', '.')); ?> / malam</p>
                                                <?php else: ?>
                                                    <p class="n-price text-muted">Harga belum tersedia</p>
                                                <?php endif; ?>
                                            </div>
                                        </a>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script src="<?php echo e(asset('js/image-slider.js')); ?>"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('inlineBookingForm');
            if (!form) return;

            const pricePerMonth = parseFloat(form.closest('.booking-card').dataset.priceMonth) || 0;
            const pricePerYear = parseFloat(form.closest('.booking-card').dataset.priceYear) || 0;
            const pricePerNight = parseFloat(form.closest('.booking-card').dataset.priceNight) || 0;
            const bookingDate = document.getElementById('booking_date');
            const durationEl = document.getElementById('duration');
            const durationUnit = document.getElementById('duration_unit');
            const guests = document.getElementById('total_guests');
            const durationSummary = document.getElementById('durationSummary');
            const totalPriceEl = document.getElementById('totalPrice');

            // Set minimum selectable date
            const today = new Date();
            const isoToday = today.toISOString().split('T')[0];
            if (bookingDate) bookingDate.setAttribute('min', isoToday);

            function formatRupiah(value) {
                return new Intl.NumberFormat('id-ID').format(value);
            }

            function updateSummary() {
                const duration = parseInt(durationEl.value || 0, 10);
                const unit = durationUnit.value;

                if (!duration || duration < 1) {
                    durationSummary.textContent = '-';
                    totalPriceEl.textContent = 'Rp -';
                    return false;
                }

                let unitPrice = 0;
                if (unit === 'month') unitPrice = pricePerMonth;
                if (unit === 'year') unitPrice = pricePerYear;
                if (unit === 'night') unitPrice = pricePerNight;

                if (!unitPrice || unitPrice <= 0) {
                    // price not set for chosen unit
                    const unitLabel = unit === 'month' ? 'bulan' : (unit === 'year' ? 'tahun' : 'hari');
                    durationSummary.textContent = duration + ' ' + unitLabel + ' (harga belum diset)';
                    totalPriceEl.textContent = 'Rp -';
                    return false;
                }

                const total = Math.max(0, duration * unitPrice);
                const unitLabel = unit === 'month' ? 'bulan' : (unit === 'year' ? 'tahun' : 'hari');
                durationSummary.textContent = duration + ' ' + unitLabel;
                totalPriceEl.textContent = 'Rp ' + formatRupiah(total);
                return true;
            }

            [bookingDate, durationEl, durationUnit, guests].forEach(el => el && el.addEventListener('change', updateSummary));

            form.addEventListener('submit', function (e) {
                e.preventDefault();
                const valid = updateSummary();
                if (!valid) {
                    alert('Durasi tidak valid atau harga belum diset untuk unit yang dipilih.');
                    return false;
                }

                // Redirect to booking create page with query params so user completes booking flow there
                const base = '<?php echo e(route('booking.create', $homestay->id)); ?>';
                const params = new URLSearchParams();
                if (bookingDate && bookingDate.value) params.set('booking_date', bookingDate.value);
                if (durationEl && durationEl.value) params.set('duration', durationEl.value);
                if (durationUnit && durationUnit.value) params.set('duration_unit', durationUnit.value);
                if (guests && guests.value) params.set('total_guests', guests.value);

                window.location.href = base + '?' + params.toString();
                return false;
            });

            // Tabs: make clicks smooth and set active state
            const tabs = document.querySelectorAll('.detail-tabs .tab-link');
            tabs.forEach(tab => {
                tab.addEventListener('click', function (e) {
                    e.preventDefault();
                    tabs.forEach(t => t.classList.remove('active'));
                    tab.classList.add('active');
                    const target = document.querySelector(tab.getAttribute('href'));
                    if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                });
            });

            // Sticky behavior disabled: sidebar will remain in normal flow so items don't follow to footer.
            // No JS required — the aside stays static and scrolls naturally with page content.

            // Rating stars: interactive hover/click and keyboard support
            (function() {
                const starPicker = document.querySelector('.star-picker');
                if (!starPicker) return;

                starPicker.setAttribute('role', 'radiogroup');
                starPicker.setAttribute('aria-label', 'Pilih rating');

                const stars = Array.from(starPicker.querySelectorAll('.rating-star.star-toggle'));
                const ratingInput = document.getElementById('reviewRating');
                let selected = parseInt(ratingInput && ratingInput.value ? ratingInput.value : 0, 10) || 0;

                function paint(v) {
                    stars.forEach(s => {
                        const val = parseInt(s.dataset.value, 10);
                        if (val <= v) {
                            s.classList.add('active');
                            s.style.opacity = '1';
                        } else {
                            s.classList.remove('active');
                            s.style.opacity = '0.55';
                        }
                        s.setAttribute('aria-checked', val <= selected ? 'true' : 'false');
                    });
                }

                stars.forEach(s => {
                    s.setAttribute('tabindex', '0');
                    s.setAttribute('role', 'radio');

                    s.addEventListener('mouseenter', () => paint(parseInt(s.dataset.value, 10)));
                    s.addEventListener('mouseleave', () => paint(selected));

                    s.addEventListener('click', () => {
                        selected = parseInt(s.dataset.value, 10);
                        if (ratingInput) ratingInput.value = selected;
                        paint(selected);
                    });

                    s.addEventListener('keydown', (e) => {
                        if (e.key === 'Enter' || e.key === ' ') {
                            e.preventDefault();
                            s.click();
                            return;
                        }
                        if (e.key === 'ArrowLeft' || e.key === 'ArrowRight') {
                            e.preventDefault();
                            if (e.key === 'ArrowLeft') selected = Math.max(1, selected - 1 || 1);
                            if (e.key === 'ArrowRight') selected = Math.min(5, (selected || 0) + 1);
                            if (ratingInput) ratingInput.value = selected;
                            paint(selected);
                        }
                    });
                });

                // initialize visual state
                paint(selected);
            })();

            // initialize
            updateSummary();
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\adakamar\resources\views/homestay/detail.blade.php ENDPATH**/ ?>