<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pencarian - Kantin D-pipe</title>
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
                <a href="/admin/dashboard" class="flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-100">
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
                                value="{{ $query }}"
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
                </div>
            </header>

            <!-- Search Results -->
            <div class="p-6">
                <!-- Header -->
                <div class="mb-6">
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Hasil Pencarian</h1>
                    <p class="text-gray-600">
                        Menampilkan <span class="font-semibold">{{ $totalResults }}</span> hasil untuk "<span class="font-semibold">{{ $query }}</span>"
                    </p>
                </div>

                @if($totalResults == 0)
                <!-- No Results -->
                <div class="bg-white rounded-xl shadow-md p-12 text-center">
                    <div class="text-6xl mb-4">🔍</div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Tidak ada hasil ditemukan</h3>
                    <p class="text-gray-600 mb-6">Coba gunakan kata kunci lain atau periksa ejaan</p>
                    <a href="{{ route('admin.dashboard') }}" class="inline-block px-6 py-3 gradient-bg text-white rounded-lg hover:shadow-lg transition font-medium">
                        Kembali ke Dashboard
                    </a>
                </div>
                @else
                <!-- Results -->
                <div class="space-y-6">
                    <!-- Menu Results -->
                    @if($results['menus']->count() > 0)
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                            <span class="text-2xl mr-2">🍽️</span>
                            Menu ({{ $results['menus']->count() }})
                        </h2>
                        <div class="space-y-3">
                            @foreach($results['menus'] as $menu)
                            <a href="{{ route('admin.menus.edit', $menu->menu_id) }}" class="block p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                                            <span class="text-2xl">🍚</span>
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-gray-800">{{ $menu->nama_menu }}</h3>
                                            <p class="text-sm text-gray-500">{{ $menu->kategori }} • Rp {{ number_format($menu->harga, 0, ',', '.') }}</p>
                                            @if($menu->lapak)
                                                <p class="text-xs text-gray-400 mt-1">Lapak: {{ $menu->lapak->nama_lapak }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <span class="px-3 py-1 text-xs rounded-full {{ $menu->stok > 0 ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                                        Stok: {{ $menu->stok }}
                                    </span>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Transaksi Results -->
                    @if($results['transaksis']->count() > 0)
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                            <span class="text-2xl mr-2">📋</span>
                            Transaksi ({{ $results['transaksis']->count() }})
                        </h2>
                        <div class="space-y-3">
                            @foreach($results['transaksis'] as $transaksi)
                            <a href="{{ route('admin.transaksi.show', $transaksi->transaksi_id) }}" class="block p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <span class="text-2xl">📦</span>
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-gray-800">#{{ $transaksi->transaksi_id }}</h3>
                                            <p class="text-sm text-gray-500">
                                                {{ $transaksi->menu->nama_menu ?? 'Menu' }} • 
                                                {{ $transaksi->user->name ?? 'User' }}
                                            </p>
                                            <p class="text-xs text-gray-400 mt-1">
                                                {{ $transaksi->waktu_transaksi ? $transaksi->waktu_transaksi->format('d M Y H:i') : '-' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold text-gray-800">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</p>
                                        <span class="px-3 py-1 text-xs rounded-full 
                                            @if($transaksi->status_transaksi == 'selesai') bg-green-100 text-green-600
                                            @elseif($transaksi->status_transaksi == 'diproses') bg-yellow-100 text-yellow-600
                                            @elseif($transaksi->status_transaksi == 'dibatalkan') bg-red-100 text-red-600
                                            @else bg-blue-100 text-blue-600
                                            @endif">
                                            {{ ucfirst($transaksi->status_transaksi) }}
                                        </span>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Lapak Results -->
                    @if($results['lapaks']->count() > 0)
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                            <span class="text-2xl mr-2">🏪</span>
                            Lapak ({{ $results['lapaks']->count() }})
                        </h2>
                        <div class="space-y-3">
                            @foreach($results['lapaks'] as $lapak)
                            <a href="{{ route('admin.lapaks.edit', $lapak->lapak_id) }}" class="block p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                                        @if($lapak->foto_profil)
                                            <img src="{{ asset('storage/' . $lapak->foto_profil) }}" alt="{{ $lapak->nama_lapak }}" class="w-12 h-12 rounded-lg object-cover">
                                        @else
                                            <span class="text-2xl">🏪</span>
                                        @endif
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-800">{{ $lapak->nama_lapak }}</h3>
                                        <p class="text-sm text-gray-500">Pemilik: {{ $lapak->pemilik ?? '-' }}</p>
                                        <p class="text-xs text-gray-400 mt-1">No. HP: {{ $lapak->no_hp_pemilik ?? '-' }}</p>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- User Results -->
                    @if($results['users']->count() > 0)
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                            <span class="text-2xl mr-2">👥</span>
                            User ({{ $results['users']->count() }})
                        </h2>
                        <div class="space-y-3">
                            @foreach($results['users'] as $user)
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="block p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                                        <span class="text-2xl">👤</span>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-800">{{ $user->name }}</h3>
                                        <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                        <p class="text-xs text-gray-400 mt-1">
                                            Terdaftar: {{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
                @endif
            </div>
        </main>
    </div>
</body>
</html>

