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
     * ĐÃ TỐI ƯU: Tách biệt sản phẩm hoạt động và Thùng rác
     */
    public function index(Request $request)
    {
        $query = Product::with(['category', 'variants.size']);

        // Nếu request có tham số trash=1, chỉ lấy sản phẩm đã xóa mềm
        if ($request->has('trash') && $request->trash == 1) {
            $query->onlyTrashed();
            $pageTitle = 'Thùng rác sản phẩm';
        } else {
            // Mặc định Laravel ẩn trashed, nhưng viết rõ để dễ quản lý
            $query->withoutTrashed();
            $pageTitle = 'Danh sách sản phẩm';
        }

        $query->withSum('variants as total_stock', 'quantity')
            ->withSum('orderDetails as total_sold', 'quantity')
            ->withAvg('reviews as avg_rating', 'rating')
            ->withCount('reviews as total_reviews')
            ->orderBy('id', 'desc');

        // Tìm kiếm theo từ khoá
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', '%' . $keyword . '%')
                  ->orWhere('product_code', 'like', '%' . $keyword . '%');
            });
        }

        $products = $query->paginate(10)->withQueryString();

        return view('admin.products.index', compact('products'), [
            'pageTitle' => $pageTitle
        ]);
    }

    /**
     * Form tạo sản phẩm mới
     */
    public function create()
    {
        $categories = Category::all();
        $sizes = Size::where('status', 'active')->get();
        $colors = Color::where('status', 'active')->get();

        return view(
            'admin.products.create',
            compact('categories', 'sizes', 'colors'),
            ['pageTitle' => 'Thêm mới sản phẩm']
        );
    }

    /**
     * Lưu sản phẩm + Album ảnh + Biến thể
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id'    => 'required|exists:categories,id',
            'product_code'   => 'required|unique:products,product_code',
            'name'           => 'required|string|max:255',
            'description'    => 'nullable|string',
            'material'       => 'nullable|string|max:150',
            'onpage'         => 'required|in:0,1',
            'album_images'   => 'nullable|array',
            'album_images.*' => 'image|mimes:jpg,jpeg,png,gif,webp|max:4096',
            'color_images'   => 'nullable|array',
            'color_images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            'variants'       => 'required|array|min:1',
            'variants.*.color_id' => 'required|exists:colors,id',
            'variants.*.size_id'  => 'required|exists:sizes,id',
            'variants.*.price'    => 'required|numeric|min:0',
            'variants.*.sale'     => 'nullable|numeric|min:0',
            'variants.*.quantity' => 'required|integer|min:0',
        ]);

        DB::beginTransaction();
        try {
            // 1. TẠO SẢN PHẨM
            $product = Product::create([
                'category_id'  => $validated['category_id'],
                'product_code' => $validated['product_code'],
                'name'         => $validated['name'],
                'description'  => $validated['description'] ?? null,
                'material'     => $validated['material'] ?? null,
                'onpage'       => (int) $validated['onpage'],
            ]);

            // 2. LƯU ẢNH ALBUM
            if ($request->hasFile('album_images')) {
                foreach ($request->file('album_images') as $img) {
                    $path = $img->store('products/photoAlbums', 'public');
                    ProductPhotoAlbum::create([
                        'product_id' => $product->id,
                        'image'      => $path,
                    ]);
                }
            }

            // 3. XỬ LÝ ẢNH THEO MÀU
            $uploadedColorImages = [];
            if ($request->hasFile('color_images')) {
                foreach ($request->file('color_images') as $colorId => $img) {
                    $variantName = Str::slug($product->name) . "-color-{$colorId}-" . uniqid() . '.' . $img->getClientOriginalExtension();
                    $uploadedColorImages[$colorId] = $img->storeAs('product_variants', $variantName, 'public');
                }
            }

            // 4. TẠO BIẾN THỂ
            foreach ($request->variants as $variantData) {
                $colorId = $variantData['color_id'];
                ProductVariant::create([
                    'product_id' => $product->id,
                    'color_id'   => $colorId,
                    'size_id'    => $variantData['size_id'],
                    'price'      => $variantData['price'],
                    'sale'       => $variantData['sale'] ?? 0,
                    'quantity'   => $variantData['quantity'],
                    'image'      => $uploadedColorImages[$colorId] ?? null,
                    'status'     => 1,
                ]);
            }

            DB::commit();
            return redirect()->route('admin.products.index')
                ->with('success', 'Đã thêm sản phẩm và các biến thể thành công!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Lỗi: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Xem chi tiết sản phẩm
     */
    public function show($id)
    {
        $product = Product::withTrashed()->with([
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
        $discountPercent = ($minSale && $minPrice && $minSale < $minPrice) ? round((($minPrice - $minSale) / $minPrice) * 100) : null;

        $avgRating    = round($product->reviews->avg('rating') ?? 0, 1);
        $ratingCount  = $product->reviews->count();

        $colors = $product->variants->pluck('color')->filter()->unique('id')->values();
        $sizes  = $product->variants->pluck('size')->filter()->unique('id')->values();

        $albumImages   = $product->photoAlbums->pluck('image')->filter()->values();
        $variantImages = $product->variants->pluck('image')->filter()->unique()->values();

        $images = collect($albumImages)->merge($variantImages)->unique()->values()->all();

        $variantPaginator = $product->variants()->with(['orderDetails', 'color', 'size'])->paginate(4);

        $variantMap = $variantPaginator->getCollection()->map(function ($v) {
            $soldQuantity = $v->orderDetails->sum('quantity');
            return [
                'id'         => $v->id,
                'color_name' => $v->color->name ?? null,
                'size_name'  => $v->size->size_code ?? null,
                'price'      => $v->price,
                'sale'       => $v->sale,
                'stock'      => $v->quantity,
                'sold'       => $soldQuantity,
                'remaining'  => max($v->quantity - $soldQuantity, 0),
                'image'      => $v->image,
            ];
        });

        $variantPaginator->setCollection($variantMap);
        
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(8)
            ->get();

        return view('admin.products.show', compact('product','displayPrice','originalPrice','discountPercent','avgRating','ratingCount','colors','sizes','images','relatedProducts'), [
            'pageTitle' => 'Chi tiết sản phẩm', 
            'variantsPaginate' => $variantPaginator
        ]);
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

        $product->update($validated);

        if ($request->hasFile('album_images')) {
            foreach ($request->file('album_images') as $img) {
                $path = $img->store('products/photoAlbums', 'public');
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
        if ($album->image) Storage::disk('public')->delete($album->image);
        $album->delete();
        return response()->json(['status' => 'success', 'message' => 'Xóa ảnh thành công !']);
    }

    /**
     * Xóa mềm (Chuyển vào thùng rác)
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->onpage = 0;
        $product->save();
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được chuyển vào thùng rác.');
    }

    /**
     * Khôi phục sản phẩm
     */
    public function restore($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();
        $product->onpage = 1; 
        $product->save();
        return redirect()->route('admin.products.index', ['trash' => 1])->with('success', 'Sản phẩm đã được khôi phục.');
    }

    /**
     * Xóa vĩnh viễn
     */
    public function forceDelete($id)
    {
        DB::beginTransaction();
        try {
            $product = Product::onlyTrashed()->with(['variants', 'photoAlbums'])->findOrFail($id);

            // Xóa file ảnh biến thể
            foreach ($product->variants as $variant) {
                if ($variant->image) Storage::disk('public')->delete($variant->image);
            }
            // Xóa file ảnh Album
            foreach ($product->photoAlbums as $album) {
                if ($album->image) Storage::disk('public')->delete($album->image);
            }

            $product->forceDelete();
            DB::commit();

            return redirect()->route('admin.products.index', ['trash' => 1])->with('success', 'Đã xóa vĩnh viễn sản phẩm.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.products.index', ['trash' => 1])->with('error', 'Không thể xóa sản phẩm đang có đơn hàng!');
        }
    }

    /* QUẢN LÝ BIẾN THỂ */

    public function productVariants($productId)
    {
        $product = Product::withTrashed()->findOrFail($productId);
        $variantsGroupedByColor = ProductVariant::where('product_id', $productId)
            ->with(['color', 'size'])
            ->orderBy('color_id', 'asc')
            ->get()
            ->groupBy('color_id'); 

        $colors = Color::where('status', 'active')->get();
        $sizes = Size::where('status', 'active')->get();
        
        return view('admin.products.variants-manager', compact('product', 'variantsGroupedByColor', 'colors', 'sizes'));
    }

    public function storeVariant(Request $request, $productId)
    {
        $validated = $request->validate([
            'color_id' => 'required|exists:colors,id',
            'size_id'  => 'required|exists:sizes,id',
            'price'    => 'required|numeric|min:0',
            'sale'     => 'nullable|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'status'   => 'required|in:active,inactive',
            'image'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $existing = ProductVariant::where('product_id', $productId)
            ->where('color_id', $validated['color_id'])
            ->where('size_id', $validated['size_id'])
            ->first();

        if ($existing) return back()->with('error', 'Biến thể này đã tồn tại!');

        $variant = new ProductVariant([
            'product_id' => $productId,
            'color_id'   => $validated['color_id'],
            'size_id'    => $validated['size_id'],
            'price'      => $validated['price'],
            'sale'       => $validated['sale'],
            'quantity'   => $validated['quantity'],
            'status'     => $validated['status'] === 'active' ? 1 : 0,
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
            'size_id'  => 'required|exists:sizes,id',
            'price'    => 'required|numeric|min:0',
            'sale'     => 'nullable|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'status'   => 'required|in:0,1',
            'image'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
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