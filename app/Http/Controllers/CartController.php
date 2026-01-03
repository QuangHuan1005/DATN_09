<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

// Import Models
use App\Models\ProductVariant;
use App\Models\Category;
use App\Models\Product;
use App\Models\Color;
use App\Models\Size;

class CartController extends Controller
{
    /**
     * Thêm vào giỏ.
     * Cấu trúc giỏ: session('cart')[ (string)$variantId ] = [...]
     */
    public function add(Request $req)
    {
        $data = $req->validate([
            'variant_id'         => ['nullable', 'integer'],
            'product_variant_id' => ['nullable', 'integer'],
            'quantity'           => ['required', 'integer', 'min:1'],
            'product_id'         => ['nullable', 'integer'],
        ]);

        // Lấy variantId từ 1 trong 2 tên field (tương thích form cũ/mới)
        $variantId = $data['variant_id'] ?? $data['product_variant_id'] ?? null;
        
        if (empty($variantId)) {
            return back()->with('error', 'Thiếu biến thể sản phẩm (variant).');
        }

        // Tìm biến thể kèm quan hệ
        $variant = ProductVariant::with(['product', 'color', 'size'])->find($variantId);
        if (!$variant) {
            return back()->with('error', 'Biến thể sản phẩm không tồn tại.');
        }

        $product    = $variant->product;
        $name       = $product->name ?? ('SP #' . ($product->id ?? ''));
        $colorName  = optional($variant->color)->name;
        $sizeName   = optional($variant->size)->name;

        // Tính giá bán: ưu tiên giá sale
        $price = (float) ($variant->sale ?? 0) > 0
            ? (float) $variant->sale
            : (float) ($variant->price ?? 0);

        $qty = (int) $data['quantity'];
        $cart = Session::get('cart', []);
        $key = (string) $variant->id;

        // == KIỂM TRA TỒN KHO ==
        $stock    = max(0, (int) ($variant->quantity ?? 0));
        $existing = isset($cart[$key]) ? (int) ($cart[$key]['quantity'] ?? 0) : 0;
        $canAdd   = max(0, $stock - $existing);

        if ($canAdd <= 0) {
            if ($req->wantsJson() || $req->ajax()) {
                return response()->json([
                    'ok'        => false,
                    'message'   => 'Sản phẩm đã hết hàng hoặc bạn đã đạt số lượng tối đa trong giỏ.',
                    'fixed_qty' => $existing,
                    'max'       => $stock,
                ], 409);
            }
            return back()->with('error', 'Sản phẩm đã hết hàng hoặc bạn đã đạt số lượng tối đa trong giỏ.');
        }

        $limited = false;
        if ($qty > $canAdd) {
            $qty     = $canAdd; 
            $limited = true;
        }

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += $qty;
            $cart[$key]['max_qty']   = $stock;
        } else {
            $cart[$key] = [
                'variant_id' => (int) $variant->id,
                'product_id' => (int) ($product->id ?? 0),
                'name'       => $name,
                'color'      => $colorName,
                'size'       => $sizeName,
                'price'      => $price,
                'quantity'   => $qty,
                'max_qty'    => $stock,
                'image'      => $this->normalizeImageUrl($product, $variant),
                'slug'       => $product->slug ?? null,
            ];
        }

        Session::put('cart', $cart);

        // Tính toán lại thông tin tổng để trả về JSON (nếu AJAX)
        $cartCount = collect($cart)->sum(fn($row) => (int)($row['quantity'] ?? 0));
        $subtotal  = collect($cart)->reduce(function($sum, $row){
            return $sum + (float)($row['price'] ?? 0) * (int)($row['quantity'] ?? 0);
        }, 0);

        if ($req->wantsJson() || $req->ajax()) {
           return response()->json([
                'ok'         => !$limited,
                'message'    => $limited 
                    ? ('Chỉ thêm tối đa do giới hạn tồn kho (còn ' . $stock . ').') 
                    : 'Đã thêm vào giỏ hàng.',
                'cart_count' => $cartCount,
                'subtotal'   => $subtotal,
                'item'       => [
                    'variant_id' => (int) $variant->id,
                    'quantity'   => (int) $cart[$key]['quantity'],
                    'price'      => (float) $cart[$key]['price'],
                    'name'       => $cart[$key]['name'],
                    'image'      => $cart[$key]['image'],
                ]
            ], $limited ? 409 : 200);
        }

        return back()->with('success', 'Đã thêm vào giỏ hàng.');
    }

    /**
     * Hiển thị trang giỏ hàng.
     */
    public function index()
    {
        $cart = Session::get('cart', []);
        $total = 0;
        foreach ($cart as $row) {
            $total += (float)($row['price'] ?? 0) * (int)($row['quantity'] ?? 0);
        }

        // Lấy dữ liệu cho sidebar/layout
        try {
            $categories = Category::orderBy('name')->get();
            $colors     = Color::orderBy('name')->get();
            $sizes      = Size::orderBy('name')->get();
            $products   = Product::latest()->take(8)->get();
        } catch (\Throwable $e) {
            $categories = collect();
            $colors     = collect();
            $sizes      = collect();
            $products   = collect();
        }

        return view('cart.index', compact('cart', 'total', 'categories', 'colors', 'sizes', 'products'));
    }

    /**
     * Xóa sản phẩm khỏi giỏ hàng.
     */
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

    /**
     * Cập nhật số lượng sản phẩm.
     */
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

        $variant = ProductVariant::find($variantId);
        $stock   = $variant ? max(0, (int) $variant->quantity) : 0;
        $prevQty = (int) ($cart[$key]['quantity'] ?? 1);
        $cart[$key]['max_qty'] = $stock; 

        if ($stock <= 0) {
            if ($req->wantsJson() || $req->ajax()) {
                return response()->json([
                    'ok'        => false,
                    'message'   => 'Sản phẩm đã hết hàng.',
                    'fixed_qty' => $prevQty,
                    'max'       => 0,
                ], 409);
            }
            return back()->with('error', 'Sản phẩm đã hết hàng.');
        }

        $limited = false;
        if ($qty > $stock) {
            $qty     = $stock;
            $limited = true;
        }

        $cart[$key]['quantity'] = $qty;
        Session::put('cart', $cart);

        $linePrice = (float)($cart[$key]['price'] ?? 0);
        $lineTotal = $linePrice * (int)$cart[$key]['quantity'];

        $cartTotal = collect($cart)->sum(fn($r) => (float)$r['price'] * (int)$r['quantity']);

        if ($req->wantsJson() || $req->ajax()) {
            return response()->json([
                'ok'            => !$limited,
                'message'       => $limited ? ('Chỉ còn ' . $stock . ' sản phẩm trong kho') : null,
                'line_total'    => $lineTotal,
                'cart_total'    => $cartTotal,
                'grand_total'   => $cartTotal,
                'item_subtotal' => $lineTotal,
                'fixed_qty'     => (int) $cart[$key]['quantity'],
                'max'           => $stock,
            ], $limited ? 409 : 200);
        }

        return back()->with('success', 'Đã cập nhật số lượng');
    }

    /**
     * Alias cho update()
     */
    public function updateQty(Request $req, $variantId)
    {
        return $this->update($req, $variantId);
    }

    /**
     * Chuẩn hóa URL ảnh sản phẩm.
     */
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

        $rel = Str::startsWith($raw, 'storage/') ? Str::after($raw, 'storage/') : $raw;
        $file = basename($rel);
        
        $candidates = array_values(array_unique(array_filter([
            'products/'.$file,
            ltrim($rel, '/'),
            'product_images/'.$file,
        ])));

        // Tìm trong disk public
        foreach ($candidates as $relPath) {
            if (Storage::disk('public')->exists($relPath)) {
                return asset('storage/'.$relPath);
            }
        }

        // Tìm trong thư mục public/ trực tiếp
        foreach ($candidates as $relPath) {
            if (is_file(public_path($relPath))) {
                return asset($relPath);
            }
        }

        return asset('images/placeholder.png');
    }
}