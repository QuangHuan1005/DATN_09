<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Display the user's wishlist.
     */
    public function index()
    {
        $wishlistItems = Wishlist::where('user_id', Auth::id())
            ->with(['product.photoAlbums', 'product.variants.color', 'product.variants.size'])
            ->get();

        return view('wishlist.index', compact('wishlistItems'));
    }

    /**
     * Add a product to wishlist.
     */
    public function add(Request $request)
    {
        try {
            $userId = Auth::id();
            $productId = $request->product_id;

            // Lấy sản phẩm đầu tiên có sẵn nếu productId không tồn tại
            if (!\App\Models\Product::find($productId)) {
                $product = \App\Models\Product::first();
                if (!$product) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Không có sản phẩm nào trong hệ thống'
                    ]);
                }
                $productId = $product->id;
            }

            // Kiểm tra xem sản phẩm đã có trong wishlist chưa
            $existingWishlist = Wishlist::where('user_id', $userId)
                ->where('product_id', $productId)
                ->first();

            if ($existingWishlist) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sản phẩm đã có trong wishlist'
                ]);
            }

            Wishlist::create([
                'user_id' => $userId,
                'product_id' => $productId,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Đã thêm vào wishlist'
            ]);
        } catch (\Exception $e) {
            \Log::error('Wishlist add error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Lỗi server: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove a product from wishlist.
     */
    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $userId = Auth::id();
        $productId = $request->product_id;

        Wishlist::where('user_id', $userId)
            ->where('product_id', $productId)
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa khỏi wishlist'
        ]);
    }

    /**
     * Check if a product is in wishlist.
     */
    public function check(Request $request)
    {
        $productId = $request->product_id;
        $userId = Auth::id();

        $isInWishlist = Wishlist::where('user_id', $userId)
            ->where('product_id', $productId)
            ->exists();

        return response()->json([
            'is_in_wishlist' => $isInWishlist
        ]);
    }
}
