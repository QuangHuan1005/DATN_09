<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\OrderDetail;
use App\Models\OrderStatusLog;
use App\Models\OrderCancelRequest;
use App\Models\User;
use App\Models\OrderStatus;
use App\Models\PaymentStatus;
use App\Models\PaymentMethod;
use App\Models\Voucher;
use App\Models\Payment;
use App\Models\Invoice;

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
        'note',
        'is_cancel_requested'
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

    // Trạng thái đơn hàng (1-7)
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

    // Lịch sử thay đổi trạng thái
    public function statusLogs()
    {
        return $this->hasMany(OrderStatusLog::class)->orderBy('created_at');
    }

    // Thông tin giao dịch thanh toán
    public function payment()
    {
        return $this->hasOne(Payment::class, 'order_id');
    }

    // Hóa đơn đơn hàng
    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'order_id');
    }
    
    // Yêu cầu hủy đơn hàng
    public function cancelRequest()
    {
        return $this->hasOne(OrderCancelRequest::class, 'order_id')->latestOfMany(); 
    }

    /**
     * =====================
     * 🧠 Logic Accessors
     * =====================
     */

    /**
     * Kiểm tra đơn hàng có thể hủy được hay không
     * Theo DB của bạn: 1=Chờ xác nhận, 2=Xác nhận -> Được hủy
     * 3=Đang giao, 4=Đã giao, 5=Hoàn thành, 6=Hủy, 7=Hoàn hàng -> Không được hủy
     */
    public function getCancelableAttribute(): bool
    {
        // Chỉ cho phép hủy nếu đơn đang ở bước Chờ xác nhận hoặc Đã xác nhận
        $allowedToCancel = [1, 2];

        return in_array($this->order_status_id, $allowedToCancel) 
               && $this->payment_status_id != 3; // Không hủy đơn đang chờ hoàn tiền
    }

    // Kiểm tra đơn đã giao hàng thành công
    public function getIsDeliveredAttribute(): bool
    {
        return $this->order_status_id == 4;
    }

    // Đơn đã hoàn thành (Khách đã ấn xác nhận)
    public function getIsCompletedAttribute(): bool
    {
        return $this->order_status_id == 5;
    }

    // Tổng số lượng sản phẩm trong đơn
    public function getTotalQuantityAttribute(): int
    {
        return $this->details->sum('quantity');
    }

    // Tính subtotal (tiền hàng chưa giảm giá)
    public function getCalcSubtotalAttribute(): int
    {
        return $this->details->sum(fn($d) => $d->price * $d->quantity);
    }

    // Định dạng ngày tháng hiển thị
    public function getFormattedDateAttribute(): string
    {
        return $this->created_at ? $this->created_at->format('d/m/Y H:i') : '';
    }

    /**
     * =====================
     * 🔍 Query Scopes
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