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

        // 2. Prompt được tinh chỉnh để xử lý dữ liệu chi tiết
        $systemPrompt = "Bạn là trợ lý ảo AI của shop thời trang 'Friday'.
        
        NHIỆM VỤ:
        - Trả lời khách hàng dựa trên [KẾT QUẢ TÌM KIẾM] bên dưới.
        - Nếu tìm thấy sản phẩm, BẮT BUỘC cung cấp Link xem chi tiết.
        
        QUY TẮC ĐỊNH DẠNG:
        - Luôn dùng định dạng Markdown cho link: [Tên Sản Phẩm](Đường_dẫn)
        - Ví dụ: [Áo Thun Teelab](http://localhost:8000/products/42) - Giá: 200k
        - Nếu có thông tin về màu sắc hoặc chất liệu trong dữ liệu, hãy nhắc đến để khách rõ.
        
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

    // --- HÀM XỬ LÝ LOGIC TÌM KIẾM NÂNG CAO ---
    private function getAdvancedDatabaseContext($message)
    {
        // 1. XỬ LÝ GIÁ (Price Parser)
        // Tìm các con số đi kèm chữ 'k' hoặc 'trăm', 'triệu' (ví dụ: 200k, 500000)
        $priceFilter = null;
        if (preg_match('/(\d+)[.,]?(\d+)?\s*(k|nghìn|vnd|đ|trăm|triệu)?/i', $message, $matches)) {
            // Logic đơn giản hóa: Lấy số đầu tiên tìm thấy làm mốc giá
            $number = intval(preg_replace('/[^0-9]/', '', $matches[0]));
            if ($number < 1000) $number *= 1000; // Hiểu 200 là 200.000
            
            // Nếu câu hỏi có từ "dưới", "nhỏ hơn"
            if (preg_match('/(dưới|nhỏ hơn|tầm|khoảng)/i', $message)) {
                $priceFilter = ['operator' => '<=', 'value' => $number];
            } 
            // Nếu câu hỏi có từ "trên", "hơn"
            elseif (preg_match('/(trên|hơn|lớn hơn)/i', $message)) {
                $priceFilter = ['operator' => '>=', 'value' => $number];
            }
        }

        // 2. TÁCH TỪ KHÓA (Keyword Extraction)
        // Loại bỏ các từ nối vô nghĩa để tìm kiếm chính xác hơn
        $stopWords = ['là', 'của', 'những', 'cái', 'chiếc', 'shop', 'có', 'không', 'với', 'tìm', 'cho', 'tôi', 'mình', 'em', 'anh', 'chị', 'xem'];
        $cleanMessage = str_replace($stopWords, '', mb_strtolower($message));
        $keywords = array_filter(explode(' ', $cleanMessage), function($w) {
            return mb_strlen($w) > 1; 
        });

        // 3. XÂY DỰNG QUERY
        $query = DB::table('products')
            ->join('product_variants', 'products.id', '=', 'product_variants.product_id')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id') // Join danh mục
            ->leftJoin('colors', 'product_variants.color_id', '=', 'colors.id')     // Join màu sắc
            ->select(
                'products.id',
                'products.name',
                'categories.name as category_name',
                'products.material',
                DB::raw('MIN(product_variants.price) as min_price'),
                DB::raw('GROUP_CONCAT(DISTINCT colors.name SEPARATOR ", ") as colors_list') // Gộp danh sách màu
            )
            ->groupBy('products.id', 'products.name', 'categories.name', 'products.material');

        // Áp dụng bộ lọc Giá (nếu có)
        if ($priceFilter) {
            $query->having('min_price', $priceFilter['operator'], $priceFilter['value']);
        }

        // Áp dụng bộ lọc Từ khóa đa năng (Tìm trong Tên, Danh mục, Màu, Mô tả)
        if (!empty($keywords)) {
            $query->where(function($q) use ($keywords) {
                foreach ($keywords as $word) {
                    $q->orWhere('products.name', 'LIKE', "%{$word}%");
                    $q->orWhere('products.description', 'LIKE', "%{$word}%"); // Tìm trong mô tả
                    $q->orWhere('categories.name', 'LIKE', "%{$word}%");      // Tìm trong danh mục (ví dụ: quần, áo)
                    $q->orWhere('colors.name', 'LIKE', "%{$word}%");          // Tìm trong màu (ví dụ: đỏ, xanh)
                    $q->orWhere('products.material', 'LIKE', "%{$word}%");    // Tìm trong chất liệu
                }
            });
        }

        // Lấy kết quả (Tăng giới hạn lên 15)
        $products = $query->limit(15)->get();

        // 4. FORMAT DỮ LIỆU TRẢ VỀ CHO AI
        $resultString = $products->map(function($p) {
            $url = url("/products/{$p->id}"); // Link sản phẩm
            $price = number_format($p->min_price);
            $colors = $p->colors_list ? "Màu: {$p->colors_list}" : "Nhiều màu";
            $cat = $p->category_name ?? 'Khác';
            $mat = $p->material ? "| Chất: {$p->material}" : "";

            return "- [{$cat}] {$p->name} | Giá: {$price} đ | {$colors} {$mat} | Link: {$url}";
        })->implode("\n");

        // Fallback: Nếu không tìm thấy gì (và không lọc giá), trả về hàng mới nhất
        if (empty($resultString) && !$priceFilter) {
            $newArrivals = DB::table('products')
                ->join('product_variants', 'products.id', '=', 'product_variants.product_id')
                ->select('products.id', 'products.name', DB::raw('MIN(product_variants.price) as price'))
                ->groupBy('products.id', 'products.name')
                ->orderBy('products.created_at', 'desc')
                ->limit(5)->get();
            
            $resultString = "Không tìm thấy sản phẩm chính xác theo yêu cầu. Gợi ý hàng mới về:\n" . 
                $newArrivals->map(fn($p) => "- {$p->name} (" . number_format($p->price) . "đ): " . url("/products/{$p->id}"))->implode("\n");
        } elseif (empty($resultString) && $priceFilter) {
            $resultString = "Không tìm thấy sản phẩm nào trong khoảng giá này.";
        }

        return $resultString;
    }
}