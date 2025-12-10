@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- Header -->
    <div class="mb-6">
        <a href="{{ route('admin.menus.index') }}" class="text-orange-500 hover:text-orange-600 font-semibold mb-4 inline-block">
            ← Kembali ke Menu
        </a>
        <h2 class="text-3xl font-bold text-gray-800">Buat Menu Baru</h2>
        <p class="text-gray-600">Tambahkan menu baru ke sistem</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl shadow-md p-6">
        <form method="POST" action="{{ route('admin.menus.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Left Column -->
                <div class="space-y-6">
                    <!-- Menu Icon Header -->
                    <div class="flex items-center space-x-4 pb-6 border-b-2 border-gray-100">
                        <div class="w-16 h-16 bg-gradient-to-br from-orange-400 to-pink-500 rounded-full flex items-center justify-center">
                            <span class="text-3xl">🍽️</span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Menu Baru</p>
                            <p class="font-bold text-gray-800 text-lg">Informasi Menu</p>
                        </div>
                    </div>

                    <!-- Nama Menu -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Nama Menu <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="nama_menu"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-orange-500 focus:outline-none @error('nama_menu') border-red-500 @enderror"
                               value="{{ old('nama_menu') }}"
                               placeholder="Contoh: Nasi Goreng Spesial"
                               required>
                        @error('nama_menu')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                        <textarea name="deskripsi"
                                  rows="4"
                                  class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-orange-500 focus:outline-none @error('deskripsi') border-red-500 @enderror"
                                  placeholder="Deskripsi menu yang menggugah selera...">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Harga & Stok -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Harga <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-semibold">Rp</span>
                                <input type="number"
                                       step="0.01"
                                       name="harga"
                                       class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-orange-500 focus:outline-none @error('harga') border-red-500 @enderror"
                                       value="{{ old('harga', 0) }}"
                                       required>
                            </div>
                            @error('harga')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Stok</label>
                            <input type="number"
                                   name="stok"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-orange-500 focus:outline-none @error('stok') border-red-500 @enderror"
                                   value="{{ old('stok', 0) }}"
                                   placeholder="0">
                            @error('stok')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori</label>
                        <select name="kategori" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-orange-500 focus:outline-none @error('kategori') border-red-500 @enderror">
                            <option value="">-- Pilih Kategori --</option>
                            <option value="makanan" {{ old('kategori') == 'makanan' ? 'selected' : '' }}>🍽️ Makanan</option>
                            <option value="minuman" {{ old('kategori') == 'minuman' ? 'selected' : '' }}>🥤 Minuman</option>
                            <option value="snack" {{ old('kategori') == 'snack' ? 'selected' : '' }}>🍪 Snack</option>
                        </select>
                        @error('kategori')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Lapak -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Lapak</label>
                        <select name="lapak_id" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-orange-500 focus:outline-none @error('lapak_id') border-red-500 @enderror">
                            <option value="">-- Pilih Lapak --</option>
                            @foreach(\App\Models\Lapak::all() as $lapak)
                                <option value="{{ $lapak->lapak_id }}" {{ old('lapak_id') == $lapak->lapak_id ? 'selected' : '' }}>
                                    {{ $lapak->nama_lapak ?? 'Lapak #'.$lapak->lapak_id }}
                                </option>
                            @endforeach
                        </select>
                        @error('lapak_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-sm text-gray-500 mt-2">💡 Pilih lapak untuk menu ini</p>
                    </div>
                </div>

                <!-- Right Column - Upload Foto -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Foto Menu</label>

                    <!-- Preview Box (Hidden by default) -->
                    <div class="mb-4 hidden" id="preview-box">
                        <div class="border-2 border-green-500 rounded-xl overflow-hidden">
                            <img src=""
                                 alt="Preview"
                                 class="w-full h-64 object-cover"
                                 id="preview-image">
                        </div>
                        <p class="text-sm text-green-600 mt-2">✨ Preview foto</p>
                    </div>

                    <!-- Placeholder (shown by default) -->
                    <div class="mb-4" id="placeholder-box">
                        <div class="border-2 border-dashed border-gray-300 rounded-xl p-12 text-center bg-gray-50">
                            <span class="text-6xl mb-3 block opacity-30">📷</span>
                            <p class="text-gray-500">Belum ada foto dipilih</p>
                        </div>
                    </div>

                    <!-- File Input -->
                    <div class="mb-4">
                        <label class="block w-full cursor-pointer">
                            <div class="border-2 border-dashed border-orange-300 rounded-xl p-6 text-center hover:border-orange-500 hover:bg-orange-50 transition">
                                <span class="text-2xl mb-2 block">📁</span>
                                <span class="text-orange-500 font-semibold">Klik untuk upload foto</span>
                                <p class="text-sm text-gray-500 mt-1">JPG, PNG - Max 2MB</p>
                            </div>
                            <input type="file"
                                   name="image"
                                   id="file-input"
                                   accept="image/*"
                                   class="hidden"
                                   onchange="showPreview(this)">
                        </label>
                        @error('image')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Info Box -->
                    <div class="bg-blue-50 border-2 border-blue-200 rounded-xl p-4">
                        <div class="flex items-start space-x-3">
                            <span class="text-2xl">💡</span>
                            <div>
                                <p class="font-semibold text-blue-800 mb-1">Tips Foto Menu</p>
                                <ul class="text-sm text-blue-700 space-y-1">
                                    <li>• Gunakan foto dengan pencahayaan baik</li>
                                    <li>• Tampilkan menu secara menarik</li>
                                    <li>• Foto akan otomatis dioptimasi</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Success Preview Box -->
            <div class="mt-6 bg-gradient-to-br from-green-50 to-emerald-50 border-2 border-green-200 rounded-xl p-5">
                <div class="flex items-center space-x-3">
                    <span class="text-3xl">🎉</span>
                    <div>
                        <p class="font-semibold text-green-800">Menu Siap Dijual!</p>
                        <p class="text-sm text-green-700">Setelah disimpan, menu akan langsung tersedia untuk pelanggan</p>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="border-t-2 border-gray-100 mt-8 pt-6 flex gap-3">
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-orange-500 to-pink-500 text-white rounded-xl font-semibold hover:shadow-lg transition">
                    💾 Simpan Menu
                </button>
                <a href="{{ route('admin.menus.index') }}" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-300 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function showPreview(input) {
    const previewBox = document.getElementById('preview-box');
    const previewImage = document.getElementById('preview-image');
    const placeholderBox = document.getElementById('placeholder-box');

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            previewImage.src = e.target.result;
            previewBox.classList.remove('hidden');
            placeholderBox.classList.add('hidden');
        }

        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
