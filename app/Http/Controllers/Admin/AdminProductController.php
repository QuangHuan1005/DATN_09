<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
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
        $products = Product::with(['category'])->withTrashed()->paginate(10);
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
            'image' => 'nullable|image',
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::withTrashed()->findOrFail($id);
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

    //Khôi phục sản phẩm
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
}
