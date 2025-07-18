<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function beli($id)
    {
        $produk = Produk::findOrFail($id);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['jumlah']++;
        } else {
            $cart[$id] = [
                'nama' => $produk->name,
                'harga' => $produk->price,
                'gambar' => $produk->gambar ?? '',
                'jumlah' => 1
            ];
        }

        session(['cart' => $cart]);
        return redirect('/keranjang')->with('success', 'Produk ditambahkan ke keranjang');
    }

    public function index()
    {
        $cart = session('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['harga'] * $item['jumlah'];
        }

        return view('cart.index', compact('cart', 'total'));
    }

    public function hapus($id)
    {
        $cart = session('cart', []);
        unset($cart[$id]);
        session(['cart' => $cart]);
        return redirect('/keranjang')->with('success', 'Produk dihapus dari keranjang');
    }

    public function update(Request $request)
    {
        $cart = session()->get('cart', []);
        $id = $request->input('id');
        $jumlah = $request->input('jumlah');

        if (isset($cart[$id])) {
            $cart[$id]['jumlah'] = $jumlah;
        }

        session(['cart' => $cart]);
        return redirect('/keranjang')->with('success', 'Jumlah produk diperbarui');
    }

    public function checkout()
    {
        $cart = session('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['harga'] * $item['jumlah'];
        }
        return view('cart.checkout', compact('cart', 'total'));
    }

    public function payment()
    {
        $cart = session('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['harga'] * $item['jumlah'];
        }
        return view('cart.payment', compact('cart', 'total'));
    }

    public function prosesPayment(Request $request)
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect('/keranjang')->with('error', 'Keranjang kosong');
        }

        DB::beginTransaction();
        try {
            $paymentId = Str::uuid();
            $invoice = 'INV-' . strtoupper(Str::random(8));
            $total = 0;

            foreach ($cart as $item) {
                $total += $item['harga'] * $item['jumlah'];
            }

            // Simpan transaksi utama
            $transaction = Transaction::create([
                'payment_id' => $paymentId,
                'invoice_number' => $invoice,
                'total_price' => $total,
                'payment_method' => 'Transfer Bank',
                'status' => 'Lunas',
                'paid_at' => now(),
            ]);

            // Simpan detail produk
            foreach ($cart as $productId => $item) {
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $productId,
                    'qty' => $item['jumlah'],
                    'price' => $item['harga'],
                    'subtotal' => $item['harga'] * $item['jumlah'],
                ]);
            }

            DB::commit();
            session()->forget('cart');
            return redirect('/riwayat')->with('success', 'Pembayaran berhasil!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal proses pembayaran: ' . $e->getMessage());
        }
    }
}

