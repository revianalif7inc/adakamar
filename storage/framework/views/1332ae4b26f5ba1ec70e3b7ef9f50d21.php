

<?php $__env->startSection('title', 'Tambah Kamar'); ?>

<?php $__env->startSection('content'); ?>
    <div class="admin-dashboard">
        <div class="container">
            <div class="admin-header">
                <div>
                    <h1><i class="fas fa-door-open"></i> Tambah Kamar Baru</h1>
                    <p class="text-muted">Buat listing kamar baru dengan informasi lengkap</p>
                </div>
            </div>

            <div class="admin-section">
                <div class="section-body">
                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger mb-4">
                            <h5 class="alert-heading"><i class="fas fa-exclamation-circle"></i> Terdapat Kesalahan</h5>
                            <ul class="mb-0">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo e(route('admin.kamar.store')); ?>" method="POST" enctype="multipart/form-data"
                        class="admin-form form-kamar">
                        <?php echo csrf_field(); ?>

                        <div class="form-group">
                            <label for="name">Nama Kamar *</label>
                            <input type="text" id="name" name="name" class="form-control" value="<?php echo e(old('name')); ?>"
                                required>
                            <small class="form-text">Nama akan tampil pada daftar kamar</small>
                        </div>

                        <div class="form-group">
                            <label for="slug">Slug (opsional)</label>
                            <input type="text" id="slug" name="slug" class="form-control" value="<?php echo e(old('slug')); ?>"
                                placeholder="Contoh: kamar-manikam-1">
                            <small class="form-text">Jika dikosongkan, sistem akan membuat slug otomatis dari nama.</small>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="categories">Kategori * (pilih lebih dari satu)</label>
                                <select id="categories" name="categories[]" class="form-select" multiple required>
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($cat->id); ?>" <?php echo e(in_array($cat->id, old('categories', [])) ? 'selected' : ''); ?>>
                                            <?php echo e($cat->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <small class="form-text">Gunakan Ctrl/Cmd atau Shift untuk memilih beberapa kategori.</small>

                                <div class="form-text mt-1">Atau ketik kategori baru:</div>
                                <input list="category-list" name="category_name" id="category_name" class="form-control mt-1"
                                    placeholder="Contoh: Kost" value="<?php echo e(old('category_name', '')); ?>">
                                <datalist id="category-list">
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($cat->name); ?>"></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </datalist>
                            </div>

                            <div class="form-group">
                                <label for="location_id">Lokasi/Alamat *</label>
                                <select id="location_id" name="location_id" class="form-select" required>
                                    <option value="">-- Pilih Lokasi --</option>
                                    <?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($loc->id); ?>" <?php echo e(old('location_id') == $loc->id ? 'selected' : ''); ?>>
                                            <?php echo e($loc->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('select[name="categories[]"]').forEach(function (el) {
        if (!el.classList.contains('choices-initialized')) {
            new Choices(el, {
                removeItemButton: true,
                searchEnabled: true,
                shouldSort: false,
                placeholderValue: 'Pilih kategori...'
            });
            el.classList.add('choices-initialized');
        }
    });
});
</script>
<?php $__env->stopSection(); ?>

                        <div class="form-group">
                            <label for="address">Alamat Lengkap</label>
                            <input type="text" id="address" name="address" class="form-control" value="<?php echo e(old('address')); ?>"
                                placeholder="Masukkan alamat lengkap yang akan tampil di listing">
                            <small class="form-text">Contoh: Jalan, RT/RW, Desa/Kelurahan (opsional)</small>
                        </div>

                        <div class="form-group">
                            <label for="description">Deskripsi *</label>
                            <textarea id="description" name="description" rows="5" class="form-control"
                                required><?php echo e(old('description')); ?></textarea>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="max_guests">Kapasitas Maksimal Tamu *</label>
                                <input type="number" id="max_guests" name="max_guests" class="form-control"
                                    value="<?php echo e(old('max_guests', 1)); ?>" min="1" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="price_per_night">Harga per Malam (Rp)</label>
                                <input type="number" id="price_per_night" name="price_per_night" class="form-control"
                                    value="<?php echo e(old('price_per_night')); ?>" step="1000" min="0">
                                <small class="form-text text-muted">Opsional — harga per malam</small>
                            </div>

                            <div class="form-group">
                                <label for="price_per_month">Harga per Bulan (Rp)</label>
                                <input type="number" id="price_per_month" name="price_per_month" class="form-control"
                                    value="<?php echo e(old('price_per_month')); ?>" step="1000" min="0">
                                <small class="form-text text-muted">Opsional — untuk kost/jangka panjang</small>
                            </div>

                            <div class="form-group">
                                <label for="price_per_year">Harga per Tahun (Rp)</label>
                                <input type="number" id="price_per_year" name="price_per_year" class="form-control"
                                    value="<?php echo e(old('price_per_year')); ?>" step="1000" min="0">
                                <small class="form-text text-muted">Opsional — untuk sewa tahunan</small>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="bedrooms">Jumlah Kamar Tidur *</label>
                                <input type="number" id="bedrooms" name="bedrooms" class="form-control"
                                    value="<?php echo e(old('bedrooms', 1)); ?>" min="1" required>
                            </div>

                            <div class="form-group">
                                <label for="bathrooms">Jumlah Kamar Mandi *</label>
                                <input type="number" id="bathrooms" name="bathrooms" class="form-control"
                                    value="<?php echo e(old('bathrooms', 1)); ?>" min="1" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="image_url">Foto Utama (Cover)</label>
                            <input type="file" id="image_url" name="image_url" class="form-control" accept="image/*">
                            <small class="form-text">Gambar utama yang muncul di daftar. Format: JPG, PNG, GIF. Max 2MB (opsional)</small>
                        </div>

                        <div class="form-group">
                            <label for="images">Gambar Tambahan (galeri)</label>
                            <input type="file" id="images" name="images[]" class="form-control" accept="image/*" multiple>
                            <small class="form-text">Unggah beberapa gambar untuk galeri (opsional). Format: JPG, PNG, WEBP. Max 4MB per file.</small>
                        </div>

                        <div class="form-group">
                            <label for="amenities">Fasilitas (pisahkan dengan koma)</label>
                            <textarea id="amenities" name="amenities" rows="3" class="form-control"
                                placeholder="Contoh: WiFi, AC, Dapur, Kolam Renang..."><?php echo e(old('amenities')); ?></textarea>
                        </div>

                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="is_featured" name="is_featured" value="1" <?php echo e(old('is_featured') ? 'checked' : ''); ?>>
                            <label class="form-check-label" for="is_featured">Tandai sebagai <strong>Kamar Pilihan</strong></label>
                        </div>

                        <div class="admin-form-actions">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save"></i> Simpan Kamar
                            </button>
                            <a href="<?php echo e(route('admin.kamar.index')); ?>" class="btn btn-secondary btn-lg">
                                <i class="fas fa-times"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\adakamar\resources\views/admin/homestays/create.blade.php ENDPATH**/ ?>