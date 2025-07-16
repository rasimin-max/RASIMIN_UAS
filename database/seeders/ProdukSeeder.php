<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProdukSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('produk')->insert([
            [
                'nama' => 'Sepatu Safety Red',
                'harga' => 250000,
                'gambar' => 'red.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'Sepatu Safety Hitam',
                'harga' => 300000,
                'gambar' => 'hitam.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'Sepatu Safety Stylish',
                'harga' => 275000,
                'gambar' => 'stylish.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}

