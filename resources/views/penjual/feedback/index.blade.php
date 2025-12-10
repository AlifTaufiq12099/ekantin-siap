@extends('layouts.penjual')

@section('title', 'Rating & Feedback')
@section('page-title', 'Rating & Feedback')
@section('page-subtitle', 'Lihat semua rating dan feedback dari pembeli')

@section('content')
<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Average Rating -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                <span class="text-2xl font-bold text-yellow-600">★</span>
            </div>
        </div>
        <h3 class="text-gray-500 text-sm mb-1">Rating Rata-rata</h3>
        <p class="text-4xl font-bold text-gray-800 mb-2">{{ $averageRating > 0 ? number_format($averageRating, 1) : '-' }}</p>
        <div class="text-sm text-gray-600 font-medium">
            {{ $averageRating > 0 ? number_format($averageRating, 1) . '/5' : '-' }}
        </div>
    </div>

    <!-- Total Rating -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <span class="text-2xl">📊</span>
            </div>
        </div>
        <h3 class="text-gray-500 text-sm mb-1">Total Rating</h3>
        <p class="text-4xl font-bold text-gray-800 mb-2">{{ number_format($totalRating, 0, ',', '.') }}</p>
        <p class="text-xs text-gray-500">Dari {{ $totalRating }} pembeli</p>
    </div>

    <!-- Rating dengan Feedback -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <span class="text-2xl">💬</span>
            </div>
        </div>
        <h3 class="text-gray-500 text-sm mb-1">Dengan Feedback</h3>
        <p class="text-4xl font-bold text-gray-800 mb-2">{{ number_format($ratings->whereNotNull('feedback')->count(), 0, ',', '.') }}</p>
        <p class="text-xs text-gray-500">Pembeli yang memberikan feedback</p>
    </div>
</div>

<!-- Rating Distribution -->
<div class="bg-white rounded-xl shadow-md p-6 mb-8">
    <h2 class="text-xl font-bold text-gray-800 mb-4">Distribusi Rating</h2>
    <div class="space-y-3">
        @for($i = 5; $i >= 1; $i--)
        <div class="flex items-center space-x-4">
            <div class="w-20 flex items-center space-x-1">
                <span class="text-sm font-semibold text-gray-700">{{ $i }} Bintang</span>
            </div>
            <div class="flex-1 bg-gray-200 rounded-full h-6 relative overflow-hidden">
                @php
                    $percentage = $totalRating > 0 ? ($ratingDistribution[$i] / $totalRating) * 100 : 0;
                @endphp
                <div class="bg-gradient-to-r from-yellow-400 to-orange-500 h-6 rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
            </div>
            <div class="w-16 text-right">
                <span class="text-sm font-semibold text-gray-700">{{ $ratingDistribution[$i] }}</span>
            </div>
        </div>
        @endfor
    </div>
</div>

<!-- List Feedback -->
<div class="bg-white rounded-xl shadow-md p-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-gray-800">Semua Rating & Feedback</h2>
    </div>

    @if($ratings->count() > 0)
    <div class="space-y-4">
        @foreach($ratings as $rating)
        <div class="p-5 bg-gray-50 rounded-lg border-l-4 border-orange-400 hover:shadow-md transition">
            <div class="flex items-start justify-between mb-3">
                <div class="flex items-center space-x-3">
                    @if($rating->user && $rating->user->foto_profil)
                        <img src="{{ asset('storage/' . $rating->user->foto_profil) }}" alt="{{ $rating->user->name }}" class="w-12 h-12 rounded-full object-cover border-2 border-orange-200">
                    @else
                        <div class="w-12 h-12 bg-gradient-to-br from-orange-400 to-pink-500 rounded-full flex items-center justify-center border-2 border-orange-200">
                            <span class="text-xl text-white">👤</span>
                        </div>
                    @endif
                    <div>
                        <p class="font-semibold text-gray-800">{{ $rating->user->name ?? 'Anonymous' }}</p>
                        <p class="text-xs text-gray-500">
                            Pesanan #{{ $rating->transaksi->transaksi_id ?? '-' }} • 
                            {{ $rating->transaksi->menu->nama_menu ?? 'Menu' }}
                        </p>
                    </div>
                </div>
                <div class="text-right">
                    @php
                        // Pastikan rating adalah integer dan valid
                        $ratingValue = (int) $rating->rating;
                        // Validasi: jika rating tidak valid, set ke 0
                        if ($ratingValue < 1 || $ratingValue > 5) {
                            $ratingValue = 0;
                        }
                        $ratingLabels = [
                            1 => 'Sangat Buruk',
                            2 => 'Buruk',
                            3 => 'Cukup',
                            4 => 'Baik',
                            5 => 'Sangat Baik'
                        ];
                        $ratingColors = [
                            1 => 'bg-red-100 text-red-800 border-red-300',
                            2 => 'bg-orange-100 text-orange-800 border-orange-300',
                            3 => 'bg-yellow-100 text-yellow-800 border-yellow-300',
                            4 => 'bg-blue-100 text-blue-800 border-blue-300',
                            5 => 'bg-green-100 text-green-800 border-green-300'
                        ];
                    @endphp
                    <div class="mb-2">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold border {{ $ratingColors[$ratingValue] ?? 'bg-gray-100 text-gray-800 border-gray-300' }}">
                            Rating: {{ $ratingValue }}/5
                        </span>
                    </div>
                    <div class="mb-1">
                        <span class="text-xs font-medium text-gray-600">{{ $ratingLabels[$ratingValue] ?? 'Tidak diketahui' }}</span>
                    </div>
                    <span class="text-xs text-gray-500">{{ $rating->created_at->format('d M Y H:i') }}</span>
                </div>
            </div>
            
            @if($rating->feedback)
            <div class="mt-3 p-3 bg-white rounded-lg border border-gray-200">
                <p class="text-sm text-gray-700 italic">"{{ $rating->feedback }}"</p>
            </div>
            @else
            <p class="text-xs text-gray-400 italic mt-2">Tidak ada feedback</p>
            @endif
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    @if($ratings->hasPages())
    <div class="mt-6">
        {{ $ratings->links() }}
    </div>
    @endif
    @else
    <div class="text-center py-12">
        <div class="text-6xl mb-4 font-bold text-gray-300">★</div>
        <p class="text-lg text-gray-500">Belum ada rating dan feedback</p>
        <p class="text-sm text-gray-400 mt-2">Rating akan muncul di sini setelah pembeli memberikan rating</p>
    </div>
    @endif
</div>
@endsection

