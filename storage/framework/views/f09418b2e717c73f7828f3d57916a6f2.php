

<?php $__env->startSection('title','Buat Kategori Artikel'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <h1>Buat Kategori Artikel</h1>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('admin.article-categories.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="name" class="form-control" value="<?php echo e(old('name')); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Slug (opsional)</label>
            <input type="text" name="slug" class="form-control" value="<?php echo e(old('slug')); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control"><?php echo e(old('description')); ?></textarea>
        </div>
        <button class="btn btn-primary">Simpan</button>
        <a href="<?php echo e(route('admin.article-categories.index')); ?>" class="btn btn-secondary">Batal</a>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\adakamar\resources\views/admin/article_categories/create.blade.php ENDPATH**/ ?>