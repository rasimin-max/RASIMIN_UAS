<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Cart;

class Payment extends Model
{
    protected $table = 'payments';
    protected $primaryKey = 'payment_id'; // Karena primary key bukan "id"
    public $incrementing = false; // Karena pakai UUID, bukan auto-increment

    protected $fillable = [
        'payment_id',
        'cart_id',
        'amount',
        'payment_method',
        'status',
        'paid_at',
    ];

    public $timestamps = true;

    // Relasi: satu payment berelasi ke satu cart
    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }
}

