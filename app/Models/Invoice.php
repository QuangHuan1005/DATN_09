<?php
// app/Models/Invoice.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'invoices';
    protected $fillable = ['order_id', 'invoice_code', 'issue_date', 'created_at', 'updated_at'];

}


