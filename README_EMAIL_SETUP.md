# Hướng dẫn thiết lập Email cho Localhost

## Cách 1: Dùng Mailtrap (Khuyên dùng cho testing)

Mailtrap là dịch vụ test email miễn phí, giúp bạn xem email mà không cần gửi thật.

### Bước 1: Đăng ký tài khoản Mailtrap

1. Truy cập: https://mailtrap.io/
2. Đăng ký tài khoản miễn phí
3. Tạo một "Inbox" mới

### Bước 2: Lấy thông tin SMTP

1. Vào **Email Testing** > **Inboxes** > Chọn inbox của bạn
2. Click vào tab **SMTP Settings**
3. Chọn **Laravel** từ dropdown
4. Copy các thông tin sau:

### Bước 3: Cấu hình trong file `.env`

Thêm hoặc cập nhật các dòng sau vào file `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourstore.com
MAIL_FROM_NAME="${APP_NAME}"
```

**Lưu ý:** Thay `your_username` và `your_password` bằng thông tin từ Mailtrap.

### Bước 4: Test

1. Đặt một đơn hàng
2. Vào Mailtrap inbox để xem email đã được gửi

---

## Cách 2: Dùng Gmail SMTP (Gửi email thật)

### Bước 1: Tạo App Password

1. Vào https://myaccount.google.com/
2. Bật **2-Step Verification**
3. Vào **Security** > **App passwords**
4. Tạo app password mới cho "Mail"
5. Copy mật khẩu (16 ký tự)

### Bước 2: Cấu hình trong file `.env`

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_gmail@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_gmail@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

### Bước 3: Test

Đặt đơn hàng và kiểm tra hộp thư email.

---

## Cách 3: Dùng Mail Log (Chỉ xem trong log, không gửi)

Phù hợp cho testing nhanh, email sẽ được lưu vào file log.

### Cấu hình trong file `.env`

```env
MAIL_MAILER=log
MAIL_FROM_ADDRESS=noreply@yourstore.com
MAIL_FROM_NAME="${APP_NAME}"
```

### Xem email

Email sẽ được lưu trong `storage/logs/laravel.log`

---

## Kiểm tra cấu hình

Sau khi cấu hình, chạy lệnh sau để test:

```bash
php artisan tinker
```

Trong tinker, chạy:

```php
Mail::raw('Test email', function($message) {
    $message->to('test@example.com')
            ->subject('Test Email');
});
```

---

## Troubleshooting

### Email không được gửi

1. Kiểm tra file log: `storage/logs/laravel.log`
2. Đảm bảo các biến trong `.env` đúng
3. Chạy: `php artisan config:clear` để xóa cache config
4. Kiểm tra kết nối internet

### Gmail báo lỗi "Less secure app"

- Phải dùng **App Password**, không dùng mật khẩu thường
- Đảm bảo đã bật 2-Step Verification

---

## Lưu ý

- **Mailtrap**: Miễn phí, tốt cho testing, không gửi email thật
- **Gmail SMTP**: Gửi email thật, có giới hạn (500 email/ngày với tài khoản miễn phí)
- **Mail Log**: Chỉ test nhanh, email không được gửi

