

<?php $__env->startSection('title', 'Edit Kamar - Owner'); ?>

<?php $__env->startSection('content'); ?>
    <div class="admin-dashboard">
        <div class="container">
            <div class="admin-header">
                <div>
                    <h1><i class="fas fa-door-open"></i> Edit Kamar</h1>
                    <p class="text-muted">Perbarui informasi kamar — nama, harga, gambar, dan fasilitas</p>
                </div>
                <a href="<?php echo e(route('owner.kamar.index')); ?>" class="btn btn-secondary">Kembali ke Daftar</a>
            </div>

            <div class="admin-section">
                <div class="section-body">

                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger mb-4">
                            <h5 class="alert-heading"><i class="fas fa-exclamation-circle"></i> Terdapat Kesalahan</h5>
                            <ul class="mb-0">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo e(route('owner.kamar.update', $homestay->id)); ?>" method="POST"
                        enctype="multipart/form-data" class="admin-form form-kamar">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <?php echo $__env->make('owner.homestays._form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                        <div class="admin-form-actions">
                            <button class="btn btn-primary btn-lg"><i class="fas fa-save"></i> Perbarui Kamar</button>
                            <a href="<?php echo e(route('owner.kamar.index')); ?>" class="btn btn-secondary btn-lg"><i class="fas fa-times"></i> Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('select[name="categories[]"]').forEach(function (el) {
        if (!el.classList.contains('choices-initialized')) {
            new Choices(el, {
                removeItemButton: true,
                searchEnabled: true,
                shouldSort: false,
                placeholderValue: 'Pilih kategori...'
            });
            el.classList.add('choices-initialized');
        }
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\adakamar\resources\views/owner/homestays/edit.blade.php ENDPATH**/ ?>