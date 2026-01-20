<div class="form-group">
    <label for="name">Nama Kamar *</label>
    <input type="text" name="name" id="name" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
        value="<?php echo e(old('name', $homestay->name ?? '')); ?>" required>
    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<div class="form-group">
    <label for="slug">Slug (opsional)</label>
    <input type="text" name="slug" id="slug" class="form-control <?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
        value="<?php echo e(old('slug', $homestay->slug ?? '')); ?>" placeholder="Contoh: kamar-manikam-1">
    <small class="form-text">Kosongkan untuk auto-generate berdasarkan nama. Hanya huruf, angka dan dash (-) yang diperbolehkan.</small>
    <?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<div class="form-row">
    <div class="form-group">
        <label for="categories">Kategori * (pilih lebih dari satu)</label>
        <select id="categories" name="categories[]" class="form-control" multiple required>
            <?php $selected = old('categories', isset($homestay) ? ($homestay->categories->pluck('id')->toArray() ?? []) : []); ?>
            <?php $__currentLoopData = \App\Models\Category::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($category->id); ?>" <?php echo e(in_array($category->id, (array) $selected) ? 'selected' : ''); ?>><?php echo e($category->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <small class="form-text">Gunakan Ctrl/Cmd atau Shift untuk memilih beberapa kategori.</small>

        <div class="form-text mt-1">Atau ketik kategori baru:</div>
        <input list="category-list" name="category_name" id="category_name" class="form-control mt-1"
            placeholder="Contoh: Kost" value="<?php echo e(old('category_name', '')); ?>">
        <datalist id="category-list">
            <?php $__currentLoopData = \App\Models\Category::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($category->name); ?>"></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </datalist>
    </div>

    <div class="form-group">
        <label for="location_id">Lokasi/Alamat *</label>
        <select id="location_id" name="location_id" class="form-control" required>
            <option value="">-- Pilih Lokasi --</option>
            <?php $__currentLoopData = \App\Models\Location::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($location->id); ?>" <?php echo e((old('location_id', $homestay->location_id ?? '') == $location->id) ? 'selected' : ''); ?>><?php echo e($location->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
</div>

<div class="form-group">
    <label for="address">Alamat Lengkap</label>
    <input type="text" name="address" id="address" class="form-control <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
        value="<?php echo e(old('address', $homestay->location ?? '')); ?>">
    <small class="form-text">Contoh: Jalan, RT/RW, Desa/Kelurahan (opsional)</small>
    <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<div class="form-group">
    <label for="description">Deskripsi *</label>
    <textarea name="description" id="description" class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
        rows="5" required><?php echo e(old('description', $homestay->description ?? '')); ?></textarea>
    <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<div class="form-row">
    <div class="form-group">
        <label for="max_guests">Kapasitas Maksimal Tamu *</label>
        <input type="number" id="max_guests" name="max_guests" class="form-control" value="<?php echo e(old('max_guests', $homestay->max_guests ?? 1)); ?>" min="1" required>
    </div>
</div>

<div class="form-row">
    <div class="form-group">
        <label for="price_per_night">Harga per Malam (Rp)</label>
        <input type="number" id="price_per_night" name="price_per_night" class="form-control"
            value="<?php echo e(old('price_per_night', $homestay->price_per_night ?? '')); ?>" step="1000" min="0">
        <small class="form-text text-muted">Opsional — harga per malam</small>
    </div>

    <div class="form-group">
        <label for="price_per_month">Harga per Bulan (Rp)</label>
        <input type="number" id="price_per_month" name="price_per_month" class="form-control"
            value="<?php echo e(old('price_per_month', $homestay->price_per_month ?? '')); ?>" step="1000" min="0">
        <small class="form-text text-muted">Opsional — untuk kost/jangka panjang</small>
    </div>

    <div class="form-group">
        <label for="price_per_year">Harga per Tahun (Rp)</label>
        <input type="number" id="price_per_year" name="price_per_year" class="form-control"
            value="<?php echo e(old('price_per_year', $homestay->price_per_year ?? '')); ?>" step="1000" min="0">
        <small class="form-text text-muted">Opsional — untuk sewa tahunan</small>
    </div>
</div>

