@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Checkout Pembayaran</h2>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Detail Pembayaran</h5>
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Total</th>
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
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <h4 class="text-end">Total Bayar: <span class="text-success">Rp{{ number_format($total, 0, ',', '.') }}</span></h4>

            {{-- ✅ Ganti ke route yang benar --}}
            <form action="{{ route('payment.proses') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success float-end mt-3">Bayar Sekarang</button>
            </form>
        </div>
    </div>
</div>
@endsection

