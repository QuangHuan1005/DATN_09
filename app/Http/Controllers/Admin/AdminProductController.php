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
        ->orderBy('id', 'asc');

    if ($request->has('keyword') && $request->keyword != '') {
        $keyword = $request->keyword;
        $query->where(function ($q) use ($keyword) {
            $q->where('name', 'like', '%' . $keyword . '%')
              ->orWhere('product_code', 'like', '%' . $keyword . '%');
        });
    }

    $products = Product::with(['category', 'variants'])
        ->withTrashed()
        ->paginate(5);

    if ($request->filled('keyword')) {
        $products = $query->paginate(5);
        $products->appends(['keyword' => $request->keyword]);
    }


        return view('admin.products.index', compact('products'));
    }

    // Form tạo sản phẩm mới
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

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

    // Xem chi tiết sản phẩm
    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    // Form chỉnh sửa sản phẩm
    public function edit(Product $product)
    {
        $product = Product::withTrashed()->findOrFail($product->id);
        $categories = Category::all();

        return view('admin.products.edit', compact('product', 'categories'));
    }

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

        $product->update([
            'category_id' => $validated['category_id'],
            'name'        => $validated['name'],
            'description' => $validated['description'] ?? null,
            'material'    => $validated['material'] ?? null,
            'onpage'      => $validated['onpage'],
        ]);

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


    /*
     * Phần quản lý biến thể sản phẩm
     */

    // Danh sách biến thể của 1 sản phẩm
    public function variants($productId)
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

        return redirect()->route('admin.products.variants', $productId)
            ->with('success', 'Thêm biến thể sản phẩm thành công!');
    }

    // Form sửa biến thể
    public function editVariant($productId, $variantId)
    {
        $product = Product::findOrFail($productId);
        $variant = ProductVariant::findOrFail($variantId);
        $colors = Color::all();
        $sizes = Size::all();

        return view('admin.products.edit-variant', compact('product', 'variant', 'colors', 'sizes'));
    }

    public function variantsByType(Request $request, $type)
{
    $query = \App\Models\ProductVariant::query();

    if ($type === 'size') {
        $query->whereNotNull('size_id');
    } elseif ($type === 'color') {
        $query->whereNotNull('color_id');
    } else {
        // Nếu type không hợp lệ, trả về view trống hoặc redirect
        return view('admin.product_variants.index', ['variants' => collect(), 'type' => $type]);
    }

    $variants = $query->orderBy('created_at', 'desc')
                      ->orderBy('id')
                      ->get();

    // Trả về view, truyền dữ liệu biến thể và loại
    return view('admin.product_variants.index', [
        'variants' => $variants,
        'type' => $type,
    ]);
}


    // Cập nhật biến thể
    public function updateVariant(Request $request, $productId, $variantId)
    {
        $variant = ProductVariant::findOrFail($variantId);

        $validated = $request->validate([
            'color_id' => 'required|exists:colors,id',
            'size_id' => 'nullable|exists:sizes,id',
            'price' => 'required|numeric|min:0',
            'sale' => 'nullable|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($variant->image && Storage::disk('public')->exists($variant->image)) {
                Storage::disk('public')->delete($variant->image);
            }

            $path = $request->file('image')->store('product_variants', 'public');
            $validated['image'] = $path;
        }

        $variant->update($validated);

        return redirect()->route('admin.products.variants', $productId)
            ->with('success', 'Cập nhật biến thể sản phẩm thành công!');
    }

    // Xóa biến thể
    public function destroyVariant($productId, $variantId)
    {
        $variant = ProductVariant::findOrFail($variantId);

        if ($variant->image && Storage::disk('public')->exists($variant->image)) {
            Storage::disk('public')->delete($variant->image);
        }

        $variant->delete();

        return redirect()->route('admin.products.variants', $productId)
            ->with('success', 'Xóa biến thể sản phẩm thành công!');
    }
}
