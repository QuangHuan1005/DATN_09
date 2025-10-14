<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role;
use App\Models\Ranking;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    /**
     * Các cột cho phép gán hàng loạt (mass assignment)
     *
     * @var array<int, string>
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
        'is_admin',
    ];

    /**
     * Các cột được ẩn khi trả về dữ liệu (ví dụ JSON)
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_token',
    ];

    /**
     * Kiểu dữ liệu chuyển đổi cho các trường đặc biệt
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean',
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
   // public function ranking()
    //{
      //  return $this->belongsTo(Ranking::class, 'ranking_id');
    //}

    /**
     * Kiểm tra xem user có phải admin không
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->is_admin === true;
    }

    /**
     * Kiểm tra xem user có phải staff không (dựa vào role)
     *
     * @return bool
     */
    public function isStaff(): bool
    {
        return $this->role && $this->role->name === 'staff';
    }
}
