<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $lapak->nama_lapak }} - Menu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .gradient-bg { background: linear-gradient(135deg, #FF8E53 0%, #FE6B8B 100%); }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
    </style>
</head>
<body class="bg-gray-50">

<div class="container mx-auto p-6">
    <div class="mb-4">
        <a href="{{ route('pembeli.lapak.select') }}" class="text-gray-600 hover:text-orange-500">&larr; Pilih Lapak Lain</a>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow mb-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="flex items-center space-x-4">
            @if($lapak->foto_profil)
                <img src="{{ asset('storage/' . $lapak->foto_profil) }}" alt="{{ $lapak->nama_lapak }}" class="w-20 h-20 rounded-full object-cover border-4 border-orange-200 shadow-md">
            @else
                <div class="w-20 h-20 gradient-bg rounded-full flex items-center justify-center text-4xl border-4 border-orange-200 shadow-md">
                    🏪
                </div>
            @endif
            <div>
                <h1 class="text-2xl font-bold">{{ $lapak->nama_lapak }}</h1>
                <p class="text-sm text-gray-600">Pemilik: {{ $lapak->pemilik }} | No: {{ $lapak->no_hp_pemilik }}</p>
            </div>
            </div>
            <a href="{{ route('pembeli.chat.show', $lapak->lapak_id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-medium transition-colors flex items-center space-x-2 shadow-md w-full sm:w-auto justify-center">
                <span class="text-xl">💬</span>
                <span>Chat dengan Penjual</span>
            </a>
        </div>
    </div>

    <h2 class="text-xl font-semibold mb-4">Menu</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($menus as $menu)
            <div class="bg-white rounded-2xl shadow p-4 card-hover">
                <div class="h-48 bg-gray-100 rounded-lg mb-4 flex items-center justify-center overflow-hidden">
                    @php
                        $imgUrl = null;
                        $exists = false;
                        
                        if (!empty($menu->image)) {
                            // Cek jika image adalah URL lengkap
                            if (str_starts_with($menu->image, 'http://') || str_starts_with($menu->image, 'https://')) {
                                $imgUrl = $menu->image;
                                $exists = true;
                            } else {
                                // Path image disimpan di storage public
                                $imgPath = $menu->image;
                                
                                // Cek apakah file ada
                                $exists = \Illuminate\Support\Facades\Storage::disk('public')->exists($imgPath);
                                
                                if ($exists) {
                                    $imgUrl = asset('storage/'.$imgPath);
                                } else {
                                    // Coba cek dengan thumbnail jika ada
                                    $thumbPath = 'menus/thumb_'.basename($imgPath);
                                    $exists = \Illuminate\Support\Facades\Storage::disk('public')->exists($thumbPath);
                                    
                                    if ($exists) {
                                        $imgUrl = asset('storage/'.$thumbPath);
                                    } else {
                                        // Fallback: coba langsung dengan path asli
                                        $imgUrl = asset('storage/'.$imgPath);
                                        $exists = true; // Anggap ada, browser akan handle 404
                                    }
                                }
                            }
                        }
                    @endphp
                    @if($imgUrl)
                        <img src="{{ $imgUrl }}" 
                             alt="{{ $menu->nama_menu }}" 
                             class="w-full h-full object-cover"
                             onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'text-center\'><span class=\'text-6xl\'>🍽️</span><p class=\'text-gray-400 text-sm mt-2\'>{{ $menu->nama_menu }}</p></div>';">
                    @else
                        <div class="text-center">
                            <span class="text-6xl">🍽️</span>
                            <p class="text-gray-400 text-sm mt-2">{{ $menu->nama_menu }}</p>
                        </div>
                    @endif
                </div>
                <h3 class="font-semibold text-lg">{{ $menu->nama_menu }}</h3>
                <p class="text-sm text-gray-500 mb-3">{{ $menu->deskripsi }}</p>
                
                <!-- Stock Indicator -->
                <div class="mb-3">
                    @if($menu->stok <= 0)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800 border border-red-300">
                            ⚠️ Stok Habis
                        </span>
                    @elseif($menu->stok <= 5)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-800 border border-orange-300">
                            ⚠️ Tersisa {{ $menu->stok }}
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 border border-green-300">
                            ✓ Tersedia
                        </span>
                    @endif
                </div>
                
                <div class="flex items-center justify-between">
                    <span class="text-orange-500 font-bold">Rp {{ number_format($menu->harga,0,',','.') }}</span>
                    @if($menu->stok <= 0)
                        <button disabled class="bg-gray-400 text-white px-3 py-2 rounded-lg cursor-not-allowed opacity-60">
                            Stok Habis
                        </button>
                    @else
                        <button onclick="openOrderForm({{ $menu->menu_id }}, '{{ addslashes($menu->nama_menu) }}', {{ $menu->harga }}, {{ $menu->stok }})" class="bg-orange-500 text-white px-3 py-2 rounded-lg hover:bg-orange-600 transition">
                            Pesan
                        </button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- Order Modal (simple) -->
    <div id="orderModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center p-4 z-50">
        <div class="bg-white rounded-2xl p-6 w-full max-w-md">
            <div class="flex items-center justify-between mb-4">
                <h3 id="orderTitle" class="text-lg font-semibold">Pesan</h3>
                <button onclick="closeOrder()" class="text-gray-400 hover:text-gray-600 text-xl">&times;</button>
            </div>
            
            <!-- Error Message -->
            <div id="stockError" class="hidden mb-4 p-3 bg-red-50 border-l-4 border-red-500 rounded">
                <p class="text-sm text-red-800 font-semibold">⚠️ Stok tidak mencukupi!</p>
                <p class="text-xs text-red-600 mt-1">Stok tersedia: <span id="availableStock">0</span></p>
            </div>
            
            <form id="orderForm" method="POST" action="{{ route('pembeli.order.store') }}">
                @csrf
                <input type="hidden" name="menu_id" id="menu_id">
                <input type="hidden" name="lapak_id" value="{{ $lapak->lapak_id }}">
                <input type="hidden" id="current_stock" value="0">

                <div class="mb-3">
                    <label class="block text-sm text-gray-700 font-semibold">Nama Menu</label>
                    <div id="menuName" class="font-medium text-gray-800"></div>
                </div>

                <div class="mb-3">
                    <label class="block text-sm text-gray-700 font-semibold mb-1">
                        Jumlah 
                        <span class="text-gray-500 font-normal">(Stok tersedia: <span id="stockDisplay" class="font-semibold text-orange-600">0</span>)</span>
                    </label>
                    <div class="flex items-center space-x-2">
                        <button type="button" onclick="decreaseQty()" class="w-10 h-10 bg-gray-200 hover:bg-gray-300 rounded-lg flex items-center justify-center font-bold text-gray-700" id="decreaseBtn">
                            -
                        </button>
                        <input 
                            type="number" 
                            name="jumlah" 
                            id="jumlah" 
                            value="1" 
                            min="1" 
                            max="1"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent text-center"
                            onchange="validateStock()"
                            oninput="validateStock()"
                        >
                        <button type="button" onclick="increaseQty()" class="w-10 h-10 bg-gray-200 hover:bg-gray-300 rounded-lg flex items-center justify-center font-bold text-gray-700" id="increaseBtn">
                            +
                        </button>
                    </div>
                    <p id="stockWarning" class="text-xs text-red-600 mt-1 hidden"></p>
                </div>

                <div class="mb-4">
                    <label class="block text-sm text-gray-700 font-semibold mb-1">Metode Pembayaran</label>
                    <select name="metode_pembayaran" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                        <option>Tunai</option>
                        <option>Transfer</option>
                    </select>
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeOrder()" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                        Batal
                    </button>
                    <button type="submit" id="submitBtn" class="px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition">
                        Kirim Pesanan
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
    let currentStock = 0;
    
    function openOrderForm(menuId, menuName, harga, stok) {
        currentStock = stok;
        document.getElementById('menu_id').value = menuId;
        document.getElementById('menuName').innerText = menuName + ' - Rp ' + Number(harga).toLocaleString('id-ID');
        document.getElementById('current_stock').value = stok;
        document.getElementById('stockDisplay').textContent = stok;
        document.getElementById('availableStock').textContent = stok;
        document.getElementById('jumlah').value = 1;
        document.getElementById('jumlah').max = stok;
        document.getElementById('stockError').classList.add('hidden');
        document.getElementById('stockWarning').classList.add('hidden');
        validateStock();
        document.getElementById('orderModal').classList.remove('hidden');
        document.getElementById('orderModal').classList.add('flex');
    }
    
    function closeOrder() {
        document.getElementById('orderModal').classList.add('hidden');
        document.getElementById('orderModal').classList.remove('flex');
        currentStock = 0;
    }
    
    function increaseQty() {
        const qtyInput = document.getElementById('jumlah');
        const currentQty = parseInt(qtyInput.value) || 1;
        if (currentQty < currentStock) {
            qtyInput.value = currentQty + 1;
            validateStock();
        }
    }
    
    function decreaseQty() {
        const qtyInput = document.getElementById('jumlah');
        const currentQty = parseInt(qtyInput.value) || 1;
        if (currentQty > 1) {
            qtyInput.value = currentQty - 1;
            validateStock();
        }
    }
    
    function validateStock() {
        const qtyInput = document.getElementById('jumlah');
        const qty = parseInt(qtyInput.value) || 1;
        const stockError = document.getElementById('stockError');
        const stockWarning = document.getElementById('stockWarning');
        const submitBtn = document.getElementById('submitBtn');
        const decreaseBtn = document.getElementById('decreaseBtn');
        const increaseBtn = document.getElementById('increaseBtn');
        
        // Reset
        stockError.classList.add('hidden');
        stockWarning.classList.add('hidden');
        submitBtn.disabled = false;
        submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        decreaseBtn.disabled = false;
        increaseBtn.disabled = false;
        
        // Validasi
        if (qty <= 0) {
            qtyInput.value = 1;
            return;
        }
        
        if (qty > currentStock) {
            stockError.classList.remove('hidden');
            stockWarning.classList.remove('hidden');
            stockWarning.textContent = `⚠️ Jumlah melebihi stok tersedia (${currentStock})`;
            qtyInput.value = currentStock;
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
        }
        
        // Disable buttons jika sudah di limit
        if (qty >= currentStock) {
            increaseBtn.disabled = true;
            increaseBtn.classList.add('opacity-50', 'cursor-not-allowed');
        } else {
            increaseBtn.disabled = false;
            increaseBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        }
        
        if (qty <= 1) {
            decreaseBtn.disabled = true;
            decreaseBtn.classList.add('opacity-50', 'cursor-not-allowed');
        } else {
            decreaseBtn.disabled = false;
            decreaseBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        }
    }
    
    // Validasi sebelum submit form
    document.getElementById('orderForm').addEventListener('submit', function(e) {
        const qty = parseInt(document.getElementById('jumlah').value) || 0;
        if (qty <= 0 || qty > currentStock) {
            e.preventDefault();
            alert('Jumlah pesanan tidak valid atau melebihi stok tersedia!');
            return false;
        }
    });
</script>

</body>
</html>
