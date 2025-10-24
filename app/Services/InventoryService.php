<?php

namespace App\Services;

use App\Models\ProductVariant;
use App\Models\Order;

class InventoryService
{
    /** Không cho vượt tồn khi thêm/cập nhật giỏ */
    public function allowedQty(int $variantId, int $requested, int $currentInCart = 0): array
    {
        $variant   = ProductVariant::select('id','quantity')->findOrFail($variantId);
        $available = max(0, (int) $variant->quantity);
        $maxAllow  = $available; // đơn giản: chưa giữ chỗ theo giỏ khác

        $newQty = min($requested, $maxAllow);
        $ok     = $requested <= $maxAllow;

        return [
            'ok'        => $ok,
            'allowed'   => $newQty,
            'available' => $available,
            'message'   => $ok ? null : "Chỉ còn {$available} sản phẩm trong kho.",
        ];
    }

    /** Trừ tồn khi đơn chuyển sang xác nhận/giao/hoàn tất (mỗi dòng chỉ trừ 1 lần) */
    public function deductForOrder(Order $order): void
    {
        $order->loadMissing('details.productVariant:id,quantity');

        foreach ($order->details as $d) {
            if ((int)$d->status !== 1) continue; // chỉ xử lý dòng mới (status mặc định = 1)
            $v = $d->productVariant; if (!$v) continue;

            $v->update(['quantity' => max(0, (int)$v->quantity - (int)$d->quantity)]);
            $d->update(['status' => 2]); // đánh dấu đã trừ
        }
    }

    /** Hoàn tồn khi đơn bị hủy/hoàn (mỗi dòng chỉ hoàn 1 lần) */
    public function restoreForOrder(Order $order): void
    {
        $order->loadMissing('details.productVariant:id,quantity');

        foreach ($order->details as $d) {
            if ((int)$d->status !== 2) continue; // chỉ hoàn cho dòng đã trừ
            $v = $d->productVariant; if (!$v) continue;

            $v->update(['quantity' => (int)$v->quantity + (int)$d->quantity]);
            $d->update(['status' => 3]); // đánh dấu đã hoàn
        }
    }
}
