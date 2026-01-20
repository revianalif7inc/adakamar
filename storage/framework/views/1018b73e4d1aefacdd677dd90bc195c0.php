

<?php $__env->startSection('content'); ?>
    <div class="container py-4">
        <h2 class="mb-3">Kamar Saya</h2>

        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>
        <?php if(session('info')): ?>
            <div class="alert alert-info"><?php echo e(session('info')); ?></div>
        <?php endif; ?>

        <?php if($bookings->count()): ?>

        
            <div class="my-rooms-grid">
                <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $hs = $booking->homestay;
                        $img = $hs->image_url ?? null;
                        $checkIn = $booking->check_in_date ? \Carbon\Carbon::parse($booking->check_in_date) : null;
                        $checkOut = $booking->check_out_date ? \Carbon\Carbon::parse($booking->check_out_date) : null;
                        $duration = ($checkIn && $checkOut) ? $checkIn->diffInDays($checkOut) : null;
                    ?>

                    <div class="booking-card my-booking-card">
                        <div class="booking-thumb">
                            <?php if(!empty($img) && \Illuminate\Support\Facades\Storage::disk('public')->exists($img)): ?>
                                <img src="<?php echo e(asset('storage/' . $img)); ?>" alt="<?php echo e($hs->name ?? $hs->title ?? 'Homestay'); ?>">
                            <?php else: ?>
                                <img src="<?php echo e(asset('images/homestays/placeholder.svg')); ?>" alt="placeholder">
                            <?php endif; ?>
                        </div>

                        <div class="booking-body">
                            <div class="booking-head">
                                <h3 class="booking-title"><?php echo e($hs->name ?? $hs->title ?? '—'); ?></h3>
                                <p class="muted booking-loc"><?php echo e($hs->location ?? ''); ?></p>
                            </div>

                            <div class="booking-meta">
                                <div class="meta-item"><strong>Check-in</strong><span><?php echo e($checkIn ? $checkIn->format('d M Y') : '—'); ?></span></div>
                                <div class="meta-item"><strong>Check-out</strong><span><?php echo e($checkOut ? $checkOut->format('d M Y') : '—'); ?></span></div>
                                <div class="meta-item"><strong>Durasi</strong><span><?php echo e($duration ? $duration . ' hari' : '—'); ?></span></div>
                            </div>

                            <div class="booking-footer">
                                <div class="price">Rp <?php echo e(number_format($booking->total_price, 0, ',', '.')); ?></div>
                                <div class="status">
                                    <?php if($booking->status === 'pending'): ?>
                                        <span class="badge badge-warning">Menunggu Pembayaran</span>
                                    <?php elseif($booking->status === 'paid'): ?>
                                        <span class="badge badge-success">Lunas</span>
                                    <?php elseif($booking->status === 'cancelled'): ?>
                                        <span class="badge badge-danger">Dibatalkan</span>
                                    <?php else: ?>
                                        <span class="badge badge-info"><?php echo e(ucfirst($booking->status)); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="booking-actions mt-2">
                                <a href="<?php echo e(route('booking.confirmation', $booking->id)); ?>" class="btn btn-sm btn-outline"><i class="fa fa-info-circle" aria-hidden="true"></i> Detail</a>

                                <?php if($booking->status === 'pending'): ?>
                                    <a href="<?php echo e(route('booking.pay.form', $booking->id)); ?>" class="btn btn-sm btn-primary"><i class="fa fa-credit-card" aria-hidden="true"></i> Bayar</a>
                                <?php endif; ?>

                                <?php if($booking->status === 'paid'): ?>
                                    <a href="<?php echo e(route('booking.confirmation', $booking->id)); ?>" class="btn btn-sm btn-ghost"><i class="fa fa-receipt" aria-hidden="true"></i> Bukti</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="mt-4"><?php echo e($bookings->links()); ?></div>
        <?php else: ?>
            <div class="empty-state">
                <img src="<?php echo e(asset('images/homestays/placeholder.svg')); ?>" alt="empty" />
                <p class="text-muted">Anda belum melakukan booking apapun.</p>
                <a href="<?php echo e(route('homestays.index')); ?>" class="btn btn-primary"><i class="fa fa-search"></i> Telusuri Homestay</a>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\adakamar\resources\views/customer/my_rooms.blade.php ENDPATH**/ ?>