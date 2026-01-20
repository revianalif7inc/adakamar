

<?php $__env->startSection('title', 'Daftar'); ?>

<?php $__env->startSection('content'); ?>
    <div class="auth-container">
        <div class="auth-box auth-box-premium">
            <div class="auth-header">
                <img src="<?php echo e(asset('images/logoAdaKamar.png')); ?>" alt="AdaKamar" class="auth-logo">
                <h1>Buat Akun Baru</h1>
                <p class="auth-subtitle">Bergabunglah dengan ribuan pengguna kami</p>
            </div>

            <?php if($errors->any()): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Ups! Ada kesalahan:</strong>
                    <ul class="mb-0 mt-2">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('register')); ?>" method="POST" class="auth-form">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" id="name" name="name" value="<?php echo e(old('name')); ?>" required placeholder="John Doe"
                        class="form-control-premium">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo e(old('email')); ?>" required
                        placeholder="nama@email.com" class="form-control-premium">
                </div>

                <div class="form-group">
                    <label for="phone">Nomor Telepon</label>
                    <input type="tel" id="phone" name="phone" value="<?php echo e(old('phone')); ?>" placeholder="+62 812-3456-7890"
                        class="form-control-premium">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required placeholder="Minimal 8 karakter"
                        class="form-control-premium">
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                        placeholder="Ulangi password Anda" class="form-control-premium">
                </div>

                <button type="submit" class="btn btn-primary btn-login">Daftar Sekarang</button>
            </form>

            <div class="auth-divider">atau</div>

            <p class="auth-link">
                Sudah punya akun?
                <a href="<?php echo e(route('login')); ?>" class="auth-link-action">Login di sini</a>
            </p>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\adakamar\resources\views/auth/register.blade.php ENDPATH**/ ?>