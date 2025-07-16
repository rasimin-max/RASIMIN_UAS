@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">🛒 Keranjang Belanja</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if (count($cart) > 0)
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($cart as $id => $item)
                    @php
                        $subtotal = $item['harga'] * $item['jumlah'];
                        $total += $subtotal;
                    @endphp
                    <tr>
                        <td>{{ $item['nama'] }}</td>
                        <td>Rp{{ number_format($item['harga'], 0, ',', '.') }}</td>
                        <td>{{ $item['jumlah'] }}</td>
                        <td>Rp{{ number_format($subtotal, 0, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('cart.hapus', $id) }}" class="btn btn-danger btn-sm">Hapus</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h4 class="text-end">Total Belanja: <span class="text-success">Rp{{ number_format($total, 0, ',', '.') }}</span></h4>

        <div class="d-flex justify-content-between mt-3">
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">← Lanjut Belanja</a>
            <a href="{{ route('cart.checkout') }}" class="btn btn-success">Checkout</a>
        </div>
    @else
        <div class="alert alert-warning">
            Keranjang kosong. Silakan pilih produk terlebih dahulu.
        </div>
        <a href="{{ route('dashboard') }}" class="btn btn-primary">Kembali ke Dashboard</a>
    @endif
</div>
@endsection

