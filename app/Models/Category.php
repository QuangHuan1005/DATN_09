<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // ✅ thêm dòng này

class Category extends Model
{
    use HasFactory, SoftDeletes; // ✅ thêm SoftDeletes vào đây

    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
    ];
}
