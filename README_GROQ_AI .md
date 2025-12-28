
# Hướng Dẫn Cài Đặt Groq Chatbot cho Friday

## 1. Lấy API Key từ Groq

1. Truy cập: https://console.groq.com/
2. Đăng ký/Đăng nhập tài khoản
3. Vào phần "API Keys" và tạo API key mới
4. Copy API key (lưu ý: chỉ hiển thị 1 lần)

## 2. Cấu Hình Laravel

### Bước 1: Thêm API Key vào `.env`

```env
GROQ_API_KEY=gsk_your_api_key_here
```

### Bước 2: Cấu hình `config/services.php`

Thêm vào file `config/services.php`:

```php
return [
    // ... các config khác

    'groq' => [
        'api_key' => env('GROQ_API_KEY'),
    ],
];
```

## 3. Cài Đặt Chatbot

### Bước 1: Copy Component

Copy file `groq-chatbot.blade.php` vào thư mục:
```
resources/views/components/groq-chatbot.blade.php
```

### Bước 2: Thêm vào Layout

Thêm component vào file layout chính của bạn (ví dụ: `app.blade.php`):

**Cách 1: Thêm trước thẻ đóng `</body>`**

```blade
<!DOCTYPE html>
<html lang="vi-VN">
<head>
    <!-- ... meta tags, css ... -->
</head>
<body>
    
    @yield('content')
    
    <!-- Chatbot Widget -->
    @include('components.groq-chatbot')
    
    <!-- Scripts -->
    @include('layouts.js')
    
</body>
</html>
```

**Cách 2: Thêm vào file blade hiện tại của bạn**

Trong file blade hiện tại (như đoạn code bạn đã gửi), thêm trước thẻ `</body>`:

```blade
<!-- ... nội dung khác ... -->

<!-- Chatbot Widget -->
@include('components.groq-chatbot')

</body>
</html>
```

## 4. Tùy Chỉnh (Optional)

### Thay đổi màu sắc

Trong file `groq-chatbot.blade.php`, tìm và sửa:

```css
/* Thay đổi màu chính */
background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);

/* Thành màu của bạn, ví dụ: */
background: linear-gradient(135deg, #FF6B6B 0%, #FF8E53 100%);
```

### Thay đổi vị trí

```css
.chatbot-button {
    bottom: 20px;  /* Khoảng cách từ dưới */
    right: 20px;   /* Khoảng cách từ phải */
    
    /* Hoặc đặt bên trái: */
    /* left: 20px; */
}
```

### Thay đổi tin nhắn chào mừng

Trong file `groq-chatbot.blade.php`, tìm:

```html
<div class="message-content">
    Xin chào! Tôi là trợ lý AI của Friday. Tôi có thể giúp gì cho bạn hôm nay?
</div>
```

### Thay đổi System Prompt

Trong phần JavaScript, tìm `conversationHistory` và sửa:

```javascript
conversationHistory = [
    {
        role: 'system',
        content: 'Bạn là trợ lý AI của Friday. Hãy giúp khách hàng về: sản phẩm thời trang, đơn hàng, chính sách đổi trả, size áo. Trả lời bằng tiếng Việt, thân thiện và chuyên nghiệp.'
    }
];
```

### Thay đổi Model

Groq hỗ trợ nhiều models:
- `mixtral-8x7b-32768` (mặc định - cân bằng)
- `llama2-70b-4096` (nhanh hơn)
- `gemma-7b-it` (nhẹ hơn)

Sửa trong file:
```javascript
const CONFIG = {
    MODEL: 'llama2-70b-4096' // Thay đổi model tại đây
};
```

## 5. Kiểm Tra

1. Chạy Laravel server: `php artisan serve`
2. Mở trình duyệt và vào trang web
3. Kiểm tra xem nút chatbot có xuất hiện ở góc dưới phải không
4. Click vào nút và thử gửi tin nhắn

## 6. Xử Lý Lỗi Thường Gặp

### Lỗi: API Key không hợp lệ

```
Solution: 
- Kiểm tra lại API key trong .env
- Chạy: php artisan config:clear
- Restart server
```

### Lỗi: CORS

```
Solution:
- Groq API hỗ trợ CORS, nên không cần cấu hình thêm
- Nếu vẫn lỗi, có thể tạo route proxy trong Laravel
```

### Lỗi: Chatbot không hiển thị

```
Solution:
- Kiểm tra xem đã include component đúng chưa
- Kiểm tra console browser (F12) xem có lỗi JS không
- Kiểm tra z-index của các element khác
```

## 7. Nâng Cao: Tạo API Proxy (Bảo Mật Hơn)

Để bảo mật API key, nên tạo route Laravel làm proxy:

### Bước 1: Tạo Controller

```php
// app/Http/Controllers/ChatbotController.php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'messages' => 'required|array',
        ]);

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.groq.api_key'),
                'Content-Type' => 'application/json',
            ])->post('https://api.groq.com/openai/v1/chat/completions', [
                'model' => 'mixtral-8x7b-32768',
                'messages' => $request->messages,
                'temperature' => 0.7,
                'max_tokens' => 1024,
            ]);

            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to process request'
            ], 500);
        }
    }
}
```

### Bước 2: Thêm Route

```php
// routes/web.php
Route::post('/api/chatbot', [ChatbotController::class, 'chat'])->name('chatbot.chat');
```

### Bước 3: Sửa JavaScript

Trong `groq-chatbot.blade.php`, thay đổi:

```javascript
// Thay vì gọi trực tiếp Groq API
const response = await fetch('{{ route('chatbot.chat') }}', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    body: JSON.stringify({
        messages: conversationHistory
    })
});
```

## 8. Tính Năng Bổ Sung (Optional)

### Lưu lịch sử chat vào Database

Tạo migration:
```bash
php artisan make:migration create_chat_histories_table
```

### Thêm typing animation

Đã có sẵn trong code với class `typing-indicator`

### Thêm sound notification

Có thể thêm âm thanh khi có tin nhắn mới

## 9. Testing

Một số câu hỏi mẫu để test:

1. "Xin chào"
2. "Tôi muốn mua áo"
3. "Chính sách đổi trả như thế nào?"
4. "Size M tương đương bao nhiêu cm?"
5. "Sản phẩm nào đang hot?"

## Liên Hệ Hỗ Trợ

Nếu cần hỗ trợ, vui lòng:
- Kiểm tra logs: `storage/logs/laravel.log`
- Kiểm tra console browser (F12)
- Đảm bảo API key còn credits

---

**Lưu ý**: API Groq có giới hạn rate limit miễn phí. Nếu sử dụng cho production, nên xem xét:
- Thêm cache cho các câu hỏi thường gặp
- Implement rate limiting
- Theo dõi usage