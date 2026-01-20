

<?php $__env->startSection('title', 'Manajemen Pemesanan'); ?>

<?php $__env->startSection('content'); ?>
    <div class="admin-bookings-list">
        <div class="container">
            <!-- Header -->
            <div class="admin-bookings-header">
                <div>
                    <h1>Manajemen Pemesanan</h1>
                    <p class="text-muted">Kelola semua pemesanan kamar dari tamu</p>
                </div>
            </div>

            <!-- Alert Messages -->
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Bookings Table -->
            <div class="bookings-list-card">
                <div class="table-responsive-wrapper">
                    <table class="table table-bookings">
                        <thead>
                            <tr>
                                <th width="60">ID</th>
                                <th>Tamu</th>
                                <th>Kamar</th>
                                <th width="100">Check-In</th>
                                <th width="100">Check-Out</th>
                                <th width="130">Total Harga</th>
                                <th width="110">Status</th>
                                <th width="100">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><strong>#<?php echo e($booking->id); ?></strong></td>
                                    <td>
                                        <div class="user-info">
                                            <p class="user-name"><?php echo e($booking->user->name); ?></p>
                                            <p class="user-email"><?php echo e($booking->user->email); ?></p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="homestay-info">
                                            <p class="homestay-name"><?php echo e($booking->homestay->name); ?></p>
                                            <p class="homestay-location">📍 <?php echo e($booking->homestay->location); ?></p>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="date-badge"><?php echo e($booking->check_in_date->format('d M Y')); ?></span>
                                    </td>
                                    <td>
                                        <span class="date-badge"><?php echo e($booking->check_out_date->format('d M Y')); ?></span>
                                    </td>
                                    <td><strong class="price-text">Rp
                                            <?php echo e(number_format(max(0, $booking->total_price), 0, ',', '.')); ?></strong></td>
                                    <td>
                                        <form action="<?php echo e(route('admin.bookings.updateStatus', $booking->id)); ?>" method="POST"
                                            class="status-form">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PUT'); ?>
                                            <select name="status" class="status-select" onchange="this.form.submit()">
                                                <option value="pending" <?php echo e($booking->status === 'pending' ? 'selected' : ''); ?>>
                                                    Menunggu</option>
                                                <option value="paid" <?php echo e($booking->status === 'paid' ? 'selected' : ''); ?>>Dibayar
                                                    (menunggu konfirmasi)</option>
                                                <option value="confirmed" <?php echo e($booking->status === 'confirmed' ? 'selected' : ''); ?>>Dikonfirmasi</option>
                                                <option value="completed" <?php echo e($booking->status === 'completed' ? 'selected' : ''); ?>>Selesai</option>
                                                <option value="cancelled" <?php echo e($booking->status === 'cancelled' ? 'selected' : ''); ?>>Dibatalkan</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="<?php echo e(route('admin.bookings.destroy', $booking->id)); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-delete" title="Hapus"
                                                onclick="return confirm('Yakin ingin menghapus pemesanan ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="8" class="text-center empty-state">
                                        <i class="fas fa-calendar empty-icon"></i>
                                        <p class="text-muted">Tidak ada pemesanan</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="pagination-wrapper">
                <?php echo e($bookings->links()); ?>

            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\adakamar\resources\views/admin/bookings/index.blade.php ENDPATH**/ ?>