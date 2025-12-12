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
    // Hiển thị danh sách sản phẩm
    public function index(Request $request)
    {
        $query = Product::with(['photoAlbums', 'category', 'variants'])
            ->withTrashed()
            ->withSum('variants as total_stock', 'quantity')
            ->withSum('orderDetails as total_sold', 'quantity')
            ->orderBy('id', 'desc');


        // ✅ Tìm kiếm theo từ khoá
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;

            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('product_code', 'like', '%' . $keyword . '%');
            });
        }

        // ✅ Phân trang
        $products = $query->paginate(5);

        // ✅ Giữ keyword khi chuyển trang
        if ($request->filled('keyword')) {
            $products->appends(['keyword' => $request->keyword]);
        }
        return view(
            'admin.products.index',
            compact('products'),
            ['pageTitle' => 'Danh sách sản phẩm']
        );
    }



    // Form tạo sản phẩm mới
    public function create()
    {
        $categories = Category::all();
        return view(
            'admin.products.create',
            compact('categories'),
            ['pageTitle' => 'Thêm mới sản phẩm']
        );
    }
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

                // ✅ BIẾN THỂ
                'variants' => 'nullable|array|min:1',
                'variants.*.color_id' => 'required_with:variants|exists:colors,id',
                'variants.*.size_id' => 'required_with:variants|exists:sizes,id',
                'variants.*.price' => 'required_with:variants|numeric|min:0',
                'variants.*.sale' => 'nullable|numeric|min:0',
                'variants.*.quantity' => 'required_with:variants|integer|min:0',
            ],
            [
                // category_id
                'category_id.required' => 'Vui lòng chọn danh mục sản phẩm.',
                'category_id.exists'   => 'Danh mục bạn chọn không tồn tại.',

                // product_code
                'product_code.required' => 'Vui lòng nhập mã sản phẩm.',
                'product_code.unique'   => 'Mã sản phẩm này đã tồn tại.',

                // name
                'name.required' => 'Vui lòng nhập tên sản phẩm.',
                'name.string'   => 'Tên sản phẩm phải là chuỗi ký tự.',
                'name.max'      => 'Tên sản phẩm không được vượt quá 255 ký tự.',

                // description
                'description.string' => 'Mô tả sản phẩm phải là chuỗi ký tự.',

                // image
                'album_images.image' => 'Tệp tải lên phải là hình ảnh.',
                'album_images.max'   => 'Ảnh không được vượt quá 5MB.',

                'variants.required' => 'Phải có ít nhất 1 biến thể.',
            ]
        );

        /* ✅ 1. TẠO SẢN PHẨM */
        $product = Product::create([
            'category_id' => $validated['category_id'],
            'product_code' => $validated['product_code'],
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'material' => $validated['material'] ?? null,
            'onpage' => (int) $validated['onpage'],
        ]);

        /* ✅ 2. LƯU ẢNH ALBUM VỚI TÊN THEO TÊN SẢN PHẨM */
        if ($request->hasFile('album_images')) {

            foreach ($request->file('album_images') as $img) {

                $ext = $img->getClientOriginalExtension();

                // Tạo tên file dạng: ao-khoac-nam-1733802234-65ab3da9c1.jpg
                $newName = Str::slug($product->name) . '-' . uniqid() . '.' . $ext;

                // Lưu vào storage/app/public/products/albums/
                $path = $img->storeAs('products/photoAlbums', $newName, 'public');

                ProductPhotoAlbum::create([
                    'product_id' => $product->id,
                    'image'      => $path,
                ]);
            }
        }



        /* ✅ 3. TẠO BIẾN THỂ */
        if (!empty($validated['variants'])) {
            foreach ($validated['variants'] as $variantData) {

                $exists = ProductVariant::where('product_id', $product->id)
                    ->where('color_id', $variantData['color_id'])
                    ->where('size_id', $variantData['size_id'])
                    ->exists();

                if ($exists) continue;

                ProductVariant::create([
                    'product_id' => $product->id,
                    'color_id'   => $variantData['color_id'],
                    'size_id'    => $variantData['size_id'],
                    'price'      => $variantData['price'],
                    'sale'       => $variantData['sale'] ?? 0,
                    'quantity'   => $variantData['quantity'],
                    'status'     => 1,
                ]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Đã thêm sản phẩm + ảnh album + biến thể thành công!');
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
        // Tính giá min / sale hiện tại
        $minPrice = $product->variants->min('price');
        $minSale  = $product->variants
            ->filter(fn($v) => $v->sale && $v->sale > 0)
            ->min('sale');

        $displayPrice    = $minSale ?: $minPrice;
        $originalPrice   = $minPrice;
        $discountPercent = null;

        if ($minSale && $minPrice && $minSale < $minPrice) {
            $discountPercent = round((($minPrice - $minSale) / $minPrice) * 100);
        }

        // Rating
        $avgRating    = round($product->reviews->avg('rating') ?? 0, 1);
        $ratingCount  = $product->reviews->count();

        // Màu & size
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

        // ===== XỬ LÝ ẢNH HIỂN THỊ THEO THỨ TỰ: 
        // photo đầu -> ảnh biến thể -> photo còn lại =====

        $albumImages   = $product->photoAlbums->pluck('image')->filter()->values()->take(6);
        $variantImages = $product->variants->pluck('image')->filter()->unique()->values();

        $images = [];

        // 1️⃣ Ảnh photoAlbums đầu tiên
        if ($albumImages->isNotEmpty()) {
            $images[] = $albumImages->first();
        }

        // 2️⃣ Toàn bộ ảnh biến thể (không trùng)
        foreach ($variantImages as $img) {
            if (!in_array($img, $images)) {
                $images[] = $img;
            }
        }

        // 3️⃣ Các ảnh photoAlbums còn lại
        foreach ($albumImages->slice(1) as $img) {
            if (!in_array($img, $images)) {
                $images[] = $img;
            }
        }

        $images = array_values($images); 
        $variantPaginator = $product->variants()  
            ->with(['orderDetails', 'color', 'size'])
            ->paginate(4);
        // 2) Biến đổi collection bên trong paginator
        $variantMap = $variantPaginator->getCollection()
            ->mapWithKeys(function ($v) {
                $key = $v->color_id . '_' . $v->size_id;
                $soldQuantity = $v->orderDetails->sum('quantity');
                $stock        = $v->quantity;
                $remaining    = max($stock - $soldQuantity, 0); // 🔹 tránh âm
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
            ->where('category_id', $product->category_id) // cùng danh mục
            ->where('id', '!=', $product->id)             // loại trừ sản phẩm hiện tại
            ->take(8)                                     // giới hạn số lượng (tùy bạn chỉnh)
            ->get();

        return view(
            'admin.products.show',
            compact(
                'product',
                'displayPrice',
                'originalPrice',
                'discountPercent',
                'avgRating',
                'ratingCount',
                'colors',
                'sizes',
                'images',
                'variantMap',
                'relatedProducts'
            ),
            [
                'pageTitle' => 'Chi tiết sản phẩm',
                'product'          => $product,
                'variantsPaginate' => $variantPaginator,
            ]
        );
    }

    // Form chỉnh sửa sản phẩm
    public function edit(Product $product)
    {
        $product = Product::withTrashed()
            ->with(['photoAlbums', 'variants.color', 'variants.size'])
            ->findOrFail($product->id);

        $categories = Category::all();

        return view(
            'admin.products.edit',
            compact('product', 'categories'),
            ['pageTitle' => 'Chỉnh sửa sản phẩm']
        );
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'exists:categories,id',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'material'    => 'nullable|string|max:150',
            'onpage'      => 'required|boolean',

            'album_images'   => 'nullable|array',
            'album_images.*' => 'image|mimes:jpg,jpeg,png,gif,webp|max:4096',
        ]);


        $product->update([
            'category_id' => $validated['category_id'],
            'name'        => $validated['name'],
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

        return redirect()->route('admin.products.index')
            ->with('success', 'Cập nhật sản phẩm thành công!');
    }
    public function destroyAlbum(Product $product, $albumId)
    {
        // Tìm album thuộc đúng product (tránh xóa nhầm)
        $album = $product->photoAlbums()->where('id', $albumId)->firstOrFail();

        // Xóa file trên storage
        if (!empty($album->image) && Storage::disk('public')->exists($album->image)) {
            Storage::disk('public')->delete($album->image);
        }

        // Xóa record DB
        $album->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Xóa ảnh thành công !',
        ]);
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
    public function forceDelete($id)
    {
        Product::withTrashed()->where('id', $id)->forceDelete();

        return redirect()->back()->with('success', 'Đã xóa vĩnh viễn sản phẩm!');
    }




    /*
     * Phần quản lý biến thể sản phẩm
     */


    // Danh sách tất cả biến thể sản phẩm
    public function variants()
    {
        $variants = ProductVariant::with(['product', 'color', 'size'])
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->get();


        return view('admin.products.variants-index', compact('variants'));
    }


    // Danh sách biến thể của 1 sản phẩm cụ thể
    public function productVariants($productId)
    {
        $product = Product::withTrashed()->findOrFail($productId);
        $variants = ProductVariant::where('product_id', $productId)
            ->with(['color', 'size'])
            ->orderBy('id', 'asc')
            ->get();

        $colors = Color::where('status', 'active')->get();
        $sizes = Size::where('status', 'active')->get();


        return view('admin.products.variants-manager', compact('product', 'variants', 'colors', 'sizes'));
    }


    // Form tạo biến thể mới
    public function createVariant($productId)
    {
        $product = Product::findOrFail($productId);
        $colors = Color::all();
        $sizes = Size::all();


        return view('admin.products.create-variant', compact('product', 'colors', 'sizes'));
    }


    // Lưu biến thể mới (Thủ công - 1 biến thể)
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
        ], [
            // Thông báo lỗi tùy chỉnh (Tiếng Việt)

            // color_id
            'color_id.required' => 'Vui lòng chọn một màu sắc cho biến thể.',
            'color_id.exists' => 'Màu sắc được chọn không hợp lệ.',


            // size_id
            'size_id.required' => 'Vui lòng chọn một kích thước cho biến thể.',
            'size_id.exists' => 'Kích thước được chọn không hợp lệ.',


            // price
            'price.required' => 'Giá Gốc là bắt buộc.',
            'price.numeric' => 'Giá Gốc phải là một số.',
            'price.min' => 'Giá Gốc không được nhỏ hơn 0.',

            // sale
            'sale.required' => 'Vui lòng nhập Giá Sale.',
            'sale.numeric' => 'Giá Sale phải là một số.',
            'sale.min' => 'Giá Sale không được nhỏ hơn 0.',


            // quantity
            'quantity.required' => 'Số lượng tồn kho là bắt buộc.',
            'quantity.integer' => 'Số lượng tồn kho phải là số nguyên.',
            'quantity.min' => 'Số lượng tồn kho không được nhỏ hơn 0.',


            // status
            'status.required' => 'Trạng thái là bắt buộc.',
            'status.in' => 'Trạng thái không hợp lệ (Chỉ chấp nhận "active" hoặc "inactive").',


            // image
            'image.image' => 'File tải lên phải là hình ảnh.',
            'image.mimes' => 'Hình ảnh phải có định dạng: jpg, jpeg, png, hoặc webp.',
            'image.max' => 'Kích thước hình ảnh không được vượt quá :max KB (2MB).',
        ]);


        // Kiểm tra xem biến thể này đã tồn tại chưa
        $existing = ProductVariant::where('product_id', $productId)
            ->where('color_id', $validated['color_id'])
            ->where('size_id', $validated['size_id'])
            ->first();


        if ($existing) {
            return back()->with('error', 'Biến thể này đã tồn tại!');
        }


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
            $path = $request->file('image')->store('product_variants', 'public');
            $variant->image = $path;
        }


        $variant->save();


        return redirect()->route('admin.products.variants.product', $productId)
            ->with('success', 'Thêm biến thể sản phẩm thành công!');
    }


    // Trộn biến thể tự động (Tạo nhiều biến thể cùng lúc)
    public function bulkStoreVariants(Request $request, $productId)
    {
        $validated = $request->validate([
            'variants' => 'required|array|min:1',
            'variants.*.size_id' => 'required|exists:sizes,id',
            'variants.*.color_id' => 'required|exists:colors,id',
            'variants.*.price' => 'required|numeric|min:0',
            'variants.*.sale' => 'nullable|numeric|min:0',
            'variants.*.quantity' => 'required|integer|min:0',
        ], [
            'variants.required' => 'Vui lòng tạo ít nhất 1 biến thể',
            'variants.*.price.required' => 'Vui lòng nhập giá cho tất cả các biến thể',
            'variants.*.quantity.required' => 'Vui lòng nhập số lượng cho tất cả các biến thể',
        ]);


        $product = Product::findOrFail($productId);
        $createdCount = 0;
        $skippedCount = 0;
        $variants = [];


        // Duyệt qua từng biến thể được gửi lên
        foreach ($validated['variants'] as $variantData) {
            // Kiểm tra xem biến thể này đã tồn tại chưa
            $existing = ProductVariant::where('product_id', $productId)
                ->where('color_id', $variantData['color_id'])
                ->where('size_id', $variantData['size_id'])
                ->first();


            if ($existing) {
                $skippedCount++;
                continue;
            }


            // Tạo biến thể mới
            $variant = ProductVariant::create([
                'product_id' => $productId,
                'color_id' => $variantData['color_id'],
                'size_id' => $variantData['size_id'],
                'price' => $variantData['price'],
                'sale' => !empty($variantData['sale']) ? $variantData['sale'] : null,
                'quantity' => $variantData['quantity'],
                'status' => 1, // 1 = active
            ]);


            $variants[] = $variant;
            $createdCount++;
        }


        $message = "Đã tạo {$createdCount} biến thể mới!";
        if ($skippedCount > 0) {
            $message .= " Bỏ qua {$skippedCount} biến thể đã tồn tại.";
        }


        return redirect()->route('admin.products.variants.product', $productId)
            ->with('success', $message);
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




    // Cập nhật biến thể sản phẩm (ProductVariant)
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


        // Kiểm tra trùng lặp (ngoại trừ chính nó)
        $existing = ProductVariant::where('product_id', $variant->product_id)
            ->where('color_id', $validated['color_id'])
            ->where('size_id', $validated['size_id'])
            ->where('id', '!=', $variantId)
            ->first();


        if ($existing) {
            return back()->with('error', 'Biến thể này đã tồn tại!');
        }


        // Cập nhật dữ liệu
        $variant->color_id = $validated['color_id'];
        $variant->size_id = $validated['size_id'];
        $variant->price = $validated['price'];
        $variant->sale = !empty($validated['sale']) ? $validated['sale'] : null;
        $variant->quantity = $validated['quantity'];
        $variant->status = $validated['status'];


        // Xử lý upload ảnh mới
        if ($request->hasFile('image')) {

            if (!empty($variant->image) && Storage::disk('public')->exists($variant->image)) {
                Storage::disk('public')->delete($variant->image);
            }

            $path = $request->file('image')->store('product_variants', 'public');
            $variant->image = $path;
        }


        $variant->save();


        return redirect()->route('admin.products.variants.product', $variant->product_id)
            ->with('success', 'Cập nhật biến thể sản phẩm thành công!');
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
