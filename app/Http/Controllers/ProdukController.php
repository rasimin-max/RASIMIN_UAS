<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * Menampilkan semua produk pada halaman dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Ambil semua data produk dari tabel 'produk'
        $produk = Produk::all();

        // Kirim data ke view 'produk.index'
        return view('produk.index', compact('produk'));
    }
}

