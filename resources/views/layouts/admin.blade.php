<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Kantin D-pipe</title>
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
    @stack('styles')
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
                <a href="/admin/dashboard" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->is('admin/dashboard') ? 'bg-purple-50 text-purple-600' : 'text-gray-700 hover:bg-gray-100' }}">
                    <span class="text-xl">📊</span>
                    <span class="font-medium">Dashboard</span>
                </a>
                <a href="{{ route('admin.menus.index') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('admin.menus.*') ? 'bg-purple-50 text-purple-600' : 'text-gray-700 hover:bg-gray-100' }}">
                    <span class="text-xl">🍽️</span>
                    <span class="font-medium">Menu</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('admin.users.*') ? 'bg-purple-50 text-purple-600' : 'text-gray-700 hover:bg-gray-100' }}">
                    <span class="text-xl">👥</span>
                    <span class="font-medium">Users</span>
                </a>
                <a href="{{ route('admin.lapaks.index') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('admin.lapaks.*') ? 'bg-purple-50 text-purple-600' : 'text-gray-700 hover:bg-gray-100' }}">
                    <span class="text-xl">🏪</span>
                    <span class="font-medium">Lapaks</span>
                </a>
                <a href="{{ route('admin.transaksi.index') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('admin.transaksi.*') ? 'bg-purple-50 text-purple-600' : 'text-gray-700 hover:bg-gray-100' }}">
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
                <!-- <div class="flex-1 max-w-xl">
                    <input 
                        type="text" 
                        placeholder="Cari menu, pesanan, user..." 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none"
                    >
                </div> -->

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

            <!-- Page Content -->
            <div class="p-6">
                @if(session('key') && session('value'))
                    <div class="mb-4 p-4 rounded-lg {{ session('key') === 'success' ? 'bg-green-50 border border-green-200 text-green-800' : 'bg-red-50 border border-red-200 text-red-800' }}">
                        {{ session('value') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    @stack('scripts')
</body>
</html>

