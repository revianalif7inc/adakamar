

<?php $__env->startSection('title', 'Pesan Homestay'); ?>

<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/booking.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <button type="submit" class="btn btn-primary btn-large">
        <i class="fa fa-arrow-right"></i> Lanjutkan Ke Pembayaran
    </button>
    <div class="booking-container">
        <div class="container">
            <h1>🏠 Pesan <?php echo e($homestay->name); ?></h1>

            <div class="booking-form-wrapper" data-price-month="<?php echo e($homestay->price_per_month ?? ''); ?>"
                data-price-year="<?php echo e($homestay->price_per_year ?? ''); ?>">
                <div class="homestay-info">
                    <?php if(!empty($homestay->image_url) && \Illuminate\Support\Facades\Storage::disk('public')->exists($homestay->image_url)): ?>
                        <img src="<?php echo e(asset('storage/' . $homestay->image_url)); ?>" alt="<?php echo e($homestay->name); ?>">
                    <?php else: ?>
                        <img src="<?php echo e(asset('images/homestays/placeholder.svg')); ?>" alt="placeholder">
                    <?php endif; ?>
                    <h3><?php echo e($homestay->name); ?></h3>
                    <p><?php echo e($homestay->location); ?></p>
                    <?php if($homestay->price_per_month): ?>
                        <p class="price">Rp <?php echo e(number_format($homestay->price_per_month, 0, ',', '.')); ?> / bulan</p>
                    <?php elseif($homestay->price_per_year): ?>
                        <p class="price">Rp <?php echo e(number_format($homestay->price_per_year, 0, ',', '.')); ?> / tahun</p>
                    <?php else: ?>
                        <p class="price text-muted">Harga belum tersedia</p>
                    <?php endif; ?>
                </div>

                <form action="<?php echo e(route('booking.store')); ?>" method="POST" class="booking-form">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="homestay_id" value="<?php echo e($homestay->id); ?>">

                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger">
                            <ul>
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <div class="form-group">
                        <label for="booking_date">📅 Tanggal Pemesanan</label>
                        <input type="date" id="booking_date" name="booking_date" value="<?php echo e(old('booking_date')); ?>" required>
                        <small class="form-text text-muted">Cukup pilih tanggal pemesanan. Durasi dan harga akan ditentukan
                            oleh pemilik nanti.</small>
                    </div>

                    <div class="form-group">
                        <label for="duration">⏱️ Durasi</label>
                        <div class="duration-row">
                            <input type="number" id="duration" name="duration" min="1" value="<?php echo e(old('duration', 1)); ?>"
                                class="form-control duration-input" required>
                            <select id="duration_unit" name="duration_unit" class="form-control duration-unit">
                                <option value="month" <?php echo e(old('duration_unit') === 'month' ? 'selected' : ''); ?>>Bulan</option>
                                <option value="year" <?php echo e(old('duration_unit') === 'year' ? 'selected' : ''); ?>>Tahun</option>
                            </select>
                        </div>
                        <small class="form-text text-muted">Pilih durasi pemesanan (mis. 1 bulan, 12 bulan, atau 1
                            tahun).</small>
                    </div>

                    <div class="form-group">
                        <label for="total_guests">👥 Jumlah Tamu</label>
                        <input type="number" id="total_guests" name="total_guests" min="1" max="<?php echo e($homestay->max_guests); ?>"
                            value="<?php echo e(old('total_guests', 1)); ?>" required>
                        <small>Kapasitas maksimal: <?php echo e($homestay->max_guests); ?> tamu</small>
                    </div>

                    <div class="form-group">
                        <label for="special_requests">💬 Permintaan Khusus (Opsional)</label>
                        <textarea id="special_requests" name="special_requests" rows="4"
                            placeholder="Tulis permintaan khusus Anda..."><?php echo e(old('special_requests')); ?></textarea>
                    </div>

                    <div class="price-summary">
                        <p>💰 Harga: <strong id="total">–</strong></p>
                        <small class="form-text text-muted">Harga akan dihitung saat pemilik mengonfirmasi atau berdasarkan
                            durasi pemesanan.</small>
                    </div>

                    <button type="submit" class="btn btn-primary btn-large">Lanjutkan Ke Pembayaran</button>
                </form>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script src="<?php echo e(asset('js/booking-form.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\adakamar\resources\views/booking/create.blade.php ENDPATH**/ ?>