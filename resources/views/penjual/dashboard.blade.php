@extends('layouts.penjual')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat datang kembali, ' . ($lapak->nama_lapak ?? 'Penjual') . ' 👋')

@section('content')
<!-- KPI Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Pesanan Hari Ini -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <span class="text-2xl">📦</span>
            </div>
            @if($persentasePesanan > 0)
                <span class="bg-green-100 text-green-600 text-xs px-2 py-1 rounded-full font-semibold">+{{ $persentasePesanan }}%</span>
            @elseif($persentasePesanan < 0)
                <span class="bg-red-100 text-red-600 text-xs px-2 py-1 rounded-full font-semibold">{{ $persentasePesanan }}%</span>
            @endif
        </div>
        <h3 class="text-gray-500 text-sm mb-1">Pesanan Hari Ini</h3>
        <p class="text-3xl font-bold text-gray-800 mb-2">{{ $pesananHariIni ?? 0 }}</p>
        <p class="text-xs text-gray-500">{{ $pesananDiproses ?? 0 }} pesanan sedang diproses</p>
    </div>

    <!-- Pendapatan Hari Ini -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <span class="text-2xl">💰</span>
            </div>
            @if($persentasePendapatan > 0)
                <span class="bg-green-100 text-green-600 text-xs px-2 py-1 rounded-full font-semibold">+{{ $persentasePendapatan }}%</span>
            @elseif($persentasePendapatan < 0)
                <span class="bg-red-100 text-red-600 text-xs px-2 py-1 rounded-full font-semibold">{{ $persentasePendapatan }}%</span>
            @endif
        </div>
        <h3 class="text-gray-500 text-sm mb-1">Pendapatan Hari Ini</h3>
        <p class="text-3xl font-bold text-gray-800 mb-2">{{ $pendapatanFormatted ?? 'Rp 0' }}</p>
        <p class="text-xs text-gray-500">
            @if($pendapatanKemarinFormatted && $pendapatanKemarinFormatted != 'Rp 0')
                Kemarin: {{ $pendapatanKemarinFormatted }}
            @else
                Belum ada pendapatan sebelumnya
            @endif
        </p>
    </div>

    <!-- Total Menu -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                <span class="text-2xl">🍽️</span>
            </div>
            @if($menuAktif > 0)
                <span class="bg-blue-100 text-blue-600 text-xs px-2 py-1 rounded-full font-semibold">Active</span>
            @else
                <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full font-semibold">Inactive</span>
            @endif
        </div>
        <h3 class="text-gray-500 text-sm mb-1">Total Menu</h3>
        <p class="text-3xl font-bold text-gray-800 mb-2">{{ $totalMenu ?? 0 }}</p>
        <p class="text-xs text-gray-500">{{ $menuTerlarisMinggu ?? 0 }} menu terlaris minggu ini</p>
    </div>

    <!-- Rating Toko -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                <span class="text-2xl">⭐</span>
            </div>
            @if($rating >= 4.5)
                <span class="bg-yellow-100 text-yellow-600 text-xs px-2 py-1 rounded-full font-semibold">Excellent</span>
            @elseif($rating >= 4.0)
                <span class="bg-green-100 text-green-600 text-xs px-2 py-1 rounded-full font-semibold">Good</span>
            @elseif($rating >= 3.0)
                <span class="bg-blue-100 text-blue-600 text-xs px-2 py-1 rounded-full font-semibold">Fair</span>
            @else
                <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full font-semibold">No Rating</span>
            @endif
        </div>
        <h3 class="text-gray-500 text-sm mb-1">Rating Toko</h3>
        <p class="text-3xl font-bold text-gray-800 mb-2">{{ $rating > 0 ? number_format($rating, 1) : '-' }}</p>
        <p class="text-xs text-gray-500">Dari {{ $totalUlasan ?? 0 }} transaksi selesai</p>
    </div>
</div>

