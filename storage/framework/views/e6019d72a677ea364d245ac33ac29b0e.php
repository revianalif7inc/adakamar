

<?php $__env->startSection('title', 'Manage Reviews'); ?>

<?php $__env->startSection('content'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/admin-reviews.css')); ?>">
<div class="admin-dashboard">
    <div class="container">
        <div class="admin-header">
            <div>
                <h1>Kelola Ulasan</h1>
                <p class="text-muted">Lihat, sunting, atau hapus ulasan yang diberikan oleh pengguna.</p>
            </div>
            <div class="admin-header-actions">
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-secondary">Kembali</a>
            </div>
        </div>

        <div class="admin-section">
            <form action="<?php echo e(route('admin.reviews.index')); ?>" method="GET" class="mb-3">
                <div class="row">
                    <div class="col-lg-4 mb-2">
                        <input type="text" name="q" class="form-control" placeholder="Cari user, homestay, atau komentar..." value="<?php echo e($q); ?>">
                    </div>

                    <div class="col-lg-3 mb-2">
                        <select name="user_id" class="form-select">
                            <option value="">Semua Pengguna</option>
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($u->id); ?>" <?php echo e(request('user_id') == $u->id ? 'selected' : ''); ?>><?php echo e($u->name); ?> (<?php echo e($u->email); ?>)</option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="col-lg-3 mb-2">
                        <select name="homestay_id" class="form-select">
                            <option value="">Semua Homestay</option>
                            <?php $__currentLoopData = $homestays; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($h->id); ?>" <?php echo e(request('homestay_id') == $h->id ? 'selected' : ''); ?>><?php echo e($h->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="col-lg-2 mb-2">
                        <select name="rating" class="form-select">
                            <option value="">Semua Rating</option>
                            <?php for($i=5; $i>=1; $i--): ?>
                                <option value="<?php echo e($i); ?>" <?php echo e(request('rating') == (string) $i ? 'selected' : ''); ?>><?php echo e($i); ?> bintang</option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <div class="col-lg-12">
                        <div class="d-flex gap-2">
                            <button class="btn btn-primary">Filter</button>
                            <a href="<?php echo e(route('admin.reviews.index')); ?>" class="btn btn-outline-secondary">Reset</a>
                        </div>
                    </div>
                </div>
            </form>

            <?php if($reviews->count()): ?>
                <table class="table table-admin">
                    <thead>
                        <tr>
                            <th width="60">ID</th>
                            <th>User</th>
                            <th>Homestay</th>
                            <th>Rating</th>
                            <th>Komentar</th>
                            <th width="120">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>#<?php echo e($r->id); ?></td>
                                <td><?php echo e($r->user->name); ?><br><small class="text-muted"><?php echo e($r->user->email); ?></small></td>
                                <td><?php echo e($r->homestay->name ?? '-'); ?></td>
                                <td><?php echo e($r->rating); ?></td>
                                <td><?php echo e(\Illuminate\Support\Str::limit($r->comment, 80)); ?></td>
                                <td>
                                    <a href="<?php echo e(route('admin.reviews.edit', $r->id)); ?>" class="btn btn-sm btn-info">Sunting</a>
                                    <form action="<?php echo e(route('admin.reviews.destroy', $r->id)); ?>" method="POST" style="display:inline-block">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus ulasan ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>

                <?php echo e($reviews->links()); ?>

            <?php else: ?>
                <p class="text-muted">Belum ada ulasan.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\adakamar\resources\views/admin/reviews/index.blade.php ENDPATH**/ ?>