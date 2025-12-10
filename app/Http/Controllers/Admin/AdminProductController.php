<?php

<<<<<<< HEAD

namespace App\Http\Controllers\Admin;


=======
namespace App\Http\Controllers\Admin;

>>>>>>> origin/phong
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductPhotoAlbum;
use App\Models\ProductVariant;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
<<<<<<< HEAD
use Illuminate\Support\Str;
=======
>>>>>>> origin/phong

class AdminProductController extends Controller
{
    // Hiển thị danh sách sản phẩm
    public function index(Request $request)
    {
<<<<<<< HEAD
        $query = Product::with(['photoAlbums', 'category', 'variants'])
            ->withTrashed()
            ->orderBy('id', 'desc');

        // ✅ Tìm kiếm theo từ khoá
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;

=======
        $query = Product::with(['category', 'variants'])
            ->withTrashed()
            ->orderBy('id', 'desc');

        if ($request->has('keyword') && $request->keyword != '') {
            $keyword = $request->keyword;
>>>>>>> origin/phong
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('product_code', 'like', '%' . $keyword . '%');
            });
        }

<<<<<<< HEAD

        // ✅ Phân trang
        $products = $query->paginate(5);

        // ✅ Giữ keyword khi chuyển trang
        if ($request->filled('keyword')) {
            $products->appends(['keyword' => $request->keyword]);
        }
=======
        $products = Product::with(['category', 'variants'])
            ->withTrashed()->orderBy('id', 'desc')
            ->paginate(5);

        if ($request->filled('keyword')) {
            $products = $query->paginate(5);
            $products->appends(['keyword' => $request->keyword]);
        }
        

>>>>>>> origin/phong

        return view(
            'admin.products.index',
            compact('products'),
            ['pageTitle' => 'Danh sách sản phẩm']
        );
    }

<<<<<<< HEAD


=======
>>>>>>> origin/phong
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

<<<<<<< HEAD

    // Lưu sản phẩm mới
    // public function store(Request $request)
    // {
    //     $validated = $request->validate(
    //         [
    //             'category_id'  => 'required|exists:categories,id',
    //             'product_code' => 'required|unique:products,product_code',
    //             'name'         => 'required|string|max:255',
    //             'description'  => 'nullable|string',
    //             'image'        => 'nullable|image|max:2048',
    //         ],
    //         [
    //             // category_id
    //             'category_id.required' => 'Vui lòng chọn danh mục sản phẩm.',
    //             'category_id.exists'   => 'Danh mục bạn chọn không tồn tại.',


    //             // product_code
    //             'product_code.required' => 'Vui lòng nhập mã sản phẩm.',
    //             'product_code.unique'   => 'Mã sản phẩm này đã tồn tại.',


    //             // name
    //             'name.required' => 'Vui lòng nhập tên sản phẩm.',
    //             'name.string'   => 'Tên sản phẩm phải là chuỗi ký tự.',
    //             'name.max'      => 'Tên sản phẩm không được vượt quá 255 ký tự.',


    //             // description
    //             'description.string' => 'Mô tả sản phẩm phải là chuỗi ký tự.',


    //             // image
    //             'image.image' => 'Tệp tải lên phải là hình ảnh.',
    //             'image.max'   => 'Ảnh không được vượt quá 2MB.',
    //         ]
    //     );


    //     $product = Product::create([
    //         'category_id'  => $validated['category_id'],
    //         'product_code' => $validated['product_code'],
    //         'name'         => $validated['name'],
    //         'description'  => $validated['description'] ?? null,
    //     ]);


    //     if ($request->hasFile('image')) {
    //         $path = $request->file('image')->store('products', 'public');
    //         ProductPhotoAlbum::create([
    //             'product_id' => $product->id,
    //             'image'      => $path,
    //         ]);
    //     }


    //     return redirect()->route('admin.products.index')
    //         ->with('success', 'Thêm sản phẩm thành công!');
    // }

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
                $newName = Str::slug($product->name) . '-' . time() . '.' . $ext;

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




