<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kantin D-pipe - Pesan Makanan Kampus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #FF8E53 0%, #FE6B8B 100%);
        }
        .hero-pattern {
            background-color: #FF8E53;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        .fade-in {
            animation: fadeIn 1s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            backdrop-filter: blur(5px);
        }
        .modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .modal-content {
            animation: slideDown 0.3s ease;
        }
        @keyframes slideDown {
            from { transform: translateY(-50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        /* WhatsApp Floating Button */
        .whatsapp-float {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 30px;
            right: 30px;
            background-color: #25d366;
            color: #FFF;
            border-radius: 50px;
            text-align: center;
            font-size: 30px;
            box-shadow: 2px 2px 10px rgba(0,0,0,0.3);
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            animation: pulse 2s infinite;
        }
        .whatsapp-float:hover {
            transform: scale(1.1);
            box-shadow: 2px 2px 20px rgba(0,0,0,0.4);
            animation: none;
        }
        .whatsapp-float svg {
            width: 35px;
            height: 35px;
            fill: white;
        }
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.7);
            }
            70% {
                box-shadow: 0 0 0 15px rgba(37, 211, 102, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(37, 211, 102, 0);
            }
        }
        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        /* Marquee Animation */
        .marquee-container {
            overflow: hidden;
            white-space: nowrap;
            position: relative;
            background: linear-gradient(135deg, #FFE5B4 0%, #FFD89B 100%);
            padding: 25px 0;
            border-radius: 20px;
        }
        .marquee-wrapper {
            display: flex;
            width: fit-content;
        }
        .marquee-content {
            display: flex;
            animation: marquee 40s linear infinite;
        }
        .marquee-container:hover .marquee-content {
            animation-play-state: paused;
        }
        @keyframes marquee {
            0% {
                transform: translateX(0);
            }
            100% {
                transform: translateX(-50%);
            }
        }
        .feedback-item {
            display: inline-flex;
            flex-shrink: 0;
            margin-right: 40px;
            padding: 20px 25px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            white-space: normal;
            width: 380px;
            vertical-align: top;
            transition: transform 0.3s ease;
        }
        .feedback-item:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
        }
    </style>
</head>
<body class="bg-gray-50">

    <!-- Navbar -->
    <nav class="bg-white shadow-lg fixed w-full top-0 z-50">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('image/logo-kantin.png') }}" alt="Logo Kantin D-pipe" class="w-12 h-12 rounded-lg object-cover shadow-md">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Kantin D-pipe</h1>
                        <p class="text-xs text-gray-500">Pesan Makanan Kampus</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="#menu" class="hidden md:block text-gray-600 hover:text-orange-500 transition">Menu</a>
                    <a href="#tentang" class="hidden md:block text-gray-600 hover:text-orange-500 transition">Tentang</a>
                    <!-- Tombol Login -->
                    <button onclick="openUserLoginModal()" class="bg-gradient-to-r from-orange-500 to-pink-500 text-white px-6 py-2 rounded-full hover:shadow-lg transition font-medium">
                        Masuk / Daftar
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-pattern pt-32 pb-20 px-6">
        <div class="container mx-auto text-center fade-in">
            <h2 class="text-5xl md:text-6xl font-bold text-white mb-6 leading-tight">
                Pesan Makanan Kampus<br/>
                <span class="text-yellow-300">Jadi Lebih Mudah</span>
            </h2>
            <p class="text-white text-lg md:text-xl mb-8 max-w-2xl mx-auto">
                Hemat waktu dengan memesan makanan favoritmu secara online. Tinggal datang dan ambil!
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                <button onclick="openUserLoginModal()" class="bg-white text-orange-500 px-8 py-4 rounded-full text-lg font-semibold hover:shadow-2xl transition transform hover:scale-105">
                    🍽️ Pesan Sekarang
                </button>
                <a href="#menu" class="border-2 border-white text-white px-8 py-4 rounded-full text-lg font-semibold hover:bg-white hover:text-orange-500 transition">
                    Lihat Menu
                </a>
            </div>
            <div class="mt-8 text-white">
                <p class="text-sm">⏰ Jam Operasional: <span class="font-semibold">07:00 - 15:00</span></p>
            </div>
        </div>
    </section>

    <!-- Menu Populer -->
    <section id="menu" class="py-20 px-6 bg-white">
        <div class="container mx-auto">
            <div class="text-center mb-12">
                <h3 class="text-4xl font-bold text-gray-800 mb-4">Menu Populer</h3>
                <p class="text-gray-600">Makanan dan minuman favorit mahasiswa</p>
            </div>

            @if($menuPopuler->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($menuPopuler as $menu)
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-hover border border-gray-100">
                    <div class="h-48 bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center relative overflow-hidden">
                        @if($menu->image)
                            <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->nama_menu }}" class="w-full h-full object-cover">
                        @else
                            <div class="text-6xl opacity-80">
                                @if($menu->kategori === 'Makanan')
                                    🍽️
                                @elseif($menu->kategori === 'Minuman')
                                    🥤
                                @else
                                    🍴
                                @endif
                            </div>
                        @endif
                        @if($menu->stok > 0)
                            <div class="absolute top-2 right-2 bg-green-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                Stok: {{ $menu->stok }}
                            </div>
                        @else
                            <div class="absolute top-2 right-2 bg-red-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                Habis
                            </div>
                        @endif
                    </div>
                    <div class="p-6">
                        <h4 class="text-xl font-bold text-gray-800 mb-2 line-clamp-1">{{ $menu->nama_menu }}</h4>
                        @if($menu->deskripsi)
                            <p class="text-sm text-gray-500 mb-2 line-clamp-2">{{ $menu->deskripsi }}</p>
                        @endif
                        <div class="flex items-center justify-between mb-3">
                            <p class="text-orange-500 font-bold text-2xl">Rp {{ number_format($menu->harga, 0, ',', '.') }}</p>
                            @if($menu->lapak)
                                <span class="text-xs text-gray-400 bg-gray-100 px-2 py-1 rounded">{{ $menu->lapak->nama_lapak }}</span>
                            @endif
                        </div>
                        <button onclick="openUserLoginModal()" class="w-full bg-gradient-to-r from-orange-500 to-pink-500 text-white py-2.5 rounded-lg hover:shadow-lg transition transform hover:scale-105 font-semibold">
                            🛒 Pesan Sekarang
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-12">
                <div class="text-6xl mb-4">🍽️</div>
                <p class="text-gray-500 text-lg">Belum ada menu tersedia saat ini</p>
                <p class="text-gray-400 text-sm mt-2">Silakan coba lagi nanti</p>
            </div>
            @endif

            @if($menuPopuler->count() > 0)
            <div class="text-center mt-12">
                <button onclick="openUserLoginModal()" class="bg-gradient-to-r from-orange-500 to-pink-500 text-white px-8 py-4 rounded-full text-lg font-semibold hover:shadow-2xl transition transform hover:scale-105">
                    Lihat Semua Menu →
                </button>
            </div>
            @endif
        </div>
    </section>
