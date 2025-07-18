<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\InvoiceController;

Route::get('/', [UserAuthController::class, 'showLogin'])->name('login');
Route::get('/login', [UserAuthController::class, 'showLogin'])->name('login.form');
Route::post('/login', [UserAuthController::class, 'login'])->name('login.process');
Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [ProdukController::class, 'index'])->name('dashboard');

    // Keranjang
    Route::get('/keranjang', [CartController::class, 'index'])->name('cart.tampil');
    Route::get('/keranjang/beli/{id}', [CartController::class, 'beli'])->name('cart.beli');
    Route::get('/keranjang/hapus/{id}', [CartController::class, 'hapus'])->name('cart.hapus');
    Route::post('/keranjang/update', [CartController::class, 'update'])->name('cart.update');

    // Checkout & Pembayaran
    Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::get('/payment', [CartController::class, 'payment'])->name('payment');
    Route::post('/payment/proses', [CartController::class, 'prosesPayment'])->name('payment.proses');

    // Riwayat & Cetak Invoice
    Route::get('/riwayat', [InvoiceController::class, 'riwayat'])->name('riwayat');
    Route::get('/invoice/{id}', [InvoiceController::class, 'cetakInvoice'])->name('invoice.cetak');

});

