<?php
// app/Models/Payment.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';
    protected $fillable = ['order_id','payment_method_id','payment_code','payment_amount','status'];

    public function method() { return $this->belongsTo(PaymentMethod::class, 'payment_method_id'); }
}
    