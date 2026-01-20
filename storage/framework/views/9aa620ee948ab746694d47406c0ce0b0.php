

<?php $__env->startSection('title', 'Konfirmasi Pemesanan'); ?>

<?php $__env->startSection('content'); ?>
    <div class="confirmation-container">
        <div class="container">
            <div class="confirmation-box confirmation-page">
                <div class="confirmation-hero">
                    <div class="hero-icon">✓</div>
                    <div class="hero-text">
                        <h1>Pemesanan Berhasil</h1>
                        <p class="muted">Terima kasih — pesanan Anda telah diterima. Nomor pesanan <strong>#<?php echo e($booking->id); ?></strong></p>
                    </div>
                    <div class="hero-status">
                        <span class="badge badge-status"><?php echo e(ucfirst($booking->status)); ?></span>
                    </div>
                </div>

                <div class="confirmation-grid">
                    <div class="confirmation-card summary">
                        <?php
                            $img = $booking->homestay->image_url ?? null;
                        ?>
                        <div class="summary-head">
                            <div class="thumb">
                                <?php if(!empty($img) && \Illuminate\Support\Facades\Storage::disk('public')->exists($img)): ?>
                                    <img src="<?php echo e(asset('storage/' . $img)); ?>" alt="<?php echo e($booking->homestay->name); ?>">
                                <?php else: ?>
                                    <img src="<?php echo e(asset('images/homestays/placeholder.svg')); ?>" alt="placeholder">
                                <?php endif; ?>
                            </div>
                            <div class="summary-title">
                                <h3><?php echo e($booking->homestay->name); ?></h3>
                                <p class="muted"><?php echo e($booking->homestay->location); ?></p>
                            </div>
                        </div>

                        <div class="summary-meta">
                            <p><strong>Check-In:</strong> <?php echo e(optional($booking->check_in_date)->format('d M Y')); ?></p>
                            <?php if($booking->check_out_date): ?>
                                <p><strong>Check-Out:</strong> <?php echo e(optional($booking->check_out_date)->format('d M Y')); ?></p>
                                <?php
                                    try { $days = $booking->check_out_date->diffInDays($booking->check_in_date); } catch (\Exception $e){ $days = null; }
                                ?>
                                <?php if($days): ?>
                                    <p><strong>Durasi:</strong> <?php echo e($days); ?> hari</p>
                                <?php endif; ?>
                            <?php else: ?>
                                <p><em>Durasi akan ditentukan pemilik</em></p>
                            <?php endif; ?>

                            <p><strong>Jumlah Tamu:</strong> <?php echo e($booking->total_guests); ?> orang</p>

                            <?php if($booking->special_requests): ?>
                                <p><strong>Permintaan:</strong> <?php echo e($booking->special_requests); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="confirmation-card details">
                        <h3>Rincian Pembayaran</h3>

                        <ul class="booking-breakdown">
                            <li><span>Subtotal</span><span>Rp <?php echo e(number_format(max(0, $booking->total_price), 0, ',', '.')); ?></span></li>
                            <li><span>Diskon</span><span>Rp 0</span></li>
                            <li class="total"><strong>Total</strong><strong>Rp <?php echo e(number_format(max(0, $booking->total_price), 0, ',', '.')); ?></strong></li>
                        </ul>

                        <div class="confirm-actions">
                            <button onclick="window.print()" class="btn btn-primary"><i class="fa fa-print btn-icon" aria-hidden="true"></i> Cetak Bukti</button>

                            <?php if(!empty($booking->homestay->owner->phone)): ?>
                                <a href="tel:<?php echo e($booking->homestay->owner->phone); ?>" class="btn btn-secondary"><i class="fa fa-phone btn-icon" aria-hidden="true"></i> Hubungi Pemilik</a>
                            <?php endif; ?>

                            <a href="<?php echo e(url('bookings/' . $booking->id)); ?>" class="btn btn-outline"><i class="fa fa-file-alt btn-icon" aria-hidden="true"></i> Lihat Detail Pemesanan</a>
                        </div>

                        <div class="small muted mt-3">Jika Anda belum melakukan pembayaran, silakan tunggu instruksi dari pemilik.</div>
                    </div>
                </div>

                <div class="next-steps">
                    <h4>Langkah Selanjutnya</h4>
                    <ol>
                        <li>Tunggu konfirmasi dari pemilik homestay</li>
                        <li>Ikuti instruksi pembayaran yang dikirim via email atau pesan</li>
                        <li>Tunjukkan bukti pembayaran saat check-in</li>
                    </ol>
                </div>

                <div class="action-buttons">
                    <a href="<?php echo e(route('home')); ?>" class="btn btn-ghost"><i class="fa fa-home btn-icon" aria-hidden="true"></i> Kembali ke Beranda</a>
                    <a href="<?php echo e(route('homestays.index')); ?>" class="btn btn-outline"><i class="fa fa-search btn-icon" aria-hidden="true"></i> Lihat Homestay Lainnya</a>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\adakamar\resources\views/booking/confirmation.blade.php ENDPATH**/ ?>