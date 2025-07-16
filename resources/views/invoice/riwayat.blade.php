@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h3>🧾 Riwayat Transaksi & Invoice</h3>

    {{-- Notifikasi Sukses --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tabel Riwayat Pembayaran --}}
    @if(count($riwayat) > 0)
        <table class="table table-bordered mt-3">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Produk</th>
                    <th>Qty</th>
                    <th>Total</th>
                    <th>Metode</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($riwayat as $r)
                <tr>
                    <td>{{ $r->payment_id }}</td>
                    <td>{{ $r->name }}</td>
                    <td>{{ $r->quantity }}</td>
                    <td>Rp{{ number_format($r->amount, 0, ',', '.') }}</td>
                    <td>{{ $r->payment_method }}</td>
                    <td>{{ $r->status }}</td>
                    <td>{{ $r->paid_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-warning">Belum ada transaksi.</div>
    @endif

    {{-- Detail Invoice Terakhir --}}
    @if(session('invoice_data'))
        @php $invoice = session('invoice_data'); @endphp
        <div class="card mt-5" id="invoice-area">
            <div class="card-header bg-dark text-white">
                <strong>🧾 Invoice Terakhir</strong>
            </div>
            <div class="card-body">
                <p><strong>ID Pembayaran:</strong> {{ $invoice->payment_id }}</p>
                <p><strong>Produk:</strong> {{ $invoice->name }}</p>
                <p><strong>Jumlah:</strong> {{ $invoice->quantity }}</p>
                <p><strong>Total:</strong> Rp{{ number_format($invoice->amount, 0, ',', '.') }}</p>
                <p><strong>Metode:</strong> {{ $invoice->payment_method }}</p>
                <p><strong>Status:</strong> {{ $invoice->status }}</p>
                <p><strong>Tanggal:</strong> {{ $invoice->paid_at }}</p>
            </div>
        </div>

        {{-- Tombol Cetak Invoice --}}
        <button onclick="printInvoice()" class="btn btn-primary mt-3">
            🖨️ Cetak Invoice
        </button>

        <script>
            function printInvoice() {
                const invoiceContent = document.getElementById('invoice-area').innerHTML;
                const printWindow = window.open('', '', 'height=600,width=800');
                printWindow.document.write('<html><head><title>Invoice</title>');
                printWindow.document.write('<style>body{font-family:sans-serif;padding:20px} .card{border:1px solid #ccc;padding:20px}</style>');
                printWindow.document.write('</head><body>');
                printWindow.document.write(invoiceContent);
                printWindow.document.write('</body></html>');
                printWindow.document.close();
                printWindow.print();
            }
        </script>
    @endif

    {{-- Tombol Kembali --}}
    <div class="mt-4">
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">← Kembali ke Katalog</a>
    </div>
</div>
@endsection

