<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Kantin D-pipe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-lg fixed h-full">
            <!-- Logo -->
            <div class="p-6 border-b">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 gradient-bg rounded-lg flex items-center justify-center text-white font-bold text-lg">
                        KD
                    </div>
                    <div>
                        <h2 class="font-bold text-gray-800">Kantin D-pipe</h2>
                        <p class="text-xs text-gray-500">Admin Panel</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="p-4 space-y-2">
                <a href="/admin/dashboard" class="flex items-center space-x-3 p-3 rounded-lg bg-purple-50 text-purple-600">
                    <span class="text-xl">📊</span>
                    <span class="font-medium">Dashboard</span>
                </a>
                <a href="{{ route('admin.menus.index') }}" class="flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-100">
                    <span class="text-xl">🍽️</span>
                    <span class="font-medium">Menu</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-100">
                    <span class="text-xl">👥</span>
                    <span class="font-medium">Users</span>
                </a>
                <a href="{{ route('admin.lapaks.index') }}" class="flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-100">
                    <span class="text-xl">🏪</span>
                    <span class="font-medium">Lapaks</span>
                </a>
                <a href="{{ route('admin.transaksi.index') }}" class="flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-100">
                    <span class="text-xl">📊</span>
                    <span class="font-medium">Laporan Transaksi</span>
                </a>
            </nav>

            <!-- Logout Button -->
            <div class="absolute bottom-0 w-full p-4 border-t">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center space-x-3 p-3 rounded-lg text-red-600 hover:bg-red-50 w-full">
                        <span class="text-xl">🚪</span>
                        <span class="font-medium">Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 ml-64 overflow-y-auto">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b px-6 py-4 flex items-center justify-between">
                <!-- Search Bar -->
                <div class="flex-1 max-w-xl">
                    <form action="{{ route('admin.search') }}" method="GET" class="flex items-center space-x-2">
                        <div class="relative flex-1">
                            <input 
                                type="text" 
                                name="q"
                                value="{{ request('q') }}"
                                placeholder="Cari menu, pesanan, user..." 
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
                            class="px-4 py-2 gradient-bg text-white rounded-lg hover:shadow-lg transition font-medium"
                        >
                            Cari
                        </button>
                    </form>
                </div>

                <!-- Right Side -->
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 gradient-bg rounded-full flex items-center justify-center text-white font-bold">
                            AD
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-gray-800">Admin</p>
                            <p class="text-xs text-gray-500">{{ session('username') ?? 'Administrator' }}</p>
                        </div>
                    </div>
                    <button class="p-2 hover:bg-gray-100 rounded-lg">
                        <span class="text-xl">🔔</span>
                    </button>
                    <button class="p-2 hover:bg-gray-100 rounded-lg">
                        <span class="text-xl">🏫</span>
                    </button>
                </div>
            </header>

            <!-- Dashboard Content -->
            <div class="p-6">
                <!-- Welcome Section -->
                <div class="mb-6">
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Dashboard</h1>
                    <p class="text-gray-600">Selamat datang kembali, Admin! 👋</p>
                </div>

                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Total Pesanan -->
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <span class="text-2xl">📋</span>
                            </div>
                            <span class="text-green-600 text-sm font-semibold">+12%</span>
                        </div>
                        <h3 class="text-gray-500 text-sm mb-1">Total Pesanan</h3>
                        <p class="text-3xl font-bold text-gray-800">{{ number_format($totalPesanan ?? 0, 0, ',', '.') }}</p>
                    </div>

                    <!-- Pendapatan -->
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <span class="text-2xl">💰</span>
                            </div>
                            <span class="text-green-600 text-sm font-semibold">+8%</span>
                        </div>
                        <h3 class="text-gray-500 text-sm mb-1">Pendapatan</h3>
                        <p class="text-3xl font-bold text-gray-800">{{ $pendapatanFormatted ?? 'Rp 0' }}</p>
                    </div>

                    <!-- Menu Aktif -->
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                <span class="text-2xl">📖</span>
                            </div>
                            <span class="text-blue-600 text-sm font-semibold">+3</span>
                        </div>
                        <h3 class="text-gray-500 text-sm mb-1">Menu Aktif</h3>
                        <p class="text-3xl font-bold text-gray-800">{{ $menuAktif ?? 0 }}</p>
                    </div>

                    <!-- Total User -->
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                                <span class="text-2xl">👥</span>
                            </div>
                            <span class="text-green-600 text-sm font-semibold">+24</span>
                        </div>
                        <h3 class="text-gray-500 text-sm mb-1">Total User</h3>
                        <p class="text-3xl font-bold text-gray-800">{{ number_format($totalUser ?? 0, 0, ',', '.') }}</p>
                    </div>
                </div>

                <!-- Two Column Layout -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Pesanan Terbaru -->
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-xl font-bold text-gray-800">Pesanan Terbaru</h2>
                            <a href="{{ route('admin.transaksi.index') }}" class="text-purple-600 text-sm font-medium hover:underline">Lihat Semua</a>
                        </div>
                        <div class="space-y-4">
                            @forelse($pesananTerbaru ?? [] as $pesanan)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-12 h-12 rounded-lg overflow-hidden flex-shrink-0">
                                            @php
                                                $menuImage = $pesanan->menu->image ?? null;
                                                $thumb = $menuImage ? 'menus/thumb_'.basename($menuImage) : null;
                                                $existsThumb = $thumb ? \Illuminate\Support\Facades\Storage::disk('public')->exists($thumb) : false;
                                                $existsMain = $menuImage ? \Illuminate\Support\Facades\Storage::disk('public')->exists($menuImage) : false;
                                            @endphp
                                            @if($existsThumb)
                                                <img src="{{ asset('storage/'.$thumb) }}" alt="{{ $pesanan->menu->nama_menu ?? 'Menu' }}" class="w-full h-full object-cover">
                                            @elseif($existsMain)
                                                <img src="{{ asset('storage/'.$menuImage) }}" alt="{{ $pesanan->menu->nama_menu ?? 'Menu' }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full bg-gradient-to-br from-orange-100 to-orange-200 rounded-lg flex items-center justify-center">
                                                    <span class="text-xl">🍚</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <p class="font-semibold text-gray-800 truncate">{{ $pesanan->menu->nama_menu ?? 'Menu' }}</p>
                                            <p class="text-sm text-gray-500 truncate">{{ $pesanan->user->name ?? 'User' }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold text-gray-800">Rp {{ number_format($pesanan->total_harga ?? 0, 0, ',', '.') }}</p>
                                        <span class="px-2 py-1 text-xs rounded-full 
                                            @if(($pesanan->status_transaksi ?? 'baru') == 'selesai') bg-green-100 text-green-600
                                            @elseif(($pesanan->status_transaksi ?? 'baru') == 'diproses') bg-yellow-100 text-yellow-600
                                            @else bg-blue-100 text-blue-600
                                            @endif">
                                            {{ ucfirst($pesanan->status_transaksi ?? 'Baru') }}
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
                            <select class="px-3 py-1 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none">
                                <option>Hari Ini</option>
                                <option>Minggu Ini</option>
                                <option>Bulan Ini</option>
                            </select>
                        </div>
                        <div class="space-y-4">
                            @forelse($menuTerlaris ?? [] as $index => $menu)
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between">
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
                                            <div class="min-w-0 flex-1">
                                                <p class="font-semibold text-gray-800 truncate">{{ $menu->nama_menu ?? 'Menu' }}</p>
                                                <p class="text-sm text-gray-500">{{ number_format($menu->total_terjual ?? 0, 0, ',', '.') }} porsi terjual</p>
                                            </div>
                                        </div>
                                        <p class="font-semibold text-gray-800">
                                            @if(($menu->total_pendapatan ?? 0) > 1000000)
                                                Rp {{ number_format(($menu->total_pendapatan ?? 0) / 1000000, 1, ',', '.') }}jt
                                            @else
                                                Rp {{ number_format($menu->total_pendapatan ?? 0, 0, ',', '.') }}
                                            @endif
                                        </p>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        @php
                                            $maxTerjual = $menuTerlaris->max('total_terjual') ?? 1;
                                            $percentage = (($menu->total_terjual ?? 0) / max($maxTerjual, 1)) * 100;
                                            $colors = ['bg-blue-500', 'bg-purple-500', 'bg-green-500', 'bg-orange-500', 'bg-yellow-500'];
                                            $color = $colors[$index % count($colors)] ?? 'bg-blue-500';
                                        @endphp
                                        <div class="{{ $color }} h-2 rounded-full" style="width: {{ min($percentage, 100) }}%"></div>
                                    </div>
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
            </div>
        </main>
</div>
</body>
</html>
