<?php $__env->startSection('title', 'Đặt hàng thành công'); ?>

<?php $__env->startSection('content'); ?>
<main id="main" class="site-main">
    <div class="container">
        <div class="cart pt-40 checkout">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="checkout-success text-center">
                        <div class="success-icon mb-4">
                            <i class="fas fa-check-circle" style="font-size: 80px; color: #28a745;"></i>
                        </div>
                        
                        <h1 class="success-title mb-3">Đặt hàng thành công!</h1>
                        
                        <p class="success-message mb-4">
                            Cảm ơn bạn đã đặt hàng. Chúng tôi sẽ xử lý đơn hàng của bạn trong thời gian sớm nhất.
                        </p>
                        
                        <div class="success-actions">
                            <a href="<?php echo e(route('home')); ?>" class="btn btn-primary btn-lg me-3">
                                <i class="fas fa-home"></i> Về trang chủ
                            </a>
                            <a href="<?php echo e(route('orders.index')); ?>" class="btn btn-outline-primary btn-lg">
                                <i class="fas fa-list"></i> Xem đơn hàng
                            </a>
</div>
                        
                        <div class="success-info mt-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="info-item">
                                        <i class="fas fa-shipping-fast mb-2" style="font-size: 30px; color: #007bff;"></i>
                                        <h5>Giao hàng nhanh</h5>
                                        <p>Giao hàng trong 2-3 ngày làm việc</p>
				</div>
				</div>
                                <div class="col-md-4">
                                    <div class="info-item">
                                        <i class="fas fa-shield-alt mb-2" style="font-size: 30px; color: #28a745;"></i>
                                        <h5>Bảo mật thông tin</h5>
                                        <p>Thông tin cá nhân được bảo mật tuyệt đối</p>
		</div>
	</div>
                                <div class="col-md-4">
                                    <div class="info-item">
                                        <i class="fas fa-headset mb-2" style="font-size: 30px; color: #ffc107;"></i>
                                        <h5>Hỗ trợ 24/7</h5>
                                        <p>Đội ngũ chăm sóc khách hàng luôn sẵn sàng</p>
</div>
				</div>
				</div>
				</div>
					</div>
				</div>
				</div>
      </div>
    </div>
</main>

<style>
.checkout-success {
    padding: 60px 20px;
    background: #f8f9fa;
    border-radius: 10px;
    margin: 40px 0;
}

.success-title {
    color: #28a745;
    font-weight: bold;
}

.success-message {
    font-size: 18px;
    color: #6c757d;
}

.success-actions {
    margin: 30px 0;
}

.info-item {
    padding: 20px;
    text-align: center;
}

.info-item h5 {
    margin: 15px 0 10px 0;
    font-weight: bold;
}

.info-item p {
    color: #6c757d;
    font-size: 14px;
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\DATN_09-main\resources\views/checkout/success.blade.php ENDPATH**/ ?>