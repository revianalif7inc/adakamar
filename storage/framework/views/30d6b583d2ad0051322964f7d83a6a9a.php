

<?php $__env->startSection('title', 'Edit Review'); ?>

<?php $__env->startSection('content'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/admin-reviews.css')); ?>">
    <div class="admin-dashboard">
        <div class="container">
            <div class="admin-header">
                <div>
                    <h1>Edit Ulasan</h1>
                    <p class="text-muted">Ubah rating atau komentar pengguna.</p>
                </div>
                <div class="admin-header-actions">
                    <a href="<?php echo e(route('admin.reviews.index')); ?>" class="btn btn-secondary">Kembali</a>
                </div>
            </div>

            <div class="admin-section">
                <form action="<?php echo e(route('admin.reviews.update', $review->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="mb-3">
                        <label class="form-label">User</label>
                        <input class="form-control" value="<?php echo e($review->user->name); ?> (<?php echo e($review->user->email); ?>)" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Homestay</label>
                        <select name="homestay_id" class="form-select">
                            <?php $__currentLoopData = $homestays; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($h->id); ?>" <?php echo e($review->homestay_id == $h->id ? 'selected' : ''); ?>><?php echo e($h->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Rating (1-5)</label>
                        <input type="number" name="rating" class="form-control" min="1" max="5"
                            value="<?php echo e($review->rating); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Komentar</label>
                        <textarea name="comment" class="form-control" rows="5"><?php echo e($review->comment); ?></textarea>
                    </div>

                    <div class="mt-4">
                        <button class="btn btn-primary">Simpan</button>
                        <a href="<?php echo e(route('admin.reviews.index')); ?>" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\adakamar\resources\views/admin/reviews/edit.blade.php ENDPATH**/ ?>