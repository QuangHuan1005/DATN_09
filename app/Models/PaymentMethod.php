<?php
// app/Models/PaymentMethod.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $table = 'payment_methods';
<<<<<<< HEAD
=======
    protected $fillable = ['name'];

>>>>>>> origin/phong
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
