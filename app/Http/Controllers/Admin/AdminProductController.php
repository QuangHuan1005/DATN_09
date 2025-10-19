<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminProductController extends Controller
{
    /**
     * Hiển thị danh sách sản phẩm, bao gồm cả soft deleted
     */
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

    /**
     * Form tạo sản phẩm mới
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Lưu sản phẩm mới
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id'  => 'required|exists:categories,id',
            'product_code' => 'required|unique:products,product_code',
            'name'         => 'required|string|max:255',
            'description'  => 'nullable|string',
            'image'        => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Thêm sản phẩm thành công!');
    }

    /**
     * Hiển thị chi tiết sản phẩm
     */
    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    /**
     * Form chỉnh sửa sản phẩm (kể cả soft deleted)
     */
    public function edit(Product $product)
    {
        $product = Product::withTrashed()->findOrFail($product->id);
        $categories = Category::all();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Cập nhật sản phẩm
     */
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

        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công!');
    }

    /**
     * Xóa mềm sản phẩm
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->onpage = 0;
        $product->save();
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được ẩn.');
    }

    /**
     * Khôi phục sản phẩm đã xóa mềm
     */
    public function restore($id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        $product->restore();
        $product->onpage = 1;
        $product->save();

        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được hiển thị lại.');
    }

    /* ==============================
       QUẢN LÝ BIẾN THỂ SẢN PHẨM
    ============================== */

    /**
     * Trang quản lý biến thể sản phẩm tổng quan
     */
    public function variants()
    {
        return view('admin.products.variants-index');
    }

    /**
     * Lấy danh sách biến thể theo loại (size hoặc color) kèm tìm kiếm
     */
    public function variantsByType(Request $request, $type)
    {
        if (!in_array($type, ['size', 'color'])) {
            abort(404);
        }

        $query = ProductVariant::where('type', $type);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('value', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $variants = $query->orderBy('created_at', 'desc')
            ->orderBy('name')
            ->get();

        $typeName = $type === 'size' ? 'Kích thước' : 'Màu sắc';

        return view('admin.products.variants-list', compact('variants', 'type', 'typeName'));
    }

    /**
     * Lưu biến thể sản phẩm mới
     */
    public function storeVariant(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'type'        => 'required|in:size,color',
            'value'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|in:active,inactive',
        ]);

        $variant = ProductVariant::create($validated);

        return redirect()->route('admin.products.variants.type', $variant->type)
            ->with('success', 'Biến thể sản phẩm đã được thêm thành công!');
    }

    /**
     * Form chỉnh sửa biến thể
     */
    public function editVariant(ProductVariant $variant)
    {
        return view('admin.products.edit-variant', compact('variant'));
    }

    /**
     * Cập nhật biến thể sản phẩm
     */
    public function updateVariant(Request $request, ProductVariant $variant)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'type'        => 'required|in:size,color',
            'value'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|in:active,inactive',
        ]);

        $variant->update($validated);

        return redirect()->route('admin.products.variants.type', $variant->type)
            ->with('success', 'Biến thể sản phẩm đã được cập nhật thành công!');
    }

    /**
     * Xóa biến thể sản phẩm
     */
    public function destroyVariant(ProductVariant $variant)
    {
        $type = $variant->type;
        $variant->delete();

        return redirect()->route('admin.products.variants.type', $type)
            ->with('success', 'Biến thể sản phẩm đã được xóa thành công!');
    }
}
