@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Laporan Penjualan Bulanan</h2>

    <!-- Pemilihan Bulan -->
    <form method="GET" action="{{ route('penjual.laporan.bulanan') }}" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <input type="month" name="bulan" value="{{ $bulan }}" class="form-control">
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary">Tampilkan</button>
            </div>
        </div>
    </form>

    <!-- Ringkasan Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h6 class="card-title">Total Transaksi</h6>
                    <h3>{{ $totalTransaksiBulan }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h6 class="card-title">Total Penjualan</h6>
                    <h3>Rp {{ number_format($totalPenjualanBulan, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h6 class="card-title">Pemasukan</h6>
                    <h3>Rp {{ number_format($totalKeuanganMasukBulan, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h6 class="card-title">Pengeluaran</h6>
                    <h3>Rp {{ number_format($totalKeuanganKeluarBulan, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab untuk Transaksi & Keuangan -->
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link active" href="#transaksi" data-bs-toggle="tab">Transaksi Bulan Ini</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#keuangan" data-bs-toggle="tab">Keuangan Bulan Ini</a>
        </li>
    </ul>

    <div class="tab-content">
        <!-- Tab Transaksi -->
        <div class="tab-pane fade show active" id="transaksi">
            <h5 class="mb-3">Daftar Transaksi Bulan {{ date('F Y', strtotime($bulan . '-01')) }}</h5>
            @if($transaksiBulan->count() > 0)
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Menu</th>
                            <th>Tanggal & Waktu</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksiBulan as $t)
                            <tr>
                                <td>{{ $t->transaksi_id }}</td>
                                <td>{{ optional($t->user)->name }}</td>
                                <td>{{ optional($t->menu)->nama_menu }}</td>
                                <td>{{ $t->waktu_transaksi->format('d-m-Y H:i') }}</td>
                                <td>{{ $t->jumlah }}</td>
                                <td>Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge bg-{{ $t->status_transaksi == 'selesai' ? 'success' : ($t->status_transaksi == 'dibatalkan' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($t->status_transaksi) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-info">Tidak ada transaksi pada bulan ini.</div>
            @endif
        </div>

        <!-- Tab Keuangan -->
        <div class="tab-pane fade" id="keuangan">
            <h5 class="mb-3">Daftar Keuangan Bulan {{ date('F Y', strtotime($bulan . '-01')) }}</h5>
            @if($keuanganBulan->count() > 0)
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tanggal</th>
                            <th>Jenis</th>
                            <th>Jumlah</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($keuanganBulan as $k)
                            <tr>
                                <td>{{ $k->keuangan_id }}</td>
                                <td>{{ $k->tanggal->format('d-m-Y') }}</td>
                                <td>{{ $k->jenis_transaksi }}</td>
                                <td>Rp {{ number_format($k->jumlah_uang, 0, ',', '.') }}</td>
                                <td>{{ $k->keterangan }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-info">Tidak ada data keuangan pada bulan ini.</div>
            @endif
        </div>
    </div>

    <a href="{{ route('penjual.dashboard') }}" class="btn btn-secondary mt-3">Kembali ke Dashboard</a>
</div>
@endsection
