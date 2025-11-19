<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query()->with([
            'category',
            'variants.color',
            'variants.size',
            'photoAlbums'
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

// public function index(Request $request)
// {
//     // Đọc tham số lọc từ query string
//     $categoryId = $request->integer('category');                  // 1 danh mục
//     $minPrice   = $request->integer('min_price');                 // số
//     $maxPrice   = $request->integer('max_price');                 // số
//     $colorIds   = array_filter((array) $request->input('colors'));// mảng id
//     $sizeIds    = array_filter((array) $request->input('sizes')); // mảng id

//     // Query sản phẩm + áp dụng bộ lọc
//     $products = Product::query()
//         ->with(['category', 'variants']) // tối ưu N+1
//         ->when($categoryId, fn($q) => $q->where('category_id', $categoryId))
//         ->when($minPrice || $maxPrice, function ($q) use ($minPrice, $maxPrice) {
//             $q->whereHas('variants', function ($v) use ($minPrice, $maxPrice) {
//                 if ($minPrice) $v->where('price', '>=', $minPrice);
//                 if ($maxPrice) $v->where('price', '<=', $maxPrice);
//             });
//         })
//         ->when(!empty($colorIds), fn($q) => $q->whereHas('variants', fn($v) => $v->whereIn('color_id', $colorIds)))
//         ->when(!empty($sizeIds),  fn($q) => $q->whereHas('variants', fn($v) => $v->whereIn('size_id',  $sizeIds)))
//         ->latest('id')
//         ->paginate(12)
//         ->appends($request->query()); // giữ nguyên tham số khi phân trang

//     // Dữ liệu cho sidebar
//     $categories = Category::query()
//         ->withCount(['products as products_count' => function ($q) {
//             // tuỳ cấu trúc, có thể where('status','published')...
//         }])->get();

//     $colors = Color::where('status', 1)->get();
//     $sizes  = Size::where('status', 1)->get();

//     // Build danh sách "active filters" để hiển thị/gỡ từng cái
//     $activeFilters = [];
//     if ($categoryId) {
//         $activeFilters[] = ['key' => 'category', 'label' => 'Danh mục: '.$categories->firstWhere('id',$categoryId)?->name, 'value' => $categoryId];
//     }
//     if ($minPrice) $activeFilters[] = ['key'=>'min_price','label'=>"Giá từ: {$minPrice}"];
//     if ($maxPrice) $activeFilters[] = ['key'=>'max_price','label'=>"Giá đến: {$maxPrice}"];
//     if ($colorIds) {
//         $labels = $colors->whereIn('id',$colorIds)->pluck('name')->implode(', ');
//         $activeFilters[] = ['key'=>'colors','label'=>"Màu: {$labels}", 'value'=>$colorIds];
//     }
//     if ($sizeIds) {
//         $labels = $sizes->whereIn('id',$sizeIds)->pluck('name')->implode(', ');
//         $activeFilters[] = ['key'=>'sizes','label'=>"Size: {$labels}", 'value'=>$sizeIds];
//     }

//     return view('products.index', compact(
//         'products','categories','colors','sizes','activeFilters'
//     ));
// }
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
    // Giữ nguyên: lấy sản phẩm + category
    $product = Product::with('category')->findOrFail($id);

    // Lấy biến thể + color + size (CHỈ LẤY BIẾN THỂ ĐANG HOẠT ĐỘNG - status = 1)
    $variants = $product->variants()
        ->where('status', 1)
        ->with(['color', 'size'])
        ->get();

    // Giữ nguyên: album ảnh, review, category, color
    $albums = $product->photoAlbums;
    $reviews = $product->reviews()->latest()->get();
    $categories = Category::all();
    $colors = Color::all();

    // Giữ nguyên: tạo variantMap (THÊM SALE)
    $variantMap = [];
    foreach ($variants as $variant) {
        $key = $variant->color_id . '-' . $variant->size_id;
        $variantMap[$key] = [
            'id'    => $variant->id,
            'price' => $variant->price,
            'sale'  => $variant->sale, // Thêm giá sale
            'stock' => (int) $variant->quantity,
            'image' => $variant->image, // Thêm ảnh biến thể
        ];
    }

    // 👉 THÊM MỚI: Lấy sản phẩm cùng danh mục (không đụng vào logic cũ)
    $relatedProducts = Product::with(['photoAlbums', 'variants'])
        ->where('category_id', $product->category_id) // cùng danh mục
        ->where('id', '!=', $product->id)             // loại trừ sản phẩm hiện tại
        ->take(8)                                     // giới hạn số lượng (tùy bạn chỉnh)
        ->get();

    // Giữ nguyên + truyền thêm relatedProducts xuống view
    return view('products.show', compact(
        'product',
        'variants',
        'albums',
        'reviews',
        'categories',
        'colors',
        'variantMap',
        'relatedProducts'
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
