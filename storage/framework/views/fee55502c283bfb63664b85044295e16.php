<?php echo csrf_field(); ?>
<div class="mb-3">
    <label class="form-label">Judul</label>
    <input type="text" name="title" value="<?php echo e(old('title', $article->title ?? '')); ?>"
        class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
    <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<div class="mb-3">
    <label class="form-label">Gambar (opsional)</label>
    <?php if(isset($article) && $article->image): ?>
        <div class="mb-2">
            <img src="<?php echo e(asset('storage/' . $article->image)); ?>" alt="cover" class="img-fluid"
                style="max-height:150px; object-fit:cover;">
        </div>
    <?php endif; ?>
    <input type="file" name="image" accept="image/*" class="form-control <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
    <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<div class="mb-3">
    <label class="form-label">Ringkasan (excerpt)</label>
    <textarea name="excerpt" class="form-control <?php $__errorArgs = ['excerpt'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
        rows="3"><?php echo e(old('excerpt', $article->excerpt ?? '')); ?></textarea>
    <?php $__errorArgs = ['excerpt'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<div class="mb-3">
    <label class="form-label">Konten</label>
    <textarea name="body" class="form-control <?php $__errorArgs = ['body'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
        rows="10"><?php echo e(old('body', $article->body ?? '')); ?></textarea>
    <?php $__errorArgs = ['body'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<?php if(isset($categories) && $categories->count()): ?>
    <div class="mb-3">
        <label class="form-label">Kategori (opsional)</label>
        <select name="categories[]" class="form-select" multiple size="6">
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $selected = in_array($cat->id, old('categories', isset($article) ? $article->categories->pluck('id')->toArray() : [])); ?>
                <option value="<?php echo e($cat->id); ?>" <?php echo e($selected ? 'selected' : ''); ?>><?php echo e($cat->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <div class="form-text">Tekan Ctrl/Cmd untuk memilih beberapa kategori.</div>
        <div class="form-text mt-2">Atau tambahkan kategori baru dengan mengetik nama pada kolom di bawah, pisahkan beberapa kategori dengan koma.</div>
        <input list="category-list" name="category_names" id="category_names" class="form-control mt-2" placeholder="Contoh: Tips, Panduan, Bali" value="<?php echo e(old('category_names', '')); ?>">
        <datalist id="category-list">
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($cat->name); ?>"></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </datalist>
    </div>
<?php else: ?>
    <div class="mb-3">
        <label class="form-label">Kategori (opsional)</label>
        <div class="form-text text-muted">Belum ada kategori artikel. Ketik nama kategori di bawah untuk membuat baru.</div>
        <input list="category-list" name="category_names" id="category_names" class="form-control mt-2" placeholder="Contoh: Tips, Panduan, Bali" value="<?php echo e(old('category_names', '')); ?>">
        <datalist id="category-list"></datalist>
    </div>
<?php endif; ?>

<div class="mb-3"> <label class="form-label">Tanggal Publikasi (opsional)</label>
    <input type="datetime-local" name="published_at"
        value="<?php echo e(old('published_at', isset($article) && $article->published_at ? \Illuminate\Support\Carbon::parse($article->published_at)->format('Y-m-d\TH:i') : '')); ?>"
        class="form-control <?php $__errorArgs = ['published_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
    <?php $__errorArgs = ['published_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>
<?php /**PATH C:\xampp\htdocs\adakamar\resources\views/admin/articles/_form.blade.php ENDPATH**/ ?>