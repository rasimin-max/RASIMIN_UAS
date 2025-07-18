@extends('layouts.app')

@section('content')
<div class="container mt-4" id="invoiceArea">
    <h4>Invoice Pembayaran</h4>
    <p><strong>ID Pembayaran:</strong> {{ $transaction->payment_id }}</p>
    <p><strong>Status:</strong> {{ $transaction->status }}</p>
    <p><strong>Metode Pembayaran:</strong> {{ $transaction->payment_method }}</p>
    <p><strong>Tanggal:</strong> {{ $transaction->created_at->format('d-m-Y H:i') }}</p>
    <hr>
    <h5>Detail Produk:</h5>
    <ul>
        @foreach ($transaction->items as $item)
            <li>{{ $item->product->name }} (x{{ $item->qty }}) - Rp{{ number_format($item->subtotal, 0, ',', '.') }}</li>
        @endforeach
    </ul>
    <hr>
    <p><strong>Total Bayar:</strong> Rp{{ number_format($transaction->total_price, 0, ',', '.') }}</p>

    <div class="mt-4">
        <a href="{{ route('dashboard') }}" class="btn btn-primary">🏠 Kembali ke Beranda</a>
        <button class="btn btn-outline-secondary ms-2" onclick="window.print()">🖨️ Print Invoice</button>
    </div>
</div>
@endsection

