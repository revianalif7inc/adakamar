

<?php $__env->startSection('title', 'Login'); ?>

<?php $__env->startSection('content'); ?>
    <div class="auth-container">
        <div class="auth-box auth-box-premium">
            <div class="auth-header">
                <img src="<?php echo e(asset('images/logoAdaKamar.png')); ?>" alt="AdaKamar" class="auth-logo">
                <h1>Masuk Akun</h1>
                <p class="auth-subtitle">Temukan kamar impianmu bersama kami</p>
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

            <form action="<?php echo e(route('login')); ?>" method="POST" class="auth-form">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo e(old('email')); ?>" required
                        placeholder="nama@email.com" class="form-control-premium">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required placeholder="Masukkan password Anda"
                        class="form-control-premium">
                </div>

                <button type="submit" class="btn btn-primary btn-login">Masuk</button>
            </form>

            <div class="auth-divider">atau</div>

            <p class="auth-link">
                Belum punya akun?
                <a href="<?php echo e(route('register')); ?>" class="auth-link-action">Daftar di sini</a>
            </p>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\adakamar\resources\views/auth/login.blade.php ENDPATH**/ ?>