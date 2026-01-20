

<?php $__env->startSection('title', 'Kelola Lokasi'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Kelola Lokasi</h1>
            <a href="<?php echo e(route('admin.locations.create')); ?>" class="btn btn-primary">Tambah Lokasi</a>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Slug</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($loop->iteration + ($locations->currentPage() - 1) * $locations->perPage()); ?></td>
                                <td><?php echo e($location->name); ?></td>
                                <td><?php echo e($location->slug); ?></td>
                                <td><?php echo e(\Illuminate\Support\Str::limit($location->description, 80)); ?></td>
                                <td>
                                    <a href="<?php echo e(route('admin.locations.edit', $location)); ?>"
                                        class="btn btn-sm btn-secondary">Edit</a>
                                    <form action="<?php echo e(route('admin.locations.destroy', $location)); ?>" method="POST"
                                        class="d-inline" onsubmit="return confirm('Hapus lokasi ini?');">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-3">
            <?php echo e($locations->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\adakamar\resources\views/admin/locations/index.blade.php ENDPATH**/ ?>