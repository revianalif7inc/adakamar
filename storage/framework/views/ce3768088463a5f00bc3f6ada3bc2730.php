<aside class="articles-widgets">
    <div class="widget-box mb-4">
        <h5 class="widget-title">Tentang Penulis Artikel</h5>
        <div class="widget-body d-flex gap-3 align-items-center">
            <?php $author = \App\Models\User::where('role', 'admin')->first(); ?>
            <div class="author-avatar">
                <?php if($author): ?>
                    <div class="avatar-circle"><?php echo e(strtoupper(substr($author->name, 0, 1))); ?></div>
                <?php else: ?>
                    <div class="avatar-circle">A</div>
                <?php endif; ?>
            </div>
            <div>
                <strong><?php echo e($author->name ?? 'Tim AdaKamar'); ?></strong>
                <p class="small text-muted mb-0">Kami berbagi tips, berita, dan panduan seputar homestay dan pariwisata.
                </p>
            </div>
        </div>
    </div>

    <div class="widget-box mb-4">
        <h5 class="widget-title">Trending Post</h5>
        <div class="widget-body">
            <ul class="list-unstyled trending-list">
                <?php
                    $trending = isset($category) ? $category->articles()->published()->orderBy('published_at', 'desc')->limit(5)->get() : \App\Models\Article::published()->orderBy('published_at', 'desc')->limit(5)->get();
                ?>
                <?php $__currentLoopData = $trending; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="trending-item">
                        <a href="<?php echo e(route('artikel.show', $t)); ?>"><?php echo e(\Illuminate\Support\Str::limit($t->title, 60)); ?></a>
                        <div class="text-muted small">
                            <?php echo e(\Illuminate\Support\Carbon::parse($t->published_at)->format('d M Y')); ?></div>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    </div>

    <?php $hasArticleCategories = \Illuminate\Support\Facades\Schema::hasTable('article_categories'); ?>
    <div class="widget-box mb-4">
        <h5 class="widget-title">Kategori Artikel</h5>
        <div class="widget-body">
            <ul class="list-unstyled categories-list">
                <?php if($hasArticleCategories): ?>
                    <?php $__currentLoopData = \App\Models\ArticleCategory::orderBy('name', 'asc')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><a href="<?php echo e(route('artikel.category', $c->slug)); ?>"><?php echo e($c->name); ?></a></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <li class="text-muted">Belum ada kategori artikel</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</aside><?php /**PATH C:\xampp\htdocs\adakamar\resources\views/articles/_widgets.blade.php ENDPATH**/ ?>