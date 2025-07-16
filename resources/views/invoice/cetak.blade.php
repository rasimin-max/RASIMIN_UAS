@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h4>Invoice Pembayaran</h4>
    <p><strong>ID Pembayaran:</strong> {{ $invoice->payment_id }}</p>
    <p><strong>Nama Produk:</strong> {{ $invoice->name }}</p>
    <p><strong>Jumlah:</strong> {{ $invoice->quantity }}</p>
    <p><strong>Total Bayar:</strong> Rp{{ number_format($invoice->amount, 0, ',', '.') }}</p>
    <p><strong>Metode:</strong> {{ $invoice->payment_method }}</p>
    <p><strong>Status:</strong> {{ $invoice->status }}</p>
    <p><strong>Tanggal:</strong> {{ $invoice->paid_at }}</p>
</div>
@endsection

