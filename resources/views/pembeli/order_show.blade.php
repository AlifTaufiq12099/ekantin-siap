<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Pesanan #{{ $t->transaksi_id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
<div class="container mx-auto px-4 py-6">
    <div class="max-w-3xl mx-auto">
        <!-- Header dengan tombol kembali -->
        <div class="mb-6">
            <a href="{{ route('pembeli.lapak.select') }}" class="inline-flex items-center text-gray-600 hover:text-orange-600 transition font-medium">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali ke Pilih Lapak
            </a>
        </div>

        <!-- Card Detail Pesanan -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Header Card dengan gradient orange -->
            <div class="bg-gradient-to-r w-full bg-orange-500 hover:bg-orange-600 px-6 py-5 text-white">
                <h2 class="text-2xl font-bold mb-1">Pesanan #{{ $t->transaksi_id }}</h2>
                <p class="text-orange-100 text-sm flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ $t->waktu_transaksi }}
                </p>
            </div>

            <!-- Content -->
            <div class="p-6 space-y-6">
                <!-- Info Menu & Ringkasan -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Info Menu -->
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <h3 class="font-semibold text-gray-800 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Informasi Menu
                        </h3>
                        <div class="space-y-2">
                            <p class="font-medium text-gray-900">{{ $t->menu->nama_menu ?? '-' }}</p>
                            <p class="text-sm text-gray-600">{{ $t->menu->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                        </div>
                    </div>

                    <!-- Ringkasan -->
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <h3 class="font-semibold text-gray-800 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            Ringkasan Pesanan
                        </h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Jumlah:</span>
                                <span class="font-semibold text-gray-900">{{ $t->jumlah }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Total:</span>
                                <span class="font-semibold text-orange-600">Rp {{ number_format($t->total_harga,0,',','.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Metode:</span>
                                <span class="font-medium text-gray-900">{{ $t->metode_pembayaran ?? 'Tunai' }}</span>
                            </div>
                            <div class="flex justify-between pt-2 border-t border-gray-200">
                                <span class="text-gray-600">Status:</span>
                                <span class="font-bold text-gray-900">{{ $t->status_transaksi }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status Pesanan -->
                <div>
                    <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Status Pesanan
                    </h4>

                    @php
                        $status = $t->status_transaksi;
                    @endphp

                    @if($status == 'menunggu_pembayaran')
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg mb-4">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-yellow-600 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                <div>
                                    <h5 class="font-semibold text-yellow-800">Menunggu Pembayaran</h5>
                                    <p class="text-yellow-700 text-sm">Silakan unggah bukti pembayaran untuk melanjutkan pesanan.</p>
                                </div>
                            </div>
                        </div>
                    @elseif($status == 'menunggu_konfirmasi')
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-lg mb-4">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <div>
                                    <h5 class="font-semibold text-blue-800">Menunggu Konfirmasi</h5>
                                    <p class="text-blue-700 text-sm">Bukti pembayaran terkirim. Menunggu konfirmasi dari penjual.</p>
                                </div>
                            </div>
                        </div>
                    @elseif($status == 'sedang_dibuat')
                        <div class="bg-indigo-50 border-l-4 border-indigo-400 p-4 rounded-lg mb-4">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-indigo-600 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                                </svg>
                                <div>
                                    <h5 class="font-semibold text-indigo-800">Sedang Dibuat</h5>
                                    <p class="text-indigo-700 text-sm">Pesanan sedang dalam proses pembuatan. Pembayaran berhasil dikonfirmasi.</p>
                                </div>
                            </div>
                        </div>
                    @elseif($status == 'siap')
                        <div class="bg-teal-50 border-l-4 border-teal-400 p-4 rounded-lg mb-4">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-teal-600 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
                                </svg>
                                <div>
                                    <h5 class="font-semibold text-teal-800">Pesanan Siap!</h5>
                                    <p class="text-teal-700 text-sm">Pesanan Anda sudah siap. Silakan ambil di lapak.</p>
                                </div>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('pembeli.order.confirmReceived', $t->transaksi_id) }}" class="mb-4">
                            @csrf
                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-lg transition shadow-md flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Konfirmasi Terima Pesanan
                            </button>
                        </form>
                    @elseif($status == 'selesai')
                        <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded-lg mb-4">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-green-600 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <div>
                                    <h5 class="font-semibold text-green-800">Pesanan Selesai</h5>
                                    <p class="text-green-700 text-sm">Terima kasih atas pesanan Anda!</p>
                                </div>
                            </div>
                        </div>

                        <!-- Form Rating (jika belum ada rating) -->
                        @php
                            $existingRating = \App\Models\Rating::where('transaksi_id', $t->transaksi_id)->first();
                        @endphp
                        @if(!$existingRating)
                        <div class="bg-gradient-to-br from-yellow-50 to-orange-50 rounded-lg p-6 border-2 border-yellow-200 mb-4">
                            <h5 class="font-semibold text-gray-800 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                Berikan Rating & Feedback
                            </h5>
                            <form action="{{ route('pembeli.order.rating', $t->transaksi_id) }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Rating <span class="text-red-500">*</span></label>
                                    <div class="flex items-center space-x-3" id="rating-stars">
                                        @for($i = 1; $i <= 5; $i++)
                                        <button 
                                            type="button" 
                                            onclick="setRating({{ $i }})" 
                                            class="star-btn text-5xl opacity-30 hover:opacity-70 hover:scale-110 active:scale-95 transition-all duration-200 cursor-pointer focus:outline-none focus:ring-2 focus:ring-yellow-500 rounded p-1 select-none" 
                                            data-rating="{{ $i }}"
                                            aria-label="Rating {{ $i }} bintang"
                                            style="user-select: none; -webkit-user-select: none; filter: grayscale(100%);"
                                        >
                                            ⭐
                                        </button>
                                        @endfor
                                    </div>
                                    <input type="hidden" name="rating" id="rating-value" value="0" required>
                                    <p class="text-xs text-gray-500 mt-2">
                                        <span id="rating-text">Pilih rating (1-5 bintang)</span>
                                    </p>
                                    @error('rating')
                                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="feedback" class="block text-sm font-semibold text-gray-700 mb-2">Feedback (Opsional)</label>
                                    <textarea 
                                        name="feedback" 
                                        id="feedback" 
                                        rows="3" 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent outline-none"
                                        placeholder="Bagikan pengalaman Anda..."
                                    ></textarea>
                                </div>
                                <button type="submit" id="submit-rating-btn" class="w-full bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600 text-white font-semibold px-6 py-3 rounded-lg transition shadow-md flex items-center justify-center opacity-50 cursor-not-allowed" disabled>
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                    </svg>
                                    Kirim Rating
                                </button>
                            </form>
                        </div>
                        @else
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-lg mb-4">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <div>
                                    <h5 class="font-semibold text-blue-800">Rating Anda</h5>
                                    <div class="flex items-center space-x-1 mt-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span class="text-xl {{ $i <= $existingRating->rating ? 'text-yellow-400' : 'text-gray-300' }}">⭐</span>
                                        @endfor
                                        <span class="ml-2 text-sm text-blue-700">({{ $existingRating->rating }}/5)</span>
                                    </div>
                                    @if($existingRating->feedback)
                                        <p class="text-sm text-blue-700 mt-2 italic">"{{ $existingRating->feedback }}"</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
                    @elseif($status == 'dibatalkan')
                        <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-lg mb-4">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-red-600 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                                <div>
                                    <h5 class="font-semibold text-red-800">Pesanan Dibatalkan</h5>
                                    <p class="text-red-700 text-sm">Pesanan ini telah dibatalkan.</p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="bg-gray-50 border-l-4 border-gray-400 p-4 rounded-lg mb-4">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-gray-600 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <div>
                                    <h5 class="font-semibold text-gray-800">Status</h5>
                                    <p class="text-gray-700 text-sm">{{ $status }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Bukti Pembayaran (jika ada) -->
                    @if($t->bukti_pembayaran)
                        <div class="mb-6">
                            <h5 class="font-semibold text-gray-800 mb-3">Bukti Pembayaran</h5>
                            <div class="relative group">
                                <img src="{{ asset('storage/'.$t->bukti_pembayaran) }}" alt="Bukti Pembayaran" class="w-full max-w-md rounded-lg shadow-md border border-gray-200">
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition rounded-lg"></div>
                            </div>
                        </div>
                    @endif

                    <!-- Form Upload Bukti Pembayaran -->
                    @if($status == 'menunggu_pembayaran')
                        <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                            <h5 class="font-semibold text-gray-800 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Upload Bukti Pembayaran
                            </h5>
                            <form action="{{ route('pembeli.order.uploadProof', $t->transaksi_id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-4">
                                    <label for="bukti" class="flex flex-col items-center justify-center w-full h-40 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-white hover:bg-gray-50 transition">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <svg class="w-10 h-10 mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                            </svg>
                                            <p class="mb-1 text-sm text-gray-500"><span class="font-semibold">Klik untuk upload</span></p>
                                            <p class="text-xs text-gray-500">PNG, JPG atau JPEG</p>
                                        </div>
                                        <input type="file" name="bukti" id="bukti" accept="image/*" required class="hidden" onchange="previewBukti(event)">
                                    </label>
                                    <div id="preview-bukti" class="mt-3 hidden">
                                        <p class="text-sm text-gray-600 mb-2 font-medium">Preview:</p>
                                        <img id="preview-bukti-image" class="w-full max-w-md rounded-lg shadow-md border border-gray-200" alt="Preview">
                                    </div>
                                </div>
                                <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold px-6 py-3 rounded-lg transition shadow-md flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                    </svg>
                                    Kirim Bukti Pembayaran
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function previewBukti(event) {
    const preview = document.getElementById('preview-bukti');
    const previewImage = document.getElementById('preview-bukti-image');
    const file = event.target.files[0];

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImage.src = e.target.result;
            preview.classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
}

function setRating(rating) {
    // Validasi rating
    if (!rating || rating < 1 || rating > 5) {
        console.error('Invalid rating value:', rating);
        return;
    }
    
    // Set nilai hidden input
    const ratingInput = document.getElementById('rating-value');
    if (ratingInput) {
        ratingInput.value = parseInt(rating);
        console.log('Rating set to:', ratingInput.value); // Debug
    }
    
    // Update tampilan bintang
    const stars = document.querySelectorAll('.star-btn');
    
    stars.forEach((star, index) => {
        const starRating = parseInt(star.getAttribute('data-rating'));
        if (starRating <= rating) {
            // Bintang yang dipilih: terang, kuning, tanpa grayscale
            star.style.opacity = '1';
            star.style.filter = 'grayscale(0%)';
            star.style.transform = 'scale(1.1)';
            star.classList.add('text-yellow-400');
        } else {
            // Bintang yang belum dipilih: redup, grayscale
            star.style.opacity = '0.2';
            star.style.filter = 'grayscale(100%)';
            star.style.transform = 'scale(1)';
            star.classList.remove('text-yellow-400');
        }
    });
    
    // Update teks rating
    const ratingText = document.getElementById('rating-text');
    if (ratingText) {
        const ratingLabels = {
            1: 'Sangat Buruk',
            2: 'Buruk',
            3: 'Cukup',
            4: 'Baik',
            5: 'Sangat Baik'
        };
        ratingText.textContent = `Rating: ${rating}/5 - ${ratingLabels[rating] || ''}`;
        ratingText.classList.remove('text-gray-500');
        ratingText.classList.add('text-yellow-600', 'font-semibold');
    }
    
    // Enable submit button
    const submitBtn = document.getElementById('submit-rating-btn');
    if (submitBtn && rating > 0) {
        submitBtn.disabled = false;
        submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        submitBtn.classList.add('hover:shadow-lg');
    }
}

// Validasi form sebelum submit
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded'); // Debug
    
    const ratingForm = document.querySelector('form[action*="rating"]');
    if (ratingForm) {
        console.log('Rating form found'); // Debug
        
        ratingForm.addEventListener('submit', function(e) {
            const ratingInput = document.getElementById('rating-value');
            const ratingValue = ratingInput ? parseInt(ratingInput.value) : 0;
            
            console.log('Form submit - Rating value:', ratingValue); // Debug
            
            if (!ratingValue || ratingValue < 1 || ratingValue > 5) {
                e.preventDefault();
                alert('Silakan pilih rating terlebih dahulu!');
                return false;
            }
            
            // Konfirmasi nilai rating sebelum submit
            console.log('Submitting rating:', ratingValue); // Debug
        });
    }
    
    // Pastikan semua star button bisa diklik
    const starButtons = document.querySelectorAll('.star-btn');
    starButtons.forEach((btn, index) => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const rating = parseInt(this.getAttribute('data-rating'));
            setRating(rating);
        });
        
        // Hover effect - preview rating
        btn.addEventListener('mouseenter', function() {
            const rating = parseInt(this.getAttribute('data-rating'));
            const stars = document.querySelectorAll('.star-btn');
            stars.forEach((star, idx) => {
                const starRating = parseInt(star.getAttribute('data-rating'));
                if (starRating <= rating) {
                    // Preview: sedikit lebih terang saat hover
                    star.style.opacity = '0.6';
                    star.style.filter = 'grayscale(50%)';
                }
            });
        });
        
        btn.addEventListener('mouseleave', function() {
            const currentRating = document.getElementById('rating-value').value || 0;
            const stars = document.querySelectorAll('.star-btn');
            stars.forEach((star, idx) => {
                const starRating = parseInt(star.getAttribute('data-rating'));
                if (starRating <= currentRating) {
                    // Kembalikan ke state terpilih
                    star.style.opacity = '1';
                    star.style.filter = 'grayscale(0%)';
                } else {
                    // Kembalikan ke state redup
                    star.style.opacity = '0.2';
                    star.style.filter = 'grayscale(100%)';
                }
            });
        });
    });
});
</script>
</body>
</html>
