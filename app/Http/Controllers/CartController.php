<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductVariant;

class CartController extends Controller
{
    // Nếu muốn bắt buộc đăng nhập:
    // public function __construct() { $this->middleware('auth'); }

    public function add(Request $req)
    {
        $data = $req->validate([
            'product_id'         => ['required','integer'],
            'product_variant_id' => ['required','exists:product_variants,id'],
            'quantity'           => ['required','integer','min:1'],
        ]);

        $variant = ProductVariant::with(['product','color','size'])->findOrFail($data['product_variant_id']);
        $price   = $variant->sale ?? $variant->price;

        // --- Option A: Lưu trên SESSION (nhanh, không cần bảng Cart)
        $cart = session()->get('cart', []);

        $key = (string)$variant->id; // mỗi biến thể là 1 dòng
        if (!isset($cart[$key])) {
            $cart[$key] = [
                'product_id'   => $variant->product_id,
                'variant_id'   => $variant->id,
                'name'         => $variant->product->name ?? 'Sản phẩm',
                'color'        => $variant->color->name ?? null,
                'size'         => $variant->size->name ?? null,
                'price'        => $price,
                'quantity'     => 0,
                'image'        => $variant->image,
            ];
        }
        $cart[$key]['quantity'] += (int)$data['quantity'];

        session()->put('cart', $cart);

        return back()->with('success', 'Đã thêm vào giỏ hàng');
    }

    public function index()
    {
        $cart = session('cart', []);
        return view('cart.index', compact('cart'));
    }

    public function remove($variantId)
    {
        $cart = session('cart', []);
        unset($cart[(string)$variantId]);
        session()->put('cart', $cart);
        return back()->with('success', 'Đã xóa sản phẩm khỏi giỏ');
    }

    public function updateQty(Request $req, $variantId)
    {
        $data = $req->validate(['quantity' => ['required','integer','min:1']]);
        $cart = session('cart', []);
        if (isset($cart[(string)$variantId])) {
            $cart[(string)$variantId]['quantity'] = (int)$data['quantity'];
            session()->put('cart', $cart);
        }
        return back()->with('success', 'Đã cập nhật số lượng');
    }
}
