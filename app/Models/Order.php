<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'user_id',
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
        'note'
    ];

    /**
     * =====================
     * 🔗 Trạng thái đơn hàng
     * =====================
     */
    const STATUS_PENDING   = 1; // Chờ xác nhận
    const STATUS_CONFIRMED = 2; // Đã xác nhận
    const STATUS_SHIPPING  = 3; // Đang giao
    const STATUS_DELIVERED = 4; // Đã giao
    const STATUS_DONE      = 5; // Hoàn thành
    const STATUS_CANCEL    = 6; // Hủy
    const STATUS_RETURNED  = 7; // Trả hàng / Hoàn trả


    /**
     * =====================
     * 🔗 Quan hệ (Relationships)
     * =====================
     */

    // Người đặt hàng
    public function user()
    {
        return $this->belongsTo(User::class);
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
     * 🧠 Accessors & Logic
     * =====================
     */

    /**
     * Kiểm tra xem đơn có thể hủy được hay không.
     * - Chỉ khi trạng thái là "Chờ xác nhận" (1) hoặc "Đã xác nhận" (2)
     * - Và trạng thái thanh toán KHÔNG phải "Đã hoàn tiền" (3)
     */
    // Product model
    public function photoAlbums()
    {
        return $this->hasMany(ProductPhotoAlbum::class, 'product_id');
    }

    // ProductPhotoAlbum model
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function getCancelableAttribute(): bool
    {
        return in_array($this->order_status_id, [self::STATUS_PENDING, self::STATUS_CONFIRMED])
            && $this->payment_status_id !== 3;
    }

    /**
     * Kiểm tra xem đơn đã hoàn thành chưa
     */
    public function getIsCompletedAttribute(): bool
    {
        return $this->order_status_id == self::STATUS_DONE;
    }

    /**
     * Tổng số lượng sản phẩm trong đơn
     */
    public function getTotalQuantityAttribute(): int
    {
        return $this->details->sum('quantity');
    }

    /**
     * Tổng tiền tạm tính (subtotal)
     */
    public function getCalcSubtotalAttribute(): int
    {
        return $this->details->sum(function ($d) {
            return $d->price * $d->quantity;
        });
    }

    /**
     * Tổng tiền sau giảm giá
     */
    public function getCalcTotalAttribute(): int
    {
        return $this->total_amount ?? $this->calc_subtotal - $this->discount;
    }

    /**
     * Định dạng ngày tạo (VD: 25/10/2025 14:30)
     */
    public function getFormattedDateAttribute(): string
    {
        return $this->created_at ? $this->created_at->format('d/m/Y H:i') : '';
    }

    /**
     * =====================
     * 🔍 Scope - Truy vấn nhanh
     * =====================
     */

    // Lấy các đơn hàng đang chờ xác nhận
    public function scopePending($query)
    {
        return $query->where('order_status_id', self::STATUS_PENDING);
    }

    // Lấy các đơn hàng đã xác nhận
    public function scopeConfirmed($query)
    {
        return $query->where('order_status_id', self::STATUS_CONFIRMED);
    }

    // Lấy các đơn hàng đang giao
    public function scopeShipping($query)
    {
        return $query->where('order_status_id', self::STATUS_SHIPPING);
    }

    // Lấy các đơn hàng đã giao
    public function scopeDelivered($query)
    {
        return $query->where('order_status_id', self::STATUS_DELIVERED);
    }

    // Lấy các đơn đã hoàn thành
    public function scopeCompleted($query)
    {
        return $query->where('order_status_id', self::STATUS_DONE);
    }

    // Lấy các đơn hàng đã hủy
    public function scopeCanceled($query)
    {
        return $query->where('order_status_id', self::STATUS_CANCEL);
    }

    // Lấy các đơn trả hàng / hoàn trả
    public function scopeReturned($query)
    {
        return $query->where('order_status_id', self::STATUS_RETURNED);
    }
}
