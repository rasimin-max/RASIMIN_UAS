<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Keranjang Belanja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        h3 span {
            font-size: 1.5rem;
        }
        table td, table th {
            vertical-align: middle !important;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <h3><span class="me-2">🛒</span>Keranjang Belanja</h3>
        
        <div class="table-responsive mt-4">
            <table class="table table-bordered align-middle text-center shadow-sm">
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
                    @forelse($cart as $id => $item)
                        @php
                            $subTotal = $item['harga'] * $item['jumlah'];
                            $total += $subTotal;
                        @endphp
                        <tr>
                            <td>{{ $item['nama'] }}</td>
                            <td>Rp{{ number_format($item['harga'], 0, ',', '.') }}</td>
                            <td>{{ $item['jumlah'] }}</td>
                            <td>Rp{{ number_format($subTotal, 0, ',', '.') }}</td>
                            <td>
                                <a href="{{ url('/hapus/' . $id) }}" class="btn btn-sm btn-danger">Hapus</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-muted">Keranjang kosong.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4">
            <h5>Total Belanja: <strong class="text-success">Rp{{ number_format($total, 0, ',', '.') }}</strong></h5>
            <div>
                <a href="{{ url('/dashboard') }}" class="btn btn-secondary me-2">← Lanjut Belanja</a>
                <a href="#" class="btn btn-success">Checkout</a> {{-- Checkout belum diimplementasi --}}
            </div>
        </div>
    </div>
</body>
</html>

