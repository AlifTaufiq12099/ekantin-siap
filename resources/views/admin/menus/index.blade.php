@extends('layouts.admin')

@section('title', 'Menu')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">Daftar Menu</h1>
    <p class="text-gray-600">Kelola menu makanan dan minuman</p>
</div>

<div class="bg-white rounded-xl shadow-md p-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
        <div class="flex-1 max-w-md">
            <form action="{{ route('admin.menus.index') }}" method="GET" class="flex items-center space-x-2">
                <div class="relative flex-1">
                    <input 
                        type="text" 
                        name="q"
                        value="{{ $query ?? '' }}"
                        placeholder="Cari menu..." 
                        class="w-full px-4 py-2 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none"
                    >
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>
                <button 
                    type="submit"
                    class="px-4 py-2 bg-gradient-to-r from-purple-500 to-indigo-600 text-white rounded-lg hover:shadow-lg transition font-medium"
                >
                    Cari
                </button>
                @if(isset($query) && $query)
                <a href="{{ route('admin.menus.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                    Reset
                </a>
                @endif
            </form>
        </div>
        <a href="{{ route('admin.menus.create') }}" class="bg-gradient-to-r from-purple-500 to-indigo-600 text-white px-4 py-2 rounded-lg hover:shadow-lg transition font-medium whitespace-nowrap">
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
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Lapak</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($menus as $m)
                <tr class="border-b border-gray-100 hover:bg-gray-50">
                    <td class="px-4 py-3 text-sm text-gray-600">{{ $m->menu_id }}</td>
                    <td class="px-4 py-3">
                        @php
                            $thumb = $m->image ? 'menus/thumb_'.basename($m->image) : null;
                            $existsThumb = $thumb ? \Illuminate\Support\Facades\Storage::disk('public')->exists($thumb) : false;
                            $existsMain = $m->image ? \Illuminate\Support\Facades\Storage::disk('public')->exists($m->image) : false;
                        @endphp
                        @if($existsThumb)
                            <img src="{{ asset('storage/'.$thumb) }}" class="w-12 h-12 object-cover rounded-lg">
                        @elseif($existsMain)
                            <img src="{{ asset('storage/'.$m->image) }}" class="w-12 h-12 object-cover rounded-lg">
                        @else
                            <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center text-gray-400">
                                <span>📷</span>
                            </div>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-sm font-medium text-gray-800">{{ $m->nama_menu }}</td>
                    <td class="px-4 py-3 text-sm text-gray-600">Rp {{ number_format($m->harga, 0, ',', '.') }}</td>
                    <td class="px-4 py-3 text-sm text-gray-600">{{ optional($m->lapak)->nama_lapak ?? '-' }}</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('admin.menus.edit', $m->menu_id) }}" class="px-3 py-1 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 transition text-sm font-medium">
                                Edit
                            </a>
                            <form action="{{ route('admin.menus.destroy', $m->menu_id) }}" method="POST" style="display:inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus menu ini?')">
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
                        Belum ada menu terdaftar
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
