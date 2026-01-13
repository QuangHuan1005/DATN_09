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
    // 1. Định nghĩa các thông báo lỗi bằng tiếng Việt
    $messages = [
        'name.required'             => 'Vui lòng nhập tên sản phẩm.',
        'category_id.required'      => 'Vui lòng chọn danh mục sản phẩm.',
        'category_id.exists'        => 'Danh mục không hợp lệ.',
        'product_code.required'     => 'Mã sản phẩm không được để trống.',
        'product_code.unique'       => 'Mã sản phẩm này đã tồn tại trong hệ thống, vui lòng chọn mã khác.',
        'onpage.required'           => 'Vui lòng chọn trạng thái hiển thị.',
        'variants.required'         => 'Bạn phải tạo ít nhất một biến thể cho sản phẩm.',
        'variants.*.price.required' => 'Giá gốc biến thể là bắt buộc.',
        'variants.*.price.numeric'  => 'Giá phải là một con số.',
        'variants.*.quantity.required' => 'Số lượng kho là bắt buộc.',
        'album_images.*.image'      => 'Tệp tin tải lên phải là hình ảnh.',
        'album_images.*.max'        => 'Dung lượng ảnh album không được vượt quá 4MB.',
    ];

    // 2. Tiến hành Validate với mảng tin nhắn tùy chỉnh
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
    ], $messages);

    DB::beginTransaction();
    try {
        // 3. TẠO SẢN PHẨM
        $product = Product::create([
            'category_id'  => $validated['category_id'],
            'product_code' => $validated['product_code'],
            'name'         => $validated['name'],
            'description'  => $validated['description'] ?? null,
            'material'     => $validated['material'] ?? null,
            'onpage'       => (int) $validated['onpage'],
        ]);

        // 4. LƯU ẢNH ALBUM
        if ($request->hasFile('album_images')) {
            foreach ($request->file('album_images') as $img) {
                $path = $img->store('products/photoAlbums', 'public');
                ProductPhotoAlbum::create([
                    'product_id' => $product->id,
                    'image'      => $path,
                ]);
            }
        }

        // 5. XỬ LÝ ẢNH THEO MÀU
        $uploadedColorImages = [];
        if ($request->hasFile('color_images')) {
            foreach ($request->file('color_images') as $colorId => $img) {
                // Sử dụng uniqid để tránh trùng tên file
                $variantName = Str::slug($product->name) . "-color-{$colorId}-" . uniqid() . '.' . $img->getClientOriginalExtension();
                $uploadedColorImages[$colorId] = $img->storeAs('product_variants', $variantName, 'public');
            }
        }

        // 6. TẠO BIẾN THỂ
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
        // Trả về lỗi kèm theo dữ liệu cũ đã nhập (withInput) để người dùng không phải nhập lại
        return back()->with('error', 'Lỗi hệ thống: ' . $e->getMessage())->withInput();
    }
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
        ], 
        [
        // THÔNG BÁO TIẾNG VIỆT TẠI ĐÂY
        'product_code.required' => 'Vui lòng nhập mã sản phẩm.',
        'product_code.unique'   => 'Mã sản phẩm này đã tồn tại trong hệ thống, vui lòng chọn mã khác.',
        'category_id.required'  => 'Vui lòng chọn danh mục sản phẩm.',
        'name.required'         => 'Tên sản phẩm không được để trống.',
        'variants.required'     => 'Sản phẩm phải có ít nhất một biến thể.',
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
    // 1. Tiền xử lý dữ liệu: Loại bỏ dấu phẩy khỏi giá VND gửi từ giao diện
    if ($request->filled('price')) {
        $request->merge(['price' => str_replace(',', '', $request->price)]);
    }
    if ($request->filled('sale')) {
        $request->merge(['sale' => str_replace(',', '', $request->sale)]);
    }

    // 2. Kiểm tra dữ liệu với thông báo tiếng Việt
    $validated = $request->validate([
        'color_id' => 'required|exists:colors,id',
        'size_id'  => 'required|exists:sizes,id',
        'price'    => 'required|numeric|min:0',
        'sale'     => 'nullable|numeric|min:0|lte:price', // sale phải nhỏ hơn hoặc bằng price
        'quantity' => 'required|integer|min:0',
        'image'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ], [
        'color_id.required' => 'Vui lòng chọn màu sắc.',
        'size_id.required'  => 'Vui lòng chọn kích thước.',
        'price.required'    => 'Giá gốc không được để trống.',
        'price.numeric'     => 'Giá gốc phải là số.',
        'price.min'         => 'Giá gốc không được nhỏ hơn 0.',
        'sale.numeric'      => 'Giá khuyến mãi phải là số.',
        'sale.min'          => 'Giá khuyến mãi không được nhỏ hơn 0.',
        'sale.lte'          => 'Giá khuyến mãi không được lớn hơn giá gốc.',
        'quantity.required' => 'Số lượng không được để trống.',
        'quantity.integer'  => 'Số lượng phải là số nguyên.',
        'quantity.min'      => 'Số lượng không được nhỏ hơn 0.',
        'image.image'       => 'Tệp tải lên phải là hình ảnh.',
        'image.mimes'       => 'Ảnh phải có định dạng: jpg, jpeg, png, webp.',
        'image.max'         => 'Dung lượng ảnh không được vượt quá 2MB.',
    ]);

    // 3. Kiểm tra trùng lặp (Màu sắc + Kích thước)
    $existing = ProductVariant::where('product_id', $productId)
        ->where('color_id', $validated['color_id'])
        ->where('size_id', $validated['size_id'])
        ->first();

    if ($existing) {
        return back()->with('error', 'Biến thể (Màu & Size) này đã tồn tại trong danh sách!');
    }

    try {
        // 4. Tạo mới biến thể
        $variant = new ProductVariant([
            'product_id' => $productId,
            'color_id'   => $validated['color_id'],
            'size_id'    => $validated['size_id'],
            'price'      => $validated['price'],
            'sale'       => $validated['sale'] ?? 0,
            'quantity'   => $validated['quantity'],
            'status'     => 1, // Mặc định là hoạt động
        ]);

        // 5. Lưu ảnh (nếu có)
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('product_variants', 'public');
            $variant->image = $path;
        }

        $variant->save();

        // Chuyển hướng về trang quản lý biến thể của sản phẩm đó
        return redirect()->route('admin.products.variants.product', $productId)
            ->with('success', 'Thêm biến thể mới thành công!');

    } catch (\Exception $e) {
        return back()->with('error', 'Lỗi hệ thống: ' . $e->getMessage());
    }
}

    /**
 * Xử lý cập nhật hàng loạt biến thể từ bảng danh sách
 */
