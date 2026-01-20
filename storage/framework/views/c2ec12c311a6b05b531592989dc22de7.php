

<?php $__env->startSection('content'); ?>
    <div class="container py-4">
        <?php if(isset($category)): ?>
            <h1 class="mb-4">Kategori: <?php echo e($category->name); ?></h1>
            <?php if($category->description): ?>
                <p class="text-muted"><?php echo e($category->description); ?></p>
            <?php endif; ?>
        <?php else: ?>
            <h1 class="mb-4">Artikel</h1>
        <?php endif; ?>

        <?php $hasArticleCategories = \Illuminate\Support\Facades\Schema::hasTable('article_categories'); ?>
        <?php if($hasArticleCategories): ?>
            <div class="d-block d-md-none mb-3">
                <select id="mobileArticleCategorySelect" class="form-select">
                    <option value="">Semua Kategori</option>
                    <?php $__currentLoopData = \App\Models\ArticleCategory::orderBy('name','asc')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($cat->slug); ?>" <?php echo e(isset($category) && $category->id == $cat->id ? 'selected' : ''); ?>><?php echo e($cat->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-lg-8">
                <?php if($articles->count()): ?>
                    <div class="row">
                        <?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-6 mb-4">
                                <div class="card h-100 shadow-sm">
                                    <?php if($article->image): ?>
                                        <img src="<?php echo e(asset('storage/' . $article->image)); ?>" class="card-img-top article-card-img" alt="<?php echo e($article->title); ?>">
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo e($article->title); ?></h5>
                                        <p class="card-text text-muted small">
                                            <?php echo e($article->published_at ? \Illuminate\Support\Carbon::parse($article->published_at)->format('d M Y') : ''); ?></p>
                                        <p class="card-text"><?php echo e(Str::limit($article->excerpt ?? strip_tags($article->body), 150)); ?></p>
                                        <a href="<?php echo e(route('artikel.show', $article)); ?>" class="btn btn-primary">Baca Selengkapnya</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <?php echo e($articles->links()); ?>

                <?php else: ?>
                    <p>Tidak ada artikel dipublikasikan.</p>
                <?php endif; ?>
            </div>

            <div class="col-lg-4">
                <?php echo $__env->make('articles._widgets', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\adakamar\resources\views/articles/index.blade.php ENDPATH**/ ?>