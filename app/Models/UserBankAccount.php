<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserBankAccount extends Model
{
    use HasFactory;

    protected $table = 'user_bank_accounts';

    protected $fillable = [
        'user_id',
        'bank_name',
        'account_number',
        'account_holder',
        'is_default'
    ];

    protected $casts = [
        'is_default' => 'boolean'
    ];

    /**
     * =====================
     * 🔗 Quan hệ (Relationships)
     * =====================
     */

    // Mỗi tài khoản ngân hàng thuộc về một user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * =====================
     * 🧠 Accessors & Logic
     * =====================
     */

    // Ẩn số tài khoản, chỉ hiện 4 số cuối
    public function getMaskedAccountNumberAttribute(): string
    {
        $length = strlen($this->account_number);
        if ($length <= 4) {
            return $this->account_number;
        }
        return str_repeat('*', $length - 4) . substr($this->account_number, -4);
    }

    /**
     * =====================
     * 🔍 Scope - Truy vấn nhanh
     * =====================
     */

    // Lọc tài khoản mặc định
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    // Lọc theo user
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
