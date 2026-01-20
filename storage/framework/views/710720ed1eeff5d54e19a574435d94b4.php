

<?php $__env->startSection('title', $article->title); ?>

<?php $__env->startSection('content'); ?>
    <div class="admin-dashboard">
        <div class="container">
            <div class="admin-header">
                <div>
                    <h1><?php echo e($article->title); ?></h1>
                    <p class="text-muted">
                        <?php echo e($article->published_at ? 'Diterbitkan ' . \Illuminate\Support\Carbon::parse($article->published_at)->format('d M Y') : 'Draft'); ?>

                    </p>
                </div>
                <div class="admin-header-actions">
                    <a href="<?php echo e(route('admin.articles.edit', $article)); ?>" class="btn btn-primary btn-sm">Edit</a>
                    <a href="<?php echo e(route('admin.articles.index')); ?>" class="btn btn-secondary btn-sm">Kembali</a>
                </div>
            </div>

            <div class="admin-section">
                <?php if($article->image): ?>
                    <div class="mb-4">
                        <img src="<?php echo e(asset('storage/' . $article->image)); ?>" alt="cover" class="img-fluid"
                            style="max-height:420px;object-fit:cover;width:100%;border-radius:8px;">
                    </div>
                <?php endif; ?>
                <div class="article-body"><?php echo nl2br(e($article->body)); ?></div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\adakamar\resources\views/admin/articles/show.blade.php ENDPATH**/ ?>