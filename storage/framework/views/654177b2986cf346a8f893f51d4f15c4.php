

<?php $__env->startSection('title', 'Kategori Homestay'); ?>

<?php $__env->startSection('meta'); ?>
    <meta name="description"
        content="Daftar kategori homestay terbaik di AdaKamar. Temukan kategori berdasarkan fasilitas, lokasi, atau kebutuhan rombongan.">
    <link rel="canonical" href="<?php echo e(route('categories.index')); ?>">
    <script type="application/ld+json">
                    <?php echo json_encode([
        "@context" => "https://schema.org",
        "@type" => "ItemList",
        "itemListElement" => $categories->map(function ($c, $i) {
            return [
                "@type" => "ListItem",
                "position" => $i + 1,
                "item" => [
                    "@id" => route('categories.show', $c->slug),
                    "name" => $c->name,
                    "description" => \Illuminate\Support\Str::limit($c->description ?? '', 160)
                ]
            ];
        })->toArray()
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>

                </script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container categories-section categories-index section-pad">
        <div class="section-header">
            <h1>Kategori Homestay</h1>
            <p class="text-muted">Temukan homestay berdasarkan kategori. Pilih kategori untuk melihat listing khusus.</p>
        </div>

        <div class="categories-grid">
            <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <a href="<?php echo e(route('categories.show', $category->slug)); ?>" class="category-card">
                    <div class="cat-icon"><?php echo e(strtoupper(substr($category->name, 0, 1))); ?></div>
                    <div class="cat-body">
                        <h4><?php echo e($category->name); ?></h4>
                        <?php if($category->description): ?>
                            <p class="cat-desc"><?php echo e(\Illuminate\Support\Str::limit($category->description, 120)); ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="category-meta">
                        <span class="category-count"><?php echo e($category->homestays_count); ?> unit</span>
                    </div>
                    <div class="card-arrow"><i class="fa fa-angle-right"></i></div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p>Tidak ada kategori</p>
            <?php endif; ?>
        </div>

        <div class="mt-4 pagination-wrapper"><?php echo e($categories->links()); ?></div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\adakamar\resources\views/pages/categories/index.blade.php ENDPATH**/ ?>