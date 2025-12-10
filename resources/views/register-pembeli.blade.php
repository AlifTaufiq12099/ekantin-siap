<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pembeli - Kantin D-pipe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .gradient-bg { background: linear-gradient(135deg, #FF8E53 0%, #FE6B8B 100%); }
        .input-focus:focus { border-color: #FF8E53; box-shadow: 0 0 0 3px rgba(255,142,83,0.1); }
    </style>
</head>
<body class="bg-gray-50">

<div class="min-h-screen flex">
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
        <div class="max-w-md w-full">
            <a href="/" class="inline-flex items-center text-gray-600 hover:text-orange-500 mb-8 transition">&larr; Kembali</a>

            <div class="text-center mb-6">
                <div class="w-20 h-20 gradient-bg rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <span class="text-4xl">🍽️</span>
                </div>
                <h1 class="text-3xl font-bold text-gray-800 mb-1">Daftar Pembeli</h1>
                <p class="text-gray-600">Buat akun untuk mulai memesan</p>
            </div>

            @if(session('key') === 'error')
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-4">
                    {{ session('value') }}
                </div>
            @endif

            <form action="/register/pembeli" method="POST" class="space-y-4">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama</label>
                    <input type="text" name="name" required value="{{ old('name') }}" class="input-focus w-full mt-1 px-4 py-3 border-2 border-gray-200 rounded-xl">
                    @error('name') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" required value="{{ old('email') }}" class="input-focus w-full mt-1 px-4 py-3 border-2 border-gray-200 rounded-xl">
                    @error('email') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" required class="input-focus w-full mt-1 px-4 py-3 border-2 border-gray-200 rounded-xl">
                    @error('password') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required class="input-focus w-full mt-1 px-4 py-3 border-2 border-gray-200 rounded-xl">
                </div>

                <button type="submit" class="w-full gradient-bg text-white py-3 rounded-xl font-semibold hover:shadow-xl transition">Daftar</button>

                <p class="text-center text-gray-600 text-sm mt-3">Sudah punya akun? <a href="/login/pembeli" class="text-orange-500 font-semibold">Masuk</a></p>
            </form>
        </div>
    </div>

    <div class="hidden lg:flex lg:w-1/2 gradient-bg items-center justify-center p-12">
        <div class="text-white text-center">
            <h2 class="text-4xl font-bold mb-4">Nikmati layanan pesan antar kantin</h2>
            <p class="opacity-90">Daftar gratis, pesan cepat, dan bayar mudah.</p>
        </div>
    </div>
</div>

</body>
</html>
