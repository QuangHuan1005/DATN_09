<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Role;
use App\Models\Ranking;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'users';

    /**
     * Các cột cho phép gán hàng loạt
     */
    protected $fillable = [
        'role_id',
        'ranking_id',
        'image',
        'username',
        'name',
        'email',
        'phone',
        'password',
        'address',
        'is_verified',
        'verification_token',
        'remember_token',
        'is_locked',
    ];

    /**
     * Các cột bị ẩn khi trả về JSON (API, response, ...)
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
    ];

    /**
     * Quan hệ với bảng roles
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    /**
     * Quan hệ với bảng rankings
     */
    public function ranking()
    {
     //   return $this->belongsTo(Ranking::class, 'ranking_id');
    }

    /**
     * Kiểm tra người dùng có phải admin không (role_id == 1)
     */
    public function isAdmin(): bool
    {
        return $this->role_id === 1;
    }

    /**
     * Kiểm tra người dùng có phải nhân viên không (role.name == 'staff')
     */
    public function isStaff(): bool
    {
        return optional($this->role)->name === 'staff';
    }

    /**
     * Kiểm tra tài khoản có bị khóa không
     */
    public function isLocked(): bool
    {
        return $this->is_locked === true;
    }
    
    
}
