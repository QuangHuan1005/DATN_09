<?php $__env->startSection('title', 'Thanh toán Momo'); ?>

<?php $__env->startPush('styles'); ?>
<style>
.momo-payment-container {
    max-width: 500px;
    margin: 50px auto;
    padding: 30px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    text-align: center;
}

.momo-logo {
    width: 120px;
    height: 120px;
    margin: 0 auto 20px;
    background: #d82d8b;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 24px;
    font-weight: bold;
}

.qr-code-container {
    margin: 30px 0;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 10px;
}

.qr-code {
    max-width: 200px;
    margin: 0 auto;
    border: 2px solid #ddd;
    border-radius: 10px;
    padding: 10px;
    background: white;
}

.payment-info {
    background: #e3f2fd;
    padding: 15px;
    border-radius: 8px;
    margin: 20px 0;
}

.payment-amount {
    font-size: 24px;
    font-weight: bold;
    color: #d82d8b;
    margin: 10px 0;
}

.payment-instructions {
    text-align: left;
    margin: 20px 0;
}

.payment-instructions ol {
    padding-left: 20px;
}

.payment-instructions li {
    margin: 8px 0;
    color: #666;
}

.btn-momo {
    background: #d82d8b;
    color: white;
    border: none;
    padding: 12px 30px;
    border-radius: 25px;
    font-weight: bold;
    text-decoration: none;
    display: inline-block;
    margin: 10px;
    transition: all 0.3s ease;
}

.btn-momo:hover {
    background: #b71c69;
    color: white;
    text-decoration: none;
}

.status-check {
    margin: 20px 0;
    padding: 15px;
    background: #fff3cd;
    border: 1px solid #ffeaa7;
    border-radius: 8px;
    color: #856404;
}

.loading {
    display: none;
}

.loading.show {
    display: block;
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="momo-payment-container">
        <div class="momo-logo">
            MOMO
        </div>
        
        <h2>Thanh toán bằng Momo</h2>
        
        <div class="payment-info">
            <p><strong>Mã đơn hàng:</strong> <?php echo e($orderId); ?></p>
            <div class="payment-amount">
                <?php if(session('pending_order.totalAmount')): ?>
                    <?php echo e(number_format(session('pending_order.totalAmount'))); ?>đ
                <?php else: ?>
                    Quét mã QR để thanh toán
                <?php endif; ?>
            </div>
        </div>

        <div class="qr-code-container">
            <h4>Quét mã QR bằng ứng dụng Momo</h4>
            <div class="qr-code">
                <img src="<?php echo e($qrCodeUrl); ?>" alt="Momo QR Code" style="width: 100%; height: auto;">
            </div>
        </div>

        <div class="payment-instructions">
            <h5>Hướng dẫn thanh toán:</h5>
            <ol>
                <li>Mở ứng dụng Momo trên điện thoại</li>
                <li>Chọn "Quét mã QR"</li>
                <li>Quét mã QR ở trên</li>
                <li>Xác nhận thông tin và thanh toán</li>
                <li>Chờ xác nhận từ hệ thống</li>
            </ol>
        </div>

        <div class="status-check">
            <p><i class="fas fa-clock"></i> Đang chờ thanh toán...</p>
            <div class="loading">
                <i class="fas fa-spinner fa-spin"></i> Đang kiểm tra trạng thái...
            </div>
        </div>

        <div>
            <a href="<?php echo e($payUrl); ?>" class="btn-momo" target="_blank">
                <i class="fas fa-mobile-alt"></i> Thanh toán trên web
            </a>
            <a href="<?php echo e(route('checkout.index')); ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>
</div>

<script>
// Kiểm tra trạng thái thanh toán mỗi 5 giây
let checkInterval;
let isDemo = <?php echo e(session('pending_order.isDemo') ? 'true' : 'false'); ?>;

function checkPaymentStatus() {
    const orderId = '<?php echo e($orderId); ?>';
    
    if (isDemo) {
        // Demo mode - tự động thanh toán sau 30 giây
        setTimeout(() => {
            clearInterval(checkInterval);
            window.location.href = '<?php echo e(route("checkout.success")); ?>';
        }, 30000);
        return;
    }
    
    fetch(`/payment/momo/status?order_id=${orderId}`)
        .then(response => response.json())
        .then(data => {
            if (data.resultCode === 0) {
                // Thanh toán thành công
                clearInterval(checkInterval);
                window.location.href = '<?php echo e(route("checkout.success")); ?>';
            } else if (data.resultCode === 1006) {
                // Chưa thanh toán, tiếp tục chờ
                console.log('Chờ thanh toán...');
            } else {
                // Thanh toán thất bại
                clearInterval(checkInterval);
                alert('Thanh toán thất bại. Vui lòng thử lại.');
                window.location.href = '<?php echo e(route("checkout.index")); ?>';
            }
        })
        .catch(error => {
            console.error('Lỗi kiểm tra trạng thái:', error);
        });
}

// Bắt đầu kiểm tra
if (isDemo) {
    // Demo mode - bắt đầu ngay
    checkInterval = setInterval(checkPaymentStatus, 1000);
} else {
    // Momo thật - bắt đầu sau 10 giây
    setTimeout(() => {
        checkInterval = setInterval(checkPaymentStatus, 5000);
    }, 10000);
}

// Dừng kiểm tra sau 10 phút
setTimeout(() => {
    clearInterval(checkInterval);
    alert('Hết thời gian thanh toán. Vui lòng thử lại.');
    window.location.href = '<?php echo e(route("checkout.index")); ?>';
}, 600000);
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\DATN_09\resources\views/payment/momo-qr.blade.php ENDPATH**/ ?>