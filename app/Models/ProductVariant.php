<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $table = 'product_variants';

    protected $fillable = [
        'product_id',
        'color_id',
        'size_id',
        'price',
        'sale',
        'image',
        'status',
        'quantity', // ✅ thêm để dùng tồn kho
    ];

    // Ép kiểu số học & tiền tệ
    protected $casts = [
        'price'    => 'decimal:2',
        'sale'     => 'decimal:2',
        'quantity' => 'integer',
        'status'   => 'integer', // DB đang để tinyint
    ];

    // Tự động append các field tính toán ra JSON
    protected $appends = [
        'status_text',
        'final_price',
        'image_url',
        'variant_label',
    ];

    /* =========================
     |  QUAN HỆ
     * ========================= */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id');
    }

    public function size()
    {
        return $this->belongsTo(Size::class, 'size_id');
    }

    /* =========================
     |  SCOPES BẠN ĐÃ CÓ (GIỮ NGUYÊN)
     * ========================= */
    // Scope: lấy biến thể đang hoạt động
    public function scopeActive($query)
    {
        // GIỮ NGUYÊN theo yêu cầu của bạn
        return $query->where('status', 'active');
    }

    /* =========================
     |  ACCESSOR BẠN ĐÃ CÓ (GIỮ NGUYÊN)
     * ========================= */
    // Accessor: hiển thị trạng thái
    public function getStatusTextAttribute()
    {
        // GIỮ NGUYÊN logic hiển thị
        return $this->status === 'active' ? 'Hoạt động' : 'Ngừng bán';
    }

    /* =========================
     |  BỔ SUNG PHỤC VỤ CHI TIẾT ĐƠN HÀNG
     * ========================= */

    // Map DB (int) ↔ model (string) cho status
    public function getStatusAttribute($value)
    {
        // 1 -> 'active', 0/khác -> 'inactive'
        return ((int)$value) === 1 ? 'active' : 'inactive';
    }

    public function setStatusAttribute($value)
    {
        // chấp nhận 'active'/'inactive' hoặc 1/0
        $this->attributes['status'] = ($value === 'active' || (int)$value === 1) ? 1 : 0;
    }

    // Giá áp dụng: sale nếu có, ngược lại price
    public function getFinalPriceAttribute()
    {
        return $this->sale !== null ? $this->sale : $this->price;
    }

    // URL ảnh đầy đủ (ưu tiên storage)
    public function getImageUrlAttribute()
    {
        if (!$this->image) return null;

        // Nếu đã là URL tuyệt đối thì trả luôn
        if (preg_match('~^https?://~i', $this->image)) {
            return $this->image;
        }
        // Ngược lại coi như ảnh lưu trong storage/public
        return asset('storage/' . ltrim($this->image, '/'));
    }

    // Nhãn biến thể gọn: "Màu: Red · Size: M"
    public function getVariantLabelAttribute()
    {
        $parts = [];
        if ($this->color?->name) $parts[] = 'Màu: ' . $this->color->name;
        if ($this->size?->name)  $parts[] = 'Size: ' . $this->size->name;
        return implode(' · ', $parts);
    }

    // % giảm (nếu có sale)
    public function getDiscountPercentAttribute()
    {
        if ($this->sale === null || $this->price <= 0) return 0;
        return round((1 - ($this->sale / $this->price)) * 100);
    }

    /* =========================
     |  SCOPES BỔ SUNG HỮU ÍCH
     * ========================= */
    // Truy vấn đúng với DB status dạng số
    public function scopeActiveFlag($query)
    {
        return $query->where('status', 1);
    }

    public function scopeInStock($query, $min = 1)
    {
        return $query->where('quantity', '>=', $min);
    }

    public function scopeOfProduct($query, $productId)
    {
        return $query->where('product_id', $productId);
    }

    public function scopeColor($query, $colorId)
    {
        return $query->where('color_id', $colorId);
    }

    public function scopeSize($query, $sizeId)
    {
        return $query->where('size_id', $sizeId);
    }
}
