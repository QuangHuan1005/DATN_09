<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderDetail extends Model
{
    use HasFactory;

    protected $table = 'order_details';

    protected $fillable = [
        'order_id',
        'product_variant_id',
        'price',
        'quantity',
        'status',
        'estimated_delivery'
    ];

    /**
     * =====================
     * 🔗 Quan hệ (Relationships)
     * =====================
     */

    // Chi tiết thuộc về đơn hàng nào
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    // Biến thể sản phẩm (kích thước, màu sắc...)
    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    // Sản phẩm chính (nếu muốn truy cập qua variant)
    public function product()
    {
        return $this->hasOneThrough(
            Product::class, 
            ProductVariant::class, 
            'id',            // Khóa chính ProductVariant
            'id',            // Khóa chính Product
            'product_variant_id', // FK trong OrderDetail
            'product_id'     // FK trong ProductVariant
        );
    }

    /**
     * =====================
     * 🧮 Accessors & Helpers
     * =====================
     */

    // Tổng tiền của dòng sản phẩm (price * quantity)
    public function getTotalPriceAttribute(): float
    {
        return $this->price * $this->quantity;
    }

    // Định dạng ngày giao hàng dự kiến
    public function getFormattedEstimatedDeliveryAttribute(): string
    {
        return $this->estimated_delivery 
            ? date('d/m/Y', strtotime($this->estimated_delivery))
            : 'Chưa xác định';
    }

    // Kiểm tra trạng thái đã giao hay chưa (1 = đang chờ, 2 = đã giao, v.v. tuỳ quy ước)
    public function getIsDeliveredAttribute(): bool
    {
        return $this->status == 2; // ví dụ: 2 = Đã giao
    }

    /**
     * =====================
     * 🔍 Scope - Truy vấn nhanh
     * =====================
     */

    // Lấy các dòng chi tiết chưa giao
    public function scopePending($query)
    {
        return $query->where('status', 1);
    }

    // Lấy các dòng chi tiết đã giao
    public function scopeDelivered($query)
    {
        return $query->where('status', 2);
    }

    // Lấy theo đơn hàng cụ thể
    public function scopeForOrder($query, $orderId)
    {
        return $query->where('order_id', $orderId);
    }
}
