<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Size extends Model
{

    use HasFactory;

    protected $table = 'sizes';

    protected $fillable = [
        'name',
        'size_code',
        'description',
        'status',
    ];

    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'size_id');
    }
}
