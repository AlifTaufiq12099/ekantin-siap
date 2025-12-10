<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Kantin D-pipe</title>
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

    <!-- Alert Success -->
    @if(session('key') === 'success')
    <div class="container mx-auto px-6 mt-4">
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center justify-between">
            <span>✅ {{ session('value') }}</span>
            <button onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900">✕</button>
        </div>
    </div>
    @endif

    <!-- Main Content -->
    <div class="container mx-auto px-6 py-8">

        <!-- Welcome Section -->
        <div class="gradient-bg rounded-3xl p-8 text-white mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-bold mb-2">Selamat Datang, {{ session('username') }}! 👋</h2>
                    <p class="text-lg opacity-90">Mau pesan apa hari ini?</p>
                </div>
                <div class="hidden md:block text-6xl">
                    🍽️
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-2xl p-6 shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm mb-1">Total Pesanan</p>
                        <h3 class="text-3xl font-bold text-gray-800">12</h3>
                    </div>
                    <div class="w-14 h-14 bg-orange-100 rounded-xl flex items-center justify-center">
                        <span class="text-3xl">📦</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm mb-1">Dalam Proses</p>
                        <h3 class="text-3xl font-bold text-gray-800">2</h3>
                    </div>
                    <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center">
                        <span class="text-3xl">🔄</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm mb-1">Siap Diambil</p>
                        <h3 class="text-3xl font-bold text-gray-800">1</h3>
                    </div>
                    <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center">
                        <span class="text-3xl">✅</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="flex space-x-4 border-b mb-6">
            <button onclick="showTab('makanan')" id="tab-makanan" class="tab-button pb-3 px-4 font-semibold text-orange-500 border-b-2 border-orange-500">
                Makanan
            </button>
            <button onclick="showTab('minuman')" id="tab-minuman" class="tab-button pb-3 px-4 font-semibold text-gray-500 hover:text-orange-500">
                Minuman
            </button>
            <button onclick="showTab('pesanan')" id="tab-pesanan" class="tab-button pb-3 px-4 font-semibold text-gray-500 hover:text-orange-500">
                Pesanan Saya
            </button>
        </div>

        <!-- Menu Makanan -->
        <div id="content-makanan" class="tab-content">
            <h3 class="text-2xl font-bold text-gray-800 mb-6">Menu Makanan</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                <!-- Menu Item 1 -->
                <div class="bg-white rounded-2xl shadow-md overflow-hidden card-hover">
                    <div class="h-40 bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center">
                        <span class="text-7xl">🍚</span>
                    </div>
                    <div class="p-5">
                        <h4 class="text-lg font-bold text-gray-800 mb-1">Nasi Gila</h4>
                        <p class="text-sm text-gray-500 mb-3">Nasi dengan campuran lengkap</p>
                        <div class="flex items-center justify-between">
                            <span class="text-xl font-bold text-orange-500">Rp 10.000</span>
                            <button class="bg-orange-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-orange-600 transition">
                                Pesan
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Menu Item 2 -->
                <div class="bg-white rounded-2xl shadow-md overflow-hidden card-hover">
                    <div class="h-40 bg-gradient-to-br from-yellow-400 to-orange-500 flex items-center justify-center">
                        <span class="text-7xl">🍜</span>
                    </div>
                    <div class="p-5">
                        <h4 class="text-lg font-bold text-gray-800 mb-1">Mie Jawa</h4>
                        <p class="text-sm text-gray-500 mb-3">Mie goreng ala Jawa</p>
                        <div class="flex items-center justify-between">
                            <span class="text-xl font-bold text-orange-500">Rp 10.000</span>
                            <button class="bg-orange-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-orange-600 transition">
                                Pesan
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Menu Item 3 -->
                <div class="bg-white rounded-2xl shadow-md overflow-hidden card-hover">
                    <div class="h-40 bg-gradient-to-br from-red-400 to-pink-500 flex items-center justify-center">
                        <span class="text-7xl">🍗</span>
                    </div>
                    <div class="p-5">
                        <h4 class="text-lg font-bold text-gray-800 mb-1">Ayam Geprek</h4>
                        <p class="text-sm text-gray-500 mb-3">Ayam crispy dengan sambal</p>
                        <div class="flex items-center justify-between">
                            <span class="text-xl font-bold text-orange-500">Rp 12.000</span>
                            <button class="bg-orange-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-orange-600 transition">
                                Pesan
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Menu Item 4 -->
                <div class="bg-white rounded-2xl shadow-md overflow-hidden card-hover">
                    <div class="h-40 bg-gradient-to-br from-green-400 to-emerald-500 flex items-center justify-center">
                        <span class="text-7xl">🥗</span>
                    </div>
                    <div class="p-5">
                        <h4 class="text-lg font-bold text-gray-800 mb-1">Gado-Gado</h4>
                        <p class="text-sm text-gray-500 mb-3">Sayuran dengan bumbu kacang</p>
                        <div class="flex items-center justify-between">
                            <span class="text-xl font-bold text-orange-500">Rp 8.000</span>
                            <button class="bg-orange-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-orange-600 transition">
                                Pesan
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Menu Minuman -->
        <div id="content-minuman" class="tab-content hidden">
            <h3 class="text-2xl font-bold text-gray-800 mb-6">Menu Minuman</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                <!-- Minuman 1 -->
                <div class="bg-white rounded-2xl shadow-md overflow-hidden card-hover">
                    <div class="h-40 bg-gradient-to-br from-amber-400 to-orange-600 flex items-center justify-center">
                        <span class="text-7xl">🥤</span>
                    </div>
                    <div class="p-5">
                        <h4 class="text-lg font-bold text-gray-800 mb-1">Es Teh</h4>
                        <p class="text-sm text-gray-500 mb-3">Teh manis dingin segar</p>
                        <div class="flex items-center justify-between">
                            <span class="text-xl font-bold text-orange-500">Rp 5.000</span>
                            <button class="bg-orange-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-orange-600 transition">
                                Pesan
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Minuman 2 -->
                <div class="bg-white rounded-2xl shadow-md overflow-hidden card-hover">
                    <div class="h-40 bg-gradient-to-br from-yellow-300 to-yellow-500 flex items-center justify-center">
                        <span class="text-7xl">🍺</span>
                    </div>
                    <div class="p-5">
                        <h4 class="text-lg font-bold text-gray-800 mb-1">Es Jeruk</h4>
                        <p class="text-sm text-gray-500 mb-3">Jeruk peras segar</p>
                        <div class="flex items-center justify-between">
                            <span class="text-xl font-bold text-orange-500">Rp 5.000</span>
                            <button class="bg-orange-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-orange-600 transition">
                                Pesan
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Minuman 3 -->
                <div class="bg-white rounded-2xl shadow-md overflow-hidden card-hover">
                    <div class="h-40 bg-gradient-to-br from-pink-300 to-pink-500 flex items-center justify-center">
                        <span class="text-7xl">🥛</span>
                    </div>
                    <div class="p-5">
                        <h4 class="text-lg font-bold text-gray-800 mb-1">Susu Coklat</h4>
                        <p class="text-sm text-gray-500 mb-3">Susu coklat premium</p>
                        <div class="flex items-center justify-between">
                            <span class="text-xl font-bold text-orange-500">Rp 6.000</span>
                            <button class="bg-orange-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-orange-600 transition">
                                Pesan
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Minuman 4 -->
                <div class="bg-white rounded-2xl shadow-md overflow-hidden card-hover">
                    <div class="h-40 bg-gradient-to-br from-green-300 to-green-500 flex items-center justify-center">
                        <span class="text-7xl">🧃</span>
                    </div>
                    <div class="p-5">
                        <h4 class="text-lg font-bold text-gray-800 mb-1">Jus Alpukat</h4>
                        <p class="text-sm text-gray-500 mb-3">Alpukat segar blend</p>
                        <div class="flex items-center justify-between">
                            <span class="text-xl font-bold text-orange-500">Rp 8.000</span>
                            <button class="bg-orange-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-orange-600 transition">
                                Pesan
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Pesanan Saya -->
        <div id="content-pesanan" class="tab-content hidden">
            <h3 class="text-2xl font-bold text-gray-800 mb-6">Pesanan Saya</h3>

            <!-- Order Item -->
            <div class="bg-white rounded-2xl shadow-md p-6 mb-4">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h4 class="font-bold text-gray-800 text-lg">#ORD-001</h4>
                        <p class="text-sm text-gray-500">10 Oktober 2025 - 10:30</p>
                    </div>
                    <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-semibold">
                        Siap Diambil
                    </span>
                </div>
                <div class="border-t pt-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-gray-600">2x Nasi Gila</span>
                        <span class="font-semibold">Rp 20.000</span>
                    </div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-gray-600">1x Es Teh</span>
                        <span class="font-semibold">Rp 5.000</span>
                    </div>
                    <div class="border-t mt-3 pt-3 flex items-center justify-between">
                        <span class="font-bold text-gray-800">Total</span>
                        <span class="font-bold text-xl text-orange-500">Rp 25.000</span>
                    </div>
                </div>
            </div>

            <!-- Order Item 2 -->
            <div class="bg-white rounded-2xl shadow-md p-6 mb-4">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h4 class="font-bold text-gray-800 text-lg">#ORD-002</h4>
                        <p class="text-sm text-gray-500">10 Oktober 2025 - 11:00</p>
                    </div>
                    <span class="bg-blue-100 text-blue-700 px-4 py-2 rounded-full text-sm font-semibold">
                        Dalam Proses
                    </span>
                </div>
                <div class="border-t pt-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-gray-600">1x Mie Jawa</span>
                        <span class="font-semibold">Rp 10.000</span>
                    </div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-gray-600">1x Es Jeruk</span>
                        <span class="font-semibold">Rp 5.000</span>
                    </div>
                    <div class="border-t mt-3 pt-3 flex items-center justify-between">
                        <span class="font-bold text-gray-800">Total</span>
                        <span class="font-bold text-xl text-orange-500">Rp 15.000</span>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <script>
        function showTab(tabName) {
            // Hide all contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });

            // Remove active from all buttons
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('text-orange-500', 'border-b-2', 'border-orange-500');
                button.classList.add('text-gray-500');
            });

            // Show selected content
            document.getElementById('content-' + tabName).classList.remove('hidden');

            // Add active to selected button
            const activeButton = document.getElementById('tab-' + tabName);
            activeButton.classList.remove('text-gray-500');
            activeButton.classList.add('text-orange-500', 'border-b-2', 'border-orange-500');
        }
    </script>

</body>
</html>
