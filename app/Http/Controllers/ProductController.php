<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Color;
use App\Models\Review;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Khởi tạo Query: CHỈ LẤY SẢN PHẨM CÒN HÀNG (có ít nhất 1 variant với quantity > 0)
        $query = Product::query()
            ->whereHas('variants', function($q) {
                $q->where('quantity', '>', 0);
            })
            ->with([
                'category:id,name,slug',
                'variants.color',
                'variants.size',
                'photoAlbums',
                'variants' => function($q) {
                    $q->where('quantity', '>', 0); // Chỉ lấy các biến thể còn hàng để hiển thị
                },
            ]);

        // ----- TÌM KIẾM THEO TÊN / MÔ TẢ -----
        if ($request->filled('keyword')) {
            $keyword = trim($request->keyword);
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'LIKE', "%{$keyword}%")
                    ->orWhere('description', 'LIKE', "%{$keyword}%");
            });
        }

        // ----- LỌC THEO DANH MỤC -----
        $filterCategoryIds = [];
        if ($request->filled('category')) {
            $categoryId = (int) $request->category;
            // Lấy tất cả category con trực tiếp của category được chọn
            $childrenIds = Category::where('parent_id', $categoryId)->pluck('id')->toArray();
            // Gom lại: chính nó + các con
            $filterCategoryIds = array_merge([$categoryId], $childrenIds);
            $query->whereIn('category_id', $filterCategoryIds);
        }

        // ----- LỌC THEO MÀU (Chỉ lọc trên các biến thể CÒN HÀNG) -----
        if ($request->filled('colors')) {
            $colorIds = (array) $request->colors;
            $query->whereHas('variants', function($q) use ($colorIds) {
                $q->whereIn('color_id', $colorIds)->where('quantity', '>', 0);
            });
        }

        // ----- LỌC THEO SIZE (Chỉ lọc trên các biến thể CÒN HÀNG) -----
        if ($request->filled('sizes')) {
            $sizeIds = (array) $request->sizes;
            $query->whereHas('variants', function($q) use ($sizeIds) {
                $q->whereIn('size_id', $sizeIds)->where('quantity', '>', 0);
            });
        }

        // ----- LỌC THEO GIÁ (Dựa trên giá của biến thể CÒN HÀNG) -----
        // ----- LỌC THEO GIÁ THỰC TẾ (Ưu tiên giá sale, tính trên biến thể còn hàng) -----