=======
    // Lưu sản phẩm mới
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id'  => 'required|exists:categories,id',
            'product_code' => 'required|unique:products,product_code',
            'name'         => 'required|string|max:255',
            'description'  => 'nullable|string',
            'image'        => 'nullable|image|max:2048',
        ]);

        $product = Product::create([
            'category_id'  => $validated['category_id'],
            'product_code' => $validated['product_code'],
            'name'         => $validated['name'],
            'description'  => $validated['description'] ?? null,
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            ProductPhotoAlbum::create([
                'product_id' => $product->id,
                'image'      => $path,
            ]);
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Thêm sản phẩm thành công!');
    }

>>>>>>> origin/phong
    // Xem chi tiết sản phẩm
    public function show($id)
    {
        $product = Product::with(['photoAlbums', 'variants.color', 'variants.size'])->findOrFail($id);
        return view(
            'admin.products.show',
            compact('product'),
            ['pageTitle' => 'Chi tiết sản phẩm']
        );
    }


<<<<<<< HEAD


    // Form chỉnh sửa sản phẩm
    public function edit(Product $product)
    {
        $product = Product::withTrashed()
            ->with(['photoAlbums', 'variants.color', 'variants.size'])
            ->findOrFail($product->id);

=======
    // Form chỉnh sửa sản phẩm
    public function edit(Product $product)
    {
        $product = Product::withTrashed()->findOrFail($product->id);
>>>>>>> origin/phong
        $categories = Category::all();

        return view(
            'admin.products.edit',
            compact('product', 'categories'),
            ['pageTitle' => 'Chỉnh sửa sản phẩm']
        );
    }

<<<<<<< HEAD
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id'   => 'required|exists:categories,id',
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string',
            'material'      => 'nullable|string|max:150',
            'onpage'        => 'required|boolean',

            // ✅ ALBUM ẢNH MỚI (nếu có)
            'album_images'   => 'nullable|array',
            'album_images.*' => 'image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        /* ✅ 1. UPDATE SẢN PHẨM */
=======
    // Cập nhật sản phẩm
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'material'    => 'nullable|string|max:150',
            'onpage'      => 'required|boolean',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

>>>>>>> origin/phong
        $product->update([
            'category_id' => $validated['category_id'],
            'name'        => $validated['name'],
            'description' => $validated['description'] ?? null,
            'material'    => $validated['material'] ?? null,
            'onpage'      => $validated['onpage'],
        ]);

<<<<<<< HEAD
        /* ✅ 2. NẾU CÓ UPLOAD ALBUM MỚI → CHỈ ADD THÊM (KHÔNG XOÁ HẾT) */
        if ($request->hasFile('album_images')) {

            foreach ($request->file('album_images') as $img) {

                $ext = $img->getClientOriginalExtension();

                // ✅ Tên file theo tên SP
                $newName = Str::slug($product->name)
                    . '-' . time()
                    . '-' . uniqid()
                    . '.' . $ext;

                $path = $img->storeAs('products/photoAlbums', $newName, 'public');

                ProductPhotoAlbum::create([
                    'product_id' => $product->id,
                    'image'      => $path,
                ]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Cập nhật sản phẩm và album ảnh thành công!');
    }



=======
        if ($request->hasFile('image')) {
            // Xóa ảnh cũ
            foreach ($product->photoAlbums as $album) {
                if (Storage::disk('public')->exists($album->image)) {
                    Storage::disk('public')->delete($album->image);
                }
                $album->delete();
            }

            // Lưu ảnh mới
            $path = $request->file('image')->store('products', 'public');
            ProductPhotoAlbum::create([
                'product_id' => $product->id,
                'image'      => $path,
            ]);
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Cập nhật sản phẩm thành công!');
    }

>>>>>>> origin/phong
    // Ẩn sản phẩm (soft delete)
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->onpage = 0;
        $product->save();
        $product->delete();

<<<<<<< HEAD

=======
>>>>>>> origin/phong
        return redirect()->route('admin.products.index')
            ->with('success', 'Sản phẩm đã được ẩn.');
    }

<<<<<<< HEAD

=======
>>>>>>> origin/phong
    // Khôi phục sản phẩm đã ẩn
    public function restore($id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        $product->restore();
        $product->onpage = 1;
        $product->save();

<<<<<<< HEAD

=======
>>>>>>> origin/phong
        return redirect()->route('admin.products.index')
            ->with('success', 'Sản phẩm đã được hiển thị lại.');
    }
    public function forceDelete($id)
    {
        Product::withTrashed()->where('id', $id)->forceDelete();
        return redirect()->back()->with('success', 'Đã xóa vĩnh viễn sản phẩm!');
    }


<<<<<<< HEAD


=======
>>>>>>> origin/phong
    /*
     * Phần quản lý biến thể sản phẩm
     */

<<<<<<< HEAD

=======
>>>>>>> origin/phong
    // Danh sách tất cả biến thể sản phẩm
    public function variants()
    {
        $variants = ProductVariant::with(['product', 'color', 'size'])
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'asc')
            ->get();

<<<<<<< HEAD

        return view('admin.products.variants-index', compact('variants'));
    }


=======
        return view('admin.products.variants-index', compact('variants'));
    }

>>>>>>> origin/phong
    // Danh sách biến thể của 1 sản phẩm cụ thể
    public function productVariants($productId)
    {
        $product = Product::withTrashed()->findOrFail($productId);
        $variants = ProductVariant::where('product_id', $productId)
            ->with(['color', 'size'])
            ->orderBy('id', 'asc')
            ->get();
<<<<<<< HEAD

        $colors = Color::where('status', 'active')->get();
        $sizes = Size::where('status', 'active')->get();


        return view('admin.products.variants-manager', compact('product', 'variants', 'colors', 'sizes'));
    }


=======
        
        $colors = Color::where('status', 'active')->get();
        $sizes = Size::where('status', 'active')->get();

        return view('admin.products.variants-manager', compact('product', 'variants', 'colors', 'sizes'));
    }

