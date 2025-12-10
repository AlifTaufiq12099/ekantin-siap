@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- Header -->
    <div class="mb-6">
        <a href="{{ route('admin.lapaks.index') }}" class="text-orange-500 hover:text-orange-600 font-semibold mb-4 inline-block">
            ← Kembali ke Daftar Lapak
        </a>
        <h2 class="text-3xl font-bold text-gray-800">Buat Lapak Baru</h2>
        <p class="text-gray-600">Tambahkan lapak penjual baru</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl shadow-md p-6 max-w-2xl">
        <form method="POST" action="{{ route('admin.lapaks.store') }}">
            @csrf

            <div class="space-y-6">
                <!-- Lapak Icon Header -->
                <div class="flex items-center space-x-4 pb-6 border-b-2 border-gray-100">
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-400 to-pink-500 rounded-full flex items-center justify-center">
                        <span class="text-3xl">🏪</span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Lapak Baru</p>
                        <p class="font-bold text-gray-800 text-lg">Informasi Lapak</p>
                    </div>
                </div>

                <!-- Nama Lapak -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Lapak <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">🏪</span>
                        <input type="text"
                               name="nama_lapak"
                               class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-orange-500 focus:outline-none @error('nama_lapak') border-red-500 @enderror"
                               value="{{ old('nama_lapak') }}"
                               placeholder="Contoh: Warung Makan Sederhana"
                               required>
                    </div>
                    @error('nama_lapak')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Pemilik -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Pemilik
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">👤</span>
                        <input type="text"
                               name="pemilik"
                               class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-orange-500 focus:outline-none @error('pemilik') border-red-500 @enderror"
                               value="{{ old('pemilik') }}"
                               placeholder="Nama pemilik lapak">
                    </div>
                    @error('pemilik')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- No HP Pemilik -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        No HP Pemilik
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">📱</span>
                        <input type="text"
                               name="no_hp_pemilik"
                               class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-orange-500 focus:outline-none @error('no_hp_pemilik') border-red-500 @enderror"
                               value="{{ old('no_hp_pemilik') }}"
                               placeholder="08xx xxxx xxxx">
                    </div>
                    @error('no_hp_pemilik')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Info Box -->
                <div class="bg-green-50 border-2 border-green-200 rounded-xl p-4">
                    <div class="flex items-start space-x-3">
                        <span class="text-2xl">✨</span>
                        <div>
                            <p class="font-semibold text-green-800 mb-1">Tips Membuat Lapak</p>
                            <ul class="text-sm text-green-700 space-y-1">
                                <li>• Gunakan nama lapak yang mudah diingat</li>
                                <li>• Pastikan nomor HP aktif untuk komunikasi</li>
                                <li>• Data pemilik dapat diubah kapan saja</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Success Preview Box -->
                <div class="bg-gradient-to-br from-orange-50 to-pink-50 border-2 border-orange-200 rounded-xl p-5">
                    <div class="flex items-center space-x-3">
                        <span class="text-3xl">🎉</span>
                        <div>
                            <p class="font-semibold text-orange-800">Lapak Siap Beroperasi!</p>
                            <p class="text-sm text-orange-700">Setelah dibuat, lapak dapat langsung menerima pesanan</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="border-t-2 border-gray-100 mt-8 pt-6 flex gap-3">
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-orange-500 to-pink-500 text-white rounded-xl font-semibold hover:shadow-lg transition">
                    💾 Buat Lapak
                </button>
                <a href="{{ route('admin.lapaks.index') }}" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-300 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
