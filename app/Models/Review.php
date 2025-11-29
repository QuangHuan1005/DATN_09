<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'reviews';

    protected $fillable = [
<<<<<<< HEAD
        'order_id',
        'product_id',
        'rating',
        'content',
        'status'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
=======
        'user_id', 'order_id', 'product_id', 'rating', 'content', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
>>>>>>> 067d11aa1ee70cf6b384050e89f5b2daf2e504e8
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
