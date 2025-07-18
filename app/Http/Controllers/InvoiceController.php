<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class InvoiceController extends Controller
{
    /**
     * Tampilkan halaman riwayat semua transaksi user.
     */
    public function riwayat()
    {
        // Ambil semua transaksi dengan relasi items dan product
        $transactions = Transaction::with('items.product')->latest()->get();

        return view('invoice.riwayat', compact('transactions'));
        // atau jika view kamu di resources/views/riwayat.blade.php:
        // return view('riwayat', compact('transactions'));
    }

    /**
     * Tampilkan detail invoice untuk satu transaksi berdasarkan ID.
     */
    public function cetakInvoice($id)
    {
        // Cari transaksi berdasarkan ID dan tampilkan relasi produk
        $transaction = Transaction::with('items.product')
            ->findOrFail($id); // pastikan ID valid

        return view('invoice.cetak', compact('transaction'));
        // atau jika view kamu di resources/views/invoice.blade.php:
        // return view('invoice', compact('transaction'));
    }
}

