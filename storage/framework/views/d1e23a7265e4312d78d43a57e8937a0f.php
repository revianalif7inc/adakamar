<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col">
                <img src="<?php echo e(asset('images/logoAdaKamar.png')); ?>" alt="AdaKamar">
                <p class="small">Platform sewa kamar terpercaya dengan pilihan penginapan terlengkap di seluruh
                    Indonesia. Temukan penginapan nyaman untuk perjalananmu.</p>
            </div>
            <div class="col">
                <h6>Menu</h6>
                <ul class="list-unstyled">
                    <li><a href="<?php echo e(route('home')); ?>">Beranda</a></li>
                    <li><a href="<?php echo e(route('kamar.index')); ?>">Kamar</a></li>
                    <li><a href="<?php echo e(route('login')); ?>">Login</a></li>
                </ul>
            </div>
            <div class="col">
                <h6>Kontak</h6>
                <p class="small">Email: support@adakamar.id<br>Tel: +62 812-3456-7890</p>
                <h6>Ikuti Kami</h6>
                <p class="small"><a href="#">Facebook</a> • <a href="#">Instagram</a> • <a href="#">Twitter</a></p>
            </div>
        </div>
        <div class="copyright">&copy; <?php echo e(date('Y')); ?> AdaKamar. All rights reserved.</div>
    </div>
</footer><?php /**PATH C:\xampp\htdocs\adakamar\resources\views/components/footer.blade.php ENDPATH**/ ?>