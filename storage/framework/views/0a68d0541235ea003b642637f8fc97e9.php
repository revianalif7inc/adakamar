

<?php $__env->startSection('title', 'Edit Artikel'); ?>

<?php $__env->startSection('content'); ?>
    <div class="admin-dashboard">
        <div class="container">
            <div class="admin-header">
                <div>
                    <h1>Edit Artikel</h1>
                    <p class="text-muted">Ubah isi artikel dan simpan.</p>
                </div>
                <div class="admin-header-actions">
                    <a href="<?php echo e(route('admin.articles.index')); ?>" class="btn btn-secondary btn-sm">Kembali</a>
                </div>
            </div>

            <div class="admin-section">
                <form action="<?php echo e(route('admin.articles.update', $article)); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo method_field('PUT'); ?>
                    <?php echo $__env->make('admin.articles._form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\adakamar\resources\views/admin/articles/edit.blade.php ENDPATH**/ ?>