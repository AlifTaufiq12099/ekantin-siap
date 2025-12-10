@extends('layouts.penjual')

@section('title', 'Pesanan')
@section('page-title', 'Pesanan')
@section('page-subtitle', 'Kelola pesanan dari pembeli')

@section('content')
<div class="bg-white rounded-xl shadow-md p-6">
    <div class="mb-6">
        <h2 class="text-xl font-semibold text-gray-800">Semua Pesanan</h2>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-200">
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">ID</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">User</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Menu</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Waktu</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Jumlah</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Total</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksis as $t)
                <tr class="border-b border-gray-100 hover:bg-gray-50">
                    <td class="px-4 py-3 text-sm text-gray-600">#{{ $t->transaksi_id }}</td>
                    <td class="px-4 py-3 text-sm font-medium text-gray-800">{{ optional($t->user)->name ?? '-' }}</td>
                    <td class="px-4 py-3 text-sm text-gray-600">{{ optional($t->menu)->nama_menu ?? '-' }}</td>
                    <td class="px-4 py-3 text-sm text-gray-600">{{ \Carbon\Carbon::parse($t->waktu_transaksi)->format('d/m/Y H:i') }}</td>
                    <td class="px-4 py-3 text-sm text-gray-600">{{ $t->jumlah }}</td>
                    <td class="px-4 py-3 text-sm font-medium text-gray-800">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 text-xs rounded-full
                            @if($t->status_transaksi == 'selesai') bg-green-100 text-green-600
                            @elseif($t->status_transaksi == 'diproses' || $t->status_transaksi == 'sedang_dibuat') bg-yellow-100 text-yellow-600
                            @elseif($t->status_transaksi == 'siap') bg-purple-100 text-purple-600
                            @else bg-blue-100 text-blue-600
                            @endif">
                            {{ ucfirst(str_replace('_', ' ', $t->status_transaksi)) }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <a href="{{ route('penjual.transaksi.show', $t->transaksi_id) }}" class="px-3 py-1 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 transition text-sm font-medium">
                            Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-4 py-8 text-center text-gray-500">
                        Belum ada pesanan
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
