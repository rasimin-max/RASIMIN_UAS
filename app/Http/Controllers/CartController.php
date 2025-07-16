<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
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
            $lastPaymentId = null;
            $lastProdukId = null;
            $lastJumlah = null;

            foreach ($cart as $id => $item) {
                $cartId = DB::table('carts')->insertGetId([
                    'product_id' => $id,
                    'quantity' => $item['jumlah'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                $paymentId = Str::uuid()->toString();
                $lastPaymentId = $paymentId;
                $lastProdukId = $id;
                $lastJumlah = $item['jumlah'];

                DB::table('payments')->insert([
                    'payment_id' => $paymentId,
                    'cart_id' => $cartId,
                    'amount' => $item['harga'] * $item['jumlah'],
                    'payment_method' => 'Manual Transfer',
                    'status' => 'Success',
                    'paid_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            DB::commit();
            session()->forget('cart');

            // Ambil data produk dan payment terakhir
            $produk = DB::table('products')->where('id', $lastProdukId)->first();
            $payment = DB::table('payments')->where('payment_id', $lastPaymentId)->first();

            // Simpan data invoice ke session
            session([
                'success' => 'Pembayaran berhasil!',
                'invoice_id' => $lastPaymentId,
                'invoice_data' => (object)[
                    'payment_id' => $payment->payment_id,
                    'name' => $produk->name,
                    'quantity' => $lastJumlah,
                    'amount' => $payment->amount,
                    'payment_method' => $payment->payment_method,
                    'status' => $payment->status,
                    'paid_at' => $payment->paid_at,
                ]
            ]);

            return redirect('/riwayat');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan data pembayaran: ' . $e->getMessage());
        }
    }
}

