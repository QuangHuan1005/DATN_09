# Hướng dẫn tích hợp VNPay

## ✅ Đã tích hợp VNPay môi trường TEST

### Thông tin VNPay Test đã cấu hình:

```env
VNPAY_TMN_CODE=HY7R6YX3
VNPAY_HASH_SECRET=Z63L4QLL6AGATBCEH7V2770CPYE2USE4
VNPAY_URL=https://sandbox.vnpayment.vn/paymentv2/vpcpay.html
VNPAY_ENVIRONMENT=sandbox
```

### Thông tin đăng nhập Merchant Admin:
- **Địa chỉ:** https://sandbox.vnpayment.vn/merchantv2/
- **Tên đăng nhập:** phongndph52116@gmail.com
- **Mật khẩu:** (Mật khẩu đăng ký)

### Thẻ test:
- **Ngân hàng:** NCB
- **Số thẻ:** 9704198526191432198
- **Tên chủ thẻ:** NGUYEN VAN A
- **Ngày phát hành:** 07/15
- **Mật khẩu OTP:** 123456

## Cách test:

1. Truy cập: `http://127.0.0.1:8000/checkout`
2. Đăng nhập tài khoản
3. Thêm sản phẩm vào giỏ hàng
4. Chọn phương thức "Thanh toán bằng VNPay"
5. Nhập thông tin giao hàng và click "Đặt hàng"
6. Sẽ chuyển đến trang VNPay test
7. Sử dụng thẻ test ở trên để thanh toán
8. Sau thanh toán sẽ chuyển về trang thành công

## Bước 1: Đăng ký tài khoản VNPay (đã hoàn thành)

1. ✅ Đã đăng ký tài khoản test tại: https://sandbox.vnpayment.vn/
2. ✅ Đã lấy thông tin:
   - `TMN_CODE` (Terminal ID): HY7R6YX3
   - `HASH_SECRET` (Secret Key): Z63L4QLL6AGATBCEH7V2770CPYE2USE4

## Bước 2: Cấu hình trong file `.env` (✅ Đã hoàn thành)

File `.env` đã được cấu hình với thông tin VNPay test:

```env
# VNPay Configuration (Sandbox/Test Environment)
VNPAY_TMN_CODE=HY7R6YX3
VNPAY_HASH_SECRET=Z63L4QLL6AGATBCEH7V2770CPYE2USE4
VNPAY_URL=https://sandbox.vnpayment.vn/paymentv2/vpcpay.html
VNPAY_QUERY_URL=https://sandbox.vnpayment.vn/merchant_webapi/merchant.html
VNPAY_RETURN_URL=http://127.0.0.1:8000/payment/vnpay/return
VNPAY_IPN_URL=http://127.0.0.1:8000/payment/vnpay/ipn
VNPAY_ENVIRONMENT=sandbox
VNPAY_VERSION=2.1.0
VNPAY_LOCALE=vn
```

### Sandbox (Test):
```env
VNPAY_URL=https://sandbox.vnpayment.vn/paymentv2/vpcpay.html
VNPAY_QUERY_URL=https://sandbox.vnpayment.vn/merchant_webapi/merchant.html
```

### Production:
```env
VNPAY_URL=https://www.vnpay.vn/paymentv2/vpcpay.html
VNPAY_QUERY_URL=https://www.vnpay.vn/merchant_webapi/merchant.html
```

## Các thành phần đã tích hợp:

### ✅ 1. File cấu hình `.env` - HOÀN THÀNH
- Đã cấu hình đầy đủ thông tin VNPay test

### ✅ 2. Config file `config/vnpay.php` - SẴN SÀNG
- Đã có config file với các setting cần thiết

### ✅ 3. Service `VNPayService` - HOÀN THÀNH
- Class xử lý tạo URL thanh toán
- Xác thực callback và IPN
- Query trạng thái giao dịch

### ✅ 4. Controller `VNPayController` - HOÀN THÀNH
- Method `return()` xử lý callback từ VNPay
- Method `ipn()` xử lý IPN notification
- Tích hợp với model Order và Payment

### ✅ 5. Routes - HOÀN THÀNH
- Route `/payment/vnpay/return` cho callback
- Route `/payment/vnpay/ipn` cho IPN

### ✅ 6. Checkout integration - HOÀN THÀNH
- Cập nhật `CheckoutController` xử lý payment_method VNPay
- Tạo đơn hàng trước khi thanh toán
- Tích hợp với cả "mua ngay" và giỏ hàng

## Bước 3: Kiểm tra cấu hình (✅ Đã hoàn thành)

Config đã được clear và cache:
```bash
php artisan config:clear
php artisan config:cache
```

## Bước 4: Test thanh toán

1. Vào trang checkout: `http://localhost:8000/checkout`
2. Chọn phương thức "Thanh toán bằng VNPay"
3. Click "Đặt hàng"
4. Sẽ redirect đến trang VNPay để thanh toán

## Lưu ý quan trọng:

1. **IPN URL phải có thể truy cập được từ internet** (không thể dùng localhost trong production)
   - Sử dụng ngrok hoặc deploy lên server để test IPN
   - IPN URL sẽ được VNPay gọi để xác nhận thanh toán

2. **Return URL** là nơi khách hàng quay lại sau khi thanh toán

3. **Kiểm tra signature** trong cả Return và IPN để đảm bảo an toàn

4. **Production**: Khi chuyển sang production, cần:
   - Đổi `VNPAY_ENVIRONMENT=production`
   - Cập nhật `VNPAY_URL` và `VNPAY_QUERY_URL` sang production
   - Sử dụng `TMN_CODE` và `HASH_SECRET` thật từ VNPay

## Xử lý đơn hàng sau thanh toán:

Trong các method `vnpayReturn()` và `vnpayIpn()` trong `PaymentController`, có TODO comments để:
- Tạo đơn hàng trong database
- Cập nhật trạng thái thanh toán
- Gửi email xác nhận

Cần implement các phần này để hoàn thiện hệ thống.


