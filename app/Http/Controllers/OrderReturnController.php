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
use Illuminate\Support\Facades\Storage;

class OrderReturnController extends Controller
{
    /**
     * Form tạo yêu cầu hoàn hàng (Trả hàng)
     */
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

        // --- BỔ SUNG: Lấy danh sách ID sản phẩm được áp dụng voucher này ---
        $eligibleProductIds = [];
        if ($order->voucher) {
            // Giả định quan hệ trong Model Voucher là products()
            $eligibleProductIds = $order->voucher->products->pluck('id')->toArray();
        }

        // 4. Group sản phẩm để khách chọn số lượng
        // Thêm trường product_id vào object để View/JS có thể đối soát với eligibleProductIds
        $groupedDetails = $order->details->groupBy('product_variant_id')->map(function ($items) {
            $firstItem = $items->first();
            return (object)[
                'product_variant_id' => $firstItem->product_variant_id,
                'product_id'         => $firstItem->productVariant->product_id, // Lấy ID sản phẩm cha
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

        // TRUYỀN THÊM: eligibleProductIds sang View
        return view('orders.return.create', compact('order', 'groupedDetails', 'userBankAccounts', 'eligibleProductIds'));
    }

    /**
     * Lưu yêu cầu hoàn hàng vào Database với Logic tính toán khấu trừ Voucher
     */
  public function store(Request $request, Order $order)
{
    // 1. Validate dữ liệu đầu vào
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
                // Lưu vào thư mục refunds trong disk public
                $path = $image->store('refunds', 'public');
                $imagePaths[] = $path;
            }
        }

        // 3. LOGIC TÍNH TOÁN THỰC TẾ (KHẤU TRỪ VOUCHER ĐÚNG SẢN PHẨM)
        $productDetails = [];
        $totalRefundAmount = 0;
        
        // Lấy danh sách ID sản phẩm được áp dụng voucher này (nếu có)
        $eligibleProductIds = [];
        if ($order->voucher) {
            // Giả định quan hệ là $order->voucher->products
            $eligibleProductIds = $order->voucher->products->pluck('id')->toArray();
        }
        
        // Tổng số tiền voucher đã sử dụng trong đơn hàng
        $totalOrderDiscount = (float) ($order->discount ?? 0);

        foreach ($request->variant_ids as $variantId) {
            $inputQty = (int) ($request->quantities[$variantId] ?? 0);
            if ($inputQty <= 0) continue;

            // Lấy thông tin chi tiết dòng sản phẩm trong đơn hàng
            $detail = $order->details->where('product_variant_id', $variantId)->first();
            if (!$detail) continue;

            // Giá trị gốc của dòng sản phẩm này (Số lượng hoàn x Đơn giá niêm yết khi mua)
            $itemOriginalTotal = (float) ($detail->price * $inputQty);

            // MẶC ĐỊNH: Không khấu trừ voucher
            $itemVoucherDeduction = 0;

            // KIỂM TRA: Nếu voucher áp dụng cho toàn sàn HOẶC SP này nằm trong danh sách áp dụng
            $isGlobalVoucher = empty($eligibleProductIds);
            $isTargetProduct = in_array($detail->productVariant->product_id, $eligibleProductIds);

            if ($totalOrderDiscount > 0 && ($isGlobalVoucher || $isTargetProduct)) {
                if ($isGlobalVoucher) {
                    // Nếu voucher toàn sàn: Chia tỷ lệ dựa trên tổng đơn chưa giảm
                    $orderSubtotal = $order->subtotal > 0 ? $order->subtotal : 1;
                    $itemVoucherDeduction = ($itemOriginalTotal / $orderSubtotal) * $totalOrderDiscount;
                } else {
                    // Nếu voucher cho sản phẩm cụ thể: Khấu trừ trực tiếp trên sản phẩm đó
                    // Công thức: (Tổng giảm giá / Tổng số lượng SP đó đã mua) * Số lượng khách hoàn trả
                    $totalQtyOfThisProductInOrder = $detail->quantity > 0 ? $detail->quantity : 1; 
                    $itemVoucherDeduction = ($totalOrderDiscount / $totalQtyOfThisProductInOrder) * $inputQty;
                }
            }

            // Tiền hoàn thực tế của dòng sản phẩm = Giá trị gốc - Phần voucher đã hưởng
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

        // 4. LƯU VÀO DATABASE BẢNG YÊU CẦU HOÀN HÀNG
        OrderReturn::create([
            'order_id'          => $order->id,
            'user_id'           => Auth::id(),
            'refund_account_id' => $request->refund_account_id,
            'reason'            => $request->reason,
            'notes'             => $request->notes, // Đã đổi tên khớp với form Request (notes)
            'images'            => json_encode($imagePaths), 
            'product_details'   => json_encode($productDetails),
            'status'            => 'pending',
            'refund_amount'     => round($totalRefundAmount),
            'return_date'       => now()
        ]);

        // 5. Cập nhật trạng thái Đơn hàng sang "Yêu cầu hoàn hàng" (ID: 7)
        $order->order_status_id = 7;

        // 6. Thu hồi điểm tích lũy theo số tiền thực hoàn (Ví dụ: 10.000đ = 1 điểm)
        $pointsToDeduct = (int) floor($totalRefundAmount / 10000);
        if ($pointsToDeduct > 0) {
            $user = Auth::user();
            DB::table('users')
                ->where('id', $user->id)
                ->update([
                    'points' => DB::raw("GREATEST(0, CAST(points AS SIGNED) - $pointsToDeduct)")
                ]);
            
            $order->note = ($order->note ? $order->note . " | " : "") . "THU HOI: -$pointsToDeduct điểm (Hoàn trả hàng)";
        }

        $order->save();

        // 7. Ghi log lịch sử trạng thái đơn hàng
        OrderStatusLog::create([
            'order_id'        => $order->id,
            'order_status_id' => 7,
            'actor_type'      => 'user',
            'actor_id'        => Auth::id(),
            'note'            => 'Gửi yêu cầu Hoàn hàng. Thực nhận (sau khi khấu trừ Voucher): ' . number_format(round($totalRefundAmount)) . 'đ'
        ]);

        DB::commit();
        
        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Gửi yêu cầu hoàn hàng thành công! Tiền hoàn đã được tính dựa trên số tiền thực tế bạn đã thanh toán cho sản phẩm đó.');

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
        // Kiểm tra quyền truy cập
        if ($return->user_id !== Auth::id()) abort(403);
        
        $return->load(['order.details.productVariant', 'refundAccount']);
        
        // Giải mã JSON chi tiết sản phẩm đã được Controller store tính toán
        $productDetails = is_string($return->product_details) 
            ? json_decode($return->product_details, true) 
            : $return->product_details;

        return view('orders.return.show', compact('return', 'productDetails'));
    }

    /**
     * Xác nhận đã nhận tiền từ phía người dùng
     */
    public function confirmReceived($id)
    {
        $return = OrderReturn::findOrFail($id);
        
        // Kiểm tra quyền sở hữu
        if ($return->user_id !== Auth::id()) {
            return back()->with('error', 'Bạn không có quyền thực hiện thao tác này.');
        }

        // Chỉ cho phép xác nhận khi trạng thái là đã hoàn tiền (refunded)
        if ($return->status === 'refunded') {
            $return->update(['status' => 'completed']);
            return back()->with('success', 'Xác nhận đã nhận tiền thành công. Yêu cầu đã hoàn tất!');
        }

        return back()->with('error', 'Trạng thái yêu cầu không hợp lệ.');
    }
}