<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Produk;

class Cart extends Model
{
    protected $table = 'carts';
    protected $fillable = ['product_id', 'quantity', 'added_at'];

    public $timestamps = true; // Karena ada created_at dan updated_at

    // Relasi: satu cart berelasi ke satu produk
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'product_id');
    }
}

