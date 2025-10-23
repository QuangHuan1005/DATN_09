<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $table = 'vouchers';
    protected $fillable = [
        'voucher_code','quantity','total_used','user_limit','sale_price','min_order_value',
        'start_date','end_date','status','description'
    ];
}
