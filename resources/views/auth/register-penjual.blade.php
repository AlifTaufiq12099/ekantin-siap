@extends('layouts.app')

@section('content')
<div class="container d-flex align-items-center justify-content-center min-vh-100">
    <div class="card shadow-sm" style="width:500px">
        <div class="card-body">
            <h4 class="card-title mb-3">Daftar Penjual</h4>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register.penjual') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nama Lengkap *</label>
                    <input type="text" name="nama_penjual" class="form-control @error('nama_penjual') is-invalid @enderror" value="{{ old('nama_penjual') }}" required>
                    @error('nama_penjual') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Email *</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                    @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Password *</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                    @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Konfirmasi Password *</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">No HP</label>
                    <input type="text" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" value="{{ old('no_hp') }}">
                    @error('no_hp') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Pilih Lapak Existing (opsional)</label>
                    <select name="lapak_id" class="form-control @error('lapak_id') is-invalid @enderror">
                        <option value="">-- Atau Buat Lapak Baru --</option>
                        @foreach($lapaks as $lapak)
                            <option value="{{ $lapak->lapak_id }}" {{ old('lapak_id') == $lapak->lapak_id ? 'selected' : '' }}>
                                {{ $lapak->nama_lapak }}
                            </option>
                        @endforeach
                    </select>
                    @error('lapak_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>

                <div id="lapak-baru" style="display:none;">
                    <hr>
                    <h6>Atau Buat Lapak Baru:</h6>
                    <div class="mb-3">
                        <label class="form-label">Nama Lapak</label>
                        <input type="text" name="nama_lapak" class="form-control @error('nama_lapak') is-invalid @enderror" value="{{ old('nama_lapak') }}">
                        @error('nama_lapak') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                <button class="btn btn-primary w-100">Daftar</button>
            </form>

            <hr>
            <p class="text-center text-muted mb-0">
                Sudah punya akun? <a href="{{ route('login.penjual') }}">Login di sini</a>
            </p>
        </div>
    </div>
</div>

<script>
    document.querySelector('select[name="lapak_id"]').addEventListener('change', function() {
        document.getElementById('lapak-baru').style.display = this.value === '' ? 'block' : 'none';
    });
</script>
@endsection
