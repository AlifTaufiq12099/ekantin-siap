<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Kantin D-pipe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .hero-pattern {
            background-color: #667eea;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-gray-50">

    <!-- Hero Section -->
    <section class="hero-pattern pt-20 pb-20 px-6 min-h-screen flex items-center justify-center">
        <div class="container mx-auto">
            <div class="max-w-md mx-auto fade-in">
                <!-- Login Card -->
                <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
                    <!-- Header -->
                    <div class="gradient-bg px-8 py-8 text-center">
                        <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                            <span class="text-4xl">👨‍💼</span>
                        </div>
                        <h1 class="text-3xl font-bold text-white mb-2">Login Admin</h1>
                        <p class="text-white opacity-90">Masuk ke panel administrator</p>
                    </div>

                    <!-- Form -->
                    <div class="px-8 py-8">
                        @if(session('key') == 'error')
                            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                                <p class="text-red-600 text-sm">{{ session('value') }}</p>
                            </div>
                        @endif

                        @if(session('key') == 'success')
                            <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                                <p class="text-green-600 text-sm">{{ session('value') }}</p>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('admin.login') }}">
                            @csrf
                            <div class="mb-6">
                                <label class="block text-gray-700 font-semibold mb-2">Username</label>
                                <input 
                                    type="text" 
                                    name="username" 
                                    value="{{ old('username') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition outline-none"
                                    placeholder="Masukkan username"
                                    required
                                    autofocus
                                >
                                @error('username')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-6">
                                <label class="block text-gray-700 font-semibold mb-2">Password</label>
                                <input 
                                    type="password" 
                                    name="password" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition outline-none"
                                    placeholder="Masukkan password"
                                    required
                                >
                                @error('password')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <button 
                                type="submit" 
                                class="w-full gradient-bg text-white py-3 rounded-lg font-semibold hover:shadow-lg transition transform hover:scale-105"
                            >
                                Masuk
                            </button>
                        </form>

                        <hr class="my-6 border-gray-200">

                        <!-- Navigation Links -->
                        <div class="text-center space-y-2">
                            <a href="/" class="block text-gray-600 hover:text-purple-600 transition text-sm">
                                ← Kembali ke Beranda
                            </a>
                            <div class="flex items-center justify-center space-x-2 text-sm text-gray-500">
                                <a href="/login/pembeli" class="hover:text-purple-600 transition">Login Pembeli</a>
                                <span>·</span>
                                <a href="/login/penjual" class="hover:text-purple-600 transition">Login Penjual</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Note -->
                <p class="text-center text-white text-sm mt-6 opacity-75">
                    Kantin D-pipe © 2025 - Panel Administrator
                </p>
            </div>
        </div>
    </section>

</body>
</html>
