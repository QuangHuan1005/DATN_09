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

        // 1. CÁC BỘ LỌC (GIỮ NGUYÊN)
        $onlySale = preg_match('/(sale|giảm giá|khuyến mãi)/i', $cleanMessage);

        $priceFilter = null;
        if (preg_match('/từ\s*(\d+).*đến\s*(\d+)/i', $cleanMessage, $matches)) {
            $min = intval($matches[1]) * ($matches[1] < 1000 ? 1000 : 1);
            $max = intval($matches[2]) * ($matches[2] < 1000 ? 1000 : 1);
            $priceFilter = ['operator' => 'BETWEEN', 'from' => $min, 'to' => $max];
        } elseif (preg_match('/(\d+)[.,]?(\d+)?\s*(k|nghìn|đ)/i', $cleanMessage, $matches)) {
            $number = intval(preg_replace('/[^0-9]/', '', $matches[0])) * ($matches[1] < 1000 ? 1000 : 1);
            if (preg_match('/(dưới|rẻ hơn)/i', $cleanMessage))
                $priceFilter = ['operator' => '<=', 'value' => $number];
            elseif (preg_match('/(trên|đắt hơn)/i', $cleanMessage))
                $priceFilter = ['operator' => '>=', 'value' => $number];
        }

        $keywords = array_filter(explode(' ', str_replace(['là', 'của', 'tìm', 'giá', 'size', 'màu'], '', $cleanMessage)));

        // 2. TRUY VẤN DATABASE (CẬP NHẬT: XỬ LÝ NULL NGAY TRONG SQL)
        $query = DB::table('products')
            ->join('product_variants', 'products.id', '=', 'product_variants.product_id')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('colors', 'product_variants.color_id', '=', 'colors.id')
            ->leftJoin('sizes', 'product_variants.size_id', '=', 'sizes.id') // Đảm bảo bảng sizes tồn tại
            ->whereNull('products.deleted_at')
            ->select(
                'products.id',
                'products.name',
                'categories.name as category_name',
                'products.material',
                // [FIX QUAN TRỌNG] Dùng COALESCE để không bao giờ bị NULL
                DB::raw('COALESCE(MIN(product_variants.price), 0) as min_price'),
                DB::raw('COALESCE(MIN(NULLIF(product_variants.sale, 0)), 0) as min_sale'),
                DB::raw('GROUP_CONCAT(DISTINCT colors.name SEPARATOR ", ") as colors_list'),
                DB::raw('GROUP_CONCAT(DISTINCT sizes.size_code SEPARATOR ", ") as sizes_list')
            )
            ->groupBy('products.id', 'products.name', 'categories.name', 'products.material');

        // ÁP DỤNG BỘ LỌC
        if ($onlySale)
            $query->where('product_variants.sale', '>', 0);

        if (!empty($keywords)) {
            foreach ($keywords as $word) {
                $query->where(function ($q) use ($word) {
                    $q->orWhere('products.name', 'LIKE', "%{$word}%")
                        ->orWhere('categories.name', 'LIKE', "%{$word}%")
                        ->orWhere('colors.name', 'LIKE', "%{$word}%")
                        ->orWhere('sizes.size_code', 'LIKE', "{$word}");
                });
            }
        }

        if ($priceFilter) {
            $sqlPrice = 'COALESCE(MIN(NULLIF(product_variants.sale, 0)), MIN(product_variants.price))';
            if ($priceFilter['operator'] === 'BETWEEN') {
                $query->havingRaw("$sqlPrice >= ? AND $sqlPrice <= ?", [$priceFilter['from'], $priceFilter['to']]);
            } else {
                $query->havingRaw("$sqlPrice {$priceFilter['operator']} ?", [$priceFilter['value']]);
            }
        }

        $products = $query->limit(100)->get();

        // 3. FORMAT DỮ LIỆU (CỰC KỲ CHI TIẾT ĐỂ AI KHÔNG BỊ MÙ)
        $resultString = $products->map(function ($p) {
            // Tính toán giá bằng PHP cho chắc chắn
            $price_goc = intval($p->min_price);
            $price_sale = intval($p->min_sale);

            // Logic chọn giá hiển thị
            $final_price = ($price_sale > 0 && $price_sale < $price_goc) ? $price_sale : $price_goc;

            // Nếu giá = 0 (Lỗi dữ liệu) -> Bỏ qua hoặc ghi "Liên hệ"
            if ($final_price <= 0)
                return null;

            $price_text = number_format($final_price) . " VNĐ";
            $note_sale = ($price_sale > 0 && $price_sale < $price_goc) ? "(ĐANG GIẢM - Gốc: " . number_format($price_goc) . "đ)" : "";

            $colors = $p->colors_list ?: "Đủ màu";
            $sizes = $p->sizes_list ?: "Đủ size"; // Fallback nếu null
            $link = url("/products/{$p->id}");

            // Chuỗi text gửi cho AI (Dùng định dạng Key: Value rõ ràng)
            return "SẢN_PHẨM: {$p->name}
            - LINK: {$link}
            - GIÁ_BÁN: {$price_text} {$note_sale}
            - MÀU_SẮC: {$colors}
            - KÍCH_CỠ: {$sizes}
            ---";
        })->filter()->unique()->implode("\n"); // filter() loại bỏ null, unique() bỏ trùng

        return empty($resultString) ? "Không tìm thấy sản phẩm phù hợp." : $resultString;
    }
}
