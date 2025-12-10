<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Kantin D-pipe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #FF8E53 0%, #FE6B8B 100%);
        }
        .input-focus:focus {
            border-color: #FF8E53;
            box-shadow: 0 0 0 3px rgba(255, 142, 83, 0.1);
        }
        .fade-in {
            animation: fadeIn 0.6s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-gray-50">

    <div class="min-h-screen flex items-center justify-center p-8">
        <div class="max-w-md w-full fade-in">
            <!-- Back Button -->
            <a href="{{ route('login.pembeli') }}" class="inline-flex items-center text-gray-600 hover:text-orange-500 mb-8 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali ke Login
            </a>

            <!-- Logo & Title -->
            <div class="text-center mb-8">
                <div class="w-20 h-20 gradient-bg rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <span class="text-5xl">🔐</span>
                </div>
                <h1 class="text-4xl font-bold text-gray-800 mb-2">Lupa Password?</h1>
                <p class="text-gray-600">Masukkan email Anda untuk reset password</p>
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

            <!-- Error Message -->
            @if(session('key') === 'error')
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-red-800 font-semibold">{{ session('value') }}</span>
                </div>
            </div>
            @endif

            <!-- Form -->
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <form action="{{ route('password.email') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            Email
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                </svg>
                            </div>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                required
                                value="{{ old('email') }}"
                                class="input-focus w-full pl-10 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none transition @error('email') border-red-500 @enderror"
                                placeholder="Masukkan email Anda"
                            >
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        class="w-full gradient-bg text-white py-3 rounded-xl font-semibold hover:shadow-xl transition transform hover:scale-105"
                    >
                        Kirim Link Reset Password
                    </button>

                    <!-- Info -->
                    <p class="text-center text-sm text-gray-600">
                        Kami akan mengirimkan link reset password ke email Anda
                    </p>
                </form>
            </div>

            <!-- Back to Login -->
            <p class="text-center text-gray-600 text-sm mt-6">
                Ingat password Anda?
                <a href="{{ route('login.pembeli') }}" class="text-orange-500 hover:text-orange-600 font-semibold">
                    Login sekarang
                </a>
            </p>
        </div>
    </div>

</body>
</html>