>>>>>>> origin/phong
    // Form tạo biến thể mới
    public function createVariant($productId)
    {
        $product = Product::findOrFail($productId);
        $colors = Color::all();
        $sizes = Size::all();

<<<<<<< HEAD

        return view('admin.products.create-variant', compact('product', 'colors', 'sizes'));
    }


=======
        return view('admin.products.create-variant', compact('product', 'colors', 'sizes'));
    }

>>>>>>> origin/phong
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
<<<<<<< HEAD
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


=======
        ]);

>>>>>>> origin/phong
        // Kiểm tra xem biến thể này đã tồn tại chưa
        $existing = ProductVariant::where('product_id', $productId)
            ->where('color_id', $validated['color_id'])
            ->where('size_id', $validated['size_id'])
            ->first();

<<<<<<< HEAD

=======
>>>>>>> origin/phong
        if ($existing) {
            return back()->with('error', 'Biến thể này đã tồn tại!');
        }

<<<<<<< HEAD

=======
>>>>>>> origin/phong
        $variant = new ProductVariant([
            'product_id' => $productId,
            'color_id' => $validated['color_id'],
            'size_id' => $validated['size_id'],
            'price' => $validated['price'],
            'sale' => $validated['sale'],
            'quantity' => $validated['quantity'],
            'status' => $validated['status'] === 'active' ? 1 : 0,
        ]);

<<<<<<< HEAD

=======
>>>>>>> origin/phong
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('product_variants', 'public');
            $variant->image = $path;
        }

<<<<<<< HEAD

        $variant->save();


=======
        $variant->save();

>>>>>>> origin/phong
        return redirect()->route('admin.products.variants.product', $productId)
            ->with('success', 'Thêm biến thể sản phẩm thành công!');
    }

<<<<<<< HEAD

=======
>>>>>>> origin/phong
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

<<<<<<< HEAD

=======
>>>>>>> origin/phong
        $product = Product::findOrFail($productId);
        $createdCount = 0;
        $skippedCount = 0;
        $variants = [];

<<<<<<< HEAD

=======
>>>>>>> origin/phong
        // Duyệt qua từng biến thể được gửi lên
        foreach ($validated['variants'] as $variantData) {
            // Kiểm tra xem biến thể này đã tồn tại chưa
            $existing = ProductVariant::where('product_id', $productId)
                ->where('color_id', $variantData['color_id'])
                ->where('size_id', $variantData['size_id'])
                ->first();

<<<<<<< HEAD

=======
>>>>>>> origin/phong
            if ($existing) {
                $skippedCount++;
                continue;
            }

<<<<<<< HEAD

=======
>>>>>>> origin/phong
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

<<<<<<< HEAD

=======
>>>>>>> origin/phong
            $variants[] = $variant;
            $createdCount++;
        }

<<<<<<< HEAD

=======
>>>>>>> origin/phong
        $message = "Đã tạo {$createdCount} biến thể mới!";
        if ($skippedCount > 0) {
            $message .= " Bỏ qua {$skippedCount} biến thể đã tồn tại.";
        }

<<<<<<< HEAD

=======
>>>>>>> origin/phong
        return redirect()->route('admin.products.variants.product', $productId)
            ->with('success', $message);
    }

<<<<<<< HEAD

=======
>>>>>>> origin/phong
    // Form sửa biến thể
    public function editVariant($variantId)
    {
        // Kiểm tra xem đây là Size hay Color dựa trên route
        $request = request();
        $type = null;
<<<<<<< HEAD

=======
        
>>>>>>> origin/phong
        // Lấy type từ referer URL
        if ($request->header('referer')) {
            $referer = $request->header('referer');
            if (strpos($referer, '/size') !== false) {
                $type = 'size';
            } elseif (strpos($referer, '/color') !== false) {
                $type = 'color';
            }
        }
<<<<<<< HEAD

=======
        
>>>>>>> origin/phong
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

<<<<<<< HEAD

        return view('admin.products.edit-variant', compact('variant', 'type', 'typeName'));
    }


