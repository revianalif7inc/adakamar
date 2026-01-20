

<?php $__env->startSection('title', 'Kelola Artikel'); ?>

<?php $__env->startSection('content'); ?>
    <div class="admin-dashboard">
        <div class="container">
            <div class="admin-header">
                <div>
                    <h1>Artikel</h1>
                    <p class="text-muted">Kelola artikel yang tampil di situs.</p>
                </div>
                <div class="admin-header-actions">
                    <a href="<?php echo e(route('admin.articles.create')); ?>" class="btn btn-primary btn-lg"><i
                            class="fas fa-plus"></i> Baru</a>
                </div>
            </div>

            <?php if(session('success')): ?>
                <div class="alert alert-success"><?php echo e(session('success')); ?></div>
            <?php endif; ?>

            <div class="admin-section">
                <div class="bookings-table-wrapper">
                    <table class="table table-admin">
                        <thead>
                            <tr>
                                <th width="60">ID</th>
                                <th>Judul</th>
                                <th>Penulis</th>
                                <th>Publikasi</th>
                                <th width="160">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td>#<?php echo e($a->id); ?></td>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <?php if($a->image): ?>
                                                <img src="<?php echo e(asset('storage/' . $a->image)); ?>" alt="thumb" class="article-thumb">
                                            <?php endif; ?>
                                            <div>
                                                <strong><?php echo e($a->title); ?></strong>
                                                <div class="text-muted small"><?php echo e(Str::limit($a->excerpt, 80)); ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?php echo e($a->author->name ?? '—'); ?></td>
                                    <td><?php echo e($a->published_at ? \Illuminate\Support\Carbon::parse($a->published_at)->format('d M Y') : 'Draft'); ?>

                                    </td>
                                    <td>
                                        <a href="<?php echo e(route('admin.articles.show', $a)); ?>" class="btn btn-xs btn-secondary"
                                            title="Lihat"><i class="fas fa-eye"></i></a>
                                        <a href="<?php echo e(route('admin.articles.edit', $a)); ?>" class="btn btn-xs btn-primary"
                                            title="Edit"><i class="fas fa-edit"></i></a>
                                        <form action="<?php echo e(route('admin.articles.destroy', $a)); ?>" method="POST"
                                            class="d-inline-block" onsubmit="return confirm('Hapus artikel ini?');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button class="btn btn-xs btn-danger" title="Hapus"><i
                                                    class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4">Belum ada artikel</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <div class="mt-3"><?php echo e($articles->links()); ?></div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\adakamar\resources\views/admin/articles/index.blade.php ENDPATH**/ ?>