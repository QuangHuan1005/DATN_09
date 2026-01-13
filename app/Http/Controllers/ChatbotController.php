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

        // 1. Phân tích và lấy dữ liệu đa chiều
        $contextData = $this->getAdvancedDatabaseContext($userMessage);

        // 2. Prompt (Không thay đổi nhiều, chỉ cập nhật hướng dẫn về giá)
        $systemPrompt = "Bạn là trợ lý ảo AI của shop thời trang 'Friday'.
        
        NHIỆM VỤ:
        - Trả lời khách hàng dựa trên [KẾT QUẢ TÌM KIẾM] bên dưới.
        - Nếu tìm thấy sản phẩm, BẮT BUỘC cung cấp Link xem chi tiết.
        
        QUY TẮC ĐỊNH DẠNG:
        - Luôn dùng định dạng Markdown cho link: [Tên Sản Phẩm](Đường_dẫn)
        - Ưu tiên nhắc đến giá Sale nếu có.
        - Ví dụ: [Áo Thun Teelab](http://localhost:8000/products/42) - Đang giảm còn 150k (Gốc 200k)
        
        [KẾT QUẢ TÌM KIẾM TỪ KHO DỮ LIỆU]:
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

    // --- HÀM XỬ LÝ LOGIC TÌM KIẾM NÂNG CAO (ĐÃ NÂNG CẤP) ---
    private function getAdvancedDatabaseContext($message)
    {
        // 1. XỬ LÝ GIÁ (Price Parser)
        $priceFilter = null;
        if (preg_match('/(\d+)[.,]?(\d+)?\s*(k|nghìn|vnd|đ|trăm|triệu)?/i', $message, $matches)) {
            $number = intval(preg_replace('/[^0-9]/', '', $matches[0]));
            if ($number < 1000) $number *= 1000;

            if (preg_match('/(dưới|nhỏ hơn|tầm|khoảng|rẻ hơn)/i', $message)) {
                $priceFilter = ['operator' => '<=', 'value' => $number];
            } elseif (preg_match('/(trên|hơn|lớn hơn|đắt hơn)/i', $message)) {
                $priceFilter = ['operator' => '>=', 'value' => $number];
            }
        }

        // 2. TÁCH TỪ KHÓA
        $stopWords = ['là', 'của', 'những', 'cái', 'chiếc', 'shop', 'có', 'không', 'với', 'tìm', 'cho', 'tôi', 'mình', 'em', 'anh', 'chị', 'xem', 'giá', 'bao', 'nhiêu'];
        $cleanMessage = str_replace($stopWords, '', mb_strtolower($message));
        $keywords = array_filter(explode(' ', $cleanMessage), function ($w) {
            return mb_strlen($w) > 1;
        });

        // 3. XÂY DỰNG QUERY
        $query = DB::table('products')
            ->join('product_variants', 'products.id', '=', 'product_variants.product_id')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('colors', 'product_variants.color_id', '=', 'colors.id')
            // [NÂNG CẤP 1] Chỉ lấy sản phẩm chưa bị xóa (Soft Delete)
            ->whereNull('products.deleted_at')
            ->select(
                'products.id',
                'products.name',
                'categories.name as category_name',
                'products.material',
                // [NÂNG CẤP 2] Lấy cả giá gốc và giá Sale (chỉ lấy giá sale > 0)
                DB::raw('MIN(product_variants.price) as min_price'),
                DB::raw('MIN(NULLIF(product_variants.sale, 0)) as min_sale'),
                DB::raw('GROUP_CONCAT(DISTINCT colors.name SEPARATOR ", ") as colors_list')
            )
            ->groupBy('products.id', 'products.name', 'categories.name', 'products.material');

        // [NÂNG CẤP 3] Logic tìm kiếm chặt chẽ hơn (AND Logic)
        // Ví dụ: "Áo đỏ" -> Sản phẩm phải thỏa mãn (có chữ "Áo") VÀ (có chữ "đỏ")
        // Logic cũ là HOẶC (có "Áo" là lấy, hoặc có "đỏ" là lấy -> dẫn đến kết quả rác)
        if (!empty($keywords)) {
            foreach ($keywords as $word) {
                $query->where(function ($subQuery) use ($word) {
                    $subQuery->orWhere('products.name', 'LIKE', "%{$word}%")
                        ->orWhere('products.description', 'LIKE', "%{$word}%")
                        ->orWhere('categories.name', 'LIKE', "%{$word}%")
                        ->orWhere('colors.name', 'LIKE', "%{$word}%")
                        ->orWhere('products.material', 'LIKE', "%{$word}%");
                });
            }
        }

        // [NÂNG CẤP 4] Lọc giá thông minh (Dựa trên giá thực tế khách phải trả)
        // Nếu có giá sale thì so sánh giá sale, không thì so sánh giá gốc
        if ($priceFilter) {
            // Logic SQL: COALESCE(min_sale, min_price) nghĩa là ưu tiên lấy min_sale, nếu null thì lấy min_price
            $query->havingRaw('COALESCE(MIN(NULLIF(product_variants.sale, 0)), MIN(product_variants.price)) ' . $priceFilter['operator'] . ' ?', [$priceFilter['value']]);
        }

        $products = $query->limit(100)->get();

        // 4. FORMAT DỮ LIỆU
        $resultString = $products->map(function ($p) {
            $url = url("/products/{$p->id}");

            // Xử lý hiển thị Giá Sale
            $priceInfo = "";
            $originalPrice = $p->min_price;
            $salePrice = $p->min_sale;

            // Nếu có giá sale và giá sale nhỏ hơn giá gốc
            if ($salePrice > 0 && $salePrice < $originalPrice) {
                $discountAmount = $originalPrice - $salePrice;
                // Format: Giảm 50k - Còn 150,000đ (Gốc: 200,000đ)
                $priceInfo = "Đang giảm " . number_format($discountAmount / 1000) . "k | Giá chỉ: " . number_format($salePrice) . "đ (Gốc: " . number_format($originalPrice) . "đ)";
            } else {
                $priceInfo = "Giá: " . number_format($originalPrice) . "đ";
            }

            $colors = $p->colors_list ? "Màu: {$p->colors_list}" : "Nhiều màu";
            $cat = $p->category_name ?? 'Khác';
            $mat = $p->material ? "| Chất: {$p->material}" : "";

            return "- [{$cat}] {$p->name} | {$priceInfo} | {$colors} {$mat} | Link: {$url}";
        })->implode("\n");

        // Fallback
        if (empty($resultString) && !$priceFilter) {
            $newArrivals = DB::table('products')
                ->join('product_variants', 'products.id', '=', 'product_variants.product_id')
                ->whereNull('products.deleted_at') // Nhớ thêm check deleted_at ở fallback
                ->select('products.id', 'products.name', DB::raw('MIN(product_variants.price) as price'))
                ->groupBy('products.id', 'products.name')
                ->orderBy('products.created_at', 'desc')
                ->limit(5)->get();

            $resultString = "Không tìm thấy sản phẩm chính xác. Gợi ý hàng mới về:\n" .
                $newArrivals->map(fn($p) => "- {$p->name} (" . number_format($p->price) . "đ): " . url("/products/{$p->id}"))->implode("\n");
        } elseif (empty($resultString) && $priceFilter) {
            $resultString = "Không tìm thấy sản phẩm nào trong khoảng giá này.";
        }

        return $resultString;
    }
}
