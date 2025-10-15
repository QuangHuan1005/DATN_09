<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    /**
     * Các cột cho phép gán hàng loạt (mass assignment)
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
    ];

    /**
     * Ẩn các cột khi trả về dữ liệu
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_token',
    ];

    /**
     * Kiểu dữ liệu cho các trường đặc biệt
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean',
    ];

    /**
     * Kiểm tra xem user có phải admin không
     */
    public function isAdmin()
    {
        return $this->is_admin === true;
    }

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
        return $this->belongsTo(Ranking::class, 'ranking_id');
    }
}
