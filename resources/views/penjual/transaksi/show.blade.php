@extends('layouts.penjual')

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- Header -->
    <div class="mb-6">
        <a href="{{ route('penjual.transaksi.index') }}" class="text-orange-500 hover:text-orange-600 font-semibold mb-4 inline-block">
            ← Kembali ke Pesanan
        </a>
        <h2 class="text-3xl font-bold text-gray-800">Detail Transaksi #{{ $t->transaksi_id }}</h2>
        <p class="text-gray-600">Informasi lengkap pesanan</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Info Card -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Informasi Pesanan -->
            <div class="bg-white rounded-2xl shadow-md p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Informasi Pesanan</h3>

                <div class="space-y-4">
                    <!-- User Info -->
                    <div class="flex items-center justify-between pb-4 border-b">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                                <span class="text-2xl">👤</span>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Pembeli</p>
                                <p class="font-semibold text-gray-800">{{ optional($t->user)->name ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Menu Info -->
                    <div class="flex items-center justify-between pb-4 border-b">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                                <span class="text-2xl">🍽️</span>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Menu</p>
                                <p class="font-semibold text-gray-800">{{ optional($t->menu)->nama_menu ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Waktu -->
                    <div class="flex items-center justify-between pb-4 border-b">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-2xl">🕐</span>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Waktu Pesanan</p>
                                <p class="font-semibold text-gray-800">{{ \Carbon\Carbon::parse($t->waktu_transaksi)->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Jumlah & Total -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-sm text-gray-500 mb-1">Jumlah</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $t->jumlah }}x</p>
                        </div>
                        <div class="bg-gradient-to-br from-orange-50 to-pink-50 rounded-xl p-4">
                            <p class="text-sm text-gray-500 mb-1">Total Harga</p>
                            <p class="text-2xl font-bold text-orange-500">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bukti Pembayaran -->
            <div class="bg-white rounded-2xl shadow-md p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Bukti Pembayaran</h3>

                @if($t->bukti_pembayaran)
                    <div class="border-2 border-gray-200 rounded-xl overflow-hidden">
                        <img src="{{ asset('storage/'.$t->bukti_pembayaran) }}"
                             class="w-full h-auto"
                             alt="Bukti Pembayaran"
                             onerror="this.onerror=null; this.src='{{ asset('images/no-image.png') }}';">
                    </div>
                    <a href="{{ asset('storage/'.$t->bukti_pembayaran) }}"
                       target="_blank"
                       class="mt-3 inline-block text-orange-500 hover:text-orange-600 font-semibold">
                        📥 Lihat Ukuran Penuh
                    </a>
                @else
                    <div class="bg-gray-50 rounded-xl p-8 text-center">
                        <span class="text-6xl mb-3 block">📄</span>
                        <p class="text-gray-500">Belum ada bukti pembayaran</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar - Status & Actions -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Status Card -->
            <div class="bg-white rounded-2xl shadow-md p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Status Pesanan</h3>

                <div class="mb-6">
                    @php
                        $statusConfig = [
                            'menunggu_konfirmasi' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700', 'label' => 'Menunggu Konfirmasi', 'icon' => '⏳'],
                            'sedang_dibuat' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'label' => 'Sedang Dibuat', 'icon' => '🔄'],
                            'siap' => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'label' => 'Siap Diambil', 'icon' => '✅'],
                            'selesai' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'label' => 'Selesai', 'icon' => '✔️'],
                            'dibatalkan' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'label' => 'Dibatalkan', 'icon' => '❌'],
                        ];
                        $currentStatus = $statusConfig[$t->status_transaksi] ?? $statusConfig['menunggu_konfirmasi'];
                    @endphp

                    <div class="{{ $currentStatus['bg'] }} {{ $currentStatus['text'] }} px-4 py-3 rounded-xl text-center font-semibold">
                        <span class="text-2xl mr-2">{{ $currentStatus['icon'] }}</span>
                        <span>{{ $currentStatus['label'] }}</span>
                    </div>
                </div>

                <!-- Update Status Form -->
                <form method="POST" action="{{ route('penjual.transaksi.updateStatus', $t->transaksi_id) }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Ubah Status</label>
                        <select name="status_transaksi" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-orange-500 focus:outline-none">
                            <option value="menunggu_konfirmasi" {{ $t->status_transaksi=='menunggu_konfirmasi' ? 'selected' : '' }}>⏳ Menunggu Konfirmasi</option>
                            <option value="sedang_dibuat" {{ $t->status_transaksi=='sedang_dibuat' ? 'selected' : '' }}>🔄 Sedang Dibuat</option>
                            <option value="siap" {{ $t->status_transaksi=='siap' ? 'selected' : '' }}>✅ Siap Diambil</option>
                            <option value="selesai" {{ $t->status_transaksi=='selesai' ? 'selected' : '' }}>✔️ Selesai</option>
                            <option value="dibatalkan" {{ $t->status_transaksi=='dibatalkan' ? 'selected' : '' }}>❌ Dibatalkan</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full bg-gradient-to-r from-orange-500 to-pink-500 text-white py-3 rounded-xl font-semibold hover:shadow-lg transition">
                        💾 Update Status
                    </button>
                </form>
            </div>

            <!-- Quick Actions -->
            @if($t->status_transaksi == 'menunggu_konfirmasi')
            <div class="bg-white rounded-2xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Aksi Cepat</h3>

                <div class="space-y-3">
                    <form method="POST" action="{{ route('penjual.transaksi.updateStatus', $t->transaksi_id) }}">
                        @csrf
                        <input type="hidden" name="status_transaksi" value="sedang_dibuat">
                        <button type="submit" class="w-full bg-green-500 text-white py-3 rounded-xl font-semibold hover:bg-green-600 transition">
                            ✅ Terima & Proses
                        </button>
                    </form>

                    <form method="POST" action="{{ route('penjual.transaksi.updateStatus', $t->transaksi_id) }}">
                        @csrf
                        <input type="hidden" name="status_transaksi" value="dibatalkan">
                        <button type="submit" class="w-full bg-red-500 text-white py-3 rounded-xl font-semibold hover:bg-red-600 transition"
                                onclick="return confirm('Yakin ingin membatalkan pesanan ini?')">
                            ❌ Tolak Pesanan
                        </button>
                    </form>
                </div>
            </div>
            @endif

            @if($t->status_transaksi == 'sedang_dibuat')
            <div class="bg-white rounded-2xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Aksi Cepat</h3>

                <form method="POST" action="{{ route('penjual.transaksi.updateStatus', $t->transaksi_id) }}">
                    @csrf
                    <input type="hidden" name="status_transaksi" value="siap">
                    <button type="submit" class="w-full bg-gradient-to-r from-green-500 to-emerald-600 text-white py-3 rounded-xl font-semibold hover:shadow-lg transition">
                        ✅ Tandai Siap Diambil
                    </button>
                </form>
            </div>
            @endif

            @if($t->status_transaksi == 'siap')
            <div class="bg-white rounded-2xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Aksi Cepat</h3>

                <form method="POST" action="{{ route('penjual.transaksi.updateStatus', $t->transaksi_id) }}">
                    @csrf
                    <input type="hidden" name="status_transaksi" value="selesai">
                    <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-indigo-600 text-white py-3 rounded-xl font-semibold hover:shadow-lg transition">
                        ✔️ Selesaikan Pesanan
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
