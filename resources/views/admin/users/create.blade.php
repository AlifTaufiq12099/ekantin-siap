@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- Header -->
    <div class="mb-6">
        <a href="{{ route('admin.users.index') }}" class="text-orange-500 hover:text-orange-600 font-semibold mb-4 inline-block">
            ← Kembali ke Daftar User
        </a>
        <h2 class="text-3xl font-bold text-gray-800">Buat User Baru</h2>
        <p class="text-gray-600">Tambahkan pengguna atau penjual baru</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl shadow-md p-6 max-w-3xl">
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf

            <div class="space-y-6">
                <!-- User Icon Header -->
                <div class="flex items-center space-x-4 pb-6 border-b-2 border-gray-100">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center">
                        <span class="text-3xl">👤</span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Registrasi Pengguna</p>
                        <p class="font-bold text-gray-800 text-lg">Informasi Akun</p>
                    </div>
                </div>

                <!-- Nama -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           name="nama"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-orange-500 focus:outline-none @error('nama') border-red-500 @enderror"
                           value="{{ old('nama') }}"
                           placeholder="Masukkan nama lengkap"
                           required>
                    @error('nama')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">📧</span>
                        <input type="email"
                               name="email"
                               class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-orange-500 focus:outline-none @error('email') border-red-500 @enderror"
                               value="{{ old('email') }}"
                               placeholder="user@example.com"
                               required>
                    </div>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">🔒</span>
                        <input type="password"
                               name="password"
                               class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-orange-500 focus:outline-none @error('password') border-red-500 @enderror"
                               placeholder="Minimal 8 karakter"
                               required>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Toggle Penjual -->
                <div class="bg-gradient-to-br from-orange-50 to-pink-50 border-2 border-orange-200 rounded-xl p-5">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox"
                               id="is_penjual"
                               name="is_penjual"
                               value="1"
                               class="w-5 h-5 text-orange-500 rounded border-gray-300 focus:ring-orange-500"
                               {{ old('is_penjual') ? 'checked' : '' }}>
                        <div class="ml-4">
                            <span class="font-semibold text-gray-800 text-lg">🏪 Daftarkan sebagai Penjual</span>
                            <p class="text-sm text-gray-600 mt-1">User ini akan memiliki akses untuk mengelola lapak dan menu</p>
                        </div>
                    </label>
                </div>

                <!-- Lapak Fields (Hidden by default) -->
                <div id="lapak-fields" style="display: none;">
                    <div class="border-t-2 border-gray-100 pt-6">
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                                <span class="text-2xl">🏪</span>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-800">Informasi Lapak</h3>
                                <p class="text-sm text-gray-600">Data lapak untuk penjual</p>
                            </div>
                        </div>

                        <div class="space-y-4 bg-gray-50 rounded-xl p-5">
                            <!-- Nama Lapak -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nama Lapak
                                </label>
                                <input type="text"
                                       name="nama_lapak"
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-orange-500 focus:outline-none bg-white @error('nama_lapak') border-red-500 @enderror"
                                       value="{{ old('nama_lapak') }}"
                                       placeholder="Contoh: Lapak Bu Siti">
                                @error('nama_lapak')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Pemilik -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nama Pemilik Lapak
                                </label>
                                <input type="text"
                                       name="pemilik"
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-orange-500 focus:outline-none bg-white @error('pemilik') border-red-500 @enderror"
                                       value="{{ old('pemilik') }}"
                                       placeholder="Nama pemilik">
                                @error('pemilik')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- No HP -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    No HP Pemilik
                                </label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">📱</span>
                                    <input type="text"
                                           name="no_hp_pemilik"
                                           class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-orange-500 focus:outline-none bg-white @error('no_hp_pemilik') border-red-500 @enderror"
                                           value="{{ old('no_hp_pemilik') }}"
                                           placeholder="08xxxxxxxxxx">
                                </div>
                                @error('no_hp_pemilik')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Info Box -->
                <div class="bg-blue-50 border-2 border-blue-200 rounded-xl p-4">
                    <div class="flex items-start space-x-3">
                        <span class="text-2xl">ℹ️</span>
                        <div>
                            <p class="font-semibold text-blue-800 mb-1">Catatan</p>
                            <ul class="text-sm text-blue-700 space-y-1">
                                <li>• Password minimal 8 karakter</li>
                                <li>• Email akan digunakan untuk login</li>
                                <li>• Jika sebagai penjual, data lapak wajib diisi</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="border-t-2 border-gray-100 mt-8 pt-6 flex gap-3">
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-orange-500 to-pink-500 text-white rounded-xl font-semibold hover:shadow-lg transition">
                    💾 Simpan User
                </button>
                <a href="{{ route('admin.users.index') }}" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-300 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
(function(){
    const checkbox = document.getElementById('is_penjual');
    const lapakFields = document.getElementById('lapak-fields');

    function toggleLapakFields(){
        if (checkbox.checked) {
            lapakFields.style.display = 'block';
            // Smooth animation
            lapakFields.style.animation = 'fadeIn 0.3s ease-in';
        } else {
            lapakFields.style.display = 'none';
        }
    }

    checkbox.addEventListener('change', toggleLapakFields);

    // Initial check on page load
    toggleLapakFields();

    // Add fade-in animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    `;
    document.head.appendChild(style);
})();
</script>
@endsection
