<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Category;

/**
 * Friday Chatbot Controller với tích hợp Database
 * 
 * Controller xử lý chatbot với khả năng:
 * - Tư vấn sản phẩm từ database
 * - Tìm kiếm sản phẩm theo tên, giá, danh mục
 * - Gợi ý sản phẩm phù hợp
 * - Kiểm tra tồn kho, giá bán, khuyến mãi
 */
class ChatbotController extends Controller
{
    // Groq API Configuration
    private $groqApiKey;
    private $groqApiUrl = 'https://api.groq.com/openai/v1/chat/completions';
    private $model = 'llama-3.3-70b-versatile';

    public function __construct()
    {
        $this->groqApiKey = env('GROQ_API_KEY');
    }

    /**
     * Main chatbot endpoint
     */
    public function ask(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500'
        ]);

        $userMessage = $request->input('message');

        try {
            // 1. Phân tích ý định người dùng (Intent Detection)
            $intent = $this->detectIntent($userMessage);

            // 2. Tìm kiếm sản phẩm liên quan (nếu cần)
            $products = $this->searchProducts($userMessage, $intent);

            // 3. Lấy thông tin chi tiết sản phẩm
            $productContext = $this->buildProductContext($products);

            // 4. Gọi AI để tạo response
            $aiResponse = $this->generateAIResponse($userMessage, $productContext, $intent);

            // 5. Tạo product links cho frontend
            $productLinks = $this->buildProductLinks($products);

            return response()->json([
                'success' => true,
                'message' => $aiResponse,
                'product_links' => $productLinks,
                'products_found' => count($products)
            ]);
        } catch (\Exception $e) {
            Log::error('Chatbot Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Xin lỗi, tôi đang gặp sự cố kỹ thuật. Vui lòng thử lại sau.',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Phát hiện ý định người dùng
     */
    private function detectIntent($message)
    {
        $message = mb_strtolower($message);

        // Intent patterns
        $intents = [
            'search_product' => [
                'keywords' => ['tìm', 'có', 'bán', 'xem', 'cho tôi', 'mua', 'sản phẩm'],
                'priority' => 1
            ],
            'check_price' => [
                'keywords' => ['giá', 'bao nhiêu', 'giá cả', 'chi phí', 'tiền'],
                'priority' => 2
            ],
            'check_stock' => [
                'keywords' => ['còn hàng', 'tồn kho', 'còn không', 'hết hàng', 'số lượng'],
                'priority' => 3
            ],
            'ask_discount' => [
                'keywords' => ['giảm giá', 'khuyến mãi', 'sale', 'ưu đãi', 'giảm'],
                'priority' => 4
            ],
            'ask_category' => [
                'keywords' => ['danh mục', 'loại', 'phân loại', 'category'],
                'priority' => 5
            ],
            'recommend' => [
                'keywords' => ['gợi ý', 'tư vấn', 'nên mua', 'recommend', 'phù hợp'],
                'priority' => 6
            ],
            'shipping_policy' => [
                'keywords' => ['vận chuyển', 'giao hàng', 'ship', 'phí ship'],
                'priority' => 7
            ],
            'return_policy' => [
                'keywords' => ['đổi trả', 'hoàn', 'return', 'đổi hàng'],
                'priority' => 8
            ],
            'general' => [
                'keywords' => ['xin chào', 'hello', 'hi', 'chào', 'hỗ trợ'],
                'priority' => 9
            ]
        ];

        // Detect intent based on keywords
        $detectedIntents = [];
        foreach ($intents as $intent => $data) {
            foreach ($data['keywords'] as $keyword) {
                if (strpos($message, $keyword) !== false) {
                    $detectedIntents[$intent] = $data['priority'];
                    break;
                }
            }
        }

        // Return highest priority intent
        if (!empty($detectedIntents)) {
            asort($detectedIntents);
            return array_key_first($detectedIntents);
        }

        return 'general';
    }

    /**
     * Tìm kiếm sản phẩm trong database
     */
    private function searchProducts($message, $intent)
    {
        // Nếu không phải intent liên quan sản phẩm, return empty
        $productIntents = ['search_product', 'check_price', 'check_stock', 'ask_discount', 'recommend'];
        if (!in_array($intent, $productIntents)) {
            return [];
        }

        // Extract keywords
        $keywords = $this->extractKeywords($message);

        // Build query
        $query = Product::with(['productVariants' => function ($q) {
            $q->where('status', 1)
                ->where('quantity', '>', 0)
                ->orderBy('price', 'asc');
        }, 'category'])
            ->where('onpage', 1)
            ->whereNull('deleted_at');

        // Search by keywords
        if (!empty($keywords)) {
            $query->where(function ($q) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $q->orWhere('name', 'LIKE', "%{$keyword}%")
                        ->orWhere('description', 'LIKE', "%{$keyword}%");
                }
            });
        }

        // Filter by price range if mentioned
        $priceRange = $this->extractPriceRange($message);
        if ($priceRange) {
            $query->whereHas('productVariants', function ($q) use ($priceRange) {
                $q->whereBetween('price', [$priceRange['min'], $priceRange['max']]);
            });
        }

        // Limit results
        $products = $query->take(5)->get();

        // If no specific products found, return trending/popular products
        if ($products->isEmpty() && in_array($intent, ['recommend', 'general'])) {
            $products = Product::with(['productVariants' => function ($q) {
                $q->where('status', 1)
                    ->where('quantity', '>', 0)
                    ->orderBy('sale', 'desc');
            }])
                ->where('onpage', 1)
                ->whereNull('deleted_at')
                ->orderBy('view', 'desc')
                ->take(5)
                ->get();
        }

        return $products;
    }

    /**
     * Extract keywords từ message
     */
    private function extractKeywords($message)
    {
        // Common Vietnamese stop words
        $stopWords = ['tôi', 'muốn', 'cần', 'mua', 'xem', 'cho', 'với', 'của', 'là', 'có', 'không', 'được', 'và', 'hoặc'];

        // Split message
        $words = preg_split('/\s+/', mb_strtolower($message));

        // Remove stop words and short words
        $keywords = array_filter($words, function ($word) use ($stopWords) {
            return !in_array($word, $stopWords) && mb_strlen($word) > 2;
        });

        return array_values($keywords);
    }

    /**
     * Extract price range từ message
     */
    private function extractPriceRange($message)
    {
        // Patterns: "dưới 500k", "từ 100k đến 200k", "khoảng 300k"

        // Pattern 1: "dưới X"
        if (preg_match('/dưới\s+(\d+)k?/i', $message, $matches)) {
            return ['min' => 0, 'max' => (int)$matches[1] * 1000];
        }

        // Pattern 2: "từ X đến Y"
        if (preg_match('/từ\s+(\d+)k?\s+đến\s+(\d+)k?/i', $message, $matches)) {
            return ['min' => (int)$matches[1] * 1000, 'max' => (int)$matches[2] * 1000];
        }

        // Pattern 3: "khoảng X"
        if (preg_match('/khoảng\s+(\d+)k?/i', $message, $matches)) {
            $price = (int)$matches[1] * 1000;
            return ['min' => $price * 0.8, 'max' => $price * 1.2];
        }

        return null;
    }

    /**
     * Build product context cho AI
     */
    private function buildProductContext($products)
    {
        if ($products->isEmpty()) {
            return "Không tìm thấy sản phẩm phù hợp trong kho.";
        }

        $context = "Sản phẩm có sẵn:\n\n";

        foreach ($products as $product) {
            $context .= "- **{$product->name}**\n";
            $context .= "  Mã: {$product->product_code}\n";
            $context .= "  Danh mục: {$product->category->name}\n";
            $context .= "  Chất liệu: {$product->material}\n";

            // Product variants info
            if ($product->productVariants->isNotEmpty()) {
                $variant = $product->productVariants->first();
                $context .= "  Giá: " . number_format($variant->price, 0, ',', '.') . "đ\n";

                if ($variant->sale) {
                    $context .= "  Giá sale: " . number_format($variant->sale, 0, ',', '.') . "đ\n";
                    $discount = round((($variant->price - $variant->sale) / $variant->price) * 100);
                    $context .= "  Giảm: {$discount}%\n";
                }

                $context .= "  Còn hàng: {$variant->quantity} sản phẩm\n";
            }

            $context .= "  Lượt xem: {$product->view}\n";
            $context .= "\n";
        }

        return $context;
    }

    /**
     * Generate AI response bằng Groq API
     */
    private function generateAIResponse($userMessage, $productContext, $intent)
    {
        $systemPrompt = $this->buildSystemPrompt($intent);

        $response = Http::timeout(30)
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->groqApiKey
            ])
            ->post($this->groqApiUrl, [
                'model' => $this->model,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $systemPrompt
                    ],
                    [
                        'role' => 'user',
                        'content' => "Context sản phẩm:\n{$productContext}\n\nCâu hỏi: {$userMessage}"
                    ]
                ],
                'temperature' => 0.7,
                'max_tokens' => 500
            ]);

        if (!$response->successful()) {
            throw new \Exception('Groq API error: ' . $response->body());
        }

        $data = $response->json();
        return $data['choices'][0]['message']['content'] ?? 'Xin lỗi, tôi không thể trả lời lúc này.';
    }

    /**
     * Build system prompt dựa trên intent
     */
    private function buildSystemPrompt($intent)
    {
        $basePrompt = "Bạn là trợ lý AI thông minh của Friday - thương hiệu thời trang urban hiện đại.

THÔNG TIN CỬA HÀNG:
- Chuyên: Thời trang nam, nữ, phụ kiện
- Miễn phí vận chuyển: Đơn hàng từ 300.000đ
- Chính sách đổi trả: 30 ngày
- Thanh toán: COD, VNPay, MoMo

";

        $intentPrompts = [
            'search_product' => "Nhiệm vụ: Giới thiệu sản phẩm có trong danh sách. Đề cập TÊN CHÍNH XÁC của từng sản phẩm.",
            'check_price' => "Nhiệm vụ: Cung cấp thông tin giá cả chi tiết, bao gồm cả giá sale nếu có.",
            'check_stock' => "Nhiệm vụ: Thông báo tình trạng còn hàng và số lượng tồn kho.",
            'ask_discount' => "Nhiệm vụ: Giới thiệu các sản phẩm đang giảm giá, nhấn mạnh % giảm.",
            'recommend' => "Nhiệm vụ: Tư vấn sản phẩm phù hợp dựa trên nhu cầu khách hàng.",
            'shipping_policy' => "Nhiệm vụ: Giải thích chính sách vận chuyển. Miễn phí ship cho đơn từ 300k.",
            'return_policy' => "Nhiệm vụ: Giải thích chính sách đổi trả 30 ngày.",
            'general' => "Nhiệm vụ: Chào hỏi và hỗ trợ khách hàng một cách thân thiện."
        ];

        $specificPrompt = $intentPrompts[$intent] ?? $intentPrompts['general'];

        return $basePrompt . $specificPrompt . "

CÁCH TRẢ LỜI:
- Thân thiện, chuyên nghiệp
- Ngắn gọn (2-3 câu chính)
- Sử dụng emoji tinh tế
- NHỚ ĐỀ CẬP TÊN SẢN PHẨM CHÍNH XÁC để frontend có thể chèn ảnh
- Format: Giới thiệu ngắn, sau đó liệt kê sản phẩm với tên cụ thể

VÍ DỤ TỐT:
'Chúng tôi có một số sản phẩm phù hợp với bạn! 

Áo sơ mi nam là lựa chọn hoàn hảo cho công sở với giá chỉ 200.000đ.

Áo polo nam cao cấp cũng rất được ưa chuộng với giá 200.000đ.

Bạn muốn xem thêm thông tin sản phẩm nào không? 😊'";
    }

    /**
     * Build product links cho frontend
     */
    private function buildProductLinks($products)
    {
        $links = [];

        foreach ($products as $product) {
            $variant = $product->productVariants->first();

            if ($variant) {
                $links[$product->name] = [
                    'name' => $product->name,
                    'product_url' => url("/product/{$product->id}"),
                    'image_url' => $variant->image
                        ? asset('storage/' . $variant->image)
                        : asset('images/no-image.png'),
                    'price' => $variant->price,
                    'sale' => $variant->sale,
                    'quantity' => $variant->quantity
                ];
            }
        }

        return $links;
    }

    /**
     * Get popular products (API endpoint)
     */
    public function getPopularProducts()
    {
        $products = Product::with(['productVariants' => function ($q) {
            $q->where('status', 1)
                ->where('quantity', '>', 0)
                ->orderBy('sale', 'desc');
        }])
            ->where('onpage', 1)
            ->whereNull('deleted_at')
            ->orderBy('view', 'desc')
            ->take(10)
            ->get();

        return response()->json([
            'success' => true,
            'products' => $products->map(function ($product) {
                $variant = $product->productVariants->first();
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'code' => $product->product_code,
                    'price' => $variant ? $variant->price : 0,
                    'sale' => $variant ? $variant->sale : null,
                    'image' => $variant && $variant->image
                        ? asset('storage/' . $variant->image)
                        : asset('images/no-image.png'),
                    'url' => url("/product/{$product->id}")
                ];
            })
        ]);
    }

    /**
     * Search products by category (API endpoint)
     */
    public function searchByCategory($categorySlug)
    {
        $category = Category::where('slug', $categorySlug)->first();

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy danh mục'
            ], 404);
        }

        $products = Product::with(['productVariants'])
            ->where('category_id', $category->id)
            ->where('onpage', 1)
            ->whereNull('deleted_at')
            ->get();

        return response()->json([
            'success' => true,
            'category' => $category->name,
            'products' => $products
        ]);
    }

    /**
     * Get all categories (API endpoint)
     */
    public function getCategories()
    {
        $categories = Category::whereNull('deleted_at')
            ->withCount(['products' => function ($q) {
                $q->where('onpage', 1);
            }])
            ->get();

        return response()->json([
            'success' => true,
            'categories' => $categories
        ]);
    }
}
