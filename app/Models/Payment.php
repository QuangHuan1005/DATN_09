<?php
// app/Models/Payment.php
namespace App\Models;
use App\Models\PaymentMethod;
use App\Models\Order;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';
    protected $fillable = ['order_id', 'payment_method_id', 'payment_code', 'payment_amount', 'status'];

    // public function method()
    // {
    //     return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    // }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function paymentMethod()
    {
        // cột khóa ngoại trong bảng payments là payment_method_id
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }
    
}
