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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminProductController extends Controller
{
    /**
     * Hiển thị danh sách sản phẩm
     */
   public function index(Request $request)
{
    $query = Product::with(['category', 'variants.size']) // Eager load các quan hệ cần thiết
        ->withTrashed()
        // ✅ Tính tổng tồn kho từ tất cả biến thể
        ->withSum('variants as total_stock', 'quantity')
        // ✅ Tính tổng số lượng đã bán từ chi tiết đơn hàng
        ->withSum('orderDetails as total_sold', 'quantity')
        // ✅ Tính trung bình sao và đếm lượt đánh giá
        ->withAvg('reviews as avg_rating', 'rating')
        ->withCount('reviews as total_reviews')
        ->orderBy('id', 'desc');

    // ✅ Tìm kiếm theo từ khoá
    if ($request->filled('keyword')) {
        $keyword = $request->keyword;
        $query->where(function ($q) use ($keyword) {
            $q->where('name', 'like', '%' . $keyword . '%')
              ->orWhere('product_code', 'like', '%' . $keyword . '%');
        });
    }

    // ✅ Phân trang & Giữ tham số search trên URL
    $products = $query->paginate(10)->withQueryString();

    return view('admin.products.index', compact('products'), [
        'pageTitle' => 'Danh sách sản phẩm'
    ]);
}

    /**
     * Form tạo sản phẩm mới (ĐÃ FIX LỖI UNDEFINED $sizes, $colors)
     */
    public function create()
    {
        $categories = Category::all();
        
        // Lấy danh sách Size và Màu sắc có trạng thái hoạt động để trộn biến thể
        $sizes = Size::where('status', 'active')->get();
        $colors = Color::where('status', 'active')->get();

        return view(
            'admin.products.create',
            compact('categories', 'sizes', 'colors'),
            ['pageTitle' => 'Thêm mới sản phẩm']
        );
    }

    /**
     * Lưu sản phẩm + Album ảnh + Biến thể gộp làm 1
     */
    public function store(Request $request)
{
    $validated = $request->validate(
        [
            'category_id' => 'required|exists:categories,id',
            'product_code' => 'required|unique:products,product_code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'material' => 'nullable|string|max:150',
            'onpage' => 'required|in:0,1',

            // ✅ ẢNH ALBUM
            'album_images'   => 'nullable|array',
            'album_images.*' => 'image|mimes:jpg,jpeg,png,gif,webp|max:4096',

            // ✅ BIẾN THỂ (Thêm validate cho image của từng biến thể)
            'variants' => 'required|array|min:1',
            'variants.*.color_id' => 'required|exists:colors,id',
            'variants.*.size_id' => 'required|exists:sizes,id',
            'variants.*.price' => 'required|numeric|min:0',
            'variants.*.sale' => 'nullable|numeric|min:0',
            'variants.*.quantity' => 'required|integer|min:0',
            'variants.*.image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', // Fix lỗi thiếu validate ảnh
        ],
        [
            'category_id.required' => 'Vui lòng chọn danh mục sản phẩm.',
            'product_code.required' => 'Vui lòng nhập mã sản phẩm.',
            'product_code.unique'   => 'Mã sản phẩm này đã tồn tại.',
            'name.required' => 'Vui lòng nhập tên sản phẩm.',
            'variants.required' => 'Phải có ít nhất 1 biến thể được tạo.',
        ]
    );

    DB::beginTransaction();
    try {
        /* ✅ 1. TẠO SẢN PHẨM */
        $product = Product::create([
            'category_id' => $validated['category_id'],
            'product_code' => $validated['product_code'],
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'material' => $validated['material'] ?? null,
            'onpage' => (int) $validated['onpage'],
        ]);

        /* ✅ 2. LƯU ẢNH ALBUM */
        if ($request->hasFile('album_images')) {
            foreach ($request->file('album_images') as $img) {
                $ext = $img->getClientOriginalExtension();
                $newName = Str::slug($product->name) . '-' . uniqid() . '.' . $ext;
                $path = $img->storeAs('products/photoAlbums', $newName, 'public');

                ProductPhotoAlbum::create([
                    'product_id' => $product->id,
                    'image'      => $path,
                ]);
            }
        }

        /* ✅ 3. TẠO BIẾN THỂ + XỬ LÝ ẢNH BIẾN THỂ */
        if (!empty($request->variants)) {
            foreach ($request->variants as $index => $variantData) {
                $pathVariantImage = null;

                // Kiểm tra và lưu ảnh cho từng biến thể dựa trên index
                if ($request->hasFile("variants.{$index}.image")) {
                    $file = $request->file("variants.{$index}.image");
                    $variantName = Str::slug($product->name) . "-v{$index}-" . uniqid() . '.' . $file->getClientOriginalExtension();
                    $pathVariantImage = $file->storeAs('product_variants', $variantName, 'public');
                }

                ProductVariant::create([
                    'product_id' => $product->id,
                    'color_id'   => $variantData['color_id'],
                    'size_id'    => $variantData['size_id'],
                    'price'      => $variantData['price'],
                    'sale'       => $variantData['sale'] ?? 0,
                    'quantity'   => $variantData['quantity'],
                    'image'      => $pathVariantImage, // Lưu đường dẫn ảnh (không còn NULL nếu có upload)
                    'status'     => 1,
                ]);
            }
        }

        DB::commit();
        return redirect()->route('admin.products.index')
            ->with('success', 'Đã thêm sản phẩm và các biến thể thành công!');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Lỗi: ' . $e->getMessage())->withInput();
    }
}
    // Xem chi tiết sản phẩm
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

        $minPrice = $product->variants->min('price');
        $minSale  = $product->variants->filter(fn($v) => $v->sale && $v->sale > 0)->min('sale');

        $displayPrice    = $minSale ?: $minPrice;
        $originalPrice   = $minPrice;
        $discountPercent = null;

        if ($minSale && $minPrice && $minSale < $minPrice) {
            $discountPercent = round((($minPrice - $minSale) / $minPrice) * 100);
        }

        $avgRating    = round($product->reviews->avg('rating') ?? 0, 1);
        $ratingCount  = $product->reviews->count();

        $colors = $product->variants->pluck('color')->filter()->unique('id')->values();
        $sizes  = $product->variants->pluck('size')->filter()->unique('id')->values();

        $albumImages   = $product->photoAlbums->pluck('image')->filter()->values()->take(6);
        $variantImages = $product->variants->pluck('image')->filter()->unique()->values();

        $images = [];
        if ($albumImages->isNotEmpty()) $images[] = $albumImages->first();
        foreach ($variantImages as $img) {
            if (!in_array($img, $images)) $images[] = $img;
        }
        foreach ($albumImages->slice(1) as $img) {
            if (!in_array($img, $images)) $images[] = $img;
        }

        $images = array_values($images); 
        $variantPaginator = $product->variants()->with(['orderDetails', 'color', 'size'])->paginate(4);

        $variantMap = $variantPaginator->getCollection()->mapWithKeys(function ($v) {
                $key = $v->color_id . '_' . $v->size_id;
                $soldQuantity = $v->orderDetails->sum('quantity');
                $stock        = $v->quantity;
                $remaining    = max($stock - $soldQuantity, 0); 
                return [
                    $key => [
                        'id'            => $v->id,
                        'color_id'      => $v->color_id,
                        'color_name'    => $v->color->name ?? null,
                        'size_id'       => $v->size_id,
                        'size_name'     => $v->size->size_code ?? null,
                        'price'         => $v->price,
                        'sale'          => $v->sale,
                        'stock'         => $stock,
                        'sold'          => $soldQuantity,
                        'remaining'     => $remaining,
                        'image'         => $v->image,
                    ],
                ];
            });
        $variantPaginator->setCollection($variantMap->values());
        
        $relatedProducts = Product::with(['photoAlbums', 'variants'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(8)
            ->get();

        return view(
            'admin.products.show',
            compact('product','displayPrice','originalPrice','discountPercent','avgRating','ratingCount','colors','sizes','images','variantMap','relatedProducts'),
            ['pageTitle' => 'Chi tiết sản phẩm', 'product' => $product, 'variantsPaginate' => $variantPaginator]
        );
    }

    public function edit(Product $product)
    {
        $product = Product::withTrashed()->with(['photoAlbums', 'variants.color', 'variants.size'])->findOrFail($product->id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'), ['pageTitle' => 'Chỉnh sửa sản phẩm']);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'exists:categories,id',
            'name'         => 'required|string|max:255',
            'description' => 'nullable|string',
            'material'    => 'nullable|string|max:150',
            'onpage'      => 'required|boolean',
            'album_images'   => 'nullable|array',
            'album_images.*' => 'image|mimes:jpg,jpeg,png,gif,webp|max:4096',
        ]);

        $product->update([
            'category_id' => $validated['category_id'],
            'name'         => $validated['name'],
            'description' => $validated['description'] ?? null,
            'material'    => $validated['material'] ?? null,
            'onpage'      => $validated['onpage'],
        ]);

        if ($request->hasFile('album_images')) {
            foreach ($request->file('album_images') as $img) {
                $ext = $img->getClientOriginalExtension();
                $newName = Str::slug($product->name) . '-' . uniqid() . '.' . $ext;
                $path = $img->storeAs('products/photoAlbums', $newName, 'public');
                ProductPhotoAlbum::create([
                    'product_id' => $product->id,
                    'image'      => $path,
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công!');
    }

    public function destroyAlbum(Product $product, $albumId)
    {
        $album = $product->photoAlbums()->where('id', $albumId)->firstOrFail();
        if (!empty($album->image) && Storage::disk('public')->exists($album->image)) {
            Storage::disk('public')->delete($album->image);
        }
        $album->delete();
        return response()->json(['status' => 'success', 'message' => 'Xóa ảnh thành công !']);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->onpage = 0;
        $product->save();
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được ẩn.');
    }

public function restore($id)
{
    try {
        $product = Product::withTrashed()->find($id);

        if (!$product) {
            return redirect()->route('admin.products.index')->with('error', 'Sản phẩm không tồn tại!');
        }

        DB::beginTransaction();
        $product->restore();
        $product->onpage = 1; 
        $product->save();
        DB::commit();

        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được khôi phục thành công.');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->route('admin.products.index')->with('error', 'Có lỗi xảy ra khi khôi phục.');
    }
}

public function forceDelete($id)
{
    try {
        $product = Product::withTrashed()->with(['variants', 'photoAlbums'])->find($id);

        if (!$product) {
            return redirect()->route('admin.products.index')->with('error', 'Sản phẩm không tồn tại!');
        }

        DB::beginTransaction();

        // Xóa ảnh và dữ liệu biến thể
        foreach ($product->variants as $variant) {
            if ($variant->image && Storage::disk('public')->exists($variant->image)) {
                Storage::disk('public')->delete($variant->image);
            }
            $variant->forceDelete(); 
        }

        // Xóa ảnh và dữ liệu Album
        foreach ($product->photoAlbums as $album) {
            if ($album->image && Storage::disk('public')->exists($album->image)) {
                Storage::disk('public')->delete($album->image);
            }
            $album->forceDelete(); 
        }

        $product->forceDelete();
        DB::commit();

        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã bị xóa vĩnh viễn khỏi hệ thống.');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->route('admin.products.index')->with('error', 'Không thể xóa vĩnh viễn sản phẩm có liên quan đến đơn hàng!');
    }
}
    /* QUẢN LÝ BIẾN THỂ */

    public function variants()
    {
        $variants = ProductVariant::with(['product', 'color', 'size'])->orderBy('created_at', 'desc')->get();
        return view('admin.products.variants-index', compact('variants'));
    }

    public function productVariants($productId)
    {
        $product = Product::withTrashed()->findOrFail($productId);
        $variants = ProductVariant::where('product_id', $productId)->with(['color', 'size'])->orderBy('id', 'asc')->get();
        $colors = Color::where('status', 'active')->get();
        $sizes = Size::where('status', 'active')->get();
        return view('admin.products.variants-manager', compact('product', 'variants', 'colors', 'sizes'));
    }

    public function storeVariant(Request $request, $productId)
    {
        $validated = $request->validate([
            'color_id' => 'required|exists:colors,id',
            'size_id' => 'required|exists:sizes,id',
            'price' => 'required|numeric|min:0',
            'sale' => 'nullable|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $existing = ProductVariant::where('product_id', $productId)
            ->where('color_id', $validated['color_id'])->where('size_id', $validated['size_id'])->first();

        if ($existing) return back()->with('error', 'Biến thể này đã tồn tại!');

        $variant = new ProductVariant([
            'product_id' => $productId,
            'color_id' => $validated['color_id'],
            'size_id' => $validated['size_id'],
            'price' => $validated['price'],
            'sale' => $validated['sale'],
            'quantity' => $validated['quantity'],
            'status' => $validated['status'] === 'active' ? 1 : 0,
        ]);

        if ($request->hasFile('image')) {
            $variant->image = $request->file('image')->store('product_variants', 'public');
        }

        $variant->save();
        return redirect()->route('admin.products.variants.product', $productId)->with('success', 'Thêm biến thể thành công!');
    }

    public function updateVariant(Request $request, $variantId)
    {
        $variant = ProductVariant::findOrFail($variantId);
        $validated = $request->validate([
            'color_id' => 'required|exists:colors,id',
            'size_id' => 'required|exists:sizes,id',
            'price' => 'required|numeric|min:0',
            'sale' => 'nullable|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'status' => 'required|in:0,1',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $variant->update($validated);
        if ($request->hasFile('image')) {
            if ($variant->image) Storage::disk('public')->delete($variant->image);
            $variant->image = $request->file('image')->store('product_variants', 'public');
            $variant->save();
        }
        return redirect()->route('admin.products.variants.product', $variant->product_id)->with('success', 'Cập nhật thành công!');
    }

    public function destroyVariant($variantId)
    {
        $variant = ProductVariant::findOrFail($variantId);
        $variant->delete();
        return redirect()->back()->with('success', "Xóa biến thể thành công!");
    }
}