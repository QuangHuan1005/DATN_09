<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     * Cần bao gồm tất cả các cột bạn muốn cho phép gán giá trị (trừ ID và timestamps)
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
    ];

    /**
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        // 'password' => 'hashed',
    ];
    
    // ------------------------------------------------------------------
    // Tùy chọn: Định nghĩa quan hệ (Relationship)
    // ------------------------------------------------------------------
    
    // public function role()
    // {
    //     return $this->belongsTo(Role::class, 'role_id');
    // }

    // public function ranking()
    // {
    //     return $this->belongsTo(Ranking::class, 'ranking_id');
    // }
}