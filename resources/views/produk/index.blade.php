<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard E-Commerce</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card-img-top {
            height: 220px;
            object-fit: contain;
        }
    </style>
</head>
<body>
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">TokoKu</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="{{ url('/dashboard') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('keranjang') ? 'active' : '' }}" href="{{ url('/keranjang') }}">Keranjang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('riwayat') ? 'active' : '' }}" href="{{ route('riwayat') }}">Riwayat</a>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link text-danger" style="text-decoration: none;">Keluar</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- Konten --}}
    <div class="container mt-5">
        <h2 class="text-center mb-4">Selamat Datang di Katalog Produk</h2>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row justify-content-center">
            @foreach ($produk as $item)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center shadow-sm">
                        <img src="{{ asset('images/' . $item->gambar) }}" class="card-img-top" alt="{{ $item->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->name }}</h5>
                            <p class="card-text">Rp{{ number_format($item->price, 0, ',', '.') }}</p>
                            <a href="{{ route('cart.beli', $item->id) }}" class="btn btn-danger w-100">Beli</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

