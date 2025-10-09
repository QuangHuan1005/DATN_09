<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all(); // Lấy tất cả sản phẩm từ cơ sở dữ liệu
        return view('products.index', compact('products')); // Truyền dữ liệu vào view
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
{
    $product = Product::with('category')->findOrFail($id);
    $variants = $product->variants()->with(['color', 'size'])->get();
    $albums = $product->photoAlbums;
    $reviews = $product->reviews()->latest()->get();

    return view('products.show', compact('product', 'variants', 'albums', 'reviews'));
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
