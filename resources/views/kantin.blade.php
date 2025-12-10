<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $nama_kantin }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Bubblegum+Sans&family=Varela+Round&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #ff9a56 0%, #ffd32a 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .main-container {
            background: white;
            border-radius: 25px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            overflow: hidden;
            margin: 20px auto;
            max-width: 900px;
        }

        .header-section {
            background: linear-gradient(135deg, #ff7e33 0%, #ffb347 100%);
            padding: 25px;
            color: white;
        }

        .header-section img {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            border: 3px solid white;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .header-title {
            font-size: 34px;
            font-weight: bold;
            margin: 0;
            text-shadow: 3px 3px 6px rgba(0,0,0,0.3);
            font-family: 'Bubblegum Sans', cursive;
            letter-spacing: 2px;
        }

        .header-subtitle {
            font-size: 14px;
            opacity: 0.95;
        }

        .nav-tabs {
            border-bottom: none;
            background: linear-gradient(135deg, #fff5e6 0%, #ffe4b3 100%);
            padding: 10px 15px 0;
        }

        .nav-tabs .nav-link {
            border: none;
            color: #ff8c42;
            font-weight: 600;
            border-radius: 15px 15px 0 0;
            padding: 12px 20px;
            transition: all 0.3s;
        }

        .nav-tabs .nav-link:hover {
            background: rgba(255, 140, 66, 0.1);
            transform: translateY(-2px);
        }

        .nav-tabs .nav-link.active {
            background: white;
            color: #ff6b35;
            font-weight: bold;
            box-shadow: 0 -3px 10px rgba(255, 140, 66, 0.2);
        }

        .content-area {
            padding: 25px;
        }

        .section-title {
            color: #ff6b35;
            font-weight: bold;
            font-size: 24px;
            margin-bottom: 20px;
            padding-left: 10px;
            border-left: 4px solid #ff8c42;
            font-family: 'Varela Round', sans-serif;
        }

        .menu-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(255, 140, 66, 0.1);
            transition: all 0.3s;
            margin-bottom: 15px;
            overflow: hidden;
        }

        .menu-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(255, 140, 66, 0.2);
        }

        .menu-card .card-body {
            padding: 15px;
        }

        .menu-img {
            width: 90px;
            height: 90px;
            object-fit: cover;
            border-radius: 12px;
            border: 3px solid #fff5e6;
        }

        .menu-name {
            font-weight: bold;
            color: #333;
            font-size: 17px;
            margin-bottom: 5px;
            font-family: 'Varela Round', sans-serif;
        }

        .menu-price {
            color: #ff6b35;
            font-weight: bold;
            font-size: 18px;
        }

        .btn-checkout {
            background: linear-gradient(135deg, #ff7e33 0%, #ff9f55 100%);
            border: none;
            color: white;
            font-weight: 600;
            padding: 10px 25px;
            border-radius: 10px;
            transition: all 0.3s;
            box-shadow: 0 4px 10px rgba(255, 126, 51, 0.3);
        }

        .btn-checkout:hover {
            background: linear-gradient(135deg, #ff6b35 0%, #ff8c42 100%);
            transform: scale(1.05);
            box-shadow: 0 6px 15px rgba(255, 126, 51, 0.4);
            color: white;
        }

        .status-section {
            background: linear-gradient(135deg, #fff5e6 0%, #ffe4b3 100%);
            padding: 20px;
            border-radius: 15px;
            margin-top: 20px;
        }

        .badge-status {
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        .badge-open {
            background: linear-gradient(135deg, #4ade80 0%, #22c55e 100%);
            box-shadow: 0 3px 10px rgba(34, 197, 94, 0.3);
        }

        .badge-closed {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            box-shadow: 0 3px 10px rgba(239, 68, 68, 0.3);
        }

        .promo-text {
            color: #ff6b35;
            font-weight: 600;
            font-size: 14px;
        }

        .empty-state {
            text-align: center;
            padding: 50px 20px;
            color: #999;
        }

        .empty-state-icon {
            font-size: 60px;
            margin-bottom: 15px;
            opacity: 0.3;
        }

        .jam-buka-info {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.2);
            padding: 8px 15px;
            border-radius: 10px;
            font-size: 14px;
            margin-top: 8px;
        }

        /* Animasi */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-10px);
            }
            60% {
                transform: translateY(-5px);
            }
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(255, 126, 51, 0.7);
            }
            70% {
                box-shadow: 0 0 0 15px rgba(255, 126, 51, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(255, 126, 51, 0);
            }
        }

        @keyframes shimmer {
            0% {
                background-position: -1000px 0;
            }
            100% {
                background-position: 1000px 0;
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        .main-container {
            animation: fadeInUp 0.8s ease-out;
        }

        .header-section img {
            animation: bounce 2s infinite;
        }

        .header-title {
            animation: slideInRight 0.6s ease-out;
        }

        .menu-card {
            animation: fadeInUp 0.6s ease-out backwards;
        }

        .menu-card:nth-child(1) { animation-delay: 0.1s; }
        .menu-card:nth-child(2) { animation-delay: 0.2s; }
        .menu-card:nth-child(3) { animation-delay: 0.3s; }
        .menu-card:nth-child(4) { animation-delay: 0.4s; }
        .menu-card:nth-child(5) { animation-delay: 0.5s; }

        .menu-img {
            transition: transform 0.4s ease, filter 0.3s ease;
        }

        .menu-card:hover .menu-img {
            transform: scale(1.1) rotate(5deg);
            filter: brightness(1.1);
        }

        .btn-checkout {
            position: relative;
            overflow: hidden;
        }

        .btn-checkout::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }

        .btn-checkout:hover::before {
            left: 100%;
        }

        .btn-checkout:active {
            transform: scale(0.95);
        }

        .badge-status {
            animation: pulse 2s infinite;
        }

        .nav-tabs .nav-link {
            position: relative;
        }

        .nav-tabs .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 3px;
            background: linear-gradient(90deg, #ff7e33, #ffb347);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .nav-tabs .nav-link.active::after {
            width: 80%;
        }

        .promo-text {
            animation: float 3s ease-in-out infinite;
        }

        .section-title {
            position: relative;
            animation: slideInRight 0.5s ease-out;
        }

        .section-title::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: linear-gradient(180deg, #ff7e33, #ffb347);
            animation: shimmer 2s infinite;
        }

        .empty-state-icon {
            animation: float 3s ease-in-out infinite;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="main-container">
            <!-- Header -->
            <div class="header-section">
                <div class="d-flex align-items-center">
                    <img src="image/kantin.png" alt="Logo Kantin">
                    <div class="ms-3">
                        <h3 class="header-title">{{ $nama_kantin }}</h3>
                        <small class="header-subtitle">🍽️ {{ $tujuan_kantin }}</small>
                        <div class="jam-buka-info">
                            <span>🕐 {{ $jam_buka }} - {{ $jam_tutup }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs -->
            <ul class="nav nav-tabs" id="menuTabs">
                <li class="nav-item">
                    <a class="nav-link active" href="#lapau-uda" data-bs-toggle="tab">🍜 Lapau Uda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#lapau-uni" data-bs-toggle="tab">🥟 Lapau Uni</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#kantin2" data-bs-toggle="tab">🍱 Kantin 2</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#kantin3" data-bs-toggle="tab">🥤 Kantin 3</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#kantin4" data-bs-toggle="tab">🍔 Kantin 4</a>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="content-area">
                <div class="tab-content">
                    <!-- Lapau Uda -->
                    <div class="tab-pane fade show active" id="lapau-uda">
                        <h5 class="section-title">Makanan</h5>
                        @foreach ($menu as $item)
                        <div class="menu-card card">
                            <div class="card-body d-flex align-items-center">
                                <img src="{{ $item['gambar'] }}" alt="{{ $item['nama'] }}" class="menu-img">
                                <div class="flex-grow-1 ms-3">
                                    <div class="menu-name">{{ $item['nama'] }}</div>
                                    <div class="menu-price">Rp 10.000</div>
                                </div>
                                <a href="#" class="btn btn-checkout">Pesan</a>
                            </div>
                        </div>
                        @endforeach

                        <h5 class="section-title mt-4">Minuman</h5>
                        @foreach ($minuman as $drink)
                        <div class="menu-card card">
                            <div class="card-body d-flex align-items-center">
                                <img src="{{ $drink['gambar'] }}" alt="{{ $drink['nama'] }}" class="menu-img">
                                <div class="flex-grow-1 ms-3">
                                    <div class="menu-name">{{ $drink['nama'] }}</div>
                                    <div class="menu-price">Rp 5.000</div>
                                </div>
                                <a href="#" class="btn btn-checkout">Pesan</a>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Tab Lainnya -->
                    <div class="tab-pane fade" id="lapau-uni">
                        <div class="empty-state">
                            <div class="empty-state-icon">🥟</div>
                            <h5>Belum Ada Menu</h5>
                            <p>Menu Lapau Uni akan segera hadir!</p>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="kantin2">
                        <div class="empty-state">
                            <div class="empty-state-icon">🍱</div>
                            <h5>Belum Ada Menu</h5>
                            <p>Menu Kantin 2 akan segera hadir!</p>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="kantin3">
                        <div class="empty-state">
                            <div class="empty-state-icon">🥤</div>
                            <h5>Belum Ada Menu</h5>
                            <p>Menu Kantin 3 akan segera hadir!</p>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="kantin4">
                        <div class="empty-state">
                            <div class="empty-state-icon">🍔</div>
                            <h5>Belum Ada Menu</h5>
                            <p>Menu Kantin 4 akan segera hadir!</p>
                        </div>
                    </div>
                </div>

                <!-- Status & Promo -->
                <div class="status-section">
                    <span class="badge badge-status {{ $status_kantin == 'Buka' ? 'badge-open' : 'badge-closed' }} text-white">
                        {{ $status_kantin == 'Buka' ? '✓' : '✕' }} {{ $status_kantin }}
                    </span>
                    <span class="promo-text ms-3">
                        @if($status_kantin == 'Buka')
                            🎉 {{ $info_promo }}
                        @else
                            {{ $info_promo }}
                        @endif
                    </span>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
