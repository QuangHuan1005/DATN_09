<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderReturn extends Model
{
    use HasFactory;

    protected $table = 'order_returns';

    protected $fillable = [
        'order_id',
        'user_id',
        'refund_account_id',
        'status',
        'reason',
        'notes',
        'rejection_reason',
        'images',
        'product_details',
        'refund_amount',
        'return_date',
    ];

    protected $casts = [
        'images' => 'array',
        'refund_amount' => 'decimal:2',
        'return_date' => 'date',
    ];

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_WAITING_FOR_RETURN = 'waiting_for_return';
    const STATUS_REJECTED = 'rejected';
    const STATUS_RETURNED = 'returned';
    const STATUS_REFUNDED = 'refunded';
    const STATUS_EXCHANGED = 'exchanged';

    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function refundAccount()
    {
        return $this->belongsTo(UserBankAccount::class, 'refund_account_id');
    }

    public function statusLogs()
    {
        return $this->hasMany(OrderReturnStatusLog::class, 'order_return_id');
    }

    // Accessors
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'Chờ xử lý',
            self::STATUS_APPROVED => 'Đã duyệt',
            self::STATUS_WAITING_FOR_RETURN => 'Chờ người dùng gửi hàng',
            self::STATUS_REJECTED => 'Từ chối',
            self::STATUS_RETURNED => 'Đã trả hàng',
            self::STATUS_REFUNDED => 'Đã hoàn tiền',
            self::STATUS_EXCHANGED => 'Đã đổi hàng',
            default => 'Không xác định',
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'badge-on-hold',
            self::STATUS_APPROVED => 'badge-processing',
            self::STATUS_WAITING_FOR_RETURN => 'badge-processing',
            self::STATUS_REJECTED => 'badge-cancelled',
            self::STATUS_RETURNED => 'badge-shipping',
            self::STATUS_REFUNDED => 'badge-completed',
            self::STATUS_EXCHANGED => 'badge-completed',
            default => 'badge-default',
        };
    }
}
