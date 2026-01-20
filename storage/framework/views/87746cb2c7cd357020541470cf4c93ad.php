

<?php $__env->startSection('title', 'Dashboard Owner'); ?>

<?php $__env->startSection('content'); ?>
    <div class="admin-dashboard">
        <div class="container">
            <!-- Header -->
            <div class="admin-header">
                <div>
                    <h1>Dashboard Owner</h1>
                    <p class="text-muted">Kelola kamar Anda dan lihat pemesanan terbaru</p>
                </div>
                <div class="admin-header-actions">
                    <a href="<?php echo e(route('owner.kamar.create')); ?>" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus"></i> Tambah Kamar Baru
                    </a>
                </div>
            </div>

            <div class="dashboard-stats">
                <div class="stat-card stat-card-kamar">
                    <div class="stat-icon"><i class="fas fa-home"></i></div>
                    <div class="stat-content">
                        <h3>Total Kamar</h3>
                        <p class="stat-number"><?php echo e($totalHomestays); ?></p>
                    </div>
                </div>

                <div class="stat-card stat-card-booking">
                    <div class="stat-icon"><i class="fas fa-calendar-check"></i></div>
                    <div class="stat-content">
                        <h3>Total Pemesanan</h3>
                        <p class="stat-number"><?php echo e($totalBookings); ?></p>
                    </div>
                </div>

                <div class="stat-card stat-card-pending">
                    <div class="stat-icon"><i class="fas fa-hourglass-half"></i></div>
                    <div class="stat-content">
                        <h3>Pemesanan Menunggu</h3>
                        <p class="stat-number"><?php echo e($pendingBookings); ?></p>
                    </div>
                </div>

                <div class="stat-card stat-card-revenue">
                    <div class="stat-icon"><i class="fas fa-money-bill-wave"></i></div>
                    <div class="stat-content">
                        <h3>Total Pendapatan</h3>
                        <p class="stat-number">Rp <?php echo e(number_format($totalRevenue ?? 0, 0, ',', '.')); ?></p>
                    </div>
                </div>
            </div>

            <div class="admin-section">
                <div class="section-header">
                    <h2><i class="fas fa-home"></i> Kamar Saya</h2>
                    <div class="section-actions">
                        <a href="<?php echo e(route('owner.kamar.index')); ?>" class="btn btn-secondary btn-sm"><i
                                class="fas fa-list"></i> Lihat Semua</a>
                        <a href="<?php echo e(route('owner.kamar.create')); ?>" class="btn btn-primary btn-sm"><i
                                class="fas fa-plus"></i> Baru</a>
                    </div>
                </div>

                <div class="section-body">
                    <?php if(isset($myHomestays) && $myHomestays->count()): ?>
                        <div class="mini-homestay-grid">
                            <?php $__currentLoopData = $myHomestays; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="mini-homestay-card">
                                    <?php if(!empty($h->image_url) && \Illuminate\Support\Facades\Storage::disk('public')->exists($h->image_url)): ?>
                                        <img src="<?php echo e(asset('storage/' . $h->image_url)); ?>" alt="<?php echo e($h->name); ?>">
                                    <?php else: ?>
                                        <img src="<?php echo e(asset('images/homestays/placeholder.svg')); ?>" alt="placeholder">
                                    <?php endif; ?>
                                    <div class="mini-homestay-body">
                                        <p class="mini-name"><?php echo e(\Illuminate\Support\Str::limit($h->name, 40)); ?></p>
                                        <a href="<?php echo e(route('owner.kamar.edit', $h->id)); ?>" class="btn btn-sm btn-secondary">Edit</a>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">Belum ada kamar yang Anda tambahkan</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="admin-section">
                <div class="section-header">
                    <h2><i class="fas fa-list-check"></i> Pemesanan Terbaru</h2>
                    <div class="section-actions">
                        <a href="<?php echo e(route('owner.kamar.index')); ?>" class="btn btn-secondary btn-sm"><i
                                class="fas fa-list"></i> Lihat Kamar Saya</a>
                    </div>
                </div>

                <div class="bookings-table-wrapper">
                    <table class="table table-admin">
                        <thead>
                            <tr>
                                <th width="50">ID</th>
                                <th>Tamu</th>
                                <th>Kamar</th>
                                <th>Check-In</th>
                                <th>Total Harga</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $recentBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><strong>#<?php echo e($booking->id); ?></strong></td>
                                    <td>
                                        <div class="user-info">
                                            <p class="user-name"><?php echo e($booking->user->name); ?></p>
                                            <p class="user-email"><?php echo e($booking->user->email); ?></p>
                                        </div>
                                    </td>
                                    <td><?php echo e($booking->homestay->name); ?></td>
                                    <td><span class="date-badge"><?php echo e($booking->check_in_date->format('d M Y')); ?></span></td>
                                    <td><strong class="price-text">Rp
                                            <?php echo e(number_format(max(0, $booking->total_price), 0, ',', '.')); ?></strong></td>
                                    <td>
                                        <?php if($booking->status === 'pending'): ?>
                                            <span class="badge badge-warning">Menunggu</span>
                                        <?php elseif($booking->status === 'confirmed'): ?>
                                            <span class="badge badge-info">Dikonfirmasi</span>
                                        <?php elseif($booking->status === 'completed'): ?>
                                            <span class="badge badge-success">Selesai</span>
                                        <?php else: ?>
                                            <span class="badge badge-danger"><?php echo e(ucfirst($booking->status)); ?></span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <p class="text-muted"><i class="fas fa-inbox"></i> Tidak ada pemesanan</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\adakamar\resources\views/owner/dashboard/index.blade.php ENDPATH**/ ?>