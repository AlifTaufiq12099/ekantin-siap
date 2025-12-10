<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi - Kantin D-pipe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .gradient-bg { background: linear-gradient(135deg, #FF8E53 0%, #FE6B8B 100%); }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('pembeli.lapak.select') }}" class="w-12 h-12 gradient-bg rounded-lg flex items-center justify-center text-white font-bold text-xl">
                        KD
                    </a>
                    <div>
                        <h1 class="text-xl font-bold text-gray-800">Notifikasi</h1>
                        <p class="text-xs text-gray-500">Semua notifikasi Anda</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('pembeli.lapak.select') }}" class="bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-lg text-sm font-medium transition">
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-6 py-6 max-w-4xl">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Semua Notifikasi</h2>
                @if($notifications->count() > 0)
                    <form action="{{ route('pembeli.notifications.markAllAsRead') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                            Tandai Semua Sudah Dibaca
                        </button>
                    </form>
                @endif
            </div>

            @if($notifications->count() > 0)
                <div class="space-y-3">
                    @foreach($notifications as $notification)
                        <div class="p-4 rounded-lg border {{ $notification->is_read ? 'bg-white border-gray-200' : 'bg-blue-50 border-blue-200' }} hover:shadow-md transition">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    @if($notification->link)
                                        <a href="{{ $notification->link }}" class="block">
                                    @endif
                                    <h3 class="font-semibold text-gray-800 text-lg">{{ $notification->title }}</h3>
                                    <p class="text-sm text-gray-600 mt-1">{{ $notification->message }}</p>
                                    <p class="text-xs text-gray-400 mt-2">{{ $notification->created_at->setTimezone('Asia/Jakarta')->format('d M Y H:i') }}</p>
                                    @if($notification->link)
                                        </a>
                                    @endif
                                </div>
                                <div class="flex items-center space-x-2 ml-4">
                                    @if(!$notification->is_read)
                                        <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                                    @endif
                                    @if(!$notification->is_read)
                                        <form action="{{ route('pembeli.notifications.markAsRead', $notification->notification_id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-xs text-blue-600 hover:text-blue-800">
                                                Tandai Dibaca
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($notifications->hasPages())
                <div class="mt-6">
                    {{ $notifications->links() }}
                </div>
                @endif
            @else
                <div class="text-center py-12">
                    <div class="text-6xl mb-4">🔔</div>
                    <p class="text-lg text-gray-500 mb-2">Tidak ada notifikasi</p>
                    <p class="text-sm text-gray-400">Notifikasi akan muncul di sini</p>
                </div>
            @endif
        </div>
    </div>
</body>
</html>

