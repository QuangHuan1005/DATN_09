# Hướng dẫn tích hợp VNPay

## Bước 1: Đăng ký tài khoản VNPay

1. Truy cập: https://sandbox.vnpayment.vn/ (Sandbox) hoặc https://www.vnpay.vn/ (Production)
2. Đăng ký tài khoản merchant
3. Lấy thông tin:
   - `TMN_CODE` (Terminal ID)
   - `HASH_SECRET` (Secret Key)

## Bước 2: Cấu hình trong file `.env`

Thêm các biến môi trường sau vào file `.env`:

```env
# VNPay Configuration
VNPAY_TMN_CODE=your_tmn_code_here
VNPAY_HASH_SECRET=your_hash_secret_here
VNPAY_ENVIRONMENT=sandbox
# hoặc production khi đã sẵn sàng

# URLs (tự động, nhưng có thể override)
VNPAY_RETURN_URL=http://localhost:8000/payment/vnpay/return
VNPAY_IPN_URL=http://localhost:8000/payment/vnpay/ipn
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

## Bước 3: Kiểm tra cấu hình

Sau khi thêm thông tin vào `.env`, chạy:
```bash
php artisan config:clear
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


