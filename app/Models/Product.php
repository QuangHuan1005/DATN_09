<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\OrderDetail;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'product_code',
        'name',
        'image',
        'description',
        'material',
        'onpage',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
