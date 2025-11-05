<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Trang chủ
     */
    public function index()
    {
        // 1. Danh mục (ví dụ: danh mục mới / danh mục có SP)
        $categories = Category::query()
            ->whereNull('parent_id') // chỉ lấy danh mục cha
            ->withCount('products')  // đếm số sản phẩm trực tiếp trong từng danh mục
            ->latest('id')
            ->take(8)
            ->get();

        // 2. Sản phẩm mới (8 sản phẩm mới nhất)
        //    - kèm album ảnh và các biến thể màu/size để front-end render badge, giá,...
        $newProducts = Product::query()
            ->with([
                'photoAlbums',          // all ảnh -> carousel / hover
                'firstPhoto',           // ảnh đại diện -> card
                'variants.color',
                'variants.size',
            ])
            ->latest('id')
            ->take(8)
            ->get();

        // 3. Sản phẩm đang giảm giá
        //    Điều kiện: có ít nhất 1 variant có sale < price
        //    Với mỗi product -> eager load:
        //        - firstPhoto: ảnh đại diện
        //        - variants: sort theo giá thực tế (sale nếu có, ngược lại price)
        $saleProducts = Product::query()
            ->whereHas('variants', function ($q) {
                $q->whereNotNull('sale')
                  ->whereColumn('sale', '<', 'price');
            })
            ->with([
                'firstPhoto',
                'variants' => function ($q) {
                    // sắp xếp variant rẻ nhất lên đầu
                    $q->orderByRaw('IFNULL(sale, price) ASC');
                },
                'variants.color',
                'variants.size',
            ])
            ->take(4)
            ->get();

        // 4. Sản phẩm thịnh hành (trending) theo lượt xem
        $trending = Product::query()
            ->with([
                'photoAlbums',
                'firstPhoto',
                'variants',
            ])
            ->orderByDesc('view')
            ->take(8)
            ->get();

        // Gửi dữ liệu sang view
        return view('home.index', compact(
            'categories',
            'newProducts',
            'saleProducts',
            'trending'
        ));
    }

    /**
     * Trang chi tiết sản phẩm
     * $id = product_id
     */
    public function show($id)
    {
        // Lấy sản phẩm + category để breadcrumb / danh mục
        $product = Product::query()
            ->with('category')
            ->findOrFail($id);

        // Lấy tất cả biến thể của sản phẩm (mỗi biến thể là 1 combination màu + size)
        // Kèm color / size để front-end dựng dropdown/matrix
        $variants = $product->variants()
            ->with(['color', 'size'])
            ->get();

        // Lấy toàn bộ album ảnh để render gallery chi tiết
        $albums = $product->photoAlbums()
            ->orderBy('id')
            ->get();

        // Đánh giá (review) gần nhất trước
        $reviews = $product->reviews()
            ->with('user') // nếu muốn hiện avatar / tên người mua
            ->latest()
            ->get();

        // Các dữ liệu để build bộ lọc hiển thị cho user
        // (ví dụ: gợi ý "Chọn màu", "Chọn size")
        // Ta có thể load full list nếu cần cho UI:
        $categories = Category::all(); // có thể dùng cho sidebar "sản phẩm liên quan theo danh mục"
        // Nếu cần màu global, size global thì có thể lấy Color::all(), Size::all()
        // nhưng dựa vào ERD bạn cho ở trên thì Color/Sizes là bảng riêng.
        // Tôi sẽ không gọi Color::all() ở đây trừ khi UI thực sự cần list full màu.

        // Build variantMap để JS trên front-end tra cứu nhanh:
        // key dạng "colorId-sizeId"
        // value gồm id biến thể, giá, tồn kho
        $variantMap = [];
        foreach ($variants as $variant) {
            $key = $variant->color_id . '-' . $variant->size_id;

            $variantMap[$key] = [
                'id'    => $variant->id,
                // giá hiển thị: nếu có sale thì ưu tiên sale
                'price' => $variant->sale !== null && $variant->sale < $variant->price
                    ? $variant->sale
                    : $variant->price,
                'original_price' => $variant->price,
                'sale_price'     => $variant->sale,
                'stock' => $variant->stock ?? 0,
            ];
        }

        // Sản phẩm liên quan (ví dụ: cùng category, bỏ chính nó)
        $relatedProducts = Product::query()
            ->where('category_id', $product->category_id)
            ->where('id', '<>', $product->id)
            ->with([
                'firstPhoto',
                'variants' => function ($q) {
                    $q->orderByRaw('IFNULL(sale, price) ASC');
                },
            ])
            ->take(8)
            ->get();

        return view('products.show', compact(
            'product',
            'variants',
            'albums',
            'reviews',
            'categories',
            'variantMap',
            'relatedProducts'
        ));
    }
}
