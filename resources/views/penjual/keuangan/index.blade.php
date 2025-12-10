@extends('layouts.penjual')

@section('title', 'Laporan Keuangan')
@section('page-title', 'Laporan Keuangan')
@section('page-subtitle', 'Total Pendapatan dari Pesanan')

@push('styles')
<style>
    /* Custom Pagination Styling */
    .pagination {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
        gap: 0.5rem;
    }
    .pagination li {
        display: inline-block;
    }
    .pagination li a,
    .pagination li span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.5rem 0.75rem;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.2s;
    }
    .pagination li a {
        background-color: white;
        color: #4b5563;
        border: 1px solid #e5e7eb;
        text-decoration: none;
    }
    .pagination li a:hover {
        background-color: #f3f4f6;
        border-color: #d1d5db;
        color: #1f2937;
    }
    .pagination li.active span {
        background-color: #f97316;
        color: white;
        border: 1px solid #f97316;
    }
    .pagination li.disabled span {
        background-color: #f3f4f6;
        color: #9ca3af;
        border: 1px solid #e5e7eb;
        cursor: not-allowed;
    }
</style>
@endpush

@section('content')
<!-- Total Pendapatan Card -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <!-- Total Pendapatan -->
    <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl shadow-lg p-8 border-l-4 border-green-500">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-gray-600 text-sm font-medium mb-2">Total Pendapatan</h3>
                <p class="text-4xl font-bold text-green-600">Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</p>
                <p class="text-xs text-gray-500 mt-2">Dari semua pesanan yang selesai</p>
            </div>
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center">
                <span class="text-4xl">💰</span>
            </div>
        </div>
    </div>

    <!-- Total Transaksi Selesai -->
    <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-xl shadow-lg p-8 border-l-4 border-blue-500">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-gray-600 text-sm font-medium mb-2">Total Pesanan Selesai</h3>
                <p class="text-4xl font-bold text-blue-600">{{ number_format($totalTransaksiSelesai ?? 0, 0, ',', '.') }}</p>
                <p class="text-xs text-gray-500 mt-2">Pesanan dengan status selesai</p>
            </div>
            <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center">
                <span class="text-4xl">✅</span>
            </div>
        </div>
    </div>
</div>

<!-- List Pesanan yang Selesai -->
<div class="bg-white rounded-xl shadow-md p-6 mb-6">
    <div class="mb-4">
        <h3 class="text-lg font-semibold text-gray-800">List Pesanan yang Selesai</h3>
        <p class="text-sm text-gray-500">Daftar semua pesanan dengan status selesai</p>
    </div>

    @if($pesananSelesai->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pembeli</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Menu</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Harga</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($pesananSelesai as $pesanan)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm text-gray-600">#{{ $pesanan->transaksi_id }}</td>
                        <td class="px-4 py-3 text-sm font-medium text-gray-800">{{ optional($pesanan->user)->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ optional($pesanan->menu)->nama_menu ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">
                            {{ \Carbon\Carbon::parse($pesanan->waktu_transaksi)->setTimezone('Asia/Jakarta')->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $pesanan->jumlah }}x</td>
                        <td class="px-4 py-3 text-sm font-semibold text-green-600">
                            Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3">
                            <a href="{{ route('penjual.transaksi.show', $pesanan->transaksi_id) }}" class="px-3 py-1 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 transition text-sm font-medium">
                                Detail
                            </a>
                        </td>
        </tr>
        @endforeach
        </tbody>
    </table>
        </div>
        
        @if($pesananSelesai->hasPages())
        <div class="mt-6 flex items-center justify-between">
            <div class="text-sm text-gray-600">
                Menampilkan {{ $pesananSelesai->firstItem() ?? 0 }} - {{ $pesananSelesai->lastItem() ?? 0 }} dari {{ $pesananSelesai->total() }} pesanan
            </div>
            <div>
                {{ $pesananSelesai->links() }}
            </div>
        </div>
        @endif
    @else
        <div class="text-center py-12">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="text-3xl">📦</span>
            </div>
            <p class="text-gray-500">Belum ada pesanan yang selesai</p>
        </div>
    @endif
</div>
@endsection
