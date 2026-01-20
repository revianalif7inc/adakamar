

<?php $__env->startSection('content'); ?>
    <div class="container py-4">
        <h2>Bayar Booking</h2>

        <div class="card mt-3">
            <div class="card-body">
                <h5 class="card-title"><?php echo e($booking->homestay->title ?? 'Homestay'); ?></h5>
                <p class="mb-1"><strong>Check In:</strong> <?php echo e($booking->check_in_date); ?></p>
                <p class="mb-1"><strong>Check Out:</strong> <?php echo e($booking->check_out_date); ?></p>
                <p class="mb-1"><strong>Total:</strong> Rp <?php echo e(number_format($booking->total_price, 0, ',', '.')); ?></p>

                <form action="<?php echo e(route('booking.pay', $booking->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <button class="btn btn-primary mt-3">Konfirmasi Pembayaran (placeholder)</button>
                    <a href="<?php echo e(route('booking.my_rooms')); ?>" class="btn btn-secondary mt-3 ms-2">Kembali</a>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\adakamar\resources\views/booking/pay.blade.php ENDPATH**/ ?>