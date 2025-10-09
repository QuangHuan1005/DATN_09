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
     * Show product variants type selection page
     */
    public function variants()
    {
        return view('admin.products.variants-index');
    }

    /**
     * Show specific variant type management page
     */
    public function variantsByType(Request $request, $type)
    {
        if (!in_array($type, ['size', 'color'])) {
            abort(404);
        }

        try {
            $query = ProductVariant::where('type', $type);
            
            // Tìm kiếm nếu có từ khóa
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('value', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            }
            
            // Sắp xếp: mới nhất trước, sau đó theo name
            $variants = $query->orderBy('created_at', 'desc')
                             ->orderBy('name')
                             ->get();
            
            $typeName = $type === 'size' ? 'Kích thước' : 'Màu sắc';
            
            return view('admin.products.variants-list', compact('variants', 'type', 'typeName'));
        } catch (\Exception $e) {
            $variants = collect();
            $typeName = $type === 'size' ? 'Kích thước' : 'Màu sắc';
            return view('admin.products.variants-list', compact('variants', 'type', 'typeName'));
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

        $variant = ProductVariant::create($request->all());

        return redirect()->route('admin.products.variants.type', $variant->type)
            ->with('success', 'Biến thể sản phẩm đã được thêm thành công!');
    }

    /**
     * Show the form for editing a product variant
     */
    public function editVariant(ProductVariant $variant)
    {
        return view('admin.products.edit-variant', compact('variant'));
    }

    /**
     * Update a product variant
     */
    public function updateVariant(Request $request, ProductVariant $variant)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:size,color',
            'value' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive'
        ]);

        $variant->update($request->all());

        return redirect()->route('admin.products.variants.type', $variant->type)
            ->with('success', 'Biến thể sản phẩm đã được cập nhật thành công!');
    }

    /**
     * Delete a product variant
     */
    public function destroyVariant(ProductVariant $variant)
    {
        $type = $variant->type;
        $variant->delete();

        return redirect()->route('admin.products.variants.type', $type)
            ->with('success', 'Biến thể sản phẩm đã được xóa thành công!');
    }
}
