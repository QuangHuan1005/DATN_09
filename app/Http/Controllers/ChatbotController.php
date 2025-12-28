<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    public function chat(Request $request)
    {
        $userMessage = $request->input('message');

        // 1. Lấy dữ liệu sản phẩm + Link chi tiết
        $contextData = $this->getDatabaseContext($userMessage);

        // 2. Prompt nâng cao: Dạy AI cách trả về Link
        $systemPrompt = "Bạn là trợ lý ảo chuyên nghiệp của 'Mixtas'.
        
        NHIỆM VỤ:
        - Trả lời câu hỏi khách hàng dựa trên [DỮ LIỆU CỬA HÀNG] bên dưới.
        - Khi liệt kê sản phẩm, BẮT BUỘC phải kèm đường dẫn (Link) để khách xem.
        
        QUY TẮC ĐỊNH DẠNG (Bắt buộc tuân thủ):
        - Định dạng danh sách sản phẩm theo kiểu Markdown link: [Tên Sản Phẩm - Giá Tiền](Đường dẫn)
        - Ví dụ: [Áo Sơ Mi Nam - 250k](http://localhost:8000/products/1)
        - Không bịa đặt đường dẫn, chỉ dùng đường dẫn có sẵn trong dữ liệu.
        - Giọng điệu: Nhiệt tình, mời khách nhấn vào link xem chi tiết.

        [DỮ LIỆU CỬA HÀNG]:
        {$contextData}";

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('GROQ_API_KEY'),
                'Content-Type'  => 'application/json',
            ])->post('https://api.groq.com/openai/v1/chat/completions', [
                'model' => 'llama-3.3-70b-versatile',
                'messages' => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user', 'content' => $userMessage],
                ],
                'temperature' => 0.3,
                'max_tokens' => 800, // Tăng token để AI trả lời được danh sách dài hơn
            ]);

            if ($response->successful()) {
                $botReply = $response->json()['choices'][0]['message']['content'] ?? 'Xin lỗi, tôi chưa tìm thấy thông tin.';
                return response()->json(['reply' => $botReply]);
            } else {
                Log::error('Groq API Error: ' . $response->body());
                return response()->json(['reply' => 'Hệ thống đang quá tải, vui lòng thử lại sau giây lát.']);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['reply' => 'Lỗi kết nối server.'], 500);
        }
    }

    private function getDatabaseContext($userMessage)
    {
        // Tách từ khóa để tìm kiếm
        $keywords = array_filter(explode(' ', $userMessage), function ($w) {
            return strlen($w) > 1; // Lấy từ có trên 1 ký tự
        });

        // Query sản phẩm
        $query = DB::table('products')
            ->join('product_variants', 'products.id', '=', 'product_variants.product_id')
            ->select(
                'products.id',
                'products.name',
                'products.product_code',
                // Lấy giá thấp nhất nếu có nhiều biến thể giá
                DB::raw('MIN(product_variants.sale) as min_sale'),
                DB::raw('MIN(product_variants.price) as min_price'),
                // Tổng tồn kho của tất cả các size/màu
                DB::raw('SUM(product_variants.quantity) as total_qty')
            )
            ->groupBy('products.id', 'products.name', 'products.product_code');

        // Logic tìm kiếm "OR": Chỉ cần tên chứa 1 trong các từ khóa
        if (!empty($keywords)) {
            $query->where(function ($q) use ($keywords) {
                foreach ($keywords as $word) {
                    $q->orWhere('products.name', 'LIKE', "%{$word}%");
                    $q->orWhere('products.product_code', 'LIKE', "%{$word}%");
                }
            });
        }

        // Tăng giới hạn lên 20 sản phẩm để liệt kê được nhiều hơn
        $products = $query->limit(20)->get();

        // Format dữ liệu gửi cho AI
        $productListString = $products->map(function ($p) {
            // TẠO ĐƯỜNG DẪN CHI TIẾT (Giả sử route xem chi tiết là /products/{id})
            // Bạn hãy đổi 'products.show' thành tên route thực tế trong web.php của bạn nếu khác
            // Hoặc dùng cứng: $url = url("/products/{$p->id}");
            $url = url("/products/{$p->id}");

            $sale = number_format($p->min_sale);
            $price = number_format($p->min_price);
            $discount = ($price - $sale);

            return "- Tên: {$p->name} | Giá từ: {$price} VND | Kho: {$p->total_qty} | Link: {$url}";
        })->implode("\n");

        if (empty($productListString)) {
            return "Không tìm thấy sản phẩm nào khớp với từ khóa trong câu hỏi.";
        }

        // Lấy thêm Voucher để chatbot tư vấn luôn
        $vouchers = DB::table('vouchers')
            ->where('status', 1)
            ->where('end_date', '>=', now())
            ->limit(3)
            ->get()
            ->map(function ($v) {
                return "- Voucher {$v->voucher_code}: {$v->description}";
            })->implode("\n");

        return "DANH SÁCH SẢN PHẨM TÌM THẤY:\n{$productListString}\n\nKHUYẾN MÃI HIỆN CÓ:\n{$vouchers}";
    }
}
