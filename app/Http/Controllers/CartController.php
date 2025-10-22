<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Models\ProductVariant;
use App\Models\Category;
use App\Models\Product;
use App\Models\Color;
use App\Models\Size;

class CartController extends Controller
{
    // Nếu muốn bắt buộc đăng nhập thì mở middleware:
    // public function __construct() { $this->middleware('auth'); }

    public function add(Request $req)
    {
        $data = $req->validate([
            'variant_id'         => ['nullable', 'integer'],
            'product_variant_id' => ['nullable', 'integer'],
            'quantity'           => ['required', 'integer', 'min:1'],
            'product_id'         => ['nullable', 'integer'],
        ]);

        $variantId = $data['variant_id'] ?? $data['product_variant_id'] ?? null;
        if (empty($variantId)) {
            return back()->with('error', 'Thiếu biến thể sản phẩm (variant).');
        }

        $variant = ProductVariant::with(['product', 'color', 'size'])->find($variantId);
        if (!$variant) {
            return back()->with('error', 'Biến thể sản phẩm không tồn tại.');
        }

        $product   = $variant->product;
        $name      = $product->name ?? ('SP #' . ($product->id ?? ''));
        $colorName = optional($variant->color)->name;
        $sizeName  = optional($variant->size)->name;

        $price = (float) ($variant->sale ?? 0) > 0
            ? (float) $variant->sale
            : (float) ($variant->price ?? 0);

        $qty = (int) $data['quantity'];
        $key = (string) $variant->id;

        $cart = Session::get('cart', []);

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += $qty;
        } else {
            $cart[$key] = [
                'variant_id' => (int) $variant->id,
                'product_id' => (int) ($product->id ?? 0),
                'name'       => $name,
                'color'      => $colorName,
                'size'       => $sizeName,
                'price'      => $price,
                'quantity'   => $qty,
                'image'      => $this->normalizeImageUrl($product, $variant),
                'slug'       => $product->slug ?? null,
            ];
        }

        Session::put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Đã thêm vào giỏ hàng!');
    }

    public function index()
    {
        $cart = Session::get('cart', []);

        $total = 0;
        foreach ($cart as $row) {
            $total += (float)($row['price'] ?? 0) * (int)($row['quantity'] ?? 0);
        }

        try {
            $categories = class_exists(Category::class) ? Category::orderBy('name')->get() : collect();
        } catch (\Throwable $e) {
            $categories = collect();
        }

        try {
            $colors = class_exists(Color::class) ? Color::orderBy('name')->get() : collect();
        } catch (\Throwable $e) {
            $colors = collect();
        }

        try {
            $sizes = class_exists(Size::class) ? Size::orderBy('name')->get() : collect();
        } catch (\Throwable $e) {
            $sizes = collect();
        }

        try {
            $products = class_exists(Product::class) ? Product::latest()->take(8)->get() : collect();
        } catch (\Throwable $e) {
            $products = collect();
        }

        return view('cart.index', [
            'cart'       => $cart,
            'total'      => $total,
            'categories' => $categories,
            'colors'     => $colors,
            'sizes'      => $sizes,
            'products'   => $products,
        ]);
    }

    public function remove($variantId)
    {
        $cart = Session::get('cart', []);
        $key  = (string) $variantId;

        if (isset($cart[$key])) {
            unset($cart[$key]);
            Session::put('cart', $cart);
            return back()->with('success', 'Đã xóa sản phẩm khỏi giỏ');
        }

        return back()->with('error', 'Sản phẩm không tồn tại trong giỏ');
    }

    public function update(Request $req, $variantId)
    {
        $qty = (int) $req->input('quantity', 1);
        if ($qty < 1) $qty = 1;

        $cart = Session::get('cart', []);
        $key  = (string) $variantId;

        if (!isset($cart[$key])) {
            if ($req->wantsJson() || $req->ajax()) {
                return response()->json(['ok' => false, 'message' => 'Sản phẩm không tồn tại trong giỏ'], 404);
            }
            return back()->with('error', 'Sản phẩm không tồn tại trong giỏ');
        }

        $cart[$key]['quantity'] = $qty;
        Session::put('cart', $cart);

        $itemSubtotal = (float)($cart[$key]['price'] ?? 0) * (int)($cart[$key]['quantity'] ?? 0);
        $cartTotal = array_reduce($cart, function ($total, $item) {
            return $total + ((float)($item['price'] ?? 0) * (int)($item['quantity'] ?? 0));
        }, 0);

        if ($req->wantsJson() || $req->ajax()) {
            return response()->json([
                'ok'            => true,
                'item_subtotal' => $itemSubtotal,
                'cart_total'    => $cartTotal,
            ]);
        }

        return back()->with('success', 'Đã cập nhật số lượng');
    }

    public function updateQty(Request $req, $variantId)
    {
        return $this->update($req, $variantId);
    }

    private function normalizeImageUrl($product, $variant = null): string
    {
        $raw = null;
        if ($variant && !empty($variant->image)) {
            $raw = $variant->image;
        } elseif (!empty($product->image)) {
            $raw = $product->image;
        } elseif (!empty($product->images)) {
            $images = is_string($product->images) ? json_decode($product->images, true) : $product->images;
            if (is_array($images)) {
                $first = $images[0] ?? null;
                $raw = is_string($first) ? $first : ($first['url'] ?? null);
            }
        }

        $raw = $raw ? ltrim($raw, '/') : '';

        if ($raw && preg_match('#^https?://#i', $raw)) {
            return $raw;
        }

        $rel = Str::startsWith($raw, 'storage/')
            ? Str::after($raw, 'storage/')
            : $raw;

        $file = basename($rel);
        $candidates = array_values(array_unique(array_filter([
            'products/' . $file,
            ltrim($rel, '/'),
            'product_images/' . $file,
        ])));

        foreach ($candidates as $relPath) {
            if (Storage::disk('public')->exists($relPath)) {
                return asset('storage/' . $relPath);
            }
        }

        foreach ($candidates as $relPath) {
            if (is_file(public_path($relPath))) {
                return asset($relPath);
            }
        }

        return asset('images/placeholder.png');
    }
}
