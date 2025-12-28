<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderCancelStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'color_class',
    ];
    
    // Nếu bạn không muốn Laravel tự động quản lý timestamps
    // public $timestamps = false; 
    
    // Định nghĩa mối quan hệ (Relational)
    public function cancelRequests()
    {
        return $this->hasMany(OrderCancelRequest::class, 'status_id');
    }
}