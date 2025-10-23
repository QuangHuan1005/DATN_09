<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // GET /account/orders
    public function index(Request $request)
    {
        $user = $request->user();

        $orders = Order::query()
            ->with(['status','paymentStatus'])
            ->where('user_id', $user->id)
            ->latest('id')
            ->paginate(10);

        return view('account.orders.index', compact('orders'));
    }

    // GET /account/history  (đã giao/hoàn thành)
    public function history(Request $request)
    {
        $user = $request->user();
        $doneIds = [4,5]; // 4=Đã giao hàng, 5=Hoàn thành

        $orders = Order::query()
            ->with(['status','paymentStatus'])
            ->where('user_id', $user->id)
            ->whereIn('order_status_id', $doneIds)
            ->latest('id')
            ->paginate(10);

        return view('account.orders.history', compact('orders'));
    }

    // GET /account/orders/{order}
    public function show(Request $request, Order $order)
    {
        $this->authorizeOwnership($request->user()->id, $order->user_id);

        $order->load([
            'status','paymentStatus','voucher',
            'payments.method',
            'details.variant.product','details.variant.color','details.variant.size',
            'notifs' => function($q){ $q->latest('created_at'); }
        ]);

        return view('account.orders.show', compact('order'));
    }

    // POST /account/orders/{order}/cancel
    public function cancel(Request $request, Order $order)
    {
        $this->authorizeOwnership($request->user()->id, $order->user_id);

        // Điều kiện hủy:
        // - Chỉ khi trạng thái đang "Chờ xác nhận" (1) hoặc "Xác nhận" (2) và chưa giao.
        // - Nếu đã thanh toán online (payment_status_id=2) thì chuyển sang Hoàn tiền (3).
        if (!in_array($order->order_status_id, [1,2])) {
            return back()->with('error', 'Không thể hủy đơn ở trạng thái hiện tại.');
        }

        DB::transaction(function () use ($order) {
            // 6 = Hủy, 3 = Hoàn tiền (theo bảng của bạn)
            $order->order_status_id = 6;

            if ($order->payment_status_id == 2) {
                // Đã thanh toán: đánh dấu hoàn tiền
                $order->payment_status_id = 3;
                // (Gợi ý) nếu có ví, ghi giao dịch ví tại đây.
            }

            $order->save();
        });

        return redirect()->route('account.orders.show', $order->id)
            ->with('success', 'Đã yêu cầu hủy đơn. Nếu bạn thanh toán online, tiền sẽ được hoàn về ví/hình thức gốc (tuỳ cấu hình).');
    }

    private function authorizeOwnership($authId, $ownerId)
    {
        abort_if($authId !== $ownerId, 404, 'Không tìm thấy đơn hàng');
    }
}
