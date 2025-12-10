@extends('layouts.admin')

@section('title', 'Transaksi')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">Riwayat Transaksi</h1>
    <p class="text-gray-600">Lihat semua transaksi yang terjadi</p>
</div>

<div class="bg-white rounded-xl shadow-md p-6">
    <div class="mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <h2 class="text-xl font-semibold text-gray-800">Semua Transaksi</h2>
            <div class="flex-1 max-w-md">
                <form action="{{ route('admin.transaksi.index') }}" method="GET" class="flex items-center space-x-2">
                    <div class="relative flex-1">
                        <input 
                            type="text" 
                            name="q"
                            value="{{ $query ?? '' }}"
                            placeholder="Cari transaksi..." 
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
                    <a href="{{ route('admin.transaksi.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                        Reset
                    </a>
                    @endif
                </form>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-200">
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">ID</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">User</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Menu</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Lapak</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Waktu</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Jumlah</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Total</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksis as $t)
                <tr class="border-b border-gray-100 hover:bg-purple-50 transition" style="cursor: pointer;">
                    <td class="px-4 py-3 text-sm text-gray-600">
                        <a href="{{ route('admin.transaksi.show', $t->transaksi_id) }}" class="block text-purple-600 hover:text-purple-800 font-medium">
                            #{{ $t->transaksi_id }}
                        </a>
                    </td>
                    <td class="px-4 py-3 text-sm font-medium text-gray-800">
                        <a href="{{ route('admin.transaksi.show', $t->transaksi_id) }}" class="block">
                            {{ optional($t->user)->name ?? '-' }}
                        </a>
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-600">
                        <a href="{{ route('admin.transaksi.show', $t->transaksi_id) }}" class="block">
                            {{ optional($t->menu)->nama_menu ?? '-' }}
                        </a>
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-600">
                        <a href="{{ route('admin.transaksi.show', $t->transaksi_id) }}" class="block">
                            {{ optional($t->lapak)->nama_lapak ?? '-' }}
                        </a>
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-600">
                        <a href="{{ route('admin.transaksi.show', $t->transaksi_id) }}" class="block">
                            {{ \Carbon\Carbon::parse($t->waktu_transaksi)->format('d/m/Y H:i') }}
                        </a>
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-600">
                        <a href="{{ route('admin.transaksi.show', $t->transaksi_id) }}" class="block">
                            {{ $t->jumlah }}
                        </a>
                    </td>
                    <td class="px-4 py-3 text-sm font-medium text-gray-800">
                        <a href="{{ route('admin.transaksi.show', $t->transaksi_id) }}" class="block">
                            Rp {{ number_format($t->total_harga, 0, ',', '.') }}
                        </a>
                    </td>
                    <td class="px-4 py-3">
                        <a href="{{ route('admin.transaksi.show', $t->transaksi_id) }}" class="block">
                            <span class="px-2 py-1 text-xs rounded-full 
                                @if($t->status_transaksi == 'selesai') bg-green-100 text-green-600
                                @elseif($t->status_transaksi == 'diproses') bg-yellow-100 text-yellow-600
                                @else bg-blue-100 text-blue-600
                                @endif">
                                {{ ucfirst($t->status_transaksi) }}
                            </span>
                        </a>
                    </td>
                    <td class="px-4 py-3">
                        <a href="{{ route('admin.transaksi.show', $t->transaksi_id) }}" 
                           class="px-3 py-1 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 transition text-sm font-medium inline-block">
                            Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="px-4 py-8 text-center text-gray-500">
                        Belum ada transaksi
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($transaksis->hasPages())
    <div class="mt-6">
        {{ $transaksis->links() }}
    </div>
    @endif
</div>
@endsection
