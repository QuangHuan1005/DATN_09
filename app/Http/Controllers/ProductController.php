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
        // Bắt đầu query chính
        $query = Product::query()->with(['category', 'variants']);
        // ----- Lọc theo DANH MỤC -----
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        // ----- Lọc theo MÀU -----
        if ($request->filled('color')) {
            $query->whereHas('variants', function ($q) use ($request) {
                $q->where('color_id', $request->color);
            });
        }

        // ----- Lọc theo KÍCH CỠ -----
        if ($request->filled('size')) {
            $query->whereHas('variants', function ($q) use ($request) {
                $q->where('size_id', $request->size);
            });
        }


        // ----- Lọc theo GIÁ -----
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
                    $query->orderBy(
                        DB::raw('(SELECT MIN(price) FROM product_variants WHERE product_id = products.id)'),
                        'asc'
                    );
                    break;
                case 'price_desc':
                    $query->orderBy(
                        DB::raw('(SELECT MAX(price) FROM product_variants WHERE product_id = products.id)'),
                        'desc'
                    );
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

        // Kết quả chính
        $products = $query->paginate(12)->appends($request->query());

        // --- Đếm số lượng cho sidebar ---
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

    public function showByCategory($slug, Request $request)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $query = Product::query()
            ->with(['category','variants'])
            ->where('category_id', $category->id)
            ->select('products.*');

        if ($request->filled('color')) {
            $query->whereHas('variants', fn($q) => $q->where('color_id', $request->color));
        }
        if ($request->filled('size')) {
            $query->whereHas('variants', fn($q) => $q->where('size_id', $request->size));
        }

        $products = $query->paginate(12)->appends($request->query());
        $sidebar  = $this->sidebarCounts();

        return view('products.index', array_merge(
            ['products' => $products, 'category' => $category],
            $sidebar
        ));
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product  = Product::with('category')->findOrFail($id);
        $variants = $product->variants()->with(['color','size'])->get();

        $albums   = $product->photoAlbums;
        $reviews  = $product->reviews()->latest()->get();

        // Màu duy nhất có trong biến thể
        $colors = $variants->filter(fn($v) => $v->color)
                        ->pluck('color')->unique('id')->values();

        // Map nhanh "colorId-sizeId" => data
        $variantMap = $variants->mapWithKeys(function ($v) {
            $key = ($v->color_id ?? '0').'-'.($v->size_id ?? '0');
            return [
                $key => [
                    'id'         => $v->id,
                    'price'      => (float)$v->price,
                    'sale'       => $v->sale ? (float)$v->sale : null,
                    'image'      => $v->image,
                    'color_id'   => $v->color_id,
                    'size_id'    => $v->size_id,
                    'color_name' => optional($v->color)->name,
                    'size_name'  => optional($v->size)->name,
                ],
            ];
        });

        // >>> THÊM DÒNG NÀY: lấy dữ liệu sidebar
        $sidebar = $this->sidebarCounts();

        // >>> TRUYỀN THÊM $categories, $colors (sidebar), $sizes vào view
        return view('products.show', array_merge(
            compact('product','variants','albums','reviews','colors','variantMap'),
            $sidebar
        ));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
     public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Đã xóa sản phẩm thành công.');
    }

    private function sidebarCounts(): array
    {
        $categories = Category::withCount('products')->get();

        $colors = Color::select('colors.*', DB::raw('COUNT(DISTINCT product_variants.product_id) as products_count'))
            ->leftJoin('product_variants', 'colors.id', '=', 'product_variants.color_id')
            ->groupBy('colors.id')
            ->get();

        $sizes = Size::select('sizes.*', DB::raw('COUNT(DISTINCT product_variants.product_id) as products_count'))
            ->leftJoin('product_variants', 'sizes.id', '=', 'product_variants.size_id')
            ->groupBy('sizes.id')
            ->get();

        return compact('categories','colors','sizes');
    }

}
