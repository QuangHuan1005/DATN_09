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
        $query = Product::query()->with([
            'category:id,name,slug',
            'variants.color',
            'variants.size',
            'photoAlbums',
            'variants',           // để lấy image, quantity
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
        if ($request->filled('category')) {
            $categoryId = (int) $request->category;

            // Lấy tất cả category con trực tiếp của category được chọn
            $childrenIds = Category::where('parent_id', $categoryId)->pluck('id')->toArray();

            // Gom lại: chính nó + các con
            $filterCategoryIds = array_merge([$categoryId], $childrenIds);

            $query->whereIn('category_id', $filterCategoryIds);
        }

        // ----- LỌC THEO MÀU -----
        if ($request->filled('color')) {
            $query->whereHas('variants', fn($q) => $q->where('color_id', $request->color));
        }

        // ----- LỌC THEO SIZE -----
        if ($request->filled('size')) {
            $query->whereHas('variants', fn($q) => $q->where('size_id', $request->size));
        }

        // ----- LỌC THEO GIÁ -----
        if ($request->filled('min_price')) {
            $query->whereHas('variants', fn($q) => $q->where('price', '>=', $request->min_price));
        }
        if ($request->filled('max_price')) {
            $query->whereHas('variants', fn($q) => $q->where('price', '<=', $request->max_price));
        }

        // ----- SẮP XẾP -----
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy(DB::raw('(SELECT MIN(price) FROM product_variants WHERE product_id = products.id)'), 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy(DB::raw('(SELECT MAX(price) FROM product_variants WHERE product_id = products.id)'), 'desc');
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

        // Dữ liệu cho filter
        $categories = Category::withCount('products')->get();
        $colors = Color::select('colors.*', DB::raw('COUNT(DISTINCT product_variants.product_id) as products_count'))
            ->leftJoin('product_variants', 'colors.id', '=', 'product_variants.color_id')
            ->groupBy('colors.id')
            ->get();
        $sizes = Size::select('sizes.*', DB::raw('COUNT(DISTINCT product_variants.product_id) as products_count'))
            ->leftJoin('product_variants', 'sizes.id', '=', 'product_variants.size_id')
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
        // Tính giá min / sale hiện tại
        $minPrice = $product->variants->min('price');
        $minSale  = $product->variants
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
            ->take(8)
            ->paginate(4);
        $canReview   = false;
        $hasReviewed = false;

        if (Auth::check()) {
            $userId = Auth::id();

            // 1) User này đã từng review sản phẩm này chưa? (qua order -> user)
            $hasReviewed = $product->reviews()
                ->whereHas('order', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                })
                ->exists();

            // 2) User này có ít nhất 1 đơn HỘI ĐỦ:
            //    - thuộc user hiện tại
            //    - trạng thái HOÀN THÀNH (ví dụ order_status_id = 5)
            //    - có chứa sản phẩm này (thông qua orderDetails())
            $completedOrderDetailsQuery = $product->orderDetails()
                ->whereHas('order', function ($q) use ($userId) {
                    $q->where('user_id', $userId)
                        ->where('order_status_id', 5); // 5 = Hoàn thành (sửa lại nếu hệ thống bạn khác)
                });

            $hasCompletedOrder = $completedOrderDetailsQuery->exists();

            $canReview = $hasCompletedOrder && ! $hasReviewed;
        }

        // Màu & size
        $colors = $product->variants
            ->pluck('color')
            ->filter()
            ->unique('id')
            ->values();

        $sizes  = $product->variants
            ->pluck('size')
            ->filter()
            ->unique('id')
            ->values();

        // ===== XỬ LÝ ẢNH HIỂN THỊ THEO THỨ TỰ: 
        // photo đầu -> ảnh biến thể -> photo còn lại =====

        $albumImages   = $product->photoAlbums->pluck('image')->filter()->values();
        $variantImages = $product->variants->pluck('image')->filter()->unique()->values();

        $images = [];

        // 1️⃣ Ảnh photoAlbums đầu tiên
        if ($albumImages->isNotEmpty()) {
            $images[] = $albumImages->first();
        }

        // 2️⃣ Toàn bộ ảnh biến thể (không trùng)
        foreach ($variantImages as $img) {
            if (!in_array($img, $images)) {
                $images[] = $img;
            }
        }

        // 3️⃣ Các ảnh photoAlbums còn lại
        foreach ($albumImages->slice(1) as $img) {
            if (!in_array($img, $images)) {
                $images[] = $img;
            }
        }

        $images = array_values($images); // reset index

        // dd($albumImages);
        // dd($images);
        // Map biến thể: key = color_id_size_id
        $variantMap = $product->variants
            ->mapWithKeys(function ($v) {
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
            ->where('category_id', $product->category_id) // cùng danh mục
            ->where('id', '!=', $product->id)             // loại trừ sản phẩm hiện tại
            ->take(8)                                     // giới hạn số lượng (tùy bạn chỉnh)
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
            'product',
            'displayPrice',
            'originalPrice',
            'discountPercent',
            'avgRating',
            'ratingCount',
            'reviews',
            'canReview',
            'hasReviewed',
            'colors',
            'sizes',
            'images',
            'variantMap',
            'relatedProducts',
            'variantCartQtyMap'

        ));
    }



    public function showByCategory($slug)
    {
        $categories = Category::all();
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = Product::where('category_id', $category->id)->paginate(12);
        return view('products.index', compact('category', 'products', 'categories', 'colors'));
    }
}
