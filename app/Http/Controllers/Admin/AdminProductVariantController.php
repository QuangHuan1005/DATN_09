<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductVariant;
use App\Models\Product;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Http\Request;

class AdminProductVariantController extends Controller
{
    /**
     * Hiển thị danh sách biến thể của một sản phẩm
     */
    public function index(Request $request)
    {
        // Lấy product_id từ query hoặc route
        $productId = $request->input('product_id');

        // Nếu chưa có product_id thì báo lỗi hoặc redirect
        if (!$productId) {
            return redirect()->back()->with('error', 'Thiếu thông tin sản phẩm.');
        }

        $product = Product::findOrFail($productId);

        $variants = ProductVariant::where('product_id', $productId)->get();

        return view('admin.product_variants.index', compact('product', 'variants'));
    }

    /**
     * Hiển thị form thêm biến thể mới
     */
    public function create(Request $request)
    {
        $productId = $request->input('product_id');
        $product = Product::findOrFail($productId);

        $colors = Color::all();
        $sizes = Size::all();

        return view('admin.product_variants.create', compact('product', 'colors', 'sizes'));
    }

    /**
     * Lưu biến thể mới vào database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'color_id' => 'required|exists:colors,id',
            'size_id' => 'nullable|exists:sizes,id',
            'price' => 'required|numeric|min:0',
            'sale' => 'nullable|numeric|min:0|lt:price',
            'quantity' => 'nullable|integer|min:0',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|max:2048',
        ]);

        // Xử lý upload ảnh nếu có
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->move(public_path('uploads/product_variants'), $filename);
            $validated['image'] = $filename;
        }

        ProductVariant::create($validated);

        return redirect()->route('admin.product_variants.index', ['product_id' => $validated['product_id']])
                         ->with('success', 'Thêm biến thể thành công.');
    }

    /**
     * Hiển thị form sửa biến thể
     */
    public function edit(string $id)
    {
        $variant = ProductVariant::findOrFail($id);

        $product = $variant->product;
        $colors = Color::all();
        $sizes = Size::all();

        return view('admin.product_variants.edit', compact('variant', 'product', 'colors', 'sizes'));
    }

    /**
     * Cập nhật biến thể
     */
    public function update(Request $request, string $id)
    {
        $variant = ProductVariant::findOrFail($id);

        $validated = $request->validate([
            'color_id' => 'required|exists:colors,id',
            'size_id' => 'nullable|exists:sizes,id',
            'price' => 'required|numeric|min:0',
            'sale' => 'nullable|numeric|min:0|lt:price',
            'quantity' => 'nullable|integer|min:0',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|max:2048',
        ]);

        // Xử lý upload ảnh nếu có
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->move(public_path('uploads/product_variants'), $filename);
            $validated['image'] = $filename;

            // Xóa ảnh cũ nếu cần (tuỳ)
            // Storage::delete('uploads/product_variants/' . $variant->image);
        }

        $variant->update($validated);

        return redirect()->route('admin.product_variants.index', ['product_id' => $variant->product_id])
                         ->with('success', 'Cập nhật biến thể thành công.');
    }

    /**
     * Xóa biến thể
     */
    public function destroy(string $id)
    {
        $variant = ProductVariant::findOrFail($id);
        $productId = $variant->product_id;

        // Nếu muốn xóa mềm thì dùng $variant->delete();
        $variant->delete();

        return redirect()->route('admin.product_variants.index', ['product_id' => $productId])
                         ->with('success', 'Xóa biến thể thành công.');
    }
}
