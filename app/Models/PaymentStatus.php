<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentStatus extends Model
{
    protected $table = 'payment_statuses';
    public $timestamps = false;
    protected $fillable = ['name'];
}
