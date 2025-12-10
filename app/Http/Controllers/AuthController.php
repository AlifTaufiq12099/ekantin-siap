<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Penjual;
use App\Models\Lapak;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /**
     * Show login form pembeli
     */
    public function showLoginPembeli()
    {
        return view('login-pembeli');
    }

    /**
     * Handle login pembeli
     */
    public function loginPembeli(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $email = $request->email;
        $password = $request->password;

        // Cek apakah variabel tersedia
        if (isset($email) && isset($password)) {
            // Coba autentikasi menggunakan guard default (users table)
            $credentials = ['email' => $email, 'password' => $password];
            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                session([
                    'user_id' => $user->id,
                    'username' => $user->name,
                    'role' => 'pembeli',
                    'logged_in' => true
                ]);

                return redirect()->route('pembeli.lapak.select')->with([
                    'key' => 'success',
                    'value' => 'Login berhasil!'
                ]);
            }

            // Email atau password salah
            return back()->with([
                'key' => 'error',
                'value' => 'Email atau Password salah!'
            ])->withInput();
        }

        // Form tidak lengkap
        return back()->with([
            'key' => 'error',
            'value' => 'Form tidak lengkap!'
        ]);
    }

    /**
     * Show login form penjual
     */
    public function showLoginPenjual()
    {
        return view('auth.login-penjual');
    }

    /**
     * Handle login penjual
     */
    public function loginPenjual(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $username = $request->username;
        $password = $request->password;

        // Cek apakah variabel tersedia
        if (isset($username) && isset($password)) {
            // Cari penjual berdasarkan email (username field bisa berisi email)
            $penjual = Penjual::where('email', $username)->first();
            
            if ($penjual && Hash::check($password, $penjual->password)) {
                // Login berhasil, set session
                session([
                    'penjual_id' => $penjual->penjual_id,
                    'user_id' => $penjual->penjual_id, // Keep for backward compatibility
                    'username' => $penjual->nama_penjual,
                    'role' => 'penjual',
                    'lapak_id' => $penjual->lapak_id,
                    'logged_in' => true
                ]);

                return redirect()->to('/penjual/dashboard')->with([
                    'key' => 'success',
                    'value' => 'Login berhasil!'
                ]);
            }

            // Username atau password salah
            return back()->with([
                'key' => 'error',
                'value' => 'Email atau Password salah!'
            ])->withInput();
        }

        // Form tidak lengkap
        return back()->with([
            'key' => 'error',
            'value' => 'Form tidak lengkap!'
        ]);
    }

    /**
     * Show login form admin
     */
    public function showLoginAdmin()
    {
        return view('auth.login-admin');
    }

    /**
     * Handle login admin
     */
    public function loginAdmin(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $username = $request->username;
        $password = $request->password;

        // Cek apakah variabel tersedia
        if (isset($username) && isset($password)) {
            // Gunakan Laravel Auth guard 'admin' untuk mencoba login
            $credentials = ['username' => $username, 'password' => $password];
            if (Auth::guard('admin')->attempt($credentials)) {
                // Set session info (optional, keep compatible with existing checks)
                $admin = Auth::guard('admin')->user();
                session([
                    'user_id' => $admin->admin_id,
                    'username' => $admin->username,
                    'role' => 'admin',
                    'logged_in' => true
                ]);

                return redirect()->to('/admin/dashboard')->with([
                    'key' => 'success',
                    'value' => 'Login berhasil!'
                ]);
            }

            // Username atau password salah
            return back()->with([
                'key' => 'error',
                'value' => 'Username atau Password salah!'
            ]);
        }

        // Form tidak lengkap
        return back()->with([
            'key' => 'error',
            'value' => 'Form tidak lengkap!'
        ]);
    }

    /**
     * Logout
     */
    public function logout()
    {
        // Hapus semua session
        session()->flush();

        return redirect()->to('/')->with([
            'key' => 'success',
            'value' => 'Logout berhasil!'
        ]);
    }

    /**
     * Show register form pembeli
     */
    public function showRegisterPembeli()
    {
        return view('register-pembeli');
    }

    /**
     * Handle register pembeli
     */
    public function registerPembeli(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($user) {
            return redirect()->route('login.pembeli')->with([
                'key' => 'success',
                'value' => 'Pendaftaran berhasil. Silakan login.'
            ]);
        }

        return back()->with([
            'key' => 'error',
            'value' => 'Terjadi kesalahan saat mendaftar.'
        ])->withInput();
    }

    /**
     * Redirect to Google OAuth
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google OAuth callback
     */
    public function handleGoogleCallback(Request $request)
    {
        try {
            // Check if error from Google
            if ($request->has('error')) {
                return redirect('/login/pembeli')->with([
                    'key' => 'error',
                    'value' => 'Login dibatalkan atau terjadi kesalahan di Google.'
                ]);
            }

            // Get code from Google
            if (!$request->has('code')) {
                return redirect('/login/pembeli')->with([
                    'key' => 'error',
                    'value' => 'Authorization code tidak ditemukan.'
                ]);
            }

            // Try to get user, if state validation fails, bypass it
            $googleUser = null;
            $googleAvatar = null;
            
            try {
                $googleUser = Socialite::driver('google')->user();
                $googleAvatar = $googleUser->avatar ?? $googleUser->getAvatar();
            } catch (\Exception $e) {
                // State validation failed, try manual approach
                \Log::warning('State validation failed, trying manual approach', ['error' => $e->getMessage()]);

                // Get access token manually
                $client = new \GuzzleHttp\Client([
                    'verify' => false // Disable SSL verification untuk development (Laragon SSL issue)
                ]);
                $response = $client->post('https://oauth2.googleapis.com/token', [
                    'form_params' => [
                        'client_id' => config('services.google.client_id'),
                        'client_secret' => config('services.google.client_secret'),
                        'code' => $request->code,
                        'grant_type' => 'authorization_code',
                        'redirect_uri' => config('services.google.redirect'),
                    ]
                ]);

                $token = json_decode((string) $response->getBody(), true);

                // Get user info
                $userResponse = $client->get('https://www.googleapis.com/oauth2/v2/userinfo', [
                    'headers' => ['Authorization' => 'Bearer ' . $token['access_token']]
                ]);

                $userData = json_decode((string) $userResponse->getBody(), true);
                $googleUser = (object) [
                    'email' => $userData['email'],
                    'name' => $userData['name'] ?? $userData['email'],
                    'id' => $userData['id']
                ];
                $googleAvatar = $userData['picture'] ?? null;
            }

            \Log::info('Google User Retrieved:', [
                'email' => $googleUser->email ?? $googleUser->getEmail(),
                'name' => $googleUser->name ?? $googleUser->getName(),
                'avatar' => $googleAvatar
            ]);

            // Cari atau buat user berdasarkan Google email
            $email = $googleUser->email ?? $googleUser->getEmail();
            $name = $googleUser->name ?? $googleUser->getName();

            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $name,
                    'password' => Hash::make(uniqid('google_')),
                ]
            );

            // Download dan simpan foto profil Google jika ada dan user belum punya foto profil
            if ($googleAvatar && empty($user->foto_profil)) {
                try {
                    $client = new \GuzzleHttp\Client([
                        'verify' => false,
                        'timeout' => 10
                    ]);
                    
                    $imageResponse = $client->get($googleAvatar);
                    $imageContent = $imageResponse->getBody()->getContents();
                    
                    // Generate unique filename
                    $filename = 'user_profiles/' . uniqid('google_') . '_' . $user->id . '.jpg';
                    
                    // Save to storage
                    Storage::disk('public')->put($filename, $imageContent);
                    
                    // Update user foto_profil
                    $user->foto_profil = $filename;
                    $user->save();
                    
                    \Log::info('Google profile photo saved:', ['filename' => $filename, 'user_id' => $user->id]);
                } catch (\Exception $e) {
                    \Log::warning('Failed to save Google profile photo:', [
                        'error' => $e->getMessage(),
                        'avatar_url' => $googleAvatar
                    ]);
                    // Continue without photo if download fails
                }
            }

            \Log::info('User Found/Created:', ['user_id' => $user->id]);

            // Set session info
            session([
                'user_id' => $user->id,
                'username' => $user->name,
                'role' => 'pembeli',
                'logged_in' => true
            ]);

            \Log::info('Session Set:', session()->all());

            return redirect('/pembeli/lapak')->with([
                'key' => 'success',
                'value' => 'Login berhasil dengan Google!'
            ]);

        } catch (\Exception $e) {
            \Log::error('Google OAuth Error:', [
                'message' => $e->getMessage(),
                'class' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return redirect('/login/pembeli')->with([
                'key' => 'error',
                'value' => 'Gagal login dengan Google: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Show forgot password form
     */
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    /**
     * Send reset password link
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.exists' => 'Email tidak terdaftar dalam sistem.'
        ]);

        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return back()->with([
                'key' => 'error',
                'value' => 'Email tidak terdaftar dalam sistem.'
            ])->withInput();
        }

        // Generate token
        $token = Str::random(64);
        
        // Simpan token ke database (hapus token lama jika ada)
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => Hash::make($token),
            'created_at' => now()
        ]);

        // Buat reset link
        $resetLink = url('/password/reset/' . $token . '?email=' . urlencode($request->email));

        // Untuk development, kita tampilkan link di response
        // Di production, kirim via email
        return back()->with([
            'key' => 'success',
            'value' => 'Link reset password telah dikirim! Link: ' . $resetLink . ' (Untuk development, link ditampilkan di sini. Di production akan dikirim via email.)'
        ]);
    }

    /**
     * Show reset password form
     */
    public function showResetForm($token)
    {
        $email = request()->query('email');
        
        // Cek token
        $reset = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->first();

        if (!$reset) {
            return redirect()->route('password.request')->with([
                'key' => 'error',
                'value' => 'Token reset password tidak valid atau sudah kadaluarsa.'
            ]);
        }

        // Cek apakah token cocok
        if (!Hash::check($token, $reset->token)) {
            return redirect()->route('password.request')->with([
                'key' => 'error',
                'value' => 'Token reset password tidak valid.'
            ]);
        }

        // Cek apakah token masih valid (max 1 jam)
        if (now()->diffInMinutes($reset->created_at) > 60) {
            DB::table('password_reset_tokens')->where('email', $email)->delete();
            return redirect()->route('password.request')->with([
                'key' => 'error',
                'value' => 'Token reset password sudah kadaluarsa. Silakan request ulang.'
            ]);
        }

        return view('auth.reset-password', compact('token', 'email'));
    }

    /**
     * Reset password
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:6|confirmed'
        ], [
            'email.exists' => 'Email tidak terdaftar dalam sistem.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 6 karakter.'
        ]);

        // Cek token
        $reset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$reset) {
            return back()->with([
                'key' => 'error',
                'value' => 'Token reset password tidak valid atau sudah kadaluarsa.'
            ])->withInput();
        }

        // Cek apakah token cocok
        if (!Hash::check($request->token, $reset->token)) {
            return back()->with([
                'key' => 'error',
                'value' => 'Token reset password tidak valid.'
            ])->withInput();
        }

        // Cek apakah token masih valid (max 1 jam)
        if (now()->diffInMinutes($reset->created_at) > 60) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return back()->with([
                'key' => 'error',
                'value' => 'Token reset password sudah kadaluarsa. Silakan request ulang.'
            ])->withInput();
        }

        // Update password
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Hapus token
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login.pembeli')->with([
            'key' => 'success',
            'value' => 'Password berhasil direset! Silakan login dengan password baru.'
        ]);
    }

}

