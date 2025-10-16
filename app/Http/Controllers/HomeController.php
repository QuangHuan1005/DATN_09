<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {

        // Danh mục nổi bật
        $categories = Category::query()
            ->withCount('products')
            ->latest('id')
            ->take(8)
            ->get();

        // Hàng mới
        $newProducts = Product::query()
            ->with(['photoAlbums', 'variants.color', 'variants.size'])
            ->latest('id')
            ->take(8)
            ->get();

        // Đang giảm giá: có variant sale < price
        $saleProducts = Product::query()
            ->whereHas('variants', function ($q) {
                $q->whereNotNull('sale')->whereColumn('sale', '<', 'price');
            })
            ->with(['photoAlbums', 'variants' => function ($q) {
                $q->orderByRaw('IFNULL(sale, price) asc');
            }])
            ->take(4)
            ->get();


        // Bán chạy: tính theo order_details.quantity, lọc đơn "Hoàn thành" 
        // $bestSellers = Product::query()
        //     ->select('products.*', DB::raw('SUM(order_details.quantity) as total_sold'))
        //     ->join('product_variants', 'product_variants.product_id', '=', 'products.id')
        //     ->join('order_details', 'order_details.product_variant_id', '=', 'product_variants.id')
        //     ->join('orders', 'orders.id', '=', 'order_details.order_id')
        //     ->join('order_statuses', 'order_statuses.id', '=', 'orders.order_status_id')
        //     ->where('order_statuses.name', 'Hoàn thành')
        //     ->groupBy('products.id')
        //     ->orderByDesc('total_sold')
        //     ->with(['photoAlbums', 'variants'])
        //     ->take(12)
        //     ->get();

        // Thịnh hành: theo lượt xem
        $trending = Product::query()
            ->with(['photoAlbums', 'variants'])
            ->orderByDesc('view')
            ->take(8)
            ->get();

        return view('home.index', compact(
            'categories',
            'newProducts',
            'saleProducts',
            'trending'
        ));
    }
}
