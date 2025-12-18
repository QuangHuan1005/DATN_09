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
    // Form tạo yêu cầu
    public function create(Order $order)
    {
        if ($order->user_id !== Auth::id()) abort(403);

        if (!in_array($order->order_status_id, [4, 5])) {
            abort(403, 'Đơn hàng không ở trạng thái cho phép hoàn hàng');
        }

        $existingReturn = OrderReturn::where('order_id', $order->id)->first();
        if ($existingReturn) {
            return redirect()->route('orders.return.show', $existingReturn)
                           ->with('error', 'Bạn đã gửi yêu cầu cho đơn này rồi');
        }

        $groupedDetails = $order->details->groupBy('product_variant_id')->map(function ($items) {
            $firstItem = $items->first();
            return (object)[
                'product_variant_id' => $firstItem->product_variant_id,
                'product_name'       => $firstItem->productVariant->product->name ?? 'Sản phẩm',
                'variant_label'      => ($firstItem->productVariant->color->name ?? '') . ' - ' . ($firstItem->productVariant->size->name ?? ''),
                'price'              => $firstItem->price,
                'max_quantity'       => $items->sum('quantity'),
                'image'              => $firstItem->productVariant->image,
                'detail_ids'         => $items->pluck('id')->toArray(),
            ];
        });

        $userBankAccounts = UserBankAccount::where('user_id', Auth::id())
                                          ->orderBy('is_default', 'desc')
                                          ->get();

        return view('orders.return.create', compact('order', 'groupedDetails', 'userBankAccounts'));
    }

    // Lưu yêu cầu (Đã sửa để luôn có order_detail_id)
    public function store(Request $request, Order $order)
    {
        $request->validate([
            'reason' => 'required|string',
            'refund_account_id' => 'required|exists:user_bank_accounts,id',
            'variant_ids' => 'required|array',
            'quantities' => 'required|array',
        ]);

        DB::beginTransaction();
        try {
            $imagePaths = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = 'uploads/returns/' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('uploads/returns'), basename($path));
                    $imagePaths[] = $path;
                }
            }

            $productDetails = [];
            $refundAmount = 0;

            foreach ($request->variant_ids as $variantId) {
                $inputQty = (int) ($request->quantities[$variantId] ?? 0);
                if ($inputQty <= 0) continue;

                $details = $order->details->where('product_variant_id', $variantId);
                $firstDetail = $details->first();

                if (!$firstDetail) continue;

                $productDetails[] = [
                    'order_detail_id'    => $firstDetail->id, // ĐẢM BẢO LUÔN CÓ
                    'product_variant_id' => $variantId,
                    'product_name'       => $firstDetail->productVariant->product->name ?? 'Sản phẩm',
                    'quantity'           => $inputQty,
                    'price'              => $firstDetail->price,
                    'total'              => $firstDetail->price * $inputQty
                ];
                
                $refundAmount += $firstDetail->price * $inputQty;
            }

            OrderReturn::create([
                'order_id' => $order->id,
                'user_id' => Auth::id(),
                'refund_account_id' => $request->refund_account_id,
                'reason' => $request->reason,
                'notes' => $request->description,
                'images' => json_encode($imagePaths),
                'product_details' => json_encode($productDetails),
                'status' => 'pending',
                'refund_amount' => $refundAmount,
                'return_date' => now()
            ]);

            $order->update(['order_status_id' => 7]);

            DB::commit();
            return redirect()->route('orders.show', $order->id)->with('success', 'Thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    // Hiển thị (Đã sửa để an toàn với dữ liệu cũ)
    public function show(OrderReturn $return)
    {
        if ($return->user_id !== Auth::id()) abort(403);

        $return->load(['order.details.productVariant', 'refundAccount']);
        $productDetails = json_decode($return->product_details, true) ?? [];

        return view('orders.return.show', compact('return', 'productDetails'));
    }
}