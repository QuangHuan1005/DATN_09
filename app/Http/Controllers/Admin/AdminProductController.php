<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;


class AdminProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
$products = Product::with(['category', 'variants'])
    ->withTrashed()
    ->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
$categories = Category::all();
return view('admin.products.create', compact('categories'));

    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    $validated = $request->validate([
        'category_id' => 'required|exists:categories,id',
        'product_code' => 'required|unique:products,product_code',
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'status' => 'required|in:active,inactive',
        'image' => 'nullable|image|max:2048',
    ]);

    if ($request->hasFile('image')) {
        $validated['image'] = $request->file('image')->store('products', 'public');
    }

    Product::create($validated);

    return redirect()->route('admin.products.index')->with('success', 'Thêm sản phẩm thành công!');
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
    $product = Product::withTrashed()->findOrFail($product->id);
    $categories = Category::all();
    return view('admin.products.edit', compact('product', 'categories'));
}


    /**
     * Update the specified resource in storage.
     */
  public function update(Request $request, Product $product)
{
    $validated = $request->validate([
        'category_id'   => 'required|exists:categories,id',
        'name'          => 'required|string|max:255',
        'description'   => 'nullable|string',
        'material'      => 'nullable|string|max:150',
        'onpage'        => 'required|boolean',
        'image'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    // Cập nhật ảnh nếu có
    if ($request->hasFile('image')) {
        if ($product->image && Storage::exists('public/' . $product->image)) {
            Storage::delete('public/' . $product->image);
        }
        $validated['image'] = $request->file('image')->store('products', 'public');
    }

    $product->update($validated);

    return redirect()
        ->route('admin.products.index')
        ->with('success', 'Cập nhật sản phẩm thành công!');
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

    return redirect()
        ->route('admin.products.index')
        ->with('success', 'Sản phẩm đã được ẩn.');
}

/**
 * Khôi phục sản phẩm
 */
public function restore($id)
{
    $product = Product::withTrashed()->findOrFail($id);
    $product->restore();
    $product->onpage = 1;
    $product->save();

    return redirect()
        ->route('admin.products.index')
        ->with('success', 'Sản phẩm đã được hiển thị lại.');
}

/* ==============================
   QUẢN LÝ BIẾN THỂ SẢN PHẨM
============================== */

public function variants()
{
    return view('admin.products.variants-index');
}

public function variantsByType(Request $request, $type)
{
    if (!in_array($type, ['size', 'color'])) {
        abort(404);
    }

    try {
        $query = ProductVariant::where('type', $type);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
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

    } catch (\Exception $e) {
        $variants = collect();
        $typeName = $type === 'size' ? 'Kích thước' : 'Màu sắc';
        return view('admin.products.variants-list', compact('variants', 'type', 'typeName'));
    }
}

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

public function editVariant(ProductVariant $variant)
{
    return view('admin.products.edit-variant', compact('variant'));
}

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

public function destroyVariant(ProductVariant $variant)
{
    $type = $variant->type;
    $variant->delete();

    return redirect()->route('admin.products.variants.type', $type)
        ->with('success', 'Biến thể sản phẩm đã được xóa thành công!');
}
