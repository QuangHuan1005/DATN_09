<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // ✅ Danh mục nổi bật
        $categories = Category::query()
            ->withCount('products')
            ->latest('id')
            ->take(8)
            ->get();

        // ✅ Hàng mới (có ảnh và biến thể)
        $newProducts = Product::query()
            ->with(['photoAlbums', 'variants.color', 'variants.size'])
            ->latest('id')
            ->take(8)
            ->get();

        // ✅ Sản phẩm đang giảm giá (có sale < price, lấy variant rẻ nhất, kèm ảnh đầu tiên)
        $saleProducts = Product::query()
            ->whereHas('variants', function ($q) {
                $q->whereNotNull('sale')
                  ->whereColumn('sale', '<', 'price');
            })
            ->with([
                'firstPhoto', // ✅ lấy ảnh đầu tiên trong bảng product_photo_albums
                'variants' => function ($q) {
                    $q->orderByRaw('IFNULL(sale, price) ASC'); // variant rẻ nhất lên đầu
                }
            ])
            ->take(4)
            ->get();

        // ✅ Sản phẩm thịnh hành theo lượt xem
        $trending = Product::query()
            ->with(['photoAlbums', 'variants'])
            ->orderByDesc('view')
            ->take(8)
            ->get();

        // 👉 Gửi dữ liệu về view
        return view('home.index', compact(
            'categories',
            'newProducts',
            'saleProducts',
            'trending'
        ));
    }
}
