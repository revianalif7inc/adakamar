

<?php $__env->startSection('title', 'Ubah Peran Pengguna'); ?>

<?php $__env->startSection('content'); ?>
    <div class="admin-dashboard">
        <div class="container">
            <div class="admin-header">
                <div>
                    <h1>Ubah Peran</h1>
                    <p class="text-muted">Ubah peran pengguna (admin, owner, customer)</p>
                </div>
            </div>

            <div class="admin-section">
                <div class="section-body">
                    <form action="<?php echo e(route('admin.users.update', $user->id)); ?>" method="POST" class="admin-form">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="form-group">
                            <label for="role">Peran</label>
                            <select name="role" id="role" class="form-control">
                                <option value="customer" <?php echo e($user->role === 'customer' ? 'selected' : ''); ?>>Customer</option>
                                <option value="owner" <?php echo e($user->role === 'owner' ? 'selected' : ''); ?>>Owner</option>
                                <option value="admin" <?php echo e($user->role === 'admin' ? 'selected' : ''); ?>>Admin</option>
                            </select>
                        </div>

                        <div class="admin-form-actions">
                            <button class="btn btn-primary">Simpan</button>
                            <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\adakamar\resources\views/admin/users/edit.blade.php ENDPATH**/ ?>