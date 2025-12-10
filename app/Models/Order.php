<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\OrderStatusLog;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'staff_id',
        'payment_status_id',
        'order_status_id',
        'voucher_id',
        'order_code',
        'name',
        'address',
        'phone',
        'subtotal',
        'discount',
        'total_amount',
        'shipping_fee',
        'grand_total',
        'customer_email',
        'payment_method_id',
        'note'
    ];

    /**
     * =====================
     * 🔗 Relationships
     * =====================
     */

    // Người đặt hàng
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Nhân viên xử lý đơn
    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    // Trạng thái đơn hàng
    public function status()
    {
        return $this->belongsTo(OrderStatus::class, 'order_status_id');
    }

    // Trạng thái thanh toán
    public function paymentStatus()
    {
        return $this->belongsTo(PaymentStatus::class, 'payment_status_id');
    }

    // Phương thức thanh toán
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

    // Mã giảm giá
    public function voucher()
    {
        return $this->belongsTo(Voucher::class, 'voucher_id');
    }

    // Chi tiết đơn hàng
    public function details()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    public function statusLogs()
    {
        return $this->hasMany(OrderStatusLog::class)->orderBy('created_at');
    }

    // Thông tin thanh toán
    public function payment()
    {
        return $this->hasOne(Payment::class, 'order_id');
    }

    // Hóa đơn
    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'order_id');
    }


    /**
     * =====================
     * 🧠 Logic
     * =====================
     */

    // Có thể hủy đơn?
    public function getCancelableAttribute(): bool
    {
        return in_array($this->order_status_id, [1, 2]) && $this->payment_status_id != 3;
    }

    // Đơn đã hoàn thành?
    public function getIsCompletedAttribute(): bool
    {
        return $this->order_status_id == 5;
    }

    // Tổng số lượng sản phẩm
    public function getTotalQuantityAttribute(): int
    {
        return $this->details->sum('quantity');
    }

    // Tính subtotal động
    public function getCalcSubtotalAttribute(): int
    {
        return $this->details->sum(fn($d) => $d->price * $d->quantity);
    }

    // Tổng sau giảm giá
    public function getCalcTotalAttribute(): int
    {
        return $this->grand_total ?? ($this->subtotal - $this->discount + $this->shipping_fee);
    }

    public function getFormattedDateAttribute(): string
    {
        return $this->created_at ? $this->created_at->format('d/m/Y H:i') : '';
    }


    /**
     * =====================
     * 🔍 Scopes
     * =====================
     */

    public function scopePending($query)
    {
        return $query->where('order_status_id', 1);
    }

    public function scopeConfirmed($query)
    {
        return $query->where('order_status_id', 2);
    }

    public function scopeShipping($query)
    {
        return $query->where('order_status_id', 3);
    }

    public function scopeDelivered($query)
    {
        return $query->where('order_status_id', 4);
    }

    public function scopeCompleted($query)
    {
        return $query->where('order_status_id', 5);
    }

    public function scopeCanceled($query)
    {
        return $query->where('order_status_id', 6);
    }

    public function scopeReturned($query)
    {
        return $query->where('order_status_id', 7);
    }
}
