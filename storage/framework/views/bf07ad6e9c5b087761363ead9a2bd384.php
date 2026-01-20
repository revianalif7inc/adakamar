

<?php $__env->startSection('title', 'Manajemen Pengguna'); ?>

<?php $__env->startSection('content'); ?>
    <div class="admin-dashboard">
        <div class="container">
            <div class="admin-header">
                <div>
                    <h1>Manajemen Pengguna</h1>
                    <p class="text-muted">Lihat dan kelola semua akun pengguna, khususnya pemilik (owner)</p>
                </div>
            </div>

            <?php if(session('success')): ?>
                <div class="alert alert-success"><?php echo e(session('success')); ?></div>
            <?php endif; ?>

            <div class="admin-section">
                <div class="section-body">

                    <div class="filters">
                        <form method="GET" action="<?php echo e(route('admin.users.index')); ?>" class="filters-form">
                            <input type="text" name="q" value="<?php echo e(old('q', $q ?? request('q'))); ?>" placeholder="Cari nama atau email..."
                                   class="form-control" />
                            <select name="role" class="form-control">
                                <option value="">Semua peran</option>
                                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($key); ?>" <?php echo e((old('role', $role ?? request('role')) === $key) ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <button type="submit" class="btn btn-primary">Cari</button>
                            <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-secondary">Reset</a>
                            <div class="ml-auto muted-count">Menampilkan <?php echo e($users->total()); ?> pengguna</div>
                        </form>
                    </div>
                    <div class="table-responsive-wrapper">
                        <table class="table table-admin">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th width="160">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($user->name); ?></td>
                                        <td><?php echo e($user->email); ?></td>
                                        <td><span class="badge role-badge role-<?php echo e($user->role); ?>"><?php echo e(ucfirst($user->role)); ?></span></td>
                                        <td>
                                            <a href="<?php echo e(route('admin.users.edit', $user->id)); ?>"
                                                class="btn btn-sm btn-info">Ubah Role</a>
                                            <?php if(auth()->id() !== $user->id): ?>
                                                <form action="<?php echo e(route('admin.users.destroy', $user->id)); ?>" method="POST" class="d-inline">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Hapus pengguna ini?')">Hapus</button>
                                                </form>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="4" class="text-center">Belum ada pengguna</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>

                        <div class="pagination-wrapper"><?php echo e($users->links()); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\adakamar\resources\views/admin/users/index.blade.php ENDPATH**/ ?>