<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionItem;

class CheckoutController extends Controller
{
    public function bayar()
    {
        $cart = session('cart', []);

        // Hitung total belanja
        $total = collect($cart)->sum(function ($item) {
            return $item['harga'] * $item['jumlah'];
        });

        // Simpan transaksi utama
        $transaction = Transaction::create([
            'invoice_number' => 'INV-' . now()->format('Ymd-His'),
            'total_price' => $total,
            'payment_method' => 'Manual Transfer',
            'status' => 'Success',
        ]);

        // Simpan detail produk (items)
        foreach ($cart as $productId => $item) {
            TransactionItem::create([
                'transaction_id' => $transaction->id,
                'product_id' => $productId,
                'qty' => $item['jumlah'],
                'price' => $item['harga'],
                'subtotal' => $item['jumlah'] * $item['harga'],
            ]);
        }

        // Hapus session cart
        session()->forget('cart');

        return redirect()->route('riwayat')->with('success', 'Pembayaran berhasil!');
    }
}

