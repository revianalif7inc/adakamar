

<?php $__env->startSection('content'); ?>
    <div class="container py-4">
        <a href="<?php echo e(route('artikel.index')); ?>" class="btn btn-link">&larr; Kembali ke Artikel</a>

        <div class="row">
            <div class="col-lg-8">
                <article class="mt-3">
                    <?php if($article->image): ?>
                        <div class="mb-3">
                            <img src="<?php echo e(asset('storage/' . $article->image)); ?>" alt="<?php echo e($article->title); ?>"
                                class="article-hero img-fluid" />
                        </div>
                    <?php endif; ?>
                    <h1><?php echo e($article->title); ?></h1>
                    <p class="text-muted">
                        <?php echo e($article->published_at ? \Illuminate\Support\Carbon::parse($article->published_at)->format('d M Y') : ''); ?>

                        <?php if($article->author): ?> • oleh <?php echo e($article->author->name); ?> <?php endif; ?>
                    </p>

                    <?php if($article->categories && $article->categories->count()): ?>
                        <p class="mt-2">
                            Kategori:
                            <?php $__currentLoopData = $article->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a
                                    href="<?php echo e(route('artikel.category', $cat->slug)); ?>"><?php echo e($cat->name); ?></a><?php echo e(!$loop->last ? ',' : ''); ?>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </p>
                    <?php endif; ?>

                    <div class="mt-4"><?php echo nl2br(e($article->body)); ?></div>
                </article>
            </div>

            <div class="col-lg-4">
                <?php echo $__env->make('articles._widgets', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\adakamar\resources\views/articles/show.blade.php ENDPATH**/ ?>