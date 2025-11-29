<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Models\Category;
use App\Models\Product;
use App\Models\Color;
use App\Models\Size;


class CartController extends Controller
{
    // Nếu muốn bắt buộc đăng nhập thì mở middleware:
    // public function __construct() { $this->middleware('auth'); }

    /**
     * Thêm vào giỏ.
     * Giữ nguyên cấu trúc giỏ: session('cart')[ (string)$variantId ] = [...]
     * Chấp nhận cả 'variant_id' hoặc 'product_variant_id' từ form.
     */
    public function add(Request $req)
    {
        $data = $req->validate([
            // Tùy form cũ của bạn, 1 trong 2 field dưới sẽ có:
            'variant_id'         => ['nullable', 'integer'],
            'product_variant_id' => ['nullable', 'integer'],
            'quantity'           => ['required', 'integer', 'min:1'],
            // Giữ lại nếu form có gửi kèm (không bắt buộc ở đây)
            'product_id'         => ['nullable', 'integer'],
            'action_type'        => ['nullable','in:add_to_cart,buy_now'],
        ]);

        // // Lấy variantId từ 1 trong 2 tên field
        // $variantId = $data['variant_id'] ?? $data['product_variant_id'] ?? null;
        // if (empty($variantId)) {
        //     return back()->with('error', 'Thiếu biến thể sản phẩm (variant).');
        // }

        // // Tìm biến thể kèm quan hệ để lấy đủ thông tin
        // $variant = ProductVariant::with(['product', 'color', 'size'])->find($variantId);
        // if (!$variant) {
        //     return back()->with('error', 'Biến thể sản phẩm không tồn tại.');
        // }

        // // Lấy thông tin hiển thị
        // $product    = $variant->product;
        // $name       = $product->name ?? ('SP #' . $product->id ?? '');
        // $colorName  = optional($variant->color)->name;
        // $sizeName   = optional($variant->size)->name;

        // // Giá: ưu tiên sale nếu > 0, else lấy price của variant
        // $price = (float) ($variant->sale ?? 0) > 0
        //     ? (float) $variant->sale
        //     : (float) ($variant->price ?? 0);

        // // Ảnh: nếu dự án của bạn có cột image cho variant thì dùng, không thì dùng ảnh product
        // $imageUrl = $this->normalizeImageUrl($product, $variant);

        // $qty = (int) $data['quantity'];

        // // Lấy giỏ hiện tại
        // $cart = Session::get('cart', []);

        // // Key giỏ HAI LÀ GIỮ NGUYÊN: (string)$variantId
        // $key = (string) $variant->id;

<<<<<<< HEAD
        // if (isset($cart[$key])) {
        //     // Cộng dồn số lượng nếu item đã tồn tại
        //     $cart[$key]['quantity'] += $qty;
        // } else {
        //     $cart[$key] = [
        //         'variant_id' => (int) $variant->id,     // để remove/update theo id cũ không đổi
        //         'product_id' => (int) ($product->id ?? 0),
        //         'name'       => $name,
        //         'color'      => $colorName,
        //         'size'       => $sizeName,
        //         'price'      => $price,
        //         'quantity'   => $qty,
        //         'image'      => $this->normalizeImageUrl($product, $variant),
        //         'slug'       => $product->slug ?? null, // nếu view cart có link về trang chi tiết

        //     ];

        // }
=======
      // == GIỚI HẠN THEO TỒN KHO ==
        $stock    = max(0, (int) ($variant->quantity ?? 0)); // tồn kho của biến thể
        $existing = isset($cart[$key]) ? (int) ($cart[$key]['quantity'] ?? 0) : 0;
        $canAdd   = max(0, $stock - $existing);

        if ($canAdd <= 0) {
            // Hết hàng hoặc đã đạt tối đa trong giỏ
            if ($req->wantsJson() || $req->ajax() || $req->expectsJson()) {
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
            $qty     = $canAdd; // clamp
            $limited = true;
        }

        if (isset($cart[$key])) {
            // Cộng dồn (đã clamp) và đồng bộ max tồn kho cho UI
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
                'max_qty'    => $stock, // <== thêm trường này
                'image'      => $this->normalizeImageUrl($product, $variant),
                'slug'       => $product->slug ?? null,
            ];
        }
>>>>>>> 067d11aa1ee70cf6b384050e89f5b2daf2e504e8

        // Session::put('cart', $cart);

        // // [EDIT] Trả JSON khi là AJAX để không chuyển trang
        // $cartCount = collect($cart)->sum(fn($row) => (int)($row['quantity'] ?? 0));
        // $subtotal  = collect($cart)->reduce(function($sum, $row){
        //     return $sum + (float)($row['price'] ?? 0) * (int)($row['quantity'] ?? 0);
        // }, 0);

<<<<<<< HEAD
        // if ($req->wantsJson() || $req->ajax() || $req->expectsJson()) {
        //     return response()->json([
        //         'ok'         => true,
        //         'message'    => 'Đã thêm vào giỏ hàng.',
        //         'cart_count' => $cartCount,
        //         'subtotal'   => $subtotal,
        //         'item'       => [
        //             'variant_id' => (int) $variant->id,
        //             'quantity'   => (int) $cart[$key]['quantity'],
        //             'price'      => (float) $cart[$key]['price'],
        //             'name'       => $cart[$key]['name'] ?? ($product->name ?? 'Sản phẩm'),
        //             'image'      => $cart[$key]['image'] ?? null,
        //         ]
        //     ]);
        // }
=======
        if ($req->wantsJson() || $req->ajax() || $req->expectsJson()) {
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
                'name'       => $cart[$key]['name'] ?? ($product->name ?? 'Sản phẩm'),
                'image'      => $cart[$key]['image'] ?? null,
            ]
        ], $limited ? 409 : 200);
        }
>>>>>>> 067d11aa1ee70cf6b384050e89f5b2daf2e504e8

        // return back()->with('success', 'Đã thêm vào giỏ hàng.');
        $variant = ProductVariant::with('product')->findOrFail($data['product_variant_id']);

    // Kiểm tra tồn kho
    if ($data['quantity'] > $variant->quantity) {
        return back()->withErrors([
            'quantity' => 'Số lượng vượt quá tồn kho hiện tại.',
        ])->withInput();
    }

    // Thêm vào giỏ (session / database tuỳ bạn)
    // Ví dụ dùng session:
    $cart = session()->get('cart', []);

    $key = $variant->id; // hoặc product_id + variant_id nếu cần

    if (isset($cart[$key])) {
        $cart[$key]['quantity'] += $data['quantity'];
    } else {
        $cart[$key] = [
            'product_id'  => $variant->product_id,
            'variant_id'  => $variant->id,
            'name'        => $variant->product->name,
            'price'       => $variant->sale && $variant->sale > 0
                                ? $variant->sale
                                : $variant->price,
            'quantity'    => $data['quantity'],
            'image'       => $variant->image ?? $variant->product->thumbnail ?? null,
        ];
    }

    session()->put('cart', $cart);

    // Điều hướng theo action_type
    if ($data['action_type'] === 'buy_now') {
        // Ví dụ chuyển thẳng sang trang checkout
        return redirect()->route('checkout.index')
            ->with('success', 'Đã thêm sản phẩm, vui lòng hoàn tất thanh toán.');
    }

    // Mặc định: chỉ thêm vào giỏ hàng
    return redirect()->route('cart.index')
        ->with('success', 'Sản phẩm đã được thêm vào giỏ hàng.');
    }

    /**
     * Trang giỏ hàng.
     * Giữ nguyên: truyền đúng biến $cart như trước.
     */
    public function index()
    {
        $cart = Session::get('cart', []);

        $total = 0;
        foreach ($cart as $row) {
            $total += (float)($row['price'] ?? 0) * (int)($row['quantity'] ?? 0);
        }

        // LẤY DỮ LIỆU CHO LAYOUT (an toàn)
        // Category: phải dùng FQCN có dấu "\" đầu
        try {
            $categories = class_exists(\App\Models\Category::class)
                ? Category::orderBy('name')->get()
                : collect();
        } catch (\Throwable $e) {
            $categories = collect();
        }

        try {
            $colors = class_exists(\App\Models\Color::class)
                ? Color::orderBy('name')->get()
                : collect();
        } catch (\Throwable $e) {
            $colors = collect();
        }

        try {
            $sizes = class_exists(\App\Models\Size::class)
                ? Size::orderBy('name')->get()
                : collect();
        } catch (\Throwable $e) {
            $sizes = collect();
        }

        // Nếu layout cần $products (gợi ý/slider)
        try {
            $products = class_exists(\App\Models\Product::class)
                ? Product::latest()->take(8)->get()
                : collect();
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

    /**
     * Xóa 1 dòng theo variantId (string|int).
     * Giữ nguyên key session là (string)$variantId.
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
     * Cập nhật số lượng theo variantId.
     * Giữ nguyên tên hàm & tham số để không ảnh hưởng route cũ.
     */
    public function update(Request $req, $variantId)
    {
        $qty = (int) $req->input('quantity', 1);
        if ($qty < 1) $qty = 1;

        $cart = Session::get('cart', []);
        $key  = (string) $variantId;

        if (!isset($cart[$key])) {
            if ($req->wantsJson() || $req->ajax() || $req->expectsJson()) {
                return response()->json(['ok' => false, 'message' => 'Sản phẩm không tồn tại trong giỏ'], 404);
            }
            return back()->with('error', 'Sản phẩm không tồn tại trong giỏ');
        }

        // Cập nhật số lượng
        // == CHẶN THEO TỒN KHO KHI CẬP NHẬT ==
        $variant = ProductVariant::find($variantId);
        $stock   = $variant ? max(0, (int) $variant->quantity) : 0;

        $prevQty = (int) ($cart[$key]['quantity'] ?? 1);
        $cart[$key]['max_qty'] = $stock; // đồng bộ cho view

        if ($stock <= 0) {
            // Hết hàng: giữ số cũ và báo lỗi
            if ($req->wantsJson() || $req->ajax() || $req->expectsJson()) {
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
            $qty     = $stock; // clamp về tồn kho
            $limited = true;
        }

        // Cập nhật số lượng (đã clamp)
        $cart[$key]['quantity'] = $qty;
        Session::put('cart', $cart);


        // Tính lại tiền dòng & tổng giỏ (KHÔNG có phí ship)
        $linePrice = (float)($cart[$key]['price'] ?? 0);
        $lineTotal = $linePrice * (int)$cart[$key]['quantity'];

        $cartTotal = 0;
        foreach ($cart as $row) {
            $cartTotal += (float)($row['price'] ?? 0) * (int)($row['quantity'] ?? 0);
        }

        if ($req->wantsJson() || $req->ajax() || $req->expectsJson()) {
          return response()->json([
            'ok'           => !$limited,
            'message'      => $limited ? ('Chỉ còn ' . $stock . ' sản phẩm trong kho') : null,
            'line_total'   => $lineTotal,
            'cart_total'   => $cartTotal,
            'grand_total'  => $cartTotal,
            'item_subtotal'=> $lineTotal,
            'fixed_qty'    => (int) $cart[$key]['quantity'],
            'max'          => $stock,
        ], $limited ? 409 : 200);
        }

        return back()->with('success', 'Đã cập nhật số lượng');
    }


    // Giữ lại hàm cũ để tương thích, cho gọi sang update()
    public function updateQty(Request $req, $variantId)
    {
        return $this->update($req, $variantId);
    }

    private function normalizeImageUrl($product, $variant = null): string
    {
        // 1) Lấy raw: ưu tiên ảnh variant -> ảnh product -> images[0]
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

        // 2) Nếu đã là URL tuyệt đối -> dùng luôn
        if ($raw && preg_match('#^https?://#i', $raw)) {
            return $raw;
        }

        // 3) Bóc 'storage/' nếu có để làm việc với public disk
        $rel = \Illuminate\Support\Str::startsWith($raw, 'storage/')
            ? \Illuminate\Support\Str::after($raw, 'storage/')
            : $raw;

        // 4) Lấy basename và ưu tiên thư mục 'products/'
$file = basename($rel);
        $candidates = array_values(array_unique(array_filter([
            // ưu tiên products/
            'products/'.$file,
            // thử giữ nguyên nếu rel có thư mục sẵn
            ltrim($rel, '/'),
            // thêm product_images/ vì dự án của bạn có thư mục này
            'product_images/'.$file,
        ])));

        // 5) Tìm trên storage/app/public
        foreach ($candidates as $relPath) {
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($relPath)) {
                return asset('storage/'.$relPath);   // => /storage/products/<file>
            }
        }

        // 6) Nếu bạn lỡ để ảnh trực tiếp trong public/
        foreach ($candidates as $relPath) {
            if (is_file(public_path($relPath))) {
                return asset($relPath);
            }
        }

        // 7) Fallback nội bộ
        return asset('images/placeholder.png');
    }



}
