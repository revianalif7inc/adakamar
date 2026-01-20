

<?php $__env->startSection('title', 'Manajemen Kamar - Owner'); ?>

<?php $__env->startSection('content'); ?>
    <div class="admin-kamar-list">
        <div class="container">
            <div class="admin-kamar-header enhanced">
                <div class="header-left">
                    <h1>Daftar Kamar Saya</h1>
                    <p class="text-muted">Kelola kamar yang Anda tambahkan (menunggu konfirmasi admin jika belum aktif)</p>
                    <div class="header-stats" aria-hidden="true">
                        <span class="stat-pill">Total: <strong><?php echo e($homestays->total()); ?></strong></span>
                        <span class="stat-pill">Halaman: <strong><?php echo e($homestays->count()); ?></strong></span>
                    </div>
                </div>

                <div class="header-actions">
                    <form method="GET" action="<?php echo e(route('owner.kamar.index')); ?>" class="search-form" role="search">
                        <input type="search" name="q" value="<?php echo e(request('q')); ?>" placeholder="Cari nama kamar..."
                            aria-label="Cari kamar" />
                        <button class="btn btn-outline btn-sm" type="submit"><i class="fa fa-search"
                                aria-hidden="true"></i></button>
                    </form>

                    <a href="<?php echo e(route('owner.kamar.create')); ?>" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus"></i> Tambah Kamar
                    </a>
                </div>
            </div>

            <?php if(session('success')): ?>
                <div class="alert alert-success"><?php echo e(session('success')); ?></div>
            <?php endif; ?>

            <div class="kamar-list-card">
                <div class="table-responsive-wrapper">
                    <table class="table table-kamar">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Harga</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $homestays; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td data-label="Nama">
                                        <div class="kamar-name-cell">
                                            <?php if(!empty($h->image_url) && \Illuminate\Support\Facades\Storage::disk('public')->exists($h->image_url)): ?>
                                                <img src="<?php echo e(asset('storage/' . $h->image_url)); ?>" alt="<?php echo e($h->name); ?>"
                                                    class="kamar-thumb">
                                            <?php else: ?>
                                                <div class="kamar-thumb-empty"><i class="fa fa-image" aria-hidden="true"></i></div>
                                            <?php endif; ?>
                                            <div>
                                                <p class="kamar-name"><?php echo e($h->name); ?></p>
                                                <small class="muted">Ditambahkan:
                                                    <?php echo e(optional($h->created_at)->format('d M Y')); ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td data-label="Harga">
                                        <?php if($h->price_per_month): ?>
                                            Rp <?php echo e(number_format($h->price_per_month, 0, ',', '.')); ?> / bulan
                                        <?php elseif($h->price_per_year): ?>
                                            Rp <?php echo e(number_format($h->price_per_year, 0, ',', '.')); ?> / tahun
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td data-label="Status">
                                        <?php if($h->is_active): ?>
                                            <span class="badge badge-success">Aktif</span>
                                        <?php else: ?>
                                            <span class="badge badge-warning">Menunggu Konfirmasi</span>
                                        <?php endif; ?>
                                    </td>
                                    <td data-label="Aksi">
                                        <div class="action-buttons">
                                            <a href="<?php echo e(route('kamar.show', ['id' => $h->id, 'slug' => $h->slug ?? ''])); ?>"
                                                target="_blank" class="btn btn-sm btn-outline"><i class="fa fa-eye"
                                                    aria-hidden="true"></i> Lihat</a>
                                            <a href="<?php echo e(route('owner.kamar.edit', $h->id)); ?>" class="btn btn-sm btn-edit"><i
                                                    class="fa fa-edit" aria-hidden="true"></i> Edit</a>
                                            <form action="<?php echo e(route('owner.kamar.destroy', $h->id)); ?>" method="POST"
                                                class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button class="btn btn-sm btn-delete"
                                                    onclick="return confirm('Hapus kamar?')"><i class="fa fa-trash"
                                                        aria-hidden="true"></i> Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="4" class="text-center">
                                        <div class="empty-state">
                                            <img src="<?php echo e(asset('images/homestays/placeholder.svg')); ?>" alt="empty" />
                                            <p class="mb-3">Belum ada kamar yang Anda tambahkan.</p>
                                            <a href="<?php echo e(route('owner.kamar.create')); ?>" class="btn btn-primary"><i
                                                    class="fa fa-plus"></i> Tambah Kamar Sekarang</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <div class="pagination-wrapper"><?php echo e($homestays->links()); ?></div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\adakamar\resources\views/owner/homestays/index.blade.php ENDPATH**/ ?>