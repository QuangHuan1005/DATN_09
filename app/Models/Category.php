<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 
class Category extends Model
{
    use HasFactory;


    protected $table = 'categories';

    protected $fillable = ['parent_id', 'name', 'slug', 'description'];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }

    use HasFactory, SoftDeletes; // ✅ thêm SoftDeletes vào đây

    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
    ];
}