if ($request->filled('min_price') || $request->filled('max_price')) {
    $min = $request->input('min_price') ? (int)$request->min_price : 0;
    $max = $request->input('max_price') ? (int)$request->max_price : null;

    $query->whereHas('variants', function ($q) use ($min, $max) {
        $q->where('quantity', '>', 0)
          ->where(function ($sub) use ($min, $max) {
                // Logic: Nếu sale > 0 thì lấy sale, ngược lại lấy price
                $actualPriceSql = 'IF(sale > 0, sale, price)';
                
                $sub->whereRaw("$actualPriceSql >= ?", [$min]);

                if ($max !== null) {
                    $sub->whereRaw("$actualPriceSql <= ?", [$max]);
                }
          });
    });
}

        // ----- SẮP XẾP (Chỉ tính trên giá biến thể CÒN HÀNG) -----
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy(DB::raw('(SELECT MIN(IF(sale > 0, sale, price)) FROM product_variants WHERE product_id = products.id AND quantity > 0)'), 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy(DB::raw('(SELECT MAX(IF(sale > 0, sale, price)) FROM product_variants WHERE product_id = products.id AND quantity > 0)'), 'desc');
                    break;
                case 'bestseller':
                    $query->leftJoin('product_variants', 'products.id', '=', 'product_variants.product_id')
                        ->leftJoin('order_details', 'product_variants.id', '=', 'order_details.product_variant_id')
                        ->select('products.*', DB::raw('SUM(order_details.quantity) as total_sold'))
                        ->groupBy('products.id')
                        ->orderByDesc('total_sold');
                    break;
                default:
                    $query->latest('created_at');
            }
        } else {
            $query->latest('created_at');
        }

        $products = $query->paginate(12)->appends($request->query());

        // ----- DỮ LIỆU CHO FILTER SIDEBAR (CHỈ ĐẾM SẢN PHẨM CÒN HÀNG) -----
        
        // 1. Danh mục: Đếm SP còn hàng
        $categories = Category::withCount(['products' => function($q) {
            $q->whereHas('variants', fn($v) => $v->where('quantity', '>', 0));
        }])->get();

        // 2. Màu sắc: Đếm số SP còn hàng mang màu đó
        $colors = Color::select('colors.*', DB::raw('COUNT(DISTINCT product_variants.product_id) as products_count'))
            ->join('product_variants', 'colors.id', '=', 'product_variants.color_id')
            ->join('products', 'products.id', '=', 'product_variants.product_id')
            ->where('product_variants.quantity', '>', 0)
            ->when(!empty($filterCategoryIds), function($q) use ($filterCategoryIds) {
                return $q->whereIn('products.category_id', $filterCategoryIds);
            })
            ->groupBy('colors.id')
            ->get();

        // 3. Size: Đếm số SP còn hàng mang size đó
        $sizes = Size::select('sizes.*', DB::raw('COUNT(DISTINCT product_variants.product_id) as products_count'))
            ->join('product_variants', 'sizes.id', '=', 'product_variants.size_id')
            ->join('products', 'products.id', '=', 'product_variants.product_id')
            ->where('product_variants.quantity', '>', 0)
            ->when(!empty($filterCategoryIds), function($q) use ($filterCategoryIds) {
                return $q->whereIn('products.category_id', $filterCategoryIds);
            })
            ->groupBy('sizes.id')
            ->get();

        return view('products.index', compact('products', 'categories', 'colors', 'sizes'));
    }

    public function suggest(Request $request)
    {
        $keyword = $request->get('q', '');
        if (strlen($keyword) < 2) {
            return response()->json([]);
        }

        $results = Product::select('id', 'name', 'image')
            ->where('name', 'LIKE', "%{$keyword}%")
            ->whereHas('variants', fn($q) => $q->where('quantity', '>', 0)) // Chỉ gợi ý SP còn hàng
            ->limit(5)
            ->get();

        return response()->json($results);
    }

   public function show($id)
    {
        $product = Product::with([
            'category:id,name',
            'variants.color:id,name,color_code',
            'variants.size:id,name,size_code',
            'photoAlbums',
            'reviews',
        ])
            ->withSum('variants as total_stock', 'quantity')
            ->withSum('orderDetails as total_sold', 'quantity')
            ->findOrFail($id);

        $sessionKey = 'product_viewed_' . $id;
        if (!session()->has($sessionKey)) {
            $product->increment('view');
            session()->put($sessionKey, true);
        }

        // Tính giá min / sale hiện tại của các variant còn hàng
        $activeVariants = $product->variants->filter(fn($v) => $v->quantity > 0);
        
        $minPrice = $activeVariants->min('price');
        $minSale  = $activeVariants
            ->filter(fn($v) => $v->sale && $v->sale > 0)
            ->min('sale');

        $displayPrice    = $minSale ?: $minPrice;
        $originalPrice   = $minPrice;
        $discountPercent = null;

        if ($minSale && $minPrice && $minSale < $minPrice) {
            $discountPercent = round((($minPrice - $minSale) / $minPrice) * 100);
        }

        // Rating
        $avgRating    = round($product->reviews->avg('rating') ?? 0, 1);
        $ratingCount  = $product->reviews->count();

        // Top reviews
        $reviews = $product->reviews()
            ->with('order.user')
            ->where('status', 1)
            ->latest('id')
            ->paginate(4);

        $canReview   = false;
        $hasReviewed = false;

        if (Auth::check()) {
            $userId = Auth::id();
            $hasReviewed = $product->reviews()
                ->whereHas('order', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                })
                ->exists();

            $hasCompletedOrder = $product->orderDetails()
                ->whereHas('order', function ($q) use ($userId) {
                    $q->where('user_id', $userId)
                        ->where('order_status_id', 5); // 5 = Hoàn thành
                })
                ->exists();

            $canReview = $hasCompletedOrder && !$hasReviewed;
        }

        // Màu & size biến thể của sản phẩm này (Chỉ lấy những cái còn hàng)
        $colors = $activeVariants->pluck('color')->filter()->unique('id')->values();
        $sizes  = $activeVariants->pluck('size')->filter()->unique('id')->values();

        // --- BẮT ĐẦU PHẦN CẬP NHẬT: Xử lý ảnh Album theo màu ---
        // 1. Lấy ảnh từ Album (ảnh chung)
        $albumImages = $product->photoAlbums->pluck('image')->filter()->values();

        // 2. Lấy ảnh từ biến thể: QUAN TRỌNG - unique theo color_id để mỗi màu chỉ xuất hiện 1 ảnh đại diện
        $variantImages = $product->variants
            ->filter(fn($v) => !empty($v->image)) // Chỉ lấy variant có ảnh
            ->unique('color_id')                  // Loại bỏ các variant trùng màu (size khác nhau)
            ->pluck('image')
            ->filter()
            ->values();

        $images = [];
        // Ảnh đầu tiên của album làm ảnh đại diện chính (nếu có)
        if ($albumImages->isNotEmpty()) {
            $images[] = $albumImages->first();
        }

        // Thêm các ảnh đại diện của từng màu vào danh sách
        foreach ($variantImages as $img) {
            if (!in_array($img, $images)) { 
                $images[] = $img; 
            }
        }

        // Thêm các ảnh còn lại trong Album (trừ ảnh đầu đã lấy)
        foreach ($albumImages->slice(1) as $img) {
            if (!in_array($img, $images)) { 
                $images[] = $img; 
            }
        }
        $images = array_values($images);
        // --- KẾT THÚC PHẦN CẬP NHẬT ---

        // Map biến thể JS
        $variantMap = $product->variants->mapWithKeys(function ($v) {
            $key = $v->color_id . '_' . $v->size_id;
            return [
                $key => [
                    'id'       => $v->id,
                    'color_id' => $v->color_id,
                    'size_id'  => $v->size_id,
                    'price'    => $v->price,
                    'sale'     => $v->sale,
                    'stock'    => $v->quantity,
                    'image'    => $v->image,
                ],
            ];
        });

        $relatedProducts = Product::with(['photoAlbums', 'variants'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->whereHas('variants', fn($q) => $q->where('quantity', '>', 0)) // Liên quan cũng phải còn hàng
            ->take(8)
            ->get();

        $cart = Session::get('cart', []);
        $variantCartQtyMap = [];
        foreach ($cart as $row) {
            if (!empty($row['variant_id'])) {
                $vid = (int) $row['variant_id'];
                $variantCartQtyMap[$vid] = (int) ($row['quantity'] ?? 0);
            }
        }

        return view('products.show', compact(
            'product', 'displayPrice', 'originalPrice', 'discountPercent',
            'avgRating', 'ratingCount', 'reviews', 'canReview', 'hasReviewed',
            'colors', 'sizes', 'images', 'variantMap', 'relatedProducts', 'variantCartQtyMap'
        ));
    }

    public function showByCategory($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        return redirect()->route('products.index', ['category' => $category->id]);
    }
}