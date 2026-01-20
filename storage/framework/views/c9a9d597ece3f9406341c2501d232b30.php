

<?php $__env->startSection('title', 'Detail Pemesanan'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container py-4">
        <div class="card booking-detail-card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h3 class="mb-1">Detail Pemesanan <small class="text-muted">#<?php echo e($booking->id); ?></small></h3>
                        <div class="small text-muted">Dibuat: <?php echo e($booking->created_at->format('d M Y H:i')); ?></div>
                    </div>
                    <div class="text-end">
                        <span class="badge badge-status badge-lg"><?php echo e(ucfirst($booking->status)); ?></span>
                        <div class="mt-2">
                            <button class="btn btn-outline btn-sm me-1" onclick="window.print()"><i class="fa fa-print"></i> Cetak</button>
                            <a href="<?php echo e(route('home')); ?>" class="btn btn-ghost btn-sm">Beranda</a>
                        </div>
                    </div>
                </div>

                <div class="booking-grid row">
                    <div class="col-md-4">
                        <div class="thumb mb-3">
                            <?php $img = $booking->homestay->image_url ?? null; ?>
                            <?php if($img && \Illuminate\Support\Facades\Storage::disk('public')->exists($img)): ?>
                                <img src="<?php echo e(asset('storage/' . $img)); ?>" alt="<?php echo e($booking->homestay->name); ?>" class="img-fluid rounded">
                            <?php else: ?>
                                <img src="<?php echo e(asset('images/homestays/placeholder.svg')); ?>" alt="placeholder" class="img-fluid rounded">
                            <?php endif; ?>
                        </div>

                        <div class="list-group list-group-flush">
                            <div class="list-group-item p-2">
                                <strong><?php echo e($booking->homestay->name); ?></strong>
                                <div class="small text-muted"><?php echo e($booking->homestay->location); ?></div>
                            </div>

                            <div class="list-group-item p-2">
                                <strong>Check-in</strong>
                                <div class="small"><?php echo e(optional($booking->check_in_date)->format('d M Y') ?? '—'); ?></div>
                            </div>

                            <div class="list-group-item p-2">
                                <strong>Check-out</strong>
                                <div class="small"><?php echo e(optional($booking->check_out_date)->format('d M Y') ?? '—'); ?></div>
                            </div>

                            <div class="list-group-item p-2">
                                <strong>Jumlah Tamu</strong>
                                <div class="small"><?php echo e($booking->total_guests); ?></div>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-8">
                        <div class="mb-3">
                            <h5>Rincian Pembayaran</h5>
                            <table class="table table-borderless">
                                <tr><td>Subtotal</td><td class="text-end">Rp <?php echo e(number_format($booking->total_price, 0, ',', '.')); ?></td></tr>
                                <tr><td>Diskon</td><td class="text-end">Rp 0</td></tr>
                                <tr class="fw-bold"><td>Total</td><td class="text-end">Rp <?php echo e(number_format($booking->total_price, 0, ',', '.')); ?></td></tr>
                            </table>
                        </div>

                        <div class="mb-3">
                            <h5>Status dan Tindakan</h5>

                            
                            <div class="booking-timeline mb-3">
                                <?php
                                    $steps = ['pending' => 'Menunggu Pembayaran', 'paid' => 'Lunas', 'confirmed' => 'Dikonfirmasi', 'completed' => 'Selesai', 'cancelled' => 'Dibatalkan'];
                                ?>

                                <div class="d-flex gap-2 flex-wrap">
                                    <?php $__currentLoopData = $steps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="timeline-step <?php echo e($booking->status === $key ? 'active' : (array_search($key, array_keys($steps)) < array_search($booking->status, array_keys($steps)) ? 'done' : '')); ?>">
                                            <div class="step-dot"></div>
                                            <div class="step-label small"><?php echo e($label); ?></div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>

                            
                            <div>
                                <?php if(auth()->id() === $booking->user_id && $booking->status === 'pending'): ?>
                                    <a href="<?php echo e(route('booking.pay.form', $booking->id)); ?>" class="btn btn-primary me-2">Bayar / Unggah Bukti</a>
                                <?php endif; ?>

                                
                                <?php
                                    $user = auth()->user();
                                    $isOwner = $user && $booking->homestay && $user->id === $booking->homestay->owner_id;
                                    $isAdmin = $user && method_exists($user, 'isAdmin') && $user->isAdmin();
                                ?>

                                <?php if($isOwner || $isAdmin): ?>
                                    <form action="<?php echo e($isAdmin ? route('admin.bookings.updateStatus', $booking->id) : route('owner.bookings.updateStatus', $booking->id)); ?>" method="POST" class="d-inline-block mt-2">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>
                                        <div class="input-group input-group-sm">
                                            <select name="status" class="form-select">
                                                <option value="pending" <?php echo e($booking->status === 'pending' ? 'selected' : ''); ?>>Menunggu Pembayaran</option>
                                                <option value="paid" <?php echo e($booking->status === 'paid' ? 'selected' : ''); ?>>Lunas</option>
                                                <option value="confirmed" <?php echo e($booking->status === 'confirmed' ? 'selected' : ''); ?>>Dikonfirmasi</option>
                                                <option value="completed" <?php echo e($booking->status === 'completed' ? 'selected' : ''); ?>>Selesai</option>
                                                <option value="cancelled" <?php echo e($booking->status === 'cancelled' ? 'selected' : ''); ?>>Dibatalkan</option>
                                            </select>
                                            <button class="btn btn-primary">Perbarui Status</button>
                                        </div>
                                    </form>
                                <?php endif; ?>

                                
                                <?php if($isAdmin): ?>
                                    <form action="<?php echo e(route('admin.bookings.destroy', $booking->id)); ?>" method="POST" class="d-inline-block ms-2">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus booking ini?')">Hapus</button>
                                    </form>
                                <?php endif; ?>

                            </div>

                        </div>

                        <div class="mb-3">
                            <h5>Kontak Pemilik</h5>
                            <?php if($booking->homestay->owner): ?>
                                <p><?php echo e($booking->homestay->owner->name); ?> — <?php echo e($booking->homestay->owner->phone ?? $booking->homestay->owner->email); ?></p>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\adakamar\resources\views/booking/show.blade.php ENDPATH**/ ?>