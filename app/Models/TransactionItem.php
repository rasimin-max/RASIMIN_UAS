<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Transaction;
use App\Models\Produk; // GANTI dari Product ke Produk

class TransactionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'product_id',
        'qty',
        'price',
        'subtotal',
    ];

    // Relasi ke tabel transactions
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    // Relasi ke tabel produk
    public function product()
    {
        return $this->belongsTo(Produk::class, 'product_id'); // GANTI Product::class ke Produk::class
    }
}

