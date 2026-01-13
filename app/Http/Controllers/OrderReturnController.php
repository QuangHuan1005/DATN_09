<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderReturn;
use App\Models\UserBankAccount;
use App\Models\OrderStatusLog;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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

        // --- Lấy danh sách ID sản phẩm được áp dụng voucher này ---
        $eligibleProductIds = [];
        if ($order->voucher) {
            $eligibleProductIds = $order->voucher->products->pluck('id')->toArray();
        }

        // 4. Group sản phẩm để khách chọn số lượng
        $groupedDetails = $order->details->groupBy('product_variant_id')->map(function ($items) {
            $firstItem = $items->first();
            return (object)[
                'product_variant_id' => $firstItem->product_variant_id,
                'product_id'         => $firstItem->productVariant->product_id,
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

        return view('orders.return.create', compact('order', 'groupedDetails', 'userBankAccounts', 'eligibleProductIds'));
    }

    /**
     * Lưu yêu cầu hoàn hàng vào Database với Logic tính toán khấu trừ Voucher
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
        ], [
            'reason.required'            => 'Vui lòng chọn lý do hoàn hàng.',
            'refund_account_id.required' => 'Vui lòng chọn tài khoản nhận tiền hoàn.',
            'variant_ids.required'       => 'Vui lòng chọn ít nhất một sản phẩm để hoàn trả.',
            'images.required'            => 'Vui lòng cung cấp ít nhất 1 hình ảnh minh chứng.',
        ]);

        DB::beginTransaction();
        try {
            // 2. Xử lý upload ảnh minh chứng
            $imagePaths = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('refunds', 'public');
                    $imagePaths[] = $path;
                }
            }

            // 3. LOGIC TÍNH TOÁN (KHẤU TRỪ VOUCHER ĐÚNG SẢN PHẨM)
            $productDetails = [];
            $totalRefundAmount = 0;
            
            $eligibleProductIds = [];
            if ($order->voucher) {
                $eligibleProductIds = $order->voucher->products->pluck('id')->toArray();
            }
            
            $totalOrderDiscount = (float) ($order->discount ?? 0);

            foreach ($request->variant_ids as $variantId) {
                $inputQty = (int) ($request->quantities[$variantId] ?? 0);
                if ($inputQty <= 0) continue;

                $detail = $order->details->where('product_variant_id', $variantId)->first();
                if (!$detail) continue;

                $itemOriginalTotal = (float) ($detail->price * $inputQty);
                $itemVoucherDeduction = 0;

                $isGlobalVoucher = empty($eligibleProductIds);
                $isTargetProduct = in_array($detail->productVariant->product_id, $eligibleProductIds);

                if ($totalOrderDiscount > 0 && ($isGlobalVoucher || $isTargetProduct)) {
                    if ($isGlobalVoucher) {
                        $orderSubtotal = $order->subtotal > 0 ? $order->subtotal : 1;
                        $itemVoucherDeduction = ($itemOriginalTotal / $orderSubtotal) * $totalOrderDiscount;
                    } else {
                        $totalQtyOfThisProductInOrder = $detail->quantity > 0 ? $detail->quantity : 1; 
                        $itemVoucherDeduction = ($totalOrderDiscount / $totalQtyOfThisProductInOrder) * $inputQty;
                    }
                }

                $itemRefundReal = $itemOriginalTotal - $itemVoucherDeduction;

                $productDetails[] = [
                    'product_variant_id' => $variantId,
                    'product_name'       => $detail->productVariant->product->name ?? 'Sản phẩm',
                    'variant_label'      => ($detail->productVariant->color->name ?? '') . ' - ' . ($detail->productVariant->size->name ?? ''),
                    'quantity'           => $inputQty,
                    'original_price'     => (int)$detail->price,
                    'voucher_deduction'  => round($itemVoucherDeduction), 
                    'refund_actual'      => round($itemRefundReal),   
                    'total_original'     => $itemOriginalTotal        
                ];
                
                $totalRefundAmount += $itemRefundReal;
            }

            // 4. LƯU VÀO DATABASE
            $newReturn = OrderReturn::create([
                'order_id'          => $order->id,
                'user_id'           => Auth::id(),
                'refund_account_id' => $request->refund_account_id,
                'reason'            => $request->reason,
                'notes'             => $request->notes, 
                'images'            => json_encode($imagePaths), 
                'product_details'   => json_encode($productDetails),
                'status'            => 'pending',
                'refund_amount'     => round($totalRefundAmount),
                'return_date'       => now()
            ]);

            // 5. Cập nhật trạng thái Đơn hàng sang "Yêu cầu hoàn hàng"
            $order->update(['order_status_id' => 7]);

            // 6. Thu hồi điểm tích lũy
            $pointsToDeduct = (int) floor($totalRefundAmount / 10000);
            if ($pointsToDeduct > 0) {
                DB::table('users')
                    ->where('id', Auth::id())
                    ->update([
                        'points' => DB::raw("GREATEST(0, CAST(points AS SIGNED) - $pointsToDeduct)")
                    ]);
                $order->note = ($order->note ? $order->note . " | " : "") . "THU HOI: -$pointsToDeduct điểm (Hoàn trả hàng)";
                $order->save();
            }

            // 7. Ghi log lịch sử
            OrderStatusLog::create([
                'order_id'        => $order->id,
                'order_status_id' => 7,
                'actor_type'      => 'user',
                'actor_id'        => Auth::id(),
                'note'            => 'Gửi yêu cầu Hoàn hàng. Thực nhận dự kiến: ' . number_format(round($totalRefundAmount)) . 'đ'
            ]);

            DB::commit();
            return redirect()->route('orders.return.show', $newReturn->id)
                ->with('success', 'Gửi yêu cầu hoàn hàng thành công!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Lỗi hoàn hàng tại đơn #{$order->id}: " . $e->getMessage());
            return back()->withInput()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Chi tiết yêu cầu hoàn hàng (Trang Show)
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

    /**
     * Xác nhận đã nhận tiền từ phía người dùng (Bước cuối cùng)
     * Khi khách nhấn nút này: Cập nhật status Hoàn hàng, Status Đơn hàng và CỘNG LẠI KHO
     */
    public function confirmReceived($id)
    {
        $return = OrderReturn::findOrFail($id);
        
        if ($return->user_id !== Auth::id()) {
            return back()->with('error', 'Bạn không có quyền thực hiện thao tác này.');
        }

        // CHỈ cho phép xác nhận khi trạng thái là 'refund_processing' 
        // (Nghĩa là Admin đã chuyển tiền và tải biên lai lên)
        if ($return->status !== 'refund_processing') {
            return back()->with('error', 'Trạng thái yêu cầu hiện tại chưa cho phép xác nhận nhận tiền.');
        }

        DB::beginTransaction();
        try {
            // 1. Cập nhật trạng thái yêu cầu hoàn hàng sang Hoàn tất
            $return->update(['status' => 'completed']);

            // 2. Cập nhật Đơn hàng gốc (Status: Đã hoàn trả, Payment: Đã hoàn tiền)
            $return->order->update([
                'order_status_id' => 7,
                'payment_status_id' => 3 
            ]);

            // 3. LOGIC QUAN TRỌNG: CỘNG LẠI TỒN KHO SẢN PHẨM
            $productDetails = is_string($return->product_details) 
                ? json_decode($return->product_details, true) 
                : $return->product_details;

            if ($productDetails) {
                foreach ($productDetails as $item) {
                    $variantId = $item['product_variant_id'] ?? null;
                    $qty = (int) ($item['quantity'] ?? 0);

                    if ($variantId && $qty > 0) {
                        $variant = ProductVariant::find($variantId);
                        if ($variant) {
                            $variant->increment('quantity', $qty);
                        }
                    } 
                }
            }

            // 4. Ghi log hệ thống
            OrderStatusLog::create([
                'order_id'        => $return->order_id,
                'order_status_id' => 7,
                'actor_type'      => 'user',
                'actor_id'        => Auth::id(),
                'note'            => 'Khách hàng xác nhận đã nhận tiền thành công. Kết thúc quy trình hoàn hàng.'
            ]);

            DB::commit();
            return back()->with('success', 'Xác nhận đã nhận tiền thành công. Yêu cầu đã hoàn tất!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Lỗi xác nhận hoàn tiền ID #{$id}: " . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra trong quá trình xác nhận.');
        }
    }
}