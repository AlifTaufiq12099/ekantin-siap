<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat - Kantin D-pipe</title>
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
                        <h1 class="text-xl font-bold text-gray-800">Chat</h1>
                        <p class="text-xs text-gray-500">Pesan dengan penjual</p>
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
        @if(session('key') === 'success')
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-4">
                {{ session('value') }}
            </div>
        @endif

        @if(session('key') === 'error')
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-4">
                {{ session('value') }}
            </div>
        @endif

        <h2 class="text-2xl font-bold text-gray-800 mb-6">Daftar Chat</h2>

        @if($lapaksWithChat->count() > 0)
            <div class="space-y-3">
                @foreach($lapaksWithChat as $lapak)
                    <a href="{{ route('pembeli.chat.show', $lapak->lapak_id) }}" class="block bg-white rounded-xl shadow-md hover:shadow-lg transition p-4 border-l-4 border-orange-400">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4 flex-1">
                                <div class="w-14 h-14 gradient-bg rounded-full flex items-center justify-center text-white text-2xl font-bold">
                                    🏪
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-bold text-gray-800 text-lg">{{ $lapak->nama_lapak }}</h3>
                                    @if($lapak->last_message)
                                        <p class="text-sm text-gray-600 truncate mt-1">
                                            {{ $lapak->last_message->message }}
                                        </p>
                                        <p class="text-xs text-gray-400 mt-1">
                                            {{ $lapak->last_message->created_at->setTimezone('Asia/Jakarta')->diffForHumans() }}
                                        </p>
                                    @else
                                        <p class="text-sm text-gray-400 italic">Belum ada pesan</p>
                                    @endif
                                </div>
                            </div>
                            @if($lapak->unread_count > 0)
                                <div class="ml-4">
                                    <span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                                        {{ $lapak->unread_count }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-xl shadow-md p-12 text-center">
                <div class="text-6xl mb-4">💬</div>
                <p class="text-lg text-gray-500 mb-2">Belum ada chat</p>
                <p class="text-sm text-gray-400">Mulai chat dengan penjual dari halaman detail lapak</p>
                <a href="{{ route('pembeli.lapak.select') }}" class="inline-block mt-4 bg-gradient-to-r from-orange-500 to-pink-500 text-white px-6 py-2 rounded-lg hover:shadow-lg transition">
                    Pilih Lapak
                </a>
            </div>
        @endif
    </div>
</body>
</html>

