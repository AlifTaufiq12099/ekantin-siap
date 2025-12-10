@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <h4>Tambah Data Keuangan (Lapak Saya)</h4>
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('penjual.keuangan.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Tanggal</label>
                <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal') }}">
                @error('tanggal') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Jenis Transaksi</label>
                <input type="text" name="jenis_transaksi" class="form-control @error('jenis_transaksi') is-invalid @enderror" value="{{ old('jenis_transaksi') }}" placeholder="Pemasukan / Pengeluaran">
                @error('jenis_transaksi') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Jumlah Uang *</label>
                <input type="number" step="0.01" name="jumlah_uang" class="form-control @error('jumlah_uang') is-invalid @enderror" value="{{ old('jumlah_uang', 0) }}" required>
                @error('jumlah_uang') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan') }}</textarea>
                @error('keterangan') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <button class="btn btn-primary">Simpan</button>
            <a href="{{ route('penjual.keuangan.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
