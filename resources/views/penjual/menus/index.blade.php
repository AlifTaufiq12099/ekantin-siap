@extends('layouts.penjual')

@section('title', 'Menu')
@section('page-title', 'Menu')
@section('page-subtitle', 'Kelola menu makanan dan minuman')

@section('content')
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-semibold text-gray-800">Daftar Menu</h2>
            <a href="{{ route('penjual.menus.create') }}" class="bg-gradient-to-r from-orange-500 to-pink-500 text-white px-4 py-2 rounded-lg hover:shadow-lg transition font-medium">
                + Tambah Menu
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">ID</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Gambar</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Nama</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Harga</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Stok</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($menus as $m)
                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $m->menu_id }}</td>
                            <td class="px-4 py-3">
                            @if(!empty($m->image))
                                @php
                                    // Hilangkan 'storage/' jika ada di database
                                    $imagePath = str_replace('storage/', '', $m->image);
                                    $imagePath = str_replace('menus/', '', $imagePath);

                                    // Build URL yang benar
                                    $imgUrl = asset('storage/menus/' . $imagePath);
                                @endphp
                                <img src="{{ $imgUrl }}" alt="{{ $m->nama_menu }}" class="w-12 h-12 object-cover rounded-lg" loading="lazy"
                                    onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center text-gray-400" style="display:none;">
                                    <span class="text-lg">📷</span>
                                </div>
                            @else
                                <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center text-gray-400">
                                    <span class="text-lg">📷</span>
                                </div>
                            @endif



                            </td>
                            <td class="px-4 py-3 text-sm font-medium text-gray-800">{{ $m->nama_menu }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">Rp {{ number_format($m->harga, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $m->stok ?? 0 }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('penjual.menus.edit', $m->menu_id) }}" class="px-3 py-1 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 transition text-sm font-medium">
                                        Edit
                                    </a>
                                    <form action="{{ route('penjual.menus.destroy', $m->menu_id) }}" method="POST" style="display:inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus menu ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="px-3 py-1 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition text-sm font-medium">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                            Belum ada menu. <a href="{{ route('penjual.menus.create') }}" class="text-orange-500 hover:underline">Tambah menu pertama</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($menus->hasPages())
        <div class="mt-6">
            {{ $menus->links() }}
        </div>
        @endif
    </div>
@endsection
