@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <h4>Edit Data Keuangan</h4>
        <form method="POST" action="{{ route('admin.keuangan.update', $item->keuangan_id) }}">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">Lapak (ID)</label>
                <input type="number" name="lapak_id" class="form-control" value="{{ old('lapak_id', $item->lapak_id) }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Tanggal</label>
                <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', $item->tanggal ? $item->tanggal->format('Y-m-d') : '') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Jenis Transaksi</label>
                <input type="text" name="jenis_transaksi" class="form-control" value="{{ old('jenis_transaksi', $item->jenis_transaksi) }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Jumlah Uang</label>
                <input type="number" step="0.01" name="jumlah_uang" class="form-control" value="{{ old('jumlah_uang', $item->jumlah_uang) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <textarea name="keterangan" class="form-control">{{ old('keterangan', $item->keterangan) }}</textarea>
            </div>
            <button class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.keuangan.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
