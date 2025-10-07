<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('variants')->get();
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive'
        ]);

        Product::create($request->all());

        return redirect()->route('admin.products.index')
            ->with('success', 'Sản phẩm đã được thêm thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive'
        ]);

        $product->update($request->all());

        return redirect()->route('admin.products.index')
            ->with('success', 'Sản phẩm đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Sản phẩm đã được xóa thành công!');
    }

    /**
     * Show product variants management page
     */
    public function variants()
    {
        try {
            $variants = ProductVariant::orderBy('type')->orderBy('name')->get();
            $sizeVariants = $variants->where('type', 'size');
            $colorVariants = $variants->where('type', 'color');
            
            return view('admin.products.variants', compact('sizeVariants', 'colorVariants'));
        } catch (\Exception $e) {
            // Nếu có lỗi, trả về view với dữ liệu rỗng
            $sizeVariants = collect();
            $colorVariants = collect();
            return view('admin.products.variants', compact('sizeVariants', 'colorVariants'));
        }
    }

    /**
     * Store a new product variant
     */
    public function storeVariant(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:size,color',
            'value' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive'
        ]);

        ProductVariant::create($request->all());

        return redirect()->route('admin.products.variants')
            ->with('success', 'Biến thể sản phẩm đã được thêm thành công!');
    }

    /**
     * Delete a product variant
     */
    public function destroyVariant(ProductVariant $variant)
    {
        $variant->delete();

        return redirect()->route('admin.products.variants')
            ->with('success', 'Biến thể sản phẩm đã được xóa thành công!');
    }
}