<!-- Feedback Rating 5 Section -->
@if(isset($feedbackRating5) && $feedbackRating5->count() > 0)
    <section class="py-12 px-6 bg-gradient-to-br from-yellow-50 to-orange-50">
        <div class="container mx-auto">
            <div class="text-center mb-8">
                <h3 class="text-3xl font-bold text-gray-800 mb-2 flex items-center justify-center">
                    <span class="text-4xl mr-3">⭐</span>
                    Testimoni Pelanggan
                </h3>
                <p class="text-gray-600">Apa kata mereka yang sudah mencoba</p>
            </div>
            
            <div class="marquee-container rounded-2xl shadow-lg">
                <div class="marquee-wrapper">
                    <div class="marquee-content">
                        @foreach($feedbackRating5 as $feedback)
                        <div class="feedback-item">
                            <div class="w-full">
                                <div class="flex items-center mb-3">
                                    <div class="flex items-center space-x-1 mr-3">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span class="text-yellow-400 text-xl">⭐</span>
                                        @endfor
                                    </div>
                                    <span class="text-sm font-bold text-gray-800">{{ $feedback->user->name ?? 'Pelanggan' }}</span>
                                </div>
                                <p class="text-gray-700 italic text-sm leading-relaxed mb-2">"{{ $feedback->feedback }}"</p>
                                @if($feedback->lapak)
                                    <p class="text-xs text-gray-500 mt-2 flex items-center">
                                        <span class="mr-1">🏪</span>
                                        {{ $feedback->lapak->nama_lapak }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                        <!-- Duplicate untuk seamless loop -->
                        @foreach($feedbackRating5 as $feedback)
                        <div class="feedback-item">
                            <div class="w-full">
                                <div class="flex items-center mb-3">
                                    <div class="flex items-center space-x-1 mr-3">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span class="text-yellow-400 text-xl">⭐</span>
                                        @endfor
                                    </div>
                                    <span class="text-sm font-bold text-gray-800">{{ $feedback->user->name ?? 'Pelanggan' }}</span>
                                </div>
                                <p class="text-gray-700 italic text-sm leading-relaxed mb-2">"{{ $feedback->feedback }}"</p>
                                @if($feedback->lapak)
                                    <p class="text-xs text-gray-500 mt-2 flex items-center">
                                        <span class="mr-1">🏪</span>
                                        {{ $feedback->lapak->nama_lapak }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
    <!-- Lapak Section -->
    @if($lapaks->count() > 0)
    <section class="py-20 px-6 bg-gradient-to-br from-orange-50 to-pink-50">
        <div class="container mx-auto">
            <div class="text-center mb-12">
                <h3 class="text-4xl font-bold text-gray-800 mb-4">Lapak Tersedia</h3>
                <p class="text-gray-600">Pilih lapak favoritmu untuk memesan</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-6xl mx-auto">
                @foreach($lapaks as $lapak)
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-hover border border-gray-100">
                    <div class="h-40 bg-gradient-to-br from-orange-400 to-pink-500 flex items-center justify-center relative overflow-hidden">
                        @if($lapak->foto_profil)
                            <img src="{{ asset('storage/' . $lapak->foto_profil) }}" alt="{{ $lapak->nama_lapak }}" class="w-full h-full object-cover">
                        @else
                            <div class="text-6xl">🏪</div>
                        @endif
                    </div>
                    <div class="p-6">
                        <h4 class="text-xl font-bold text-gray-800 mb-2">{{ $lapak->nama_lapak }}</h4>
                        <p class="text-gray-600 text-sm mb-4">{{ $lapak->deskripsi ?? 'Lapak makanan dan minuman' }}</p>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-500">📍 {{ $lapak->lokasi ?? 'Kampus' }}</span>
                            <button onclick="openUserLoginModal()" class="bg-gradient-to-r from-orange-500 to-pink-500 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:shadow-lg transition">
                                Kunjungi →
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    

    <!-- Fitur Section -->
    <section id="tentang" class="py-20 px-6 bg-white">
        <div class="container mx-auto">
            <div class="text-center mb-12">
                <h3 class="text-4xl font-bold text-gray-800 mb-4">Kenapa Pilih Kami?</h3>
                <p class="text-gray-600">Solusi terbaik untuk kebutuhan makan siangmu</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <div class="text-center p-8 bg-gradient-to-br from-orange-50 to-pink-50 rounded-2xl shadow-lg card-hover border border-orange-100">
                    <div class="w-20 h-20 gradient-bg rounded-full flex items-center justify-center mx-auto mb-4 transform hover:scale-110 transition">
                        <span class="text-4xl">⚡</span>
                    </div>
                    <h4 class="text-xl font-bold text-gray-800 mb-2">Hemat Waktu</h4>
                    <p class="text-gray-600">Pesan online, ambil langsung tanpa antri panjang</p>
                </div>

                <div class="text-center p-8 bg-gradient-to-br from-orange-50 to-pink-50 rounded-2xl shadow-lg card-hover border border-orange-100">
                    <div class="w-20 h-20 gradient-bg rounded-full flex items-center justify-center mx-auto mb-4 transform hover:scale-110 transition">
                        <span class="text-4xl">💳</span>
                    </div>
                    <h4 class="text-xl font-bold text-gray-800 mb-2">Pembayaran Mudah</h4>
                    <p class="text-gray-600">Bayar tunai atau transfer, semua bisa</p>
                </div>

                <div class="text-center p-8 bg-gradient-to-br from-orange-50 to-pink-50 rounded-2xl shadow-lg card-hover border border-orange-100">
                    <div class="w-20 h-20 gradient-bg rounded-full flex items-center justify-center mx-auto mb-4 transform hover:scale-110 transition">
                        <span class="text-4xl">🎯</span>
                    </div>
                    <h4 class="text-xl font-bold text-gray-800 mb-2">Terpercaya</h4>
                    <p class="text-gray-600">Digunakan oleh ribuan mahasiswa setiap hari</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Floating WhatsApp Button -->
    <a href="https://wa.me/6282287191389?text=Halo%20Kantin%20D-pipe,%20saya%20ingin%20menayakan%20sesuatu"
       target="_blank"
       class="whatsapp-float"
       title="Chat WhatsApp">
        <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
            <path d="M16.002 0h-.004C7.162 0 0 7.162 0 16c0 3.5 1.128 6.738 3.042 9.366L1.05 30.952l5.814-1.938C9.377 30.866 12.574 32 16.002 32 24.838 32 32 24.838 32 16S24.838 0 16.002 0zm9.522 22.684c-.408 1.15-2.028 2.108-3.312 2.384-.878.184-2.022.334-5.876-1.262-4.912-2.034-8.086-6.984-8.33-7.304-.244-.318-1.994-2.656-1.994-5.066s1.262-3.594 1.71-4.086c.448-.49 1.008-.612 1.364-.612.326 0 .652.006.938.018.306.012.714-.116 1.118.854.408 1.008 1.394 3.418 1.518 3.666.122.246.204.532.042.85-.164.326-.244.53-.49.818-.244.286-.514.64-.734.858-.244.246-.498.512-.214.998.286.49 1.268 2.092 2.722 3.386 1.87 1.662 3.444 2.178 3.932 2.424.49.246.774.204 1.058-.122.286-.326 1.23-1.438 1.558-1.93.326-.49.654-.408 1.102-.246.45.162 2.856 1.348 3.346 1.594.49.244.816.368.938.572.122.204.122 1.18-.286 2.33z"/>
        </svg>
    </a>

    <!-- Footer -->
    <footer class="gradient-bg py-8 px-6 text-white">
        <div class="container mx-auto text-center">
            <p class="text-lg font-semibold mb-2">Kantin D-pipe</p>
            <p class="text-sm opacity-90">📍 Kampus | ⏰ 07:00 - 15:00 | 📞 Contact Us</p>
            <p class="text-xs mt-4 opacity-75">&copy; 2025 Kantin D-pipe. All rights reserved.</p>
        </div>
    </footer>

    <!-- Modal Login User (Pembeli & Penjual) -->
    <div id="userLoginModal" class="modal">
        <div class="modal-content bg-white rounded-3xl shadow-2xl max-w-md w-full mx-4 p-8">
            <div class="text-center mb-8">
                <div class="w-16 h-16 gradient-bg rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-3xl">🔐</span>
                </div>
                <h3 class="text-3xl font-bold text-gray-800 mb-2">Masuk Sebagai</h3>
                <p class="text-gray-600">Pilih role untuk melanjutkan</p>
            </div>

            <div class="space-y-4">
                <!-- Role Pembeli -->
                <a href="/login/pembeli" class="block bg-gradient-to-r from-orange-500 to-pink-500 text-white p-4 rounded-xl hover:shadow-xl transition transform hover:scale-105">
                    <div class="flex items-center">
                        <div class="text-4xl mr-4">🍽️</div>
                        <div>
                            <h4 class="font-bold text-lg">Pembeli</h4>
                            <p class="text-sm opacity-90">Pesan makanan favoritmu</p>
                        </div>
                    </div>
                </a>

                <!-- Role Penjual -->
                <a href="/login/penjual" class="block bg-gradient-to-r from-green-500 to-emerald-600 text-white p-4 rounded-xl hover:shadow-xl transition transform hover:scale-105">
                    <div class="flex items-center">
                        <div class="text-4xl mr-4">👨‍🍳</div>
                        <div>
                            <h4 class="font-bold text-lg">Penjual</h4>
                            <p class="text-sm opacity-90">Kelola menu & pesanan</p>
                        </div>
                    </div>
                </a>
            </div>

            <button onclick="closeUserLoginModal()" class="w-full mt-6 text-gray-600 py-3 rounded-xl border-2 border-gray-200 hover:bg-gray-50 transition">
                Batal
            </button>
        </div>
    </div>

    <script>
        // Modal User Login (Pembeli & Penjual)
        function openUserLoginModal() {
            document.getElementById('userLoginModal').classList.add('active');
        }

        function closeUserLoginModal() {
            document.getElementById('userLoginModal').classList.remove('active');
        }

        // Close modal when clicking outside
        document.getElementById('userLoginModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeUserLoginModal();
            }
        });

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>

</body>
</html>
