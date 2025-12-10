<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPhotoAlbum extends Model
{
    use HasFactory;

    protected $table = 'product_photo_albums';

<<<<<<< HEAD
    protected $fillable = [
        'product_id',
        'image'
    ];
=======
    protected $fillable = ['product_id', 'image'];
>>>>>>> origin/phong

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
