

<?php $__env->startSection('title', 'Kategori Artikel'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Kategori Artikel</h1>
            <a href="<?php echo e(route('admin.article-categories.create')); ?>" class="btn btn-primary">Buat Kategori</a>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
        <?php endif; ?>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Slug</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($c->name); ?></td>
                        <td><?php echo e($c->slug); ?></td>
                        <td><?php echo e(Str::limit($c->description, 80)); ?></td>
                        <td>
                            <a href="<?php echo e(route('admin.article-categories.edit', $c)); ?>" class="btn btn-sm btn-secondary">Edit</a>
                            <form action="<?php echo e(route('admin.article-categories.destroy', $c)); ?>" method="POST"
                                class="d-inline-block" onsubmit="return confirm('Hapus kategori?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

        <?php echo e($categories->links()); ?>

    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\adakamar\resources\views/admin/article_categories/index.blade.php ENDPATH**/ ?>