<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Lapak - Kantin D-pipe</title>
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
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        .lapak-card {
            cursor: pointer;
            border: 3px solid transparent;
            transition: all 0.3s ease;
        }
        .lapak-card:hover {
            border-color: #FF8E53;
            transform: scale(1.02);
        }
        .lapak-card.selected {
            border-color: #FF8E53;
            background: linear-gradient(135deg, rgba(255, 142, 83, 0.1) 0%, rgba(254, 107, 139, 0.1) 100%);
        }

        /* Mobile Menu Toggle */
        .mobile-menu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }
        .mobile-menu.active {
            max-height: 500px;
        }

        /* Floating Button */
        .floating-btn {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 40;
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.4);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% {
                box-shadow: 0 8px 20px rgba(59, 130, 246, 0.4);
            }
            50% {
                box-shadow: 0 8px 30px rgba(59, 130, 246, 0.6);
            }
        }

        .floating-btn:hover {
            transform: scale(1.1);
            transition: transform 0.2s;
        }
    </style>
</head>
<body class="bg-gray-50">

    <!-- Navbar -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4 py-3">
            <!-- Desktop & Mobile Header -->
            <div class="flex items-center justify-between">
                <!-- Logo & Title -->
                <div class="flex items-center space-x-2">
                    <img src="{{ asset('image/logo-kantin.png') }}" alt="Logo Kantin D-pipe" class="w-12 h-12 rounded-lg object-cover shadow-md">

                   
                    <div>
                        <h1 class="text-base sm:text-xl font-bold text-gray-800">Kantin D-pipe</h1>
                        <p class="text-xs text-gray-500 hidden sm:block">⏰ 07:00 - 15:00</p>
                    </div>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-4">
                    <!-- Notification Bell -->
                    <div class="relative">
                        <button id="notification-btn" class="relative p-2 text-gray-600 hover:text-orange-600 hover:bg-orange-50 rounded-lg transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            <span id="notification-badge" class="absolute top-0 right-0 bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center hidden">0</span>
                        </button>
                    </div>
                    <a href="{{ route('pembeli.chat.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition text-sm font-medium">
                        💬 Chat
                    </a>
                    <a href="{{ route('pembeli.profile.edit') }}" class="flex items-center space-x-3 hover:bg-gray-100 px-3 py-2 rounded-lg transition cursor-pointer">
                        @if($user && $user->foto_profil)
                            <img src="{{ asset('storage/' . $user->foto_profil) }}" alt="Foto Profil" class="w-10 h-10 rounded-full object-cover border-2 border-orange-200">
                        @else
                            <div class="w-10 h-10 bg-gradient-to-br from-orange-400 to-pink-500 rounded-full flex items-center justify-center border-2 border-orange-200">
                                <span class="text-sm text-white">👤</span>
                            </div>
                        @endif
                    <div class="text-right">
                        <p class="text-sm font-semibold text-gray-800">{{ session('username') }}</p>
                        <p class="text-xs text-gray-500">Pembeli</p>
                    </div>
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition text-sm font-medium">
                            Logout
                        </button>
                    </form>
                </div>

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-btn" class="md:hidden p-2 rounded-lg hover:bg-gray-100 transition">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>

            <!-- Mobile Menu Dropdown -->
            <div id="mobile-menu" class="mobile-menu md:hidden">
                <div class="py-4 space-y-3 border-t mt-3">
                    <a href="{{ route('pembeli.chat.index') }}" class="block w-full bg-blue-500 text-white px-4 py-3 rounded-lg hover:bg-blue-600 transition text-sm font-medium text-center">
                        💬 Chat
                    </a>
                    <a href="{{ route('pembeli.profile.edit') }}" class="px-2 py-2 bg-gray-50 rounded-lg flex items-center space-x-3 hover:bg-gray-100 transition">
                        @if($user && $user->foto_profil)
                            <img src="{{ asset('storage/' . $user->foto_profil) }}" alt="Foto Profil" class="w-10 h-10 rounded-full object-cover border-2 border-orange-200">
                        @else
                            <div class="w-10 h-10 bg-gradient-to-br from-orange-400 to-pink-500 rounded-full flex items-center justify-center border-2 border-orange-200">
                                <span class="text-sm text-white">👤</span>
                            </div>
                        @endif
                        <div>
                        <p class="text-sm font-semibold text-gray-800">{{ session('username') }}</p>
                        <p class="text-xs text-gray-500">Pembeli</p>
                    </div>
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-red-500 text-white px-4 py-3 rounded-lg hover:bg-red-600 transition text-sm font-medium">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-4 sm:py-8">

        <!-- Welcome Section -->
        <div class="gradient-bg rounded-2xl sm:rounded-3xl p-4 sm:p-8 text-white mb-6 sm:mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl sm:text-3xl font-bold mb-1 sm:mb-2">Selamat Datang, {{ session('username') }}! 👋</h2>
                    <p class="text-sm sm:text-lg opacity-90">Pilih lapak favorit dan pesan makananmu!</p>
                </div>
                <div class="text-3xl sm:text-6xl">
                    🍽
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('key') === 'success')
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="text-green-800 font-semibold">{{ session('value') }}</span>
            </div>
        </div>
        @endif

        <!-- Pilih Lapak Section -->
        <div id="section-lapak">
            <h3 class="text-xl sm:text-2xl font-bold text-gray-800 mb-4 sm:mb-6">Pilih Lapak</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-8">
                @foreach($lapaks as $lapak)
                    <a href="{{ route('pembeli.lapak.show', $lapak->lapak_id) }}" class="lapak-card bg-white rounded-xl sm:rounded-2xl shadow-md p-4 sm:p-6 block">
                        <div class="flex items-start justify-between mb-3 sm:mb-4">
                            <div class="flex items-center space-x-2 sm:space-x-3">
                                @if($lapak->foto_profil)
                                    <img src="{{ asset('storage/' . $lapak->foto_profil) }}" alt="{{ $lapak->nama_lapak }}" class="w-12 h-12 sm:w-16 sm:h-16 rounded-lg sm:rounded-xl object-cover border-2 border-orange-200 shadow-md">
                                @else
                                    <div class="w-12 h-12 sm:w-16 sm:h-16 gradient-bg rounded-lg sm:rounded-xl flex items-center justify-center text-2xl sm:text-3xl">
                                        🏪
                                    </div>
                                @endif
                                <div>
                                    <h4 class="font-bold text-gray-800 text-base sm:text-lg">{{ $lapak->nama_lapak }}</h4>
                                    <p class="text-xs sm:text-sm text-gray-500">⭐ 4.8</p>
                                </div>
                            </div>
                            <span class="bg-green-100 text-green-700 px-2 sm:px-3 py-1 rounded-full text-xs font-semibold">Buka</span>
                        </div>
                        <div class="space-y-1 sm:space-y-2 text-xs sm:text-sm text-gray-600">
                            <div class="flex items-center">
                                <span class="mr-2">👤</span>
                                <span>{{ $lapak->pemilik ?? '-' }}</span>
                            </div>
                            <div class="flex items-center">
                                <span class="mr-2">📱</span>
                                <span>{{ $lapak->no_hp_pemilik ?? '-' }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

    </div>

    <!-- Floating Button Riwayat Pesanan -->
    <a href="{{ route('pembeli.riwayat') }}" class="floating-btn bg-blue-500 hover:bg-blue-600 text-white rounded-full p-4 flex items-center space-x-2 shadow-lg">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
        </svg>
        <span class="hidden sm:inline font-medium">Riwayat</span>
    </a>

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
                    <a href="{{ route('pembeli.notifications.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
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
            fetch('{{ route("pembeli.notifications.getNotifications") }}')
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
            if (badge) {
                if (count > 0) {
                    badge.textContent = count > 99 ? '99+' : count;
                    badge.classList.remove('hidden');
                } else {
                    badge.classList.add('hidden');
                }
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
            if (modal) {
                modal.classList.remove('hidden');
                isNotificationModalOpen = true;
                loadNotifications();
            }
        }

        // Close notification modal
        function closeNotificationModal() {
            const modal = document.getElementById('notification-modal');
            if (modal) {
                modal.classList.add('hidden');
                isNotificationModalOpen = false;
            }
        }

        // Mark notification as read
        function markAsRead(id) {
            const baseUrl = '{{ url("/pembeli/notifications") }}';
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

        // Mobile Menu Toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('active');
        });
        }

        // Select Lapak
        function selectLapak(slug, el) {
            document.querySelectorAll('.lapak-card').forEach(c => c.classList.remove('selected'));
            el.classList.add('selected');
        }

        // Notification event listeners
        const notificationBtn = document.getElementById('notification-btn');
        if (notificationBtn) {
            notificationBtn.addEventListener('click', openNotificationModal);
        }

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

</body>
</html>