<div class="form-row">
    <div class="form-group">
        <label for="bedrooms">Jumlah Kamar Tidur *</label>
        <input type="number" name="bedrooms" id="bedrooms"
            class="form-control <?php $__errorArgs = ['bedrooms'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" min="1"
            value="<?php echo e(old('bedrooms', $homestay->bedrooms ?? 1)); ?>" required>
        <?php $__errorArgs = ['bedrooms'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
    <div class="form-group">
        <label for="bathrooms">Jumlah Kamar Mandi *</label>
        <input type="number" name="bathrooms" id="bathrooms"
            class="form-control <?php $__errorArgs = ['bathrooms'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" min="1"
            value="<?php echo e(old('bathrooms', $homestay->bathrooms ?? 1)); ?>" required>
        <?php $__errorArgs = ['bathrooms'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
</div>

    <div class="form-group">
        <label for="amenities">Fasilitas (pisahkan dengan koma)</label>
        <input type="text" name="amenities" id="amenities" class="form-control"
            value="<?php echo e(old('amenities', isset($homestay->amenities) ? implode(',', (array) $homestay->amenities) : '')); ?>"
            placeholder="Contoh: WiFi, AC, Dapur">
    </div>

    <div class="form-group">
        <label for="image_url">Foto Utama (Cover)</label>
        <div class="current-image">
            <?php if(!empty($homestay->image_url) && \Illuminate\Support\Facades\Storage::disk('public')->exists($homestay->image_url)): ?>
                <a href="<?php echo e(asset('storage/' . $homestay->image_url)); ?>" target="_blank" rel="noopener">
                    <img src="<?php echo e(asset('storage/' . $homestay->image_url)); ?>" alt="<?php echo e($homestay->name); ?>" class="image-preview">
                </a>
                <p>Foto saat ini</p>
            <?php else: ?>
                <img src="<?php echo e(asset('images/homestays/placeholder.svg')); ?>" alt="placeholder" class="image-preview">
                <p class="text-muted">Belum ada foto</p>
            <?php endif; ?>
        </div>

        <div class="mt-2">
            <input type="file" id="image_url" name="image_url" accept="image/*" class="form-control">
            <small class="form-text">Format: JPG, PNG, GIF. Max 2MB (Kosongkan jika tidak ingin mengubah)</small>
        </div>

        <div class="mt-3">
            <label for="images">Gambar Tambahan (galeri)</label>
            <input type="file" id="images" name="images[]" accept="image/*" multiple class="form-control">
            <small class="form-text">Unggah beberapa gambar untuk galeri (opsional). Format: JPG, PNG, WEBP. Max 4MB per file.</small>
        </div>

        <?php if(!empty($homestay->images) && is_array($homestay->images) && count($homestay->images)): ?>
            <div class="mt-3">
                <label class="form-label">Gambar Galeri</label>
                <div class="d-flex gap-2 flex-wrap">
                    <?php $__currentLoopData = $homestay->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div style="width:120px;text-align:center">
                            <?php if(\Illuminate\Support\Facades\Storage::disk('public')->exists($img)): ?>
                                <img src="<?php echo e(asset('storage/' . $img)); ?>" alt="" class="image-preview-small">
                            <?php else: ?>
                                <img src="<?php echo e(asset('images/homestays/placeholder.svg')); ?>" alt="" class="image-preview-small">
                            <?php endif; ?>
                            <div class="form-check mt-1">
                                <input type="checkbox" name="remove_images[]" value="<?php echo e($img); ?>" id="remove_<?php echo e(md5($img)); ?>">
                                <label for="remove_<?php echo e(md5($img)); ?>" class="small">Hapus</label>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <?php if(\Illuminate\Support\Facades\Schema::hasColumn('homestays', 'is_featured')): ?>
        <div class="form-group form-check mt-3">
            <input type="checkbox" class="form-check-input" id="is_featured" name="is_featured" value="1" <?php echo e(old('is_featured', $homestay->is_featured ?? false) ? 'checked' : ''); ?>>
            <label class="form-check-label" for="is_featured">Tandai sebagai <strong>Kamar Pilihan</strong></label>
        </div>
    <?php endif; ?>

    <div class="form-group text-muted small">
        Gambar tambahan dapat diunggah saat edit atau melalui galeri homestay.
    </div>
</div><?php /**PATH C:\xampp\htdocs\adakamar\resources\views/owner/homestays/_form.blade.php ENDPATH**/ ?>