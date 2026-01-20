

<?php $__env->startSection('title', 'Edit Lokasi'); ?>

<?php $__env->startSection('content'); ?>
    <div class="admin-dashboard">
        <div class="container">
            <div class="admin-header">
                <div>
                    <h1><i class="fas fa-map-marker-alt"></i> Edit Lokasi</h1>
                    <p class="text-muted">Perbarui informasi lokasi <?php echo e($location->name); ?></p>
                </div>
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

                    <form action="<?php echo e(route('admin.locations.update', $location)); ?>" method="POST" class="admin-form">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="form-group">
                            <label for="name">Nama Lokasi</label>
                            <input type="text" id="name" name="name" class="form-control"
                                value="<?php echo e(old('name', $location->name)); ?>" placeholder="Masukkan nama lokasi" required>
                            <small class="form-text">Nama unik untuk lokasi kamar</small>
                        </div>

                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea id="description" name="description" class="form-control" rows="4"
                                placeholder="Jelaskan lokasi ini..."><?php echo e(old('description', $location->description)); ?></textarea>
                            <small class="form-text">Deskripsi singkat tentang lokasi (opsional)</small>
                        </div>

                        <div class="admin-form-actions">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save"></i> Perbarui Lokasi
                            </button>
                            <a href="<?php echo e(route('admin.locations.index')); ?>" class="btn btn-secondary btn-lg">
                                <i class="fas fa-times"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\adakamar\resources\views/admin/locations/edit.blade.php ENDPATH**/ ?>