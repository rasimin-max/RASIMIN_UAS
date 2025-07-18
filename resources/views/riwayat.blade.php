@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Riwayat Transaksi</h3>

    {{-- Tombol ke Beranda --}}
    <a href="{{ route('dashboard') }}" class="btn btn-primary mb-3">🏠 Beranda</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Invoice</th>
                <th>Produk</th>
                <th>Total</th>
                <th>Metode</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->invoice_number }}</td>
                    <td>
                        <ul>
                            @foreach ($transaction->items as $item)
                                <li>{{ $item->product->name }} x {{ $item->qty }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>Rp{{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                    <td>{{ $transaction->payment_method }}</td>
                    <td>{{ $transaction->status }}</td>
                    <td>{{ $transaction->created_at->format('d-m-Y H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Belum ada transaksi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

