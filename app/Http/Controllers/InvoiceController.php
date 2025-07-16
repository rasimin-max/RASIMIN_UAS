<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    /**
     * Menampilkan riwayat transaksi.
     */
    public function riwayat()
    {
        $riwayat = DB::table('payments')
            ->join('carts', 'payments.cart_id', '=', 'carts.id')
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->select('payments.*', 'products.name', 'products.price', 'carts.quantity')
            ->orderBy('payments.paid_at', 'desc')
            ->get();

        return view('invoice.riwayat', compact('riwayat'));
    }

    /**
     * Menampilkan invoice berdasarkan ID.
     */
    public function cetakInvoice($payment_id)
    {
        $invoice = DB::table('payments')
            ->join('carts', 'payments.cart_id', '=', 'carts.id')
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->where('payments.payment_id', $payment_id)
            ->select('payments.*', 'products.name', 'carts.quantity')
            ->first();

        if (!$invoice) {
            abort(404, 'Invoice tidak ditemukan');
        }

        return view('invoice.cetak', compact('invoice'));
    }
}

