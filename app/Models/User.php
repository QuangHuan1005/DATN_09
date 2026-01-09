<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Role;
use App\Models\UserAddress;
use App\Models\UserBankAccount;
use App\Models\Product;
use App\Models\Order;
use App\Models\Voucher;
use App\Models\UserVoucher;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'users';

    /**
     * Các cột cho phép gán hàng loạt (Mass Assignment)
     * Đã bỏ 'username' vì dùng Email làm định danh duy nhất.
     */
    protected $fillable = [
        'role_id',
        'ranking_id',
        'image',
        'name',
        'email',
        'phone',
        'password',
        'address',
        'is_verified',
        'verification_token',
        'remember_token',
        'is_locked',
        'points', 
    ];

    /**
     * Các cột bị ẩn khi trả về JSON
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_token',
    ];

    /**
     * Kiểu dữ liệu tự động chuyển đổi
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_verified' => 'boolean',
        'is_locked' => 'boolean',
        'points' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | QUAN HỆ (RELATIONSHIPS)
    |--------------------------------------------------------------------------
    */

    /**
     * Quan hệ với bảng roles (Mỗi user có 1 vai trò)
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    /**
     * Quan hệ với UserAddress (Một user có nhiều địa chỉ)
     */
    public function addresses()
    {
        return $this->hasMany(UserAddress::class);
    }

    /**
     * Lấy địa chỉ mặc định
     */
    public function defaultAddress()
    {
        return $this->hasOne(UserAddress::class)->where('is_default', true);
    }

    /**
     * Quan hệ với UserBankAccount (Lấy 1 tài khoản duy nhất để hiển thị và sửa)
     */
    public function bankAccount()
    {
        return $this->hasOne(UserBankAccount::class, 'user_id');
    }

    /**
     * Quan hệ với UserBankAccount (Nhiều tài khoản)
     */
    public function bankAccounts()
    {
        return $this->hasMany(UserBankAccount::class);
    }

    /**
     * Lấy tài khoản ngân hàng mặc định
     */
    public function defaultBankAccount()
    {
        return $this->hasOne(UserBankAccount::class)->where('is_default', true);
    }

    /**
     * Sản phẩm yêu thích (Nhiều - Nhiều)
     */
    public function favorites()
    {
        return $this->belongsToMany(Product::class, 'product_favorites');
    }

    /**
     * Gán đơn hàng cho nhân viên (Staff)
     */
    public function assignedOrders()
    {
        return $this->hasMany(Order::class, 'staff_id');
    }

    /**
     * Danh sách đơn hàng đã mua
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    /**
     * Voucher mà user đang sở hữu thông qua bảng trung gian
     */
    public function ownedVouchers()
    {
        return $this->belongsToMany(Voucher::class, 'user_vouchers')
                    ->withPivot('status', 'code')
                    ->withTimestamps();
    }

    /**
     * Truy cập trực tiếp bản ghi trong bảng trung gian vouchers
     */
    public function userVouchers()
    {
        return $this->hasMany(UserVoucher::class);
    }

    /*
    |--------------------------------------------------------------------------
    | CÁC HÀM KIỂM TRA (HELPERS)
    |--------------------------------------------------------------------------
    */

    /**
     * Kiểm tra Admin
     */
    public function isAdmin(): bool
    {
        return (int)$this->role_id === 1;
    }

    /**
     * Kiểm tra tài khoản bị khóa
     */
    public function isLocked(): bool
    {
        return $this->is_locked === true;
    }
}