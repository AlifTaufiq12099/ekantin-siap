@extends('layouts.penjual')

@section('title', 'Laporan Keuangan')
@section('page-title', 'Laporan Keuangan')
@section('page-subtitle', 'Laporan Penjualan Harian - ' . now()->format('d F Y'))

@section('content')
<!-- KPI Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Transaksi -->
    <div class="bg-blue-50 rounded-xl shadow-md p-6 border-l-4 border-blue-500">
        <div class="flex items-center justify-between mb-2">
            <h3 class="text-gray-600 text-sm font-medium">Total Transaksi</h3>
            <span class="text-2xl">📊</span>
        </div>
        <p class="text-3xl font-bold text-blue-600">{{ $totalTransaksiHari ?? 0 }}</p>
    </div>

    <!-- Total Penjualan -->
    <div class="bg-green-50 rounded-xl shadow-md p-6 border-l-4 border-green-500">
        <div class="flex items-center justify-between mb-2">
            <h3 class="text-gray-600 text-sm font-medium">Total Penjualan</h3>
            <span class="text-2xl">💰</span>
        </div>
        <p class="text-3xl font-bold text-green-600">Rp {{ number_format($totalPenjualanHari ?? 0, 0, ',', '.') }}</p>
    </div>

    <!-- Pemasukan -->
    
    <!-- Pengeluaran -->
   
</div>

<!-- Tab Navigation -->
<div class="bg-white rounded-xl shadow-md mb-6">
    <div class="border-b border-gray-200">
        <nav class="flex -mb-px">
            <button onclick="showTab('transaksi')" id="tab-transaksi" class="px-6 py-4 text-sm font-medium text-orange-600 border-b-2 border-orange-500 active-tab">
                Transaksi Harian
            </button>
            <button onclick="showTab('keuangan')" id="tab-keuangan" class="px-6 py-4 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent hover:border-gray-300">
                Keuangan Harian
            </button>
        </nav>
    </div>

    <!-- Tab Content: Transaksi -->
    <div id="content-transaksi" class="p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Daftar Transaksi Hari Ini</h3>
        </div>
        @if(isset($transaksiHari) && $transaksiHari->count() > 0)
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
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksiHari as $t)
                            <tr class="border-b border-gray-100 hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm text-gray-600">#{{ $t->transaksi_id }}</td>
                                <td class="px-4 py-3 text-sm font-medium text-gray-800">{{ optional($t->user)->name ?? '-' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ optional($t->menu)->nama_menu ?? '-' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ \Carbon\Carbon::parse($t->waktu_transaksi)->format('H:i') }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $t->jumlah }}</td>
                                <td class="px-4 py-3 text-sm font-medium text-gray-800">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 text-xs rounded-full font-medium
                                        @if($t->status_transaksi == 'selesai') bg-green-100 text-green-600
                                        @elseif($t->status_transaksi == 'dibatalkan') bg-red-100 text-red-600
                                        @else bg-yellow-100 text-yellow-600
                                        @endif">
                                        {{ ucfirst(str_replace('_', ' ', $t->status_transaksi)) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-12 bg-gray-50 rounded-lg">
                <span class="text-4xl mb-4 block">📋</span>
                <p class="text-gray-600 font-medium">Tidak ada transaksi pada hari ini</p>
                <p class="text-sm text-gray-500 mt-2">Transaksi akan muncul di sini setelah ada pesanan</p>
            </div>
        @endif
    </div>

    <!-- Tab Content: Keuangan -->
    <div id="content-keuangan" class="p-6 hidden">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Daftar Keuangan Hari Ini</h3>
        </div>
        @if(isset($keuanganHari) && $keuanganHari->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">ID</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Tanggal</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Jenis</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Jumlah</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($keuanganHari as $k)
                            <tr class="border-b border-gray-100 hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm text-gray-600">#{{ $k->keuangan_id }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ \Carbon\Carbon::parse($k->tanggal)->format('d-m-Y') }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 text-xs rounded-full font-medium
                                        @if($k->jenis_transaksi == 'Pemasukan') bg-green-100 text-green-600
                                        @else bg-red-100 text-red-600
                                        @endif">
                                        {{ $k->jenis_transaksi }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm font-medium text-gray-800">Rp {{ number_format($k->jumlah_uang, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $k->keterangan ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-12 bg-gray-50 rounded-lg">
                <span class="text-4xl mb-4 block">💰</span>
                <p class="text-gray-600 font-medium">Tidak ada data keuangan pada hari ini</p>
                <p class="text-sm text-gray-500 mt-2">Data keuangan akan muncul di sini setelah ada pencatatan</p>
            </div>
        @endif
    </div>
</div>

<!-- Back Button -->
<div class="mt-6">
    <a href="{{ route('penjual.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali ke Dashboard
    </a>
</div>

@push('scripts')
<script>
    function showTab(tabName) {
        // Hide all tab contents
        document.getElementById('content-transaksi').classList.add('hidden');
        document.getElementById('content-keuangan').classList.add('hidden');
        
        // Remove active class from all tabs
        document.getElementById('tab-transaksi').classList.remove('text-orange-600', 'border-orange-500', 'active-tab');
        document.getElementById('tab-transaksi').classList.add('text-gray-500', 'border-transparent');
        document.getElementById('tab-keuangan').classList.remove('text-orange-600', 'border-orange-500', 'active-tab');
        document.getElementById('tab-keuangan').classList.add('text-gray-500', 'border-transparent');
        
        // Show selected tab content
        if (tabName === 'transaksi') {
            document.getElementById('content-transaksi').classList.remove('hidden');
            document.getElementById('tab-transaksi').classList.remove('text-gray-500', 'border-transparent');
            document.getElementById('tab-transaksi').classList.add('text-orange-600', 'border-orange-500', 'active-tab');
        } else if (tabName === 'keuangan') {
            document.getElementById('content-keuangan').classList.remove('hidden');
            document.getElementById('tab-keuangan').classList.remove('text-gray-500', 'border-transparent');
            document.getElementById('tab-keuangan').classList.add('text-orange-600', 'border-orange-500', 'active-tab');
        }
    }
</script>
@endpush
@endsection
