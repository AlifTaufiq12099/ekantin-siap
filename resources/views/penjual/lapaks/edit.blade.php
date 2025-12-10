@extends('layouts.penjual')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Edit Profil Lapak</h1>
            <p class="text-gray-600">Perbarui informasi dan foto profil lapak Anda</p>
        </div>

        <!-- Success Message -->
        @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="text-green-800 font-semibold">{{ session('success') }}</span>
            </div>
        </div>
        @endif

        <!-- Error Message from Session (only show if lapak doesn't exist) -->
        @if(session('key') === 'error' && !$lapak)
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <span class="text-red-800 font-semibold">{{ session('value') }}</span>
            </div>
        </div>
        @endif

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
            <form method="POST" action="{{ route('penjual.lapak.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="p-6 space-y-6">
                    <!-- Foto Profil Lapak -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Foto Profil Lapak
                        </label>
                        <div class="flex flex-col items-center space-y-4">
                            <!-- Preview Foto -->
                            <div class="relative">
                                @if($lapak && $lapak->foto_profil)
                                    <img id="preview-foto" src="{{ asset('storage/' . $lapak->foto_profil) }}" alt="Foto Profil" class="w-48 h-48 rounded-full object-cover border-4 border-orange-200 shadow-lg">
                                @else
                                    <div id="preview-foto" class="w-48 h-48 rounded-full bg-gradient-to-br from-orange-400 to-pink-500 flex items-center justify-center border-4 border-orange-200 shadow-lg">
                                        <span class="text-6xl text-white">🏪</span>
                                    </div>
                                @endif
                                <!-- <div class="absolute bottom-0 right-0 bg-orange-500 text-white rounded-full p-2 shadow-lg">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div> -->
                            </div>
                            
                            <!-- Upload Button -->
                            <label for="foto_profil" class="cursor-pointer">
                                <div class="bg-gradient-to-r from-orange-500 to-pink-500 text-white px-6 py-3 rounded-lg hover:shadow-lg transition transform hover:scale-105 font-semibold flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                    </svg>
                                    <span>Pilih Foto Profil</span>
                                </div>
                                <input 
                                    type="file" 
                                    name="foto_profil" 
                                    id="foto_profil" 
                                    accept="image/*"
                                    class="hidden"
                                    onchange="previewImage(this)"
                                >
                            </label>
                            <p class="text-xs text-gray-500 text-center">Format: JPG, PNG, GIF (Max: 2MB)</p>
                        </div>
                        @error('foto_profil')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <hr class="border-gray-200">

                    <!-- Nama Lapak -->
                    <div>
                        <label for="nama_lapak" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nama Lapak <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="nama_lapak"
                            id="nama_lapak"
                            value="{{ old('nama_lapak', $lapak->nama_lapak ?? '') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition @error('nama_lapak') border-red-500 @enderror"
                            placeholder="Contoh: Lapak Ica"
                            required
                        >
                        @error('nama_lapak')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Pemilik -->
                    <div>
                        <label for="pemilik" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nama Pemilik
                        </label>
                        <input
                            type="text"
                            name="pemilik"
                            id="pemilik"
                            value="{{ old('pemilik', $lapak->pemilik ?? '') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition @error('pemilik') border-red-500 @enderror"
                            placeholder="Nama pemilik lapak"
                        >
                        @error('pemilik')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- No HP Pemilik -->
                    <div>
                        <label for="no_hp_pemilik" class="block text-sm font-semibold text-gray-700 mb-2">
                            No. HP Pemilik
                        </label>
                        <input
                            type="text"
                            name="no_hp_pemilik"
                            id="no_hp_pemilik"
                            value="{{ old('no_hp_pemilik', $lapak->no_hp_pemilik ?? '') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition @error('no_hp_pemilik') border-red-500 @enderror"
                            placeholder="Contoh: 081234567890"
                        >
                        @error('no_hp_pemilik')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="bg-gray-50 px-6 py-4 flex flex-col sm:flex-row gap-3 sm:gap-4 justify-end border-t border-gray-200">
                    <a href="{{ route('penjual.dashboard') }}" class="w-full sm:w-auto px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-100 transition text-center">
                        Batal
                    </a>
                    <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-orange-500 to-pink-500 text-white font-semibold rounded-lg hover:shadow-lg transition transform hover:scale-105">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function previewImage(input) {
        const preview = document.getElementById('preview-foto');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                // Jika sebelumnya adalah div placeholder, ubah menjadi img
                if (preview.tagName === 'DIV') {
                    const newImg = document.createElement('img');
                    newImg.id = 'preview-foto';
                    newImg.src = e.target.result;
                    newImg.className = 'w-48 h-48 rounded-full object-cover border-4 border-orange-200 shadow-lg';
                    newImg.alt = 'Foto Profil';
                    preview.parentNode.replaceChild(newImg, preview);
                } else {
                    preview.src = e.target.result;
                }
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
