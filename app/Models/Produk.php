<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'products';
    protected $fillable = ['name', 'category', 'price', 'stock', 'description', 'gambar'];
}