=======
        return view('admin.products.edit-variant', compact('variant', 'type', 'typeName'));
    }

>>>>>>> origin/phong
    public function variantsByType(Request $request, $type)
    {
        // Xác định loại biến thể và tên hiển thị
        $typeName = $type === 'size' ? 'Kích thước' : 'Màu sắc';
<<<<<<< HEAD

        // Lấy dữ liệu từ bảng colors hoặc sizes
        if ($type === 'size') {
            $variants = Size::query();
        } elseif ($type === 'color') {
            $variants = Color::query();
=======
        
        // Lấy dữ liệu từ bảng colors hoặc sizes
        if ($type === 'size') {
            $variants = \App\Models\Size::query();
        } elseif ($type === 'color') {
            $variants = \App\Models\Color::query();
>>>>>>> origin/phong
        } else {
            return redirect()->route('admin.products.variants')
                ->with('error', 'Loại biến thể không hợp lệ');
        }

<<<<<<< HEAD

=======
>>>>>>> origin/phong
        // Tìm kiếm nếu có
        if ($request->has('search') && $request->search) {
            $variants->where('name', 'like', '%' . $request->search . '%');
        }

<<<<<<< HEAD

        $variants = $variants->orderBy('created_at', 'desc')
            ->orderBy('id')
            ->get();

=======
        $variants = $variants->orderBy('created_at', 'desc')
                            ->orderBy('id')
                            ->get();
>>>>>>> origin/phong

        // Trả về view danh sách biến thể
        return view('admin.products.variants-list', [
            'variants' => $variants,
            'type' => $type,
            'typeName' => $typeName,
        ]);
    }


<<<<<<< HEAD


=======
>>>>>>> origin/phong
    // Cập nhật biến thể sản phẩm (ProductVariant)
    public function updateVariant(Request $request, $variantId)
    {
        $variant = ProductVariant::findOrFail($variantId);
<<<<<<< HEAD

=======
        
>>>>>>> origin/phong
        $validated = $request->validate([
            'color_id' => 'required|exists:colors,id',
            'size_id' => 'required|exists:sizes,id',
            'price' => 'required|numeric|min:0',
            'sale' => 'nullable|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'status' => 'required|in:0,1',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

<<<<<<< HEAD

=======
>>>>>>> origin/phong
        // Kiểm tra trùng lặp (ngoại trừ chính nó)
        $existing = ProductVariant::where('product_id', $variant->product_id)
            ->where('color_id', $validated['color_id'])
            ->where('size_id', $validated['size_id'])
            ->where('id', '!=', $variantId)
            ->first();

<<<<<<< HEAD

=======
>>>>>>> origin/phong
        if ($existing) {
            return back()->with('error', 'Biến thể này đã tồn tại!');
        }

<<<<<<< HEAD

=======
>>>>>>> origin/phong
        // Cập nhật dữ liệu
        $variant->color_id = $validated['color_id'];
        $variant->size_id = $validated['size_id'];
        $variant->price = $validated['price'];
        $variant->sale = !empty($validated['sale']) ? $validated['sale'] : null;
        $variant->quantity = $validated['quantity'];
        $variant->status = $validated['status'];

<<<<<<< HEAD

=======
>>>>>>> origin/phong
        // Xử lý upload ảnh mới
        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu có
            if ($variant->image) {
                Storage::delete('public/' . $variant->image);
            }
            $path = $request->file('image')->store('product_variants', 'public');
            $variant->image = $path;
        }

<<<<<<< HEAD

        $variant->save();


=======
        $variant->save();

>>>>>>> origin/phong
        return redirect()->route('admin.products.variants.product', $variant->product_id)
            ->with('success', 'Cập nhật biến thể sản phẩm thành công!');
    }

<<<<<<< HEAD

=======
>>>>>>> origin/phong
    // Xóa biến thể
    public function destroyVariant($variantId)
    {
        // Kiểm tra xem đây là Size hay Color dựa trên referer
        $request = request();
        $type = null;
<<<<<<< HEAD

=======
        
>>>>>>> origin/phong
        if ($request->header('referer')) {
            $referer = $request->header('referer');
            if (strpos($referer, '/size') !== false) {
                $type = 'size';
            } elseif (strpos($referer, '/color') !== false) {
                $type = 'color';
            }
        }
<<<<<<< HEAD

=======
        
>>>>>>> origin/phong
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

<<<<<<< HEAD

        $variant->delete();


=======
        $variant->delete();

>>>>>>> origin/phong
        return redirect()->route('admin.products.variants.type', $type)
            ->with('success', "Xóa {$typeName} thành công!");
    }
}
