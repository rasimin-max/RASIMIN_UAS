<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'total_price',
        'payment_method',
        'status',
    ];

    /**
     * Relasi: 1 transaksi punya banyak item.
     */
    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }
}

