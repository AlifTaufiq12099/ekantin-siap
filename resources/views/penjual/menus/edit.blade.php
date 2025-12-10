@extends('layouts.penjual')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Edit Menu</h1>
            <p class="text-gray-600">Perbarui informasi menu di Lapak Saya</p>
        </div>

        <!-- Error Summary -->
        @if($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-red-500 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <div class="flex-1">
                    <h3 class="text-red-800 font-semibold mb-1">Terdapat beberapa kesalahan:</h3>
                    <ul class="list-disc list-inside text-red-700 space-y-1">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        <!-- Form -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <form method="POST" action="{{ route('penjual.menus.update', $menu->menu_id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="p-6 space-y-6">
                    <!-- Nama Menu -->
                    <div>
                        <label for="nama_menu" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nama Menu <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="nama_menu"
                            id="nama_menu"
                            value="{{ old('nama_menu', $menu->nama_menu) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition @error('nama_menu') border-red-500 @enderror"
                            placeholder="Contoh: Nasi Goreng Spesial"
                            required
                        >
                        @error('nama_menu')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label for="deskripsi" class="block text-sm font-semibold text-gray-700 mb-2">
                            Deskripsi
                        </label>
                        <textarea
                            name="deskripsi"
                            id="deskripsi"
                            rows="4"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition @error('deskripsi') border-red-500 @enderror"
                            placeholder="Jelaskan menu Anda secara detail..."
                        >{{ old('deskripsi', $menu->deskripsi) }}</textarea>
                        @error('deskripsi')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <!-- Harga & Stok (Grid) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Harga -->
                        <div>
                            <label for="harga" class="block text-sm font-semibold text-gray-700 mb-2">
                                Harga <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 font-medium">Rp</span>
                                <input
                                    type="number"
                                    step="0.01"
                                    name="harga"
                                    id="harga"
                                    value="{{ old('harga', $menu->harga) }}"
                                    class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition @error('harga') border-red-500 @enderror"
                                    placeholder="0"
                                    min="0"
                                    required
                                >
                            </div>
                            @error('harga')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <!-- Stok -->
                        <div>
                            <label for="stok" class="block text-sm font-semibold text-gray-700 mb-2">
                                Stok
                            </label>
                            <input
                                type="number"
                                name="stok"
                                id="stok"
                                value="{{ old('stok', $menu->stok) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition @error('stok') border-red-500 @enderror"
                                placeholder="0"
                                min="0"
                            >
                            @error('stok')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label for="kategori" class="block text-sm font-semibold text-gray-700 mb-2">
                            Kategori
                        </label>
                        <select
                            name="kategori"
                            id="kategori"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition @error('kategori') border-red-500 @enderror"
                        >
                            <option value="">Pilih Kategori</option>
                            <option value="makanan" {{ old('kategori', $menu->kategori) == 'makanan' ? 'selected' : '' }}>Makanan</option>
                            <option value="minuman" {{ old('kategori', $menu->kategori) == 'minuman' ? 'selected' : '' }}>Minuman</option>
                            <option value="snack" {{ old('kategori', $menu->kategori) == 'snack' ? 'selected' : '' }}>Snack</option>
                            <option value="dessert" {{ old('kategori', $menu->kategori) == 'dessert' ? 'selected' : '' }}>Dessert</option>
                        </select>
                        @error('kategori')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <!-- Upload Foto -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Foto Menu <span class="text-gray-500 text-xs font-normal">(opsional)</span>
                        </label>

                        <!-- Current Image Preview -->
                        @if(!empty($menu->image))
                        <div class="mb-4 relative group">
                            <img src="{{ asset('storage/'.$menu->image) }}" alt="{{ $menu->nama_menu }}" class="w-full h-64 object-cover rounded-lg shadow-md">
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition rounded-lg flex items-center justify-center">
                                <p class="text-white opacity-0 group-hover:opacity-100 transition font-semibold">Foto saat ini</p>
                            </div>
                        </div>
                        @endif

                        <!-- Upload New Image -->
                        <div class="flex items-center justify-center w-full">
                            <label for="image" class="flex flex-col items-center justify-center w-full h-48 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition @error('image') border-red-500 @enderror">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500">
                                        <span class="font-semibold">{{ !empty($menu->image) ? 'Klik untuk ganti foto' : 'Klik untuk upload' }}</span> atau drag and drop
                                    </p>
                                    <p class="text-xs text-gray-500">PNG, JPG atau JPEG (MAX. 2MB)</p>
                                </div>
                                <input
                                    type="file"
                                    name="image"
                                    id="image"
                                    class="hidden"
                                    accept="image/*"
                                    onchange="previewImage(event)"
                                >
                            </label>
                        </div>
                        <div id="preview" class="mt-4 hidden">
                            <p class="text-sm text-gray-600 mb-2 font-semibold">Preview Foto Baru:</p>
                            <img id="preview-image" class="w-full h-64 object-cover rounded-lg shadow-md" alt="Preview">
                        </div>
                        @error('image')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="bg-gray-50 px-6 py-4 flex flex-col sm:flex-row gap-3 sm:gap-4 justify-end border-t border-gray-200">
                    <a href="{{ route('penjual.menus.index') }}" class="w-full sm:w-auto px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-100 transition text-center">
                        Batal
                    </a>
                    <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-orange-500 text-white font-semibold rounded-lg hover:bg-orange-600 transition shadow-md">
                        <span class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Simpan Perubahan
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewImage(event) {
    const preview = document.getElementById('preview');
    const previewImage = document.getElementById('preview-image');
    const file = event.target.files[0];

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImage.src = e.target.result;
            preview.classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
}
</script>
@endsection
