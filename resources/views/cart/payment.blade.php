@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h3>Konfirmasi Pembayaran</h3>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cart as $item)
            <tr>
                <td>{{ $item['nama'] }}</td>
                <td>Rp{{ number_format($item['harga']) }}</td>
                <td>{{ $item['jumlah'] }}</td>
                <td>Rp{{ number_format($item['harga'] * $item['jumlah']) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h5>Total: <strong>Rp{{ number_format($total) }}</strong></h5>

    <form action="{{ route('payment.proses') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-success mt-3">Bayar Sekarang</button>
    </form>
</div>
@endsection