<!-- Two Column Layout -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Pesanan Terbaru -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-gray-800">Pesanan Terbaru</h2>
            <a href="{{ route('penjual.transaksi.index') }}" class="text-orange-500 text-sm font-medium hover:underline">Lihat Semua</a>
        </div>
        <div class="space-y-4">
            @forelse($pesananTerbaru ?? [] as $pesanan)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex-1">
                        <div class="flex items-center space-x-2 mb-1">
                            <span class="text-sm font-semibold text-gray-800">#{{ $pesanan->transaksi_id }}</span>
                            <span class="text-sm text-gray-600">
                                {{ $pesanan->jumlah }}x {{ $pesanan->menu->nama_menu ?? 'Menu' }}
                            </span>
                        </div>
                        <p class="text-xs text-gray-500">
                            {{ $pesanan->user->name ?? 'User' }} • {{ \Carbon\Carbon::parse($pesanan->waktu_transaksi)->diffForHumans() }}
                        </p>
                    </div>
                    <div class="text-right ml-4">
                        <p class="text-sm font-semibold text-gray-800 mb-1">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</p>
                        <span class="px-2 py-1 text-xs rounded-full font-medium
                            @if($pesanan->status_transaksi == 'selesai' || $pesanan->status_transaksi == 'siap') bg-green-100 text-green-600
                            @elseif($pesanan->status_transaksi == 'diproses' || $pesanan->status_transaksi == 'sedang_dibuat') bg-yellow-100 text-yellow-600
                            @else bg-blue-100 text-blue-600
                            @endif">
                            @if($pesanan->status_transaksi == 'siap') Siap Diambil
                            @elseif($pesanan->status_transaksi == 'diproses' || $pesanan->status_transaksi == 'sedang_dibuat') Diproses
                            @elseif($pesanan->status_transaksi == 'baru' || $pesanan->status_transaksi == 'menunggu_pembayaran') Pesanan Baru
                            @else {{ ucfirst(str_replace('_', ' ', $pesanan->status_transaksi)) }}
                            @endif
                        </span>
                    </div>
                </div>
            @empty
                <div class="text-center py-8 text-gray-500">
                    <p class="text-lg">Belum ada pesanan terbaru</p>
                    <p class="text-sm mt-2">Pesanan akan muncul di sini setelah ada transaksi</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Menu Terlaris -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-gray-800">Menu Terlaris</h2>
        </div>
        <div class="space-y-4">
            @forelse($menuTerlaris ?? [] as $index => $menu)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 rounded-lg overflow-hidden flex-shrink-0">
                            @php
                                $menuImage = $menu->image ?? null;
                                $thumb = $menuImage ? 'menus/thumb_'.basename($menuImage) : null;
                                $existsThumb = $thumb ? \Illuminate\Support\Facades\Storage::disk('public')->exists($thumb) : false;
                                $existsMain = $menuImage ? \Illuminate\Support\Facades\Storage::disk('public')->exists($menuImage) : false;
                            @endphp
                            @if($existsThumb)
                                <img src="{{ asset('storage/'.$thumb) }}" alt="{{ $menu->nama_menu ?? 'Menu' }}" class="w-full h-full object-cover">
                            @elseif($existsMain)
                                <img src="{{ asset('storage/'.$menuImage) }}" alt="{{ $menu->nama_menu ?? 'Menu' }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-orange-100 to-orange-200 rounded-lg flex items-center justify-center">
                                    <span class="text-xl">🍚</span>
                                </div>
                            @endif
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">{{ $menu->nama_menu }}</p>
                            <p class="text-xs text-gray-500">{{ number_format($menu->total_terjual ?? 0, 0, ',', '.') }} terjual</p>
                        </div>
                    </div>
                    <p class="font-semibold text-gray-800">
                        Rp {{ number_format($menu->harga, 0, ',', '.') }}
                    </p>
                </div>
            @empty
                <div class="text-center py-8 text-gray-500">
                    <p class="text-lg">Belum ada menu terlaris</p>
                    <p class="text-sm mt-2">Menu akan muncul di sini setelah ada transaksi yang selesai</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Feedback Section -->
@if(isset($feedbackTerbaru) && $feedbackTerbaru->count() > 0)
<div class="mt-6">
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-gray-800 flex items-center">
                <span class="text-2xl mr-2">💬</span>
                Feedback Terbaru
            </h2>
            <a href="{{ route('penjual.feedback.index') }}" class="text-orange-500 text-sm font-medium hover:underline">Lihat Semua</a>
        </div>
        <div class="space-y-4">
            @foreach($feedbackTerbaru as $feedback)
            <div class="p-4 bg-gray-50 rounded-lg border-l-4 border-orange-400">
                <div class="flex items-start justify-between mb-2">
                    <div class="flex items-center space-x-2">
                        <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center">
                        @if($feedback->user && $feedback->user->foto_profil)
                        <img src="{{ asset('storage/' . $feedback->user->foto_profil) }}" alt="{{ $feedback->user->name }}" class="w-10 h-10 rounded-full object-cover border-2 border-orange-200">
                        @else
                        <div class="w-10 h-10 bg-gradient-to-br from-orange-400 to-pink-500 rounded-full flex items-center justify-center border-2 border-orange-200">
                            <span class="text-xl text-white">👤</span>
                        </div>
                        @endif
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">{{ $feedback->user->name ?? 'Anonymous' }}</p>
                            <div class="flex items-center space-x-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="text-sm {{ $i <= $feedback->rating ? 'text-yellow-400' : 'text-gray-300' }}">⭐</span>
                                @endfor
                                <span class="text-xs text-gray-500 ml-1">({{ $feedback->rating }}/5)</span>
                            </div>
                        </div>
                    </div>
                    <span class="text-xs text-gray-500">{{ $feedback->created_at->diffForHumans() }}</span>
                </div>
                @if($feedback->feedback)
                    <p class="text-sm text-gray-700 mt-2 italic">"{{ $feedback->feedback }}"</p>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif
@endsection
