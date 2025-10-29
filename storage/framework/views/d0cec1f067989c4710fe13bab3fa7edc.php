<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Thanh toán ATM - Mixtas</title>
    <base href="/">
    
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <style>
        @charset "UTF-8";
        
        * {
            box-sizing: border-box;
        }
        
        html, body {
            font-family: 'Roboto', -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", sans-serif !important;
            padding: 0;
            margin: 0;
            background-color: #f5f5f5;
            line-height: inherit;
            overflow-x: hidden;
            height: 100%;
            position: relative;
            min-height: 100%;
        }
        
        .header {
            background: white;
            padding: 15px 30px;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            font-size: 24px;
            font-weight: 700;
            color: #333;
        }
        
        .header-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .header-info span {
            display: flex;
            align-items: center;
            gap: 5px;
            color: #666;
            font-size: 14px;
        }
        
        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px;
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
            min-height: calc(100vh - 200px);
        }
        
        .left-panel, .right-panel {
            background: white;
            border-radius: 8px;
            overflow: hidden;
        }
        
        .panel-header {
            background: #f8f9fa;
            padding: 15px 20px;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .panel-title {
            font-size: 16px;
            font-weight: 500;
            color: #333;
        }
        
        .tab-active {
            background: #007bff;
            color: white;
            padding: 5px 15px;
            border-radius: 4px;
            font-size: 14px;
        }
        
        .panel-content {
            padding: 20px;
        }
        
        .search-box {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        
        .search-box:focus {
            outline: none;
            border-color: #007bff;
        }
        
        .bank-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 10px;
            margin-bottom: 30px;
        }
        
        .bank-item {
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            padding: 15px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
            min-height: 80px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        
        .bank-item:hover {
            border-color: #007bff;
            box-shadow: 0 2px 8px rgba(0,123,255,0.2);
        }
        
        .bank-item.selected {
            border-color: #007bff;
            background: #e3f2fd;
        }
        
        .bank-logo {
            width: 40px;
            height: 40px;
            margin-bottom: 8px;
            background: #f5f5f5;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            color: #666;
        }
        
        .bank-name {
            font-size: 11px;
            font-weight: 500;
            color: #333;
            line-height: 1.2;
        }
        
        .cancel-link {
            text-align: center;
            margin-top: 20px;
        }
        
        .cancel-link a {
            color: #666;
            text-decoration: none;
            font-size: 14px;
        }
        
        .cancel-link a:hover {
            color: #333;
        }
        
        .order-info {
            background: white;
            border-radius: 4px;
            padding: 20px;
        }
        
        .order-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-size: 14px;
        }
        
        .order-item:last-child {
            margin-bottom: 0;
            padding-top: 15px;
            border-top: 1px solid #e0e0e0;
            font-weight: 600;
            font-size: 16px;
        }
        
        .order-label {
            color: #666;
        }
        
        .order-value {
            color: #333;
            font-weight: 500;
        }
        
        .order-amount {
            color: #007bff;
            font-weight: 700;
            font-size: 18px;
        }
        
        .timer {
            display: flex;
            align-items: center;
            gap: 5px;
            color: #666;
            font-size: 14px;
        }
        
        .footer {
            background: white;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e0e0e0;
            margin-top: 50px;
        }
        
        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .security-badges {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 20px 0;
        }
        
        .security-badge {
            background: #f8f9fa;
            padding: 8px 15px;
            border-radius: 4px;
            font-size: 12px;
            color: #666;
            border: 1px solid #e0e0e0;
        }
        
        .footer-links {
            margin: 20px 0;
        }
        
        .footer-links a {
            color: #666;
            text-decoration: none;
            margin: 0 10px;
            font-size: 14px;
        }
        
        .footer-links a:hover {
            color: #333;
        }
        
        .copyright {
            color: #999;
            font-size: 12px;
            margin-top: 20px;
        }
        
        .loading {
            display: none;
            text-align: center;
            padding: 20px;
        }
        
        .loading.show {
            display: block;
        }
        
        .spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #007bff;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            margin: 0 auto 10px;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Custom notice styling */
        .payment-notice {
            margin-bottom: 15px;
            padding: 12px 15px;
            background: linear-gradient(135deg, #e3f2fd, #f3e5f5);
            border-left: 4px solid #2196f3;
            border-radius: 6px;
            font-size: 13px;
            color: #1565c0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .payment-notice i {
            color: #2196f3;
            margin-right: 8px;
        }
        
        .payment-notice strong {
            color: #0d47a1;
        }
        
        @media (max-width: 768px) {
            .main-container {
                grid-template-columns: 1fr;
                padding: 15px;
                gap: 20px;
            }
            
            .header {
                padding: 15px;
                flex-direction: column;
                gap: 10px;
            }
            
            .header-info {
                flex-direction: column;
                gap: 10px;
            }
            
            .bank-grid {
                grid-template-columns: repeat(3, 1fr);
            }
            
            .bank-item {
                padding: 10px;
                min-height: 70px;
            }
            
            .payment-notice {
                font-size: 12px;
                padding: 10px 12px;
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <div class="logo">Mixtas</div>
        <div class="header-info">
            <span>
                <i class="fas fa-phone"></i>
                1900 633 927 (07h00 - 24h00)
            </span>
            <span>
                <i class="fas fa-envelope"></i>
                support@mixtas.vn
            </span>
            <span>
                <i class="fas fa-globe"></i>
                <i class="fas fa-flag"></i>
            </span>
        </div>
    </div>

    <!-- Main Container -->
    <div class="main-container">
        <!-- Left Panel - Bank Selection -->
        <div class="left-panel">
            <div class="panel-header">
                <div class="panel-title">Thẻ ATM / Tài khoản ngân hàng</div>
                <div class="tab-active">ATM</div>
            </div>
            <div class="panel-content">
                <input type="text" class="search-box" placeholder="Tìm kiếm ngân hàng" id="searchBank">
                
                <div class="bank-grid" id="bankGrid">
                    <div class="bank-item" data-bank="vietcombank">
                        <div class="bank-logo">
                            <i class="fas fa-university"></i>
                        </div>
                        <div class="bank-name">Vietcombank</div>
                    </div>
                    <div class="bank-item" data-bank="bidv">
                        <div class="bank-logo">
                            <i class="fas fa-university"></i>
                        </div>
                        <div class="bank-name">BIDV</div>
                    </div>
                    <div class="bank-item" data-bank="agribank">
                        <div class="bank-logo">
                            <i class="fas fa-university"></i>
                        </div>
                        <div class="bank-name">AGRIBANK</div>
                    </div>
                    <div class="bank-item" data-bank="vietinbank">
                        <div class="bank-logo">
                            <i class="fas fa-university"></i>
                        </div>
                        <div class="bank-name">VietinBank</div>
                    </div>
                    <div class="bank-item" data-bank="techcombank">
                        <div class="bank-logo">
                            <i class="fas fa-university"></i>
                        </div>
                        <div class="bank-name">TECHCOMBANK</div>
                    </div>
                    <div class="bank-item" data-bank="sacombank">
                        <div class="bank-logo">
                            <i class="fas fa-university"></i>
                        </div>
                        <div class="bank-name">Sacombank</div>
                    </div>
                    <div class="bank-item" data-bank="tpbank">
                        <div class="bank-logo">
                            <i class="fas fa-university"></i>
                        </div>
                        <div class="bank-name">TPBank</div>
                    </div>
                    <div class="bank-item" data-bank="mbbank">
                        <div class="bank-logo">
                            <i class="fas fa-university"></i>
                        </div>
                        <div class="bank-name">MB</div>
                    </div>
                    <div class="bank-item" data-bank="vib">
                        <div class="bank-logo">
                            <i class="fas fa-university"></i>
                        </div>
                        <div class="bank-name">VIB</div>
                    </div>
                    <div class="bank-item" data-bank="eximbank">
                        <div class="bank-logo">
                            <i class="fas fa-university"></i>
                        </div>
                        <div class="bank-name">EXIMBANK</div>
                    </div>
                    <div class="bank-item" data-bank="shb">
                        <div class="bank-logo">
                            <i class="fas fa-university"></i>
                        </div>
                        <div class="bank-name">SHB</div>
                    </div>
                    <div class="bank-item" data-bank="msb">
                        <div class="bank-logo">
                            <i class="fas fa-university"></i>
                        </div>
                        <div class="bank-name">MSB</div>
                    </div>
                    <div class="bank-item" data-bank="hdbank">
                        <div class="bank-logo">
                            <i class="fas fa-university"></i>
                        </div>
                        <div class="bank-name">HDBank</div>
                    </div>
                    <div class="bank-item" data-bank="seabank">
                        <div class="bank-logo">
                            <i class="fas fa-university"></i>
                        </div>
                        <div class="bank-name">SeABank</div>
                    </div>
                    <div class="bank-item" data-bank="bacabank">
                        <div class="bank-logo">
                            <i class="fas fa-university"></i>
                        </div>
                        <div class="bank-name">BAC A BANK</div>
                    </div>
                    <div class="bank-item" data-bank="ncb">
                        <div class="bank-logo">
                            <i class="fas fa-university"></i>
                        </div>
                        <div class="bank-name">NCB</div>
                    </div>
                    <div class="bank-item" data-bank="scb">
                        <div class="bank-logo">
                            <i class="fas fa-university"></i>
                        </div>
                        <div class="bank-name">SCB</div>
                    </div>
                    <div class="bank-item" data-bank="bvbank">
                        <div class="bank-logo">
                            <i class="fas fa-university"></i>
                        </div>
                        <div class="bank-name">BVBank</div>
                    </div>
                    <div class="bank-item" data-bank="nama">
                        <div class="bank-logo">
                            <i class="fas fa-university"></i>
                        </div>
                        <div class="bank-name">NAM A BANK</div>
                    </div>
                    <div class="bank-item" data-bank="vieta">
                        <div class="bank-logo">
                            <i class="fas fa-university"></i>
                        </div>
                        <div class="bank-name">VIET A BANK</div>
                    </div>
                </div>
                
                <div class="cancel-link">
                    <a href="<?php echo e(route('checkout.index')); ?>">✕ Hủy giao dịch</a>
                </div>
            </div>
        </div>

        <!-- Right Panel - Order Information -->
        <div class="right-panel">
            <div class="panel-header">
                <div class="panel-title">Thông tin đơn hàng</div>
                <div class="timer">
                    <i class="fas fa-clock"></i>
                    <span id="countdown">15:00</span>
                </div>
            </div>
            <div class="panel-content">
                <div class="order-info">
                    <div class="order-item">
                        <span class="order-label">Đơn vị chấp nhận thanh toán</span>
                        <span class="order-value">Mixtas</span>
                    </div>
                    <div class="order-item">
                        <span class="order-label">Mã đơn hàng</span>
                        <span class="order-value"><?php echo e($orderId); ?></span>
                    </div>
                    <div class="order-item">
                        <span class="order-label">Số tiền thanh toán</span>
                        <span class="order-amount"><?php echo e(number_format(session('pending_order.totalAmount', 0))); ?> VND</span>
                    </div>
                </div>
                
                <div class="loading" id="loading">
                    <div class="spinner"></div>
                    <p>Đang xử lý thanh toán...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="footer-content">
            <div>Giải pháp thanh toán được cung cấp bởi <strong>Mixtas</strong></div>
            
            <div class="security-badges">
                <div class="security-badge">GlobalSign</div>
                <div class="security-badge">Trustwave</div>
                <div class="security-badge">PCI-DSS VALIDATED</div>
            </div>
            
            <div class="footer-links">
                <a href="#">Về Mixtas</a> |
                <a href="#">Hướng dẫn thanh toán</a> |
                <a href="#">Câu hỏi thường gặp</a> |
                <a href="#">Liên hệ</a>
            </div>
            
            <div class="copyright">
                © 2024-2025 Bản quyền thuộc về Mixtas
            </div>
        </div>
    </div>

    <script>
        let selectedBank = null;
        let countdownTimer = null;
        let timeLeft = 15 * 60; // 15 phút
        
        // Countdown timer
        function startCountdown() {
            countdownTimer = setInterval(() => {
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                const timeString = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                document.getElementById('countdown').textContent = timeString;
                
                if (timeLeft <= 0) {
                    clearInterval(countdownTimer);
                    alert('Hết thời gian thanh toán. Vui lòng thử lại.');
                    window.location.href = '<?php echo e(route("checkout.index")); ?>';
                }
                
                timeLeft--;
            }, 1000);
        }
        
        // Tìm kiếm ngân hàng
        document.getElementById('searchBank').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const bankItems = document.querySelectorAll('.bank-item');
            
            bankItems.forEach(item => {
                const bankName = item.querySelector('.bank-name').textContent.toLowerCase();
                if (bankName.includes(searchTerm)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        });
        
        // Chọn ngân hàng
        document.querySelectorAll('.bank-item').forEach(item => {
            item.addEventListener('click', function() {
                document.querySelectorAll('.bank-item').forEach(b => b.classList.remove('selected'));
                this.classList.add('selected');
                selectedBank = this.dataset.bank;
                
                // Hiển thị form nhập thông tin thẻ
                showCardForm();
            });
        });
        
        // Hiển thị form nhập thông tin thẻ
        function showCardForm() {
            if (selectedBank) {
                // Tạo form nhập thông tin thẻ
                const formHTML = `
                    <div class="card-form" style="margin-top: 20px; padding: 20px; background: #f8f9fa; border-radius: 8px;">
                        <h4 style="margin-bottom: 20px; color: #333;">Nhập thông tin thẻ</h4>
                        
                        <div style="margin-bottom: 15px;">
                            <label style="display: block; margin-bottom: 5px; font-weight: 500; color: #333;">Số thẻ ATM</label>
                            <input type="text" id="cardNumber" class="search-box" placeholder="Nhập số thẻ ATM" maxlength="19" style="margin-bottom: 0;">
                        </div>
                        
                        <div style="margin-bottom: 15px;">
                            <label style="display: block; margin-bottom: 5px; font-weight: 500; color: #333;">Tên chủ thẻ</label>
                            <input type="text" id="cardName" class="search-box" placeholder="Nhập tên chủ thẻ" style="margin-bottom: 0;">
                        </div>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                            <div>
                                <label style="display: block; margin-bottom: 5px; font-weight: 500; color: #333;">Ngày hết hạn</label>
                                <input type="text" id="expiryDate" class="search-box" placeholder="MM/YY" maxlength="5" style="margin-bottom: 0;">
                            </div>
                            <div>
                                <label style="display: block; margin-bottom: 5px; font-weight: 500; color: #333;">CVV</label>
                                <input type="text" id="cvv" class="search-box" placeholder="CVV" maxlength="4" style="margin-bottom: 0;">
                            </div>
                        </div>
                        
                        <div class="payment-notice">
                            <i class="fas fa-shield-alt"></i>
                            <strong>Lưu ý:</strong> Thông tin thẻ được mã hóa và bảo mật. Vui lòng nhập chính xác thông tin thẻ của bạn.
                        </div>
                        
                        <button onclick="processPayment()" style="width: 100%; background: #007bff; color: white; border: none; padding: 12px; border-radius: 4px; font-size: 16px; font-weight: 500; cursor: pointer; transition: background 0.3s;">
                            <i class="fas fa-credit-card"></i> Thanh toán
                        </button>
                    </div>
                `;
                
                // Xóa form cũ nếu có
                const existingForm = document.querySelector('.card-form');
                if (existingForm) {
                    existingForm.remove();
                }
                
                // Thêm form mới
                document.querySelector('.panel-content').insertAdjacentHTML('beforeend', formHTML);
                
                // Thêm event listeners cho form mới
                addCardFormListeners();
            }
        }
        
        // Thêm event listeners cho form thẻ
        function addCardFormListeners() {
            // Format số thẻ
            const cardNumberInput = document.getElementById('cardNumber');
            if (cardNumberInput) {
                cardNumberInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\s/g, '').replace(/[^0-9]/gi, '');
                    let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
                    e.target.value = formattedValue;
                });
            }
            
            // Format ngày hết hạn
            const expiryDateInput = document.getElementById('expiryDate');
            if (expiryDateInput) {
                expiryDateInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    if (value.length >= 2) {
                        value = value.substring(0, 2) + '/' + value.substring(2, 4);
                    }
                    e.target.value = value;
                });
            }
            
            // Chỉ cho phép nhập số cho CVV
            const cvvInput = document.getElementById('cvv');
            if (cvvInput) {
                cvvInput.addEventListener('input', function(e) {
                    e.target.value = e.target.value.replace(/[^0-9]/g, '');
                });
            }
        }
        
        // Xử lý thanh toán
        function processPayment() {
            const cardNumber = document.getElementById('cardNumber')?.value.replace(/\s/g, '');
            const cardName = document.getElementById('cardName')?.value;
            const expiryDate = document.getElementById('expiryDate')?.value;
            const cvv = document.getElementById('cvv')?.value;
            
            // Validation
            if (!selectedBank) {
                alert('Vui lòng chọn ngân hàng');
                return;
            }
            
            if (!cardNumber || cardNumber.length < 16) {
                alert('Vui lòng nhập số thẻ hợp lệ');
                return;
            }
            
            if (!cardName || !cardName.trim()) {
                alert('Vui lòng nhập tên chủ thẻ');
                return;
            }
            
            if (!expiryDate || expiryDate.length !== 5) {
                alert('Vui lòng nhập ngày hết hạn hợp lệ');
                return;
            }
            
            if (!cvv || cvv.length < 3) {
                alert('Vui lòng nhập CVV hợp lệ');
                return;
            }
            
            // Hiển thị loading
            document.getElementById('loading').classList.add('show');
            
            // Gửi dữ liệu đến server
            const formData = new FormData();
            formData.append('bank', selectedBank);
            formData.append('card_number', cardNumber);
            formData.append('card_name', cardName);
            formData.append('expiry_date', expiryDate);
            formData.append('cvv', cvv);
            formData.append('_token', '<?php echo e(csrf_token()); ?>');
            
            fetch('<?php echo e(route("payment.atm.process")); ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Thanh toán thành công
                    clearInterval(countdownTimer);
                    window.location.href = data.redirect_url;
                } else {
                    // Thanh toán thất bại
                    alert(data.message || 'Thanh toán thất bại. Vui lòng thử lại.');
                    document.getElementById('loading').classList.remove('show');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra. Vui lòng thử lại.');
                document.getElementById('loading').classList.remove('show');
            });
        }
        
        // Khởi tạo
        document.addEventListener('DOMContentLoaded', function() {
            startCountdown();
        });
    </script>
</body>
</html>
<?php /**PATH C:\laragon\www\DATN_09\resources\views/payment/atm.blade.php ENDPATH**/ ?>