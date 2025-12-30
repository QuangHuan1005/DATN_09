<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderReturn;
use App\Models\UserBankAccount;
use App\Models\OrderStatusLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage; // Đã thêm để xử lý Storage

class OrderReturnController extends Controller
{
    /**
     * Form tạo yêu cầu hoàn hàng (Trả hàng)
     */
    public function create(Order $order)
    {
        // 1. Kiểm tra quyền sở hữu
        if ($order->user_id !== Auth::id()) abort(403);

        // 2. Kiểm tra trạng thái: Chỉ 4 (Đã giao) hoặc 5 (Hoàn thành) mới được trả hàng
        if (!in_array((int)$order->order_status_id, [4, 5])) {
            return redirect()->route('orders.show', $order->id)
                             ->with('error', 'Đơn hàng không ở trạng thái cho phép hoàn hàng (Phải đã giao hàng).');
        }

        // 3. Kiểm tra xem đã tồn tại yêu cầu trả hàng chưa
        $existingReturn = OrderReturn::where('order_id', $order->id)->first();
        if ($existingReturn) {
            return redirect()->route('orders.show', $order->id)
                             ->with('error', 'Bạn đã gửi yêu cầu hoàn hàng cho đơn này rồi.');
        }

        // 4. Group sản phẩm để khách chọn số lượng
        $groupedDetails = $order->details->groupBy('product_variant_id')->map(function ($items) {
            $firstItem = $items->first();
            return (object)[
                'product_variant_id' => $firstItem->product_variant_id,
                'product_name'       => $firstItem->productVariant->product->name ?? 'Sản phẩm',
                'variant_label'      => ($firstItem->productVariant->color->name ?? '') . ' - ' . ($firstItem->productVariant->size->name ?? ''),
                'price'              => $firstItem->price,
                'max_quantity'       => $items->sum('quantity'),
                'image'              => $firstItem->productVariant->image ?? $firstItem->productVariant->product->image,
            ];
        });

        // 5. Lấy danh sách tài khoản ngân hàng để hoàn tiền
        $userBankAccounts = UserBankAccount::where('user_id', Auth::id())
                                           ->orderBy('is_default', 'desc')
                                           ->get();

        return view('orders.return.create', compact('order', 'groupedDetails', 'userBankAccounts'));
    }

    /**
     * Lưu yêu cầu hoàn hàng vào Database
     */
    public function store(Request $request, Order $order)
    {
        $request->validate([
            'reason'            => 'required|string',
            'refund_account_id' => 'required|exists:user_bank_accounts,id',
            'variant_ids'       => 'required|array',
            'quantities'        => 'required|array',
            'images'            => 'required|array|min:1',
            'images.*'          => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        DB::beginTransaction();
        try {
            // 1. Xử lý upload ảnh minh chứng vào storage/app/public/refunds
            $imagePaths = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    // Lưu file vào storage/app/public/refunds
                    $path = $image->store('refunds', 'public');
                    $imagePaths[] = $path;
                }
            }

            // 2. Tính toán chi tiết sản phẩm và tiền hoàn
            $productDetails = [];
            $totalRefundAmount = 0;

            foreach ($request->variant_ids as $variantId) {
                $inputQty = (int) ($request->quantities[$variantId] ?? 0);
                if ($inputQty <= 0) continue;

                $detail = $order->details->where('product_variant_id', $variantId)->first();
                if (!$detail) continue;

                $lineTotal = (int)($detail->price * $inputQty);
                $productDetails[] = [
                    'product_variant_id' => $variantId,
                    'product_name'       => $detail->productVariant->product->name ?? 'Sản phẩm',
                    'quantity'           => $inputQty,
                    'price'              => (int)$detail->price,
                    'total'              => $lineTotal
                ];
                
                $totalRefundAmount += $lineTotal;
            }

            // 3. LƯU VÀO DB
            OrderReturn::create([
                'order_id'          => $order->id,
                'user_id'           => Auth::id(),
                'refund_account_id' => $request->refund_account_id,
                'reason'            => $request->reason,
                'notes'             => $request->description,
                'images'            => json_encode($imagePaths), 
                'product_details'   => json_encode($productDetails),
                'status'            => OrderReturn::STATUS_PENDING,
                'refund_amount'     => $totalRefundAmount,
                'return_date'       => now()
            ]);

            // 4. Chuyển trạng thái Đơn hàng sang Hoàn hàng (ID: 7)
            $order->order_status_id = 7;

            // 5. Thu hồi điểm tích lũy (Tỷ lệ 100đ = 1 điểm)
            $pointsToDeduct = (int) floor($order->subtotal / 100);
            if ($pointsToDeduct > 0) {
                DB::table('users')
                    ->where('id', Auth::id())
                    ->update([
                        'points' => DB::raw("GREATEST(0, CAST(points AS SIGNED) - $pointsToDeduct)")
                    ]);
                
                $order->note = ($order->note ? $order->note . " | " : "") . "THU HOI: -$pointsToDeduct CP (Tra hang)";
            }

            $order->save();

            // 6. Ghi log lịch sử trạng thái
            OrderStatusLog::create([
                'order_id'        => $order->id,
                'order_status_id' => 7,
                'actor_type'      => 'user',
                'note'            => 'Khách hàng gửi yêu cầu Trả hàng / Hoàn tiền. Lý do: ' . $request->reason
            ]);

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
        
        $productDetails = is_string($return->product_details) 
            ? json_decode($return->product_details, true) 
            : $return->product_details;

        return view('orders.return.show', compact('return', 'productDetails'));
    }
}