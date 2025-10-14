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
        $categories = Category::all();
        // 1. Sản phẩm mới nhất
        $newProducts = Product::with('category')
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        // 2. Sản phẩm nổi bật (có thể là onpage = 1 )
        $featuredProducts = Product::with('category')
            ->where('onpage', 1)
            ->orderBy('updated_at', 'desc')
            ->take(8)
            ->get();

        // 3. Sản phẩm bán chạy nhất (tính theo tổng số lượng trong order_details)
        // $bestSellingProducts = Product::select('products.*', DB::raw('SUM(order_details.quantity) as total_sold'))
        //     ->join('product_variants', 'products.id', '=', 'product_variants.product_id')
        //     ->join('order_details', 'product_variants.id', '=', 'order_details.product_variant_id')
        //     ->groupBy('products.id')
        //     ->orderByDesc('total_sold')
        //     ->take(8)
        //     ->get();

        return view('home.index', compact('newProducts', 'featuredProducts', 'categories'));
    }
        


        
}
