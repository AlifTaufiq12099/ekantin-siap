@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- Header -->
    <div class="mb-6">
        <a href="{{ route('admin.users.index') }}" class="text-orange-500 hover:text-orange-600 font-semibold mb-4 inline-block">
            ← Kembali ke Daftar User
        </a>
        <h2 class="text-3xl font-bold text-gray-800">Edit User</h2>
        <p class="text-gray-600">Perbarui informasi pengguna</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl shadow-md p-6 max-w-2xl">
        <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- User Icon Header -->
                <div class="flex items-center space-x-4 pb-6 border-b-2 border-gray-100">
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-400 to-pink-500 rounded-full flex items-center justify-center">
                        <span class="text-3xl">👤</span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Edit Pengguna</p>
                        <p class="font-bold text-gray-800 text-lg">{{ $user->name }}</p>
                    </div>
                </div>

                <!-- Nama -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           name="nama"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-orange-500 focus:outline-none @error('nama') border-red-500 @enderror"
                           value="{{ old('nama', $user->name) }}"
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
                               value="{{ old('email', $user->email) }}"
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
                        Password Baru
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">🔒</span>
                        <input type="password"
                               name="password"
                               class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-orange-500 focus:outline-none @error('password') border-red-500 @enderror"
                               placeholder="••••••••">
                    </div>
                    <p class="text-sm text-gray-500 mt-2">💡 Kosongkan jika tidak ingin mengubah password</p>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Info Box -->
                <div class="bg-blue-50 border-2 border-blue-200 rounded-xl p-4">
                    <div class="flex items-start space-x-3">
                        <span class="text-2xl">ℹ️</span>
                        <div>
                            <p class="font-semibold text-blue-800 mb-1">Informasi Penting</p>
                            <ul class="text-sm text-blue-700 space-y-1">
                                <li>• Email akan digunakan untuk login</li>
                                <li>• Password minimal 8 karakter</li>
                                <li>• Perubahan akan tersimpan secara permanen</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="border-t-2 border-gray-100 mt-8 pt-6 flex gap-3">
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-orange-500 to-pink-500 text-white rounded-xl font-semibold hover:shadow-lg transition">
                    💾 Simpan Perubahan
                </button>
                <a href="{{ route('admin.users.index') }}" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-300 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
