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

        // 1. Phân tích và lấy dữ liệu
        $contextData = $this->getAdvancedDatabaseContext($userMessage);

        // 2. Prompt (CẬP NHẬT MỚI: Thêm quy tắc lọc nghiêm ngặt)
        // 2. Prompt (CẬP NHẬT: Bắt buộc hiển thị giá Sale)
        $systemPrompt = "Bạn là nhân viên tư vấn của shop thời trang 'Friday'.

        DỮ LIỆU SẢN PHẨM:
        {$contextData}

        QUY TẮC HIỂN THỊ (TUÂN THỦ NGHIÊM NGẶT):
        1. LỌC SIZE/MÀU: Nếu khách hỏi size/màu cụ thể, chỉ liệt kê sản phẩm có đúng size/màu đó trong dữ liệu. Nếu không khớp -> BỎ QUA.
        
        2. BẮT BUỘC VỀ GIÁ:
           - Mọi sản phẩm liệt kê ra ĐỀU PHẢI CÓ GIÁ.
           - Sử dụng giá trị 'GIÁ_BÁN' trong dữ liệu để hiển thị.
           - Tuyệt đối không được bỏ trống phần giá tiền.

        3. ĐỊNH DẠNG TRẢ LỜI:
           - [Tên Sản Phẩm](Link)
           - Giá: [Giá Bán] (Nếu có giá gốc thì mở ngoặc ghi thêm)
           - Thông tin: [Màu, Size...]

        Ví dụ mẫu:
        - [Áo Thun Teelab](...) 
          Giá: 150.000đ (Gốc: 200.000đ)
          Màu: Đen, Size: M, L";

        try {
            // ... (Phần gọi API giữ nguyên)
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('GROQ_API_KEY'),
                'Content-Type' => 'application/json',
            ])->post('https://api.groq.com/openai/v1/chat/completions', [
                        'model' => 'llama-3.3-70b-versatile',
                        'messages' => [
                            ['role' => 'system', 'content' => $systemPrompt],
                            ['role' => 'user', 'content' => $userMessage],
                        ],
                        'temperature' => 0.3,
                        'max_tokens' => 800,
                    ]);

            if ($response->successful()) {
                return response()->json(['reply' => $response->json()['choices'][0]['message']['content']]);
            } else {
                return response()->json(['reply' => 'Hệ thống đang bận, vui lòng thử lại sau.']);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['reply' => 'Lỗi kết nối.'], 500);
        }
    }
   private function getAdvancedDatabaseContext($message)
{
    $cleanMessage = mb_strtolower($message);

    // 1. Phân tích ý định (Intent)
    $onlySale = preg_match('/(sale|giảm giá|khuyến mãi|rẻ hơn)/i', $cleanMessage);

    // 2. Xử lý từ khóa thông minh (Stop Words)
    $stopWords = ['shop', 'có', 'sản', 'phẩm', 'nào', 'đang', 'không', 'tìm', 'giúp', 'cho', 'mình', 'với', 'là', 'của', 'giá', 'size', 'màu', 'loại'];
    $words = explode(' ', $cleanMessage);
    $keywords = array_filter($words, function($word) use ($stopWords) {
        return !in_array($word, $stopWords) && mb_strlen($word) > 1;
    });

    // 3. Truy vấn Database
    $query = DB::table('products')
        // Sử dụng Left Join để tránh mất sản phẩm nếu thiếu biến thể
        ->leftJoin('product_variants', 'products.id', '=', 'product_variants.product_id')
        ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
        ->leftJoin('colors', 'product_variants.color_id', '=', 'colors.id')
        ->leftJoin('sizes', 'product_variants.size_id', '=', 'sizes.id')
        ->whereNull('products.deleted_at')
        ->select(
            'products.id',
            'products.name',
            'categories.name as category_name',
            DB::raw('COALESCE(MIN(product_variants.price), 0) as min_price'),
            DB::raw('COALESCE(MIN(NULLIF(product_variants.sale, 0)), 0) as min_sale'),
            DB::raw('GROUP_CONCAT(DISTINCT colors.name SEPARATOR ", ") as colors_list'),
            DB::raw('GROUP_CONCAT(DISTINCT sizes.size_code SEPARATOR ", ") as sizes_list')
        )
        ->groupBy('products.id', 'products.name', 'categories.name');

    // Áp dụng bộ lọc Sale
    if ($onlySale) {
        $query->where('product_variants.sale', '>', 0);
    }

    // Áp dụng bộ lọc Từ khóa (Chỉ lọc nếu có từ khóa thực sự có nghĩa)
    if (!empty($keywords)) {
        $query->where(function ($q) use ($keywords) {
            foreach ($keywords as $word) {
                $q->orWhere('products.name', 'LIKE', "%{$word}%")
                  ->orWhere('categories.name', 'LIKE', "%{$word}%")
                  ->orWhere('colors.name', 'LIKE', "%{$word}%");
            }
        });
    }

    $products = $query->limit(10)->get(); // Lấy 10 sản phẩm tiêu biểu để không bị tràn Prompt

    // 4. Format dữ liệu
    if ($products->isEmpty()) {
        return "Hiện tại không có sản phẩm nào khớp chính xác. Shop có các mẫu mới về trong danh mục Thời trang Friday.";
    }

    return $products->map(function ($p) {
        $price_goc = intval($p->min_price);
        $price_sale = intval($p->min_sale);
        $final_price = ($price_sale > 0 && $price_sale < $price_goc) ? $price_sale : $price_goc;

        // Nếu dữ liệu giá lỗi, mặc định hiển thị giá gốc
        $display_price = $final_price > 0 ? number_format($final_price) : "Liên hệ";
        
        $link = url("/products/{$p->id}");
        $colors = $p->colors_list ?: "Liên hệ shop";
        $sizes = $p->sizes_list ?: "Liên hệ shop";

        return "SẢN_PHẨM: {$p->name}
        - LINK: {$link}
        - GIÁ_BÁN: {$display_price} VNĐ " . ($price_sale > 0 ? "(GIẢM GIÁ)" : "") . "
        - MÀU_SẮC: {$colors}
        - KÍCH_CỠ: {$sizes}
        ---";
    })->implode("\n");
}
}