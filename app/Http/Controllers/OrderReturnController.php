<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderReturn;
use App\Models\UserBankAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderReturnController extends Controller
{
    /**
     * Form tạo yêu cầu hoàn hàng
     */
    public function create(Order $order)
    {
        // Kiểm tra quyền sở hữu đơn hàng
        if ($order->user_id !== Auth::id()) abort(403);

        // Chỉ cho phép hoàn hàng nếu đơn đã Giao (4) hoặc Hoàn thành (5)
        if (!in_array((int)$order->order_status_id, [4, 5])) {
            abort(403, 'Đơn hàng không ở trạng thái cho phép hoàn hàng');
        }

        // Kiểm tra xem đã tồn tại yêu cầu cho đơn này chưa
        $existingReturn = OrderReturn::where('order_id', $order->id)->first();
        if ($existingReturn) {
            return redirect()->route('orders.return.show', $existingReturn)
                             ->with('error', 'Bạn đã gửi yêu cầu cho đơn này rồi');
        }

        // Group sản phẩm theo variant để khách chọn số lượng cần trả
        $groupedDetails = $order->details->groupBy('product_variant_id')->map(function ($items) {
            $firstItem = $items->first();
            return (object)[
                'product_variant_id' => $firstItem->product_variant_id,
                'product_name'       => $firstItem->productVariant->product->name ?? 'Sản phẩm',
                'variant_label'      => ($firstItem->productVariant->color->name ?? '') . ' - ' . ($firstItem->productVariant->size->name ?? ''),
                'price'              => $firstItem->price,
                'max_quantity'       => $items->sum('quantity'),
                'image'              => $firstItem->productVariant->image ?? $firstItem->productVariant->product->image,
                'detail_ids'         => $items->pluck('id')->toArray(),
            ];
        });

        $userBankAccounts = UserBankAccount::where('user_id', Auth::id())
                                          ->orderBy('is_default', 'desc')
                                          ->get();

        return view('orders.return.create', compact('order', 'groupedDetails', 'userBankAccounts'));
    }

    /**
     * Lưu yêu cầu hoàn hàng và thực hiện Thu hồi điểm ngay lập tức
     */
    public function store(Request $request, Order $order)
    {
        $request->validate([
            'reason'            => 'required|string',
            'refund_account_id' => 'required|exists:user_bank_accounts,id',
            'variant_ids'       => 'required|array',
            'quantities'        => 'required|array',
        ]);

        DB::beginTransaction();
        try {
            // 1. Xử lý upload ảnh minh chứng (lưu vào public/uploads/returns)
            $imagePaths = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = 'uploads/returns/' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('uploads/returns'), basename($path));
                    $imagePaths[] = $path;
                }
            }

            // 2. Tính toán số tiền hoàn dựa trên sản phẩm khách chọn
            $productDetails = [];
            $refundAmount = 0;

            foreach ($request->variant_ids as $variantId) {
                $inputQty = (int) ($request->quantities[$variantId] ?? 0);
                if ($inputQty <= 0) continue;

                $details = $order->details->where('product_variant_id', $variantId);
                $firstDetail = $details->first();

                if (!$firstDetail) continue;

                $lineTotal = (int)($firstDetail->price * $inputQty);
                $productDetails[] = [
                    'order_detail_id'    => $firstDetail->id,
                    'product_variant_id' => $variantId,
                    'product_name'       => $firstDetail->productVariant->product->name ?? 'Sản phẩm',
                    'quantity'           => $inputQty,
                    'price'              => (int)$firstDetail->price,
                    'total'              => $lineTotal
                ];
                
                $refundAmount += $lineTotal;
            }

            // 3. Lưu thông tin vào bảng order_returns
            OrderReturn::create([
                'order_id'          => $order->id,
                'user_id'           => Auth::id(),
                'refund_account_id' => $request->refund_account_id,
                'reason'            => $request->reason,
                'notes'             => $request->description,
                'images'            => json_encode($imagePaths),
                'product_details'   => json_encode($productDetails),
                'status'            => 'pending',
                'refund_amount'     => $refundAmount,
                'return_date'       => now()
            ]);

            // 4. Cập nhật trạng thái đơn hàng sang Hoàn hàng (ID: 7)
            $order->order_status_id = 7;

            // 5. --- LOGIC THU HỒI ĐIỂM (Tỷ lệ 10.000đ = 1 điểm) ---
           $points = (int) floor($order->subtotal / 100);

            if ($pointsToDeduct > 0) {
                $userId = Auth::id();
                
                // Sử dụng Query Builder trực tiếp để ghi đè mọi rào cản Eloquent
                // GREATEST(0, CAST(points AS SIGNED) - X) đảm bảo không bị âm điểm
                DB::table('users')
                    ->where('id', $userId)
                    ->update([
                        'points' => DB::raw("GREATEST(0, CAST(points AS SIGNED) - $pointsToDeduct)")
                    ]);
                
                // Ghi chú vào Note để Admin và Khách tiện đối soát
                $order->note = ($order->note ? $order->note . " | " : "") . "THU HOI: -$pointsToDeduct CP (Hoan hang)";
            }

            // Lưu thay đổi trạng thái và note cho đơn hàng
            $order->save();

            DB::commit();
            return redirect()->route('orders.show', $order->id)->with('success', 'Gửi yêu cầu hoàn hàng thành công!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Lỗi hoàn hàng tại đơn #{$order->id}: " . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Chi tiết yêu cầu hoàn hàng
     */
    public function show(OrderReturn $return)
    {
        if ($return->user_id !== Auth::id()) abort(403);

        $return->load(['order.details.productVariant', 'refundAccount']);
        $productDetails = json_decode($return->product_details, true) ?? [];

        return view('orders.return.show', compact('return', 'productDetails'));
    }
}