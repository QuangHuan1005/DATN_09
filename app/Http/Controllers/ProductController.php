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
            $query->where('category_id', $request->category);
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
        $product = Product::with('category')->findOrFail($id);
        $variants = $product->variants()->with(['color', 'size'])->get();
        $albums = $product->photoAlbums;
        $reviews = $product->reviews()->latest()->get();
        $categories = Category::all();
        $colors = Color::all();

        // Tạo variantMap
        $variantMap = [];

        foreach ($variants as $variant) {
            $key = $variant->color_id . '-' . $variant->size_id;
            $variantMap[$key] = [
                'id' => $variant->id,
                'price' => $variant->price,
                'stock' => $variant->stock ?? 0,
            ];
        }

        return view('products.show', compact('product', 'variants', 'albums', 'reviews', 'categories', 'colors', 'variantMap'));
    }





    public function showByCategory($slug)
    {
        $categories = Category::all();
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = Product::where('category_id', $category->id)->paginate(12);
        return view('products.index', compact('category', 'products', 'categories', 'colors'));
    }
}
