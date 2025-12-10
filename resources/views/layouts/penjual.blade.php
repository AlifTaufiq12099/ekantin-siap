<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Penjual') - Kantin D-pipe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #FF8E53 0%, #FE6B8B 100%);
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-lg fixed h-full">
            <!-- Logo Header -->
            <div class="p-6 border-b">
                <div class="flex items-center space-x-3 mb-4">
                <img src="{{ asset('image/logo-kantin.png') }}" alt="Logo Kantin D-pipe" class="w-12 h-12 rounded-lg object-cover shadow-md">

                    <div>
                        <h2 class="font-bold text-gray-800">Dashboard Penjual</h2>
                        <p class="text-xs text-gray-500">Kantin D-pipe</p>
                    </div>
                </div>

                <!-- Lapak Info Card -->
                @php
                    $penjualId = session('penjual_id');
                    $penjual = $penjualId ? \App\Models\Penjual::find($penjualId) : null;
                    $lapak = ($penjual && $penjual->lapak_id) ? \App\Models\Lapak::find($penjual->lapak_id) : null;
                @endphp
                @if($lapak)
                <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                    <div class="flex items-center space-x-2 mb-3">
                        <span class="text-2xl">🏪</span>
                        <h3 class="font-bold text-gray-800 text-sm">{{ $lapak->nama_lapak }}</h3>
                    </div>
                    <div class="space-y-1 text-xs text-gray-600 mb-3">
                        
                        <p>👤 {{ $lapak->pemilik ?? '-' }}</p>
                        <p>📱 {{ $lapak->no_hp_pemilik ?? '-' }}</p>
                    </div>
                    <a href="{{ route('penjual.lapak.edit') }}" class="text-orange-500 text-xs font-semibold hover:text-orange-600">
                        Edit Profil →
                    </a>
                </div>
                @endif
            </div>

            <!-- Navigation -->
            <nav class="p-4 space-y-2">
                <a href="{{ route('penjual.dashboard') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('penjual.dashboard') ? 'bg-orange-50 text-orange-600 border-l-4 border-orange-500' : 'text-gray-700 hover:bg-gray-100' }}">
                    <span class="text-xl">📊</span>
                    <span class="font-medium">Dashboard</span>
                </a>
                <a href="{{ route('penjual.transaksi.index') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('penjual.transaksi.*') ? 'bg-orange-50 text-orange-600 border-l-4 border-orange-500' : 'text-gray-700 hover:bg-gray-100' }}">
                    <span class="text-xl">📋</span>
                    <span class="font-medium">Pesanan</span>
                </a>
                <a href="{{ route('penjual.menus.index') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('penjual.menus.*') ? 'bg-orange-50 text-orange-600 border-l-4 border-orange-500' : 'text-gray-700 hover:bg-gray-100' }}">
                    <span class="text-xl">🍽️</span>
                    <span class="font-medium">Menu</span>
                </a>
                <a href="{{ route('penjual.keuangan.index') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('penjual.keuangan.*') ? 'bg-orange-50 text-orange-600 border-l-4 border-orange-500' : 'text-gray-700 hover:bg-gray-100' }}">
                    <span class="text-xl">💰</span>
                    <span class="font-medium">Laporan Keuangan</span>
                </a>
                <a href="{{ route('penjual.feedback.index') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('penjual.feedback.*') ? 'bg-orange-50 text-orange-600 border-l-4 border-orange-500' : 'text-gray-700 hover:bg-gray-100' }}">
                    <span class="text-xl">⭐</span>
                    <span class="font-medium">Rating & Feedback</span>
                </a>
                <a href="{{ route('penjual.chat.index') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('penjual.chat.*') ? 'bg-orange-50 text-orange-600 border-l-4 border-orange-500' : 'text-gray-700 hover:bg-gray-100' }}">
                    <span class="text-xl">💬</span>
                    <span class="font-medium">Chat</span>
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
                <div class="flex-1">
                    <h1 class="text-2xl font-bold text-gray-800">@yield('page-title', 'Dashboard')</h1>
                    @hasSection('page-subtitle')
                        <p class="text-sm text-gray-600 mt-1">@yield('page-subtitle')</p>
                    @endif
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Notification Bell -->
                    <div class="relative">
                        <button id="notification-btn" class="relative p-2 text-gray-600 hover:text-orange-600 hover:bg-orange-50 rounded-lg transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            <span id="notification-badge" class="absolute top-0 right-0 bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center hidden">0</span>
                        </button>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-semibold text-gray-800">Hari ini</p>
                        <p class="text-xs text-gray-500">{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</p>
                    </div>
                    <div class="w-10 h-10 gradient-bg rounded-full flex items-center justify-center text-white font-bold">
                        {{ substr(session('username') ?? 'P', 0, 1) }}
                    </div>
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

    <!-- Notification Modal -->
    <div id="notification-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" onclick="closeNotificationModal()"></div>
            <div class="relative bg-white rounded-lg shadow-xl w-full max-w-md transform transition-all">
                <!-- Modal Header -->
                <div class="flex items-center justify-between p-4 border-b">
                    <h3 class="text-lg font-semibold text-gray-800">Notifikasi Sistem</h3>
                    <button onclick="closeNotificationModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <!-- Modal Body -->
                <div id="notification-content" class="p-4 max-h-96 overflow-y-auto">
                    <div class="text-center py-8 text-gray-500">
                        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-orange-500 mx-auto"></div>
                        <p class="mt-2">Memuat notifikasi...</p>
                    </div>
                </div>
                <!-- Modal Footer -->
                <div class="p-4 border-t bg-gray-50">
                    <a href="{{ route('penjual.notifications.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        Lihat Seluruh Notifikasi →
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        let notificationPolling = null;
        let isNotificationModalOpen = false;

        // Load notifications
        function loadNotifications() {
            fetch('{{ route("penjual.notifications.getNotifications") }}')
                .then(response => response.json())
                .then(data => {
                    updateNotificationBadge(data.unread_count);
                    if (isNotificationModalOpen) {
                        updateNotificationContent(data.notifications);
                    }
                })
                .catch(error => {
                    console.error('Error loading notifications:', error);
                });
        }

        // Update notification badge
        function updateNotificationBadge(count) {
            const badge = document.getElementById('notification-badge');
            if (count > 0) {
                badge.textContent = count > 99 ? '99+' : count;
                badge.classList.remove('hidden');
            } else {
                badge.classList.add('hidden');
            }
        }

        // Update notification content
        function updateNotificationContent(notifications) {
            const content = document.getElementById('notification-content');
            
            if (notifications.length === 0) {
                content.innerHTML = `
                    <div class="text-center py-8 text-gray-500">
                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        <p>Tidak ada notifikasi</p>
                    </div>
                `;
                return;
            }

            content.innerHTML = notifications.map(notif => {
                const link = notif.link ? `onclick="window.location.href='${notif.link}'" style="cursor: pointer;"` : '';
                return `
                <div class="mb-3 p-3 rounded-lg border ${notif.is_read ? 'bg-white border-gray-200' : 'bg-blue-50 border-blue-200'}" ${link}>
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-800 text-sm">${notif.title}</h4>
                            <p class="text-sm text-gray-600 mt-1">${notif.message}</p>
                            <p class="text-xs text-gray-400 mt-1">${notif.created_at}</p>
                        </div>
                        ${!notif.is_read ? '<div class="w-2 h-2 bg-blue-500 rounded-full ml-2 mt-1"></div>' : ''}
                    </div>
                </div>
            `;
            }).join('');
        }

        // Open notification modal
        function openNotificationModal() {
            const modal = document.getElementById('notification-modal');
            modal.classList.remove('hidden');
            isNotificationModalOpen = true;
            loadNotifications();
        }

        // Close notification modal
        function closeNotificationModal() {
            const modal = document.getElementById('notification-modal');
            modal.classList.add('hidden');
            isNotificationModalOpen = false;
        }

        // Mark notification as read
        function markAsRead(id) {
            const baseUrl = '{{ url("/penjual/notifications") }}';
            const url = baseUrl + '/' + id + '/read';
            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                loadNotifications();
            })
            .catch(error => {
                console.error('Error marking as read:', error);
            });
        }

        // Event listeners
        document.getElementById('notification-btn').addEventListener('click', openNotificationModal);

        // Poll for new notifications every 10 seconds
        notificationPolling = setInterval(loadNotifications, 10000);

        // Initial load
        loadNotifications();

        // Stop polling when page is hidden
        document.addEventListener('visibilitychange', function() {
            if (document.hidden) {
                if (notificationPolling) {
                    clearInterval(notificationPolling);
                }
            } else {
                notificationPolling = setInterval(loadNotifications, 10000);
                loadNotifications();
            }
        });
    </script>

    @stack('scripts')
</body>
</html>

