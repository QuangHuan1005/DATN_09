<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductPhotoAlbum;
use App\Models\ProductVariant;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminProductController extends Controller
{
    // Hiển thị danh sách sản phẩm
    public function index(Request $request)
    {
        $query = Product::with(['category', 'variants'])
            ->withTrashed()
            ->orderBy('id', 'desc');

        if ($request->has('keyword') && $request->keyword != '') {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('product_code', 'like', '%' . $keyword . '%');
            });
        }

        $products = Product::with(['category', 'variants'])
            ->withTrashed()->withSum('variants as total_stock', 'quantity')
            // tổng đã bán = sum(quantity) trên order_details
            ->withSum('orderDetails as total_sold', 'quantity')
            // rating
            ->withAvg('reviews as avg_rating', 'rating')
            ->withCount('reviews as reviews_count')
            ->orderByDesc('id')
            ->paginate(10);
        
        return view(
            'admin.products.index',
            compact('products'),
            ['pageTitle' => 'Danh sách sản phẩm']
        );
    }
    // public function index()
    // {
    //     $products = Product::query()
    //         ->with([
    //             'category:id,name',
    //             'variants.size:id,size_code',
    //             'variants',           // để lấy image, quantity
    //         ])
    //         // tổng tồn kho = sum(quantity) trên variants
    //         ->withSum('variants as total_stock', 'quantity')
    //         // tổng đã bán = sum(quantity) trên order_details
    //         ->withSum('orderDetails as total_sold', 'quantity')
    //         // rating
    //         ->withAvg('reviews as avg_rating', 'rating')
    //         ->withCount('reviews as reviews_count')
    //         ->orderByDesc('id')
    //         ->paginate(10);

    //     return view('admin.products.index', compact('products'));
    // }

    // Form tạo sản phẩm mới
    public function create()
    {
        $categories = Category::all();
        $sizes = Size::where('status', 1)->get();
        $colors = Color::where('status', 1)->get();

        return view(
            'admin.products.create',
            compact('categories', 'sizes', 'colors'),
            ['pageTitle' => 'Thêm mới sản phẩm']
        );
    }

    // Lưu sản phẩm mới
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id'  => 'required|exists:categories,id',
            'product_code' => 'required|unique:products,product_code',
            'name'         => 'required|string|max:255',
            'description'  => 'nullable|string',
            'material'     => 'nullable|string|max:150',
            'onpage'       => 'required|boolean',
            'image.*'      => 'nullable|image|max:2048',
        ]);

        $product = Product::create([
            'category_id'  => $validated['category_id'],
            'product_code' => $validated['product_code'],
            'name'         => $validated['name'],
            'description'  => $validated['description'] ?? null,
            'material'     => $validated['material'] ?? null,
            'onpage'       => $validated['onpage'] ?? 0,
            'view'         => 0,
        ]);
        //Tạo các biến 
        foreach ($request->size_ids as $sizeId) {
            foreach ($request->color_ids as $colorId) {
                ProductVariant::create([
                    'product_id' => $product->id,
                    'size_id' => $sizeId,
                    'color_id' => $colorId,
                    'price' => $request->price,
                    'sale' => $request->sale,
                    'quantity' => $request->quantity,
                    'status' => 1,
                ]);
            }
        }
        // Upload ảnh (nhiều ảnh)
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $img) {
                $path = $img->store('products', 'public');
                $product->photoAlbums()->create([
                    'image' => $path,
                ]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Thêm sản phẩm thành công!');
    }

    // Xem chi tiết sản phẩm
    public function show(Product $product)
    {
        // Load đầy đủ quan hệ cần cho trang chi tiết
        $product->load([
            'category:id,name',
            'variants.color:id,name,color_code',
            'variants.size:id,name,size_code',
            'photoAlbums',
        ])->withSum('variants as total_stock', 'quantity')
            // tổng đã bán = sum(quantity) trên order_details
            ->withSum('orderDetails as total_sold', 'quantity');


        // Tính giá min / sale
        $minPrice = $product->variants->min('price');
        $minSale  = $product->variants
            ->filter(fn($v) => $v->sale && $v->sale > 0)
            ->min('sale');

        $displayPrice    = $minSale ?: $minPrice;
        $originalPrice   = $minPrice;     // để gạch ngang
        $discountPercent = null;

        if ($minSale && $minPrice && $minSale < $minPrice) {
            $discountPercent = round((($minPrice - $minSale) / $minPrice) * 100);
        }

        // Rating chung
        $avgRating    = round($product->reviews->avg('rating') ?? 0, 1);
        $ratingCount  = $product->reviews->count();

        // 2 review nổi bật (mới nhất)
        $topReviews = $product->reviews()
            ->with('order.user')
            ->where('status', 1)          // nếu có cột status publish
            ->latest()
            ->take(8)
            ->get();
        // Màu & size duy nhất
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

        // Ảnh cho carousel: ưu tiên album, nếu không có lấy từ variant
        $images = $product->photoAlbums->pluck('image')->toArray();

        if (empty($images)) {
            $images = $product->variants
                ->pluck('image')
                ->filter()
                ->unique()
                ->values()
                ->toArray();
        }

        return view('admin.products.show', compact(
            'product',
            'displayPrice',
            'originalPrice',
            'discountPercent',
            'avgRating',
            'ratingCount',
            'topReviews',
            'colors',
            'sizes',
            'images'
        ), ['pageTitle' => 'Chi Tiết Sản Phẩm']);
    }

    // Form chỉnh sửa sản phẩm
    public function edit(Product $product)
    {
        $product = Product::with([
            'variants.size',
            'variants.color',
            'photoAlbums'
        ])->withTrashed()->findOrFail($product->id);

        $categories = Category::all();

        return view(
            'admin.products.edit',
            compact('product', 'categories'),
            ['pageTitle' => 'Chỉnh sửa sản phẩm']
        );
    }

    // Cập nhật sản phẩm
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'material'    => 'nullable|string|max:150',
            'price'       => 'required|numeric|min:0',
            'sale'        => 'nullable|numeric|min:0',
            'onpage'      => 'required|boolean',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $product->update([
            'category_id' => $validated['category_id'],
            'name'        => $validated['name'],
            'description' => $validated['description'] ?? null,
            'material'    => $validated['material'] ?? null,
            'price'       => $request->price,
            'sale'        => $request->sale,
            'onpage'      => $validated['onpage'],
        ]);

        if ($request->has('variants')) {
            foreach ($request->variants as $variantId => $data) {
                ProductVariant::where('id', $variantId)->update([
                    'quantity' => $data['quantity'],
                ]);
            }
        }

        if ($request->hasFile('file')) {

            // xóa ảnh cũ
            foreach ($product->photoAlbums as $album) {
                Storage::disk('public')->delete($album->image);
                $album->delete();
            }

            // Lưu ảnh mới
            foreach ($request->file('file') as $img) {
                $path = $img->store('products', 'public');
                ProductPhotoAlbum::create([
                    'product_id' => $product->id,
                    'image'      => $path,
                ]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Cập nhật sản phẩm thành công!');
    }

    // Ẩn sản phẩm (soft delete)
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->onpage = 0;
        $product->save();
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Sản phẩm đã được ẩn.');
    }

    // Khôi phục sản phẩm đã ẩn
    public function restore($id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        $product->restore();
        $product->onpage = 1;
        $product->save();

        return redirect()->route('admin.products.index')
            ->with('success', 'Sản phẩm đã được hiển thị lại.');
    }
    // public function forceDelete($id)
    // {
    //     Product::withTrashed()->where('id', $id)->forceDelete();
    //     return redirect()->back()->with('success', 'Đã xóa vĩnh viễn sản phẩm!');
    // }


    /*
     * Phần quản lý biến thể sản phẩm
     */

    // Danh sách tất cả biến thể sản phẩm
    public function variants()
    {
        $variants = ProductVariant::with(['product', 'color', 'size'])
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'asc')
            ->get();

        return view(
            'admin.products.variants-index',
            compact('variants'),
            ['pageTitle' => 'Danh Sách Biến Thể']
        );
    }

    // Danh sách biến thể của 1 sản phẩm cụ thể
    public function productVariants($productId)
    {
        $product = Product::withTrashed()->findOrFail($productId);
        $variants = ProductVariant::where('product_id', $productId)
            ->with(['color', 'size'])
            ->orderBy('id', 'asc')
            ->get();

        return view('admin.products.variants-index', compact('product', 'variants'));
    }

    // Form tạo biến thể mới
    public function createVariant($productId)
    {
        $product = Product::findOrFail($productId);
        $colors = Color::all();
        $sizes = Size::all();

        return view('admin.products.create-variant', compact('product', 'colors', 'sizes'));
    }

    // Lưu biến thể mới
    public function storeVariant(Request $request, $productId)
    {
        $validated = $request->validate([
            'color_id' => 'required|exists:colors,id',
            'size_id' => 'nullable|exists:sizes,id',
            'price' => 'required|numeric|min:0',
            'sale' => 'nullable|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $variant = new ProductVariant($validated);
        $variant->product_id = $productId;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('product_variants', 'public');
            $variant->image = $path;
        }

        $variant->save();

        return redirect()->route('admin.products.variants.product', $productId)
            ->with('success', 'Thêm biến thể sản phẩm thành công!');
    }

    // Form sửa biến thể
    public function editVariant($variantId)
    {
        // Kiểm tra xem đây là Size hay Color dựa trên route
        $request = request();
        $type = null;

        // Lấy type từ referer URL
        if ($request->header('referer')) {
            $referer = $request->header('referer');
            if (strpos($referer, '/size') !== false) {
                $type = 'size';
            } elseif (strpos($referer, '/color') !== false) {
                $type = 'color';
            }
        }

        if ($type === 'size') {
            $variant = Size::findOrFail($variantId);
            $typeName = 'Kích thước';
        } elseif ($type === 'color') {
            $variant = Color::findOrFail($variantId);
            $typeName = 'Màu sắc';
        } else {
            // Fallback: thử tìm trong ProductVariant
            $variant = ProductVariant::findOrFail($variantId);
            $typeName = 'Biến thể sản phẩm';
        }

        return view('admin.products.edit-variant', compact('variant', 'type', 'typeName'));
    }

    public function variantsByType(Request $request, $type)
    {
        // Xác định loại biến thể và tên hiển thị
        $typeName = $type === 'size' ? 'Kích thước' : 'Màu sắc';

        // Lấy dữ liệu từ bảng colors hoặc sizes
        if ($type === 'size') {
            $variants = Size::query();
        } elseif ($type === 'color') {
            $variants = Color::query();
        } else {
            return redirect()->route('admin.products.variants')
                ->with('error', 'Loại biến thể không hợp lệ');
        }

        // Tìm kiếm nếu có
        if ($request->has('search') && $request->search) {
            $variants->where('name', 'like', '%' . $request->search . '%');
        }

        $variants = $variants->orderBy('created_at', 'desc')
            ->orderBy('id')
            ->get();

        // Trả về view danh sách biến thể
        return view('admin.products.variants-list', [
            'variants' => $variants,
            'type' => $type,
            'typeName' => $typeName,
        ]);
    }


    // Cập nhật biến thể
    public function updateVariant(Request $request, $variantId)
    {
        $type = $request->input('type');

        if ($type === 'size') {
            $variant = Size::findOrFail($variantId);
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'size_code' => 'nullable|string|max:50',
                'description' => 'nullable|string',
                'status' => 'required|in:active,inactive',
            ]);
        } elseif ($type === 'color') {
            $variant = Color::findOrFail($variantId);
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'color_code' => 'nullable|string|max:50',
                'description' => 'nullable|string',
                'status' => 'required|in:active,inactive',
            ]);
        } else {
            return redirect()->route('admin.products.variants')
                ->with('error', 'Loại biến thể không hợp lệ');
        }

        $variant->update($validated);

        $typeName = $type === 'size' ? 'kích thước' : 'màu sắc';
        return redirect()->route('admin.products.variants.type', $type)
            ->with('success', "Cập nhật {$typeName} thành công!");
    }

    // Xóa biến thể
    public function destroyVariant($variantId)
    {
        // Kiểm tra xem đây là Size hay Color dựa trên referer
        $request = request();
        $type = null;

        if ($request->header('referer')) {
            $referer = $request->header('referer');
            if (strpos($referer, '/size') !== false) {
                $type = 'size';
            } elseif (strpos($referer, '/color') !== false) {
                $type = 'color';
            }
        }

        if ($type === 'size') {
            $variant = Size::findOrFail($variantId);
            $typeName = 'kích thước';
        } elseif ($type === 'color') {
            $variant = Color::findOrFail($variantId);
            $typeName = 'màu sắc';
        } else {
            return redirect()->route('admin.products.variants')
                ->with('error', 'Loại biến thể không hợp lệ');
        }

        $variant->delete();

        return redirect()->route('admin.products.variants.type', $type)
            ->with('success', "Xóa {$typeName} thành công!");
    }
}
