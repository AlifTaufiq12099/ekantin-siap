<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'E-Kantin') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">E-Kantin</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.users.index') }}">Users</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.menus.index') }}">Menus</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.lapaks.index') }}">Lapaks</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.keuangan.index') }}">Keuangan</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.transaksi.index') }}">Transaksi</a></li>
            </ul>
        </div>
        <div class="d-flex">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn btn-outline-danger">Logout</button>
            </form>
        </div>
    </div>
</nav>
<div class="container mt-4">
    @if(session('key') && session('value'))
        <div class="alert alert-{{ session('key') === 'success' ? 'success' : 'danger' }}">{{ session('value') }}</div>
    @endif

    @yield('content')
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