public function bulkUpdate(Request $request, $productId)
{
    // 1. Kiểm tra dữ liệu đầu vào
    $request->validate([
        'variants' => 'required|array',
        'variants.*.price' => 'required|numeric|min:0',
        'variants.*.quantity' => 'required|integer|min:0',
        'color_images' => 'nullable|array',
        'color_images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ], [
        'variants.*.price.required' => 'Giá gốc không được để trống.',
        'variants.*.quantity.required' => 'Số lượng không được để trống.',
        'color_images.*.image' => 'Tệp tải lên phải là hình ảnh.',
    ]);

    DB::beginTransaction();
    try {
        // 2. Xử lý upload ảnh theo màu (nếu có)
        // Chúng ta lưu đường dẫn ảnh vào mảng với key là color_id
        $colorImagesMap = [];
        if ($request->hasFile('color_images')) {
            foreach ($request->file('color_images') as $colorId => $file) {
                $path = $file->store('product_variants', 'public');
                $colorImagesMap[$colorId] = $path;
            }
        }

        // 3. Cập nhật từng dòng biến thể
        foreach ($request->variants as $variantId => $data) {
            $variant = ProductVariant::findOrFail($variantId);
            
            // Chuẩn bị dữ liệu cập nhật
            // Sử dụng null coalescing operator (??) để tránh lỗi Undefined Index
            $updateData = [
                'price'    => $data['price'],
                'sale'     => $data['sale'] ?? 0,
                'quantity' => $data['quantity'],
                'status'   => $data['status'] ?? 1, // Nếu form không gửi status, mặc định là 1 (Hoạt động)
            ];

            // 4. Kiểm tra và cập nhật ảnh mới cho nhóm màu
            if (isset($colorImagesMap[$variant->color_id])) {
                // Chỉ xóa ảnh cũ nếu ảnh đó thực sự tồn tại và không dùng chung cho các record khác
                // (Hoặc đơn giản là xóa nếu bạn upload ảnh riêng biệt cho từng biến thể)
                if ($variant->image && Storage::disk('public')->exists($variant->image)) {
                    Storage::disk('public')->delete($variant->image);
                }
                
                $updateData['image'] = $colorImagesMap[$variant->color_id];
            }

            // Thực hiện cập nhật vào Database
            $variant->update($updateData);
        }

        DB::commit();
        return back()->with('success', 'Đã lưu toàn bộ thay đổi biến thể thành công!');

    } catch (\Exception $e) {
        DB::rollBack();
        
        // Nếu có lỗi, hãy xóa các file ảnh vừa mới upload lên để tránh rác server
        if (!empty($colorImagesMap)) {
            foreach ($colorImagesMap as $path) {
                Storage::disk('public')->delete($path);
            }
        }

        return back()->with('error', 'Lỗi hệ thống: ' . $e->getMessage());
    }
}

/**
 * Xóa vĩnh viễn một biến thể sản phẩm
 */
public function destroyVariant($variantId)
{
    try {
        // 1. Tìm biến thể cần xóa
        $variant = ProductVariant::findOrFail($variantId);
        
        // 2. Kiểm tra và xóa file ảnh vật lý trên storage (nếu có)
        if ($variant->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($variant->image)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($variant->image);
        }

        // 3. Thực hiện xóa trong Database
        $variant->delete();

        // 4. Trả về trang trước đó với thông báo thành công
        return back()->with('success', 'Đã xóa biến thể thành công!');

    } catch (\Exception $e) {
        // Trả về lỗi nếu có vấn đề (ví dụ biến thể đang nằm trong đơn hàng nếu có ràng buộc)
        return back()->with('error', 'Không thể xóa biến thể này. Lỗi: ' . $e->getMessage());
    }
}
}