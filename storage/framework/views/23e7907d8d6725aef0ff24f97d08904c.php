

<?php $__env->startSection('title', 'Manajemen Kamar - Admin'); ?>

<?php $__env->startSection('content'); ?>
    <div class="admin-kamar-list">
        <div class="container">
            <!-- Header -->
            <div class="admin-kamar-header">
                <div>
                    <h1>Manajemen Kamar</h1>
                    <p class="text-muted">Kelola semua kamar yang tersedia di platform</p>
                </div>
                <a href="<?php echo e(route('admin.kamar.create')); ?>" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus"></i> Tambah Kamar Baru
                </a>
            </div>

            <!-- Alert Messages -->
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Kamar List Table -->
            <div class="kamar-list-card">

                <div class="filters">
                    <form method="GET" action="<?php echo e(route('admin.kamar.index')); ?>" class="filters-form">
                        <input type="text" name="q" value="<?php echo e(old('q', $q ?? request('q'))); ?>"
                            placeholder="Cari nama, lokasi atau deskripsi..." class="form-control" />

                        <select name="category" class="form-control">
                            <option value="">Semua Kategori</option>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($cat->id); ?>" <?php echo e((old('category', $category ?? request('category')) == $cat->id) ? 'selected' : ''); ?>><?php echo e($cat->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>

                        <select name="location_id" class="form-control">
                            <option value="">Semua Lokasi</option>
                            <?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($loc->id); ?>" <?php echo e((old('location_id', $location ?? request('location_id')) == $loc->id) ? 'selected' : ''); ?>><?php echo e($loc->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>

                        <select name="status" class="form-control">
                            <option value="">Semua Status</option>
                            <option value="active" <?php echo e((old('status', $status ?? request('status')) === 'active') ? 'selected' : ''); ?>>Aktif</option>
                            <option value="inactive" <?php echo e((old('status', $status ?? request('status')) === 'inactive') ? 'selected' : ''); ?>>Nonaktif</option>
                        </select>

                        <button type="submit" class="btn btn-primary">Cari</button>
                        <a href="<?php echo e(route('admin.kamar.index')); ?>" class="btn btn-secondary">Reset</a>

                        <div class="ml-auto text-muted">Menampilkan <?php echo e($homestays->total()); ?> kamar</div>
                    </form>
                </div>

                <div class="table-responsive-wrapper">
                    <table class="table table-kamar">
                        <thead>
                            <tr>
                                <th width="200">Nama Kamar</th>
                                <th width="80">Featured</th>
                                <th width="120">Kategori</th>
                                <th width="180">Pemilik</th>
                                <th width="150">Lokasi</th>
                                <th width="120">Harga</th>
                                <th width="80">Kamar</th>
                                <th width="80">Kapasitas</th>
                                <th width="80">Rating</th>
                                <th width="90">Status</th>
                                <th width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $homestays; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $homestay): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td data-label="Nama Kamar">
                                        <div class="kamar-name-cell">
                                            <?php if(!empty($homestay->image_url) && \Illuminate\Support\Facades\Storage::disk('public')->exists($homestay->image_url)): ?>
                                                <a href="<?php echo e(asset('storage/' . $homestay->image_url)); ?>" target="_blank"
                                                    rel="noopener">
                                                    <img src="<?php echo e(asset('storage/' . $homestay->image_url)); ?>"
                                                        alt="<?php echo e($homestay->name); ?>" class="kamar-thumb-lg">
                                                </a>
                                            <?php else: ?>
                                                <a href="<?php echo e(asset('images/homestays/placeholder.svg')); ?>" target="_blank"
                                                    rel="noopener">
                                                    <img src="<?php echo e(asset('images/homestays/placeholder.svg')); ?>" alt="placeholder"
                                                        class="kamar-thumb-lg">
                                                </a>
                                            <?php endif; ?>
                                            <div>
                                                <p class="kamar-name"><?php echo e($homestay->name); ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td data-label="Featured">
                                        <?php if($homestay->is_featured): ?>
                                            <span class="badge badge-success">Ya</span>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td data-label="Kategori">
                                        <span class="category-badge"
                                            title="<?php echo e($homestay->categories->pluck('name')->implode(', ')); ?>">Kost</span>
                                    </td>
                                    <td data-label="Pemilik">
                                        <?php if($homestay->owner): ?>
                                            <a
                                                href="<?php echo e(route('admin.users.edit', $homestay->owner->id)); ?>"><?php echo e($homestay->owner->name); ?></a>
                                            <br><small class="text-muted"><?php echo e($homestay->owner->email); ?></small>
                                        <?php else: ?>
                                            <small class="text-muted">—</small>
                                        <?php endif; ?>
                                    </td>
                                    <td data-label="Lokasi">
                                        <small class="text-muted"><?php echo e($homestay->location); ?></small>
                                    </td>
                                    <td data-label="Harga">
                                        <?php if($homestay->price_per_month): ?>
                                            <strong class="price-display">Rp
                                                <?php echo e(number_format($homestay->price_per_month, 0, ',', '.')); ?> / bulan</strong>
                                        <?php elseif($homestay->price_per_year): ?>
                                            <strong class="price-display">Rp
                                                <?php echo e(number_format($homestay->price_per_year, 0, ',', '.')); ?> / tahun</strong>
                                        <?php elseif($homestay->price_per_night): ?>
                                            <strong class="price-display">Rp
                                                <?php echo e(number_format($homestay->price_per_night, 0, ',', '.')); ?> / malam</strong>
                                        <?php else: ?>
                                            <small class="text-muted">Harga belum tersedia</small>
                                        <?php endif; ?>
                                    </td>
                                    <td data-label="Kamar">
                                        <span class="badge badge-info"><?php echo e($homestay->bedrooms); ?></span>
                                    </td>
                                    <td data-label="Kapasitas">
                                        <span class="capacity-badge"><?php echo e($homestay->max_guests); ?> <i
                                                class="fas fa-user"></i></span>
                                    </td>
                                    <td data-label="Rating">
                                        <span class="rating-display">
                                            <?php if($homestay->rating): ?>
                                                <i class="fas fa-star rating-star"></i>
                                                <?php echo e(number_format($homestay->rating, 1)); ?>

                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </span>
                                    </td>
                                    <td data-label="Status">
                                        <?php if($homestay->is_active): ?>
                                            <span class="badge badge-success"><i class="fas fa-check-circle"></i> Aktif</span>
                                        <?php else: ?>
                                            <span class="badge badge-danger"><i class="fas fa-times-circle"></i> Nonaktif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td data-label="Aksi">
                                        <div class="action-buttons">
                                            <a href="<?php echo e(route('admin.kamar.edit', $homestay->id)); ?>" class="btn btn-sm btn-edit"
                                                title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <form action="<?php echo e(route('admin.kamar.toggleFeature', $homestay->id)); ?>" method="POST"
                                                class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PUT'); ?>
                                                <button type="submit"
                                                    class="btn btn-sm <?php echo e($homestay->is_featured ? 'btn-outline-success' : 'btn-outline-secondary'); ?>"
                                                    title="Toggle Feature">
                                                    <i class="fas fa-thumbtack"></i>
                                                </button>
                                            </form>

                                            <?php if(!$homestay->is_active && $homestay->owner): ?>
                                                <form action="<?php echo e(route('admin.kamar.confirm', $homestay->id)); ?>" method="POST"
                                                    class="d-inline">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('PUT'); ?>
                                                    <button type="submit" class="btn btn-sm btn-primary" title="Konfirmasi">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                            <?php endif; ?>

                                            <form action="<?php echo e(route('admin.kamar.destroy', $homestay->id)); ?>" method="POST"
                                                class="delete-form">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-delete" title="Hapus"
                                                    onclick="return confirm('Yakin ingin menghapus kamar ini? Data yang sudah dihapus tidak bisa dipulihkan.')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="10" class="text-center empty-state">
                                        <i class="fas fa-inbox empty-icon"></i>
                                        <p class="text-muted">Belum ada kamar. <a
                                                href="<?php echo e(route('admin.kamar.create')); ?>">Tambah kamar sekarang</a></p>
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
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\adakamar\resources\views/admin/homestays/index.blade.php ENDPATH**/ ?>