<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'value',
        'description',
        'status'
    ];

    protected $casts = [
        'status' => 'string'
    ];

    // Scope để lấy biến thể theo loại
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Scope để lấy biến thể đang hoạt động
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Accessor để hiển thị trạng thái
    public function getStatusTextAttribute()
    {
        return $this->status === 'active' ? 'Hoạt động' : 'Không hoạt động';
    }

    // Accessor để hiển thị loại biến thể
    public function getTypeTextAttribute()
    {
        return $this->type === 'size' ? 'Kích thước' : 'Màu sắc';
    }
}