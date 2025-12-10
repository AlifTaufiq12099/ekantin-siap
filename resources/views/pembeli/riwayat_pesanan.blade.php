<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan - Kantin D-pipe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #FF8E53 0%, #FE6B8B 100%);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="bg-gray-50">

    <!-- Navbar -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 gradient-bg rounded-lg flex items-center justify-center text-white font-bold text-xl">
                        KD
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-800">Kantin D-pipe</h1>
                        <p class="text-xs text-gray-500">⏰ 07:00 - 15:00</p>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <!-- User Info -->
                    <div class="hidden md:block text-right">
                        <p class="text-sm font-semibold text-gray-800">{{ session('username') }}</p>
                        <p class="text-xs text-gray-500">Pembeli</p>
                    </div>

                    <!-- Logout Button -->
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition text-sm font-medium">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto px-6 py-8">
        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-800 mb-2">Riwayat Pesanan</h2>
                <p class="text-gray-600">Lihat semua pesanan yang pernah kamu buat</p>
            </div>
            <a href="{{ route('pembeli.lapak.select') }}" class="bg-gradient-to-r from-orange-500 to-pink-500 text-white px-6 py-2 rounded-lg hover:shadow-lg transition font-medium">
                ← Pilih Lapak
            </a>
        </div>

        <!-- Alert Messages -->
        @if(session('key') && session('value'))
            <div class="mb-4 p-4 rounded-lg {{ session('key') === 'success' ? 'bg-green-50 border border-green-200 text-green-800' : 'bg-red-50 border border-red-200 text-red-800' }}">
                {{ session('value') }}
            </div>
        @endif

        <!-- Riwayat Pesanan -->
        @forelse($transaksis as $transaksi)
            <div class="bg-white rounded-2xl shadow-md p-6 mb-4 card-hover">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1">
                        <div class="flex items-center space-x-3 mb-2">
                            <h3 class="text-xl font-bold text-gray-800">Pesanan #{{ $transaksi->transaksi_id }}</h3>
                            <span class="px-3 py-1 text-xs rounded-full font-semibold
                                @if($transaksi->status_transaksi == 'selesai') bg-green-100 text-green-600
                                @elseif($transaksi->status_transaksi == 'diproses' || $transaksi->status_transaksi == 'sedang_dibuat') bg-yellow-100 text-yellow-600
                                @elseif($transaksi->status_transaksi == 'menunggu_konfirmasi' || $transaksi->status_transaksi == 'menunggu_pembayaran') bg-blue-100 text-blue-600
                                @elseif($transaksi->status_transaksi == 'siap') bg-purple-100 text-purple-600
                                @elseif($transaksi->status_transaksi == 'dibatalkan') bg-red-100 text-red-600
                                @else bg-gray-100 text-gray-600
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $transaksi->status_transaksi)) }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-500">
                            📅 {{ \Carbon\Carbon::parse($transaksi->waktu_transaksi)->format('d/m/Y H:i') }}
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="text-2xl font-bold text-orange-500">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4 pb-4 border-b border-gray-100">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Menu</p>
                        <p class="font-semibold text-gray-800">{{ $transaksi->menu->nama_menu ?? '-' }}</p>
                        <p class="text-xs text-gray-500">{{ $transaksi->menu->deskripsi ?? '' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Lapak</p>
                        <p class="font-semibold text-gray-800">{{ $transaksi->lapak->nama_lapak ?? '-' }}</p>
                        <p class="text-xs text-gray-500">{{ $transaksi->lapak->pemilik ?? '' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Detail</p>
                        <p class="font-semibold text-gray-800">Jumlah: {{ $transaksi->jumlah }} porsi</p>
                        <p class="text-xs text-gray-500">Metode: {{ ucfirst($transaksi->metode_pembayaran ?? 'Tunai') }}</p>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <a href="{{ route('pembeli.order.show', $transaksi->transaksi_id) }}" class="px-4 py-2 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 transition text-sm font-medium">
                        Lihat Detail
                    </a>
                    
                    @if($transaksi->status_transaksi == 'siap')
                        <form action="{{ route('pembeli.order.confirmReceived', $transaksi->transaksi_id) }}" method="POST" onsubmit="return confirm('Konfirmasi pesanan sudah diterima?')">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition text-sm font-medium">
                                Konfirmasi Diterima
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl shadow-md p-12 text-center">
                <div class="text-6xl mb-4">📦</div>
                <h3 class="text-2xl font-bold text-gray-800 mb-2">Belum Ada Pesanan</h3>
                <p class="text-gray-600 mb-6">Kamu belum pernah membuat pesanan. Yuk pesan makanan favoritmu!</p>
                <a href="{{ route('pembeli.lapak.select') }}" class="inline-block bg-gradient-to-r from-orange-500 to-pink-500 text-white px-6 py-3 rounded-lg hover:shadow-lg transition font-medium">
                    Pilih Lapak Sekarang
                </a>
            </div>
        @endforelse

        <!-- Pagination -->
        @if($transaksis->hasPages())
            <div class="mt-6">
                {{ $transaksis->links() }}
            </div>
        @endif
    </div>

</body>
</html>

