

<?php $__env->startSection('title', 'Buat Artikel'); ?>

<?php $__env->startSection('content'); ?>
    <div class="admin-dashboard">
        <div class="container">
            <div class="admin-header">
                <div>
                    <h1>Buat Artikel Baru</h1>
                    <p class="text-muted">Tulis dan terbitkan artikel baru.</p>
                </div>
                <div class="admin-header-actions">
                    <a href="<?php echo e(route('admin.articles.index')); ?>" class="btn btn-secondary btn-sm">Kembali</a>
                </div>
            </div>

            <div class="admin-section">
                <div class="section-body">
                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo e(route('admin.articles.store')); ?>" method="POST" enctype="multipart/form-data" class="admin-form">
                        <?php echo $__env->make('admin.articles._form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                        <div class="admin-form-actions mt-3">
                            <button class="btn btn-primary">Simpan</button>
                            <a href="<?php echo e(route('admin.articles.index')); ?>" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\adakamar\resources\views/admin/articles/create.blade.php ENDPATH**/ ?>