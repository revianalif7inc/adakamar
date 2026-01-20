

<?php $__env->startSection('title', 'Kelola Kategori'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Kelola Kategori</h1>
            <a href="<?php echo e(route('admin.categories.create')); ?>" class="btn btn-primary">Tambah Kategori</a>
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
                            <th>Pinned</th>
                            <th>Urutan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($loop->iteration + ($categories->currentPage() - 1) * $categories->perPage()); ?></td>
                                <td><?php echo e($category->name); ?></td>
                                <td><?php echo e($category->slug); ?></td>
                                <td><?php echo e(\Illuminate\Support\Str::limit($category->description, 80)); ?></td>
                                <td>
                                    <form action="<?php echo e(route('admin.categories.togglePin', $category)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <button
                                            class="btn btn-sm <?php echo e($category->is_pinned ? 'btn-success' : 'btn-outline'); ?>"><?php echo e($category->is_pinned ? 'Pinned' : 'Pin'); ?></button>
                                    </form>
                                </td>
                                <td>
                                    <div class="category-meta">
                                        <form action="<?php echo e(route('admin.categories.move', $category)); ?>" method="POST"
                                            class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="direction" value="up">
                                            <button class="btn btn-sm btn-secondary">▲</button>
                                        </form>

                                        <form action="<?php echo e(route('admin.categories.move', $category)); ?>" method="POST"
                                            class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="direction" value="down">
                                            <button class="btn btn-sm btn-secondary">▼</button>
                                        </form>
                                        <span class="sort-order"><?php echo e($category->sort_order); ?></span>
                                    </div>
                                </td>
                                <td>
                                    <a href="<?php echo e(route('admin.categories.edit', $category)); ?>"
                                        class="btn btn-sm btn-secondary">Edit</a>
                                    <form action="<?php echo e(route('admin.categories.destroy', $category)); ?>" method="POST"
                                        class="d-inline" onsubmit="return confirm('Hapus kategori ini?');">
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
            <?php echo e($categories->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\adakamar\resources\views/admin/categories/index.blade.php ENDPATH**/ ?>