<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\kantin;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    // Ambil menu populer (menu dengan stok > 0, limit 8)
    $menuPopuler = \App\Models\Menu::where('stok', '>', 0)
        ->with('lapak')
        ->orderBy('menu_id', 'desc')
        ->limit(8)
        ->get();
    
    // Ambil semua lapak untuk ditampilkan
    $lapaks = \App\Models\Lapak::all();
    
    // Ambil feedback rating 5 untuk ditampilkan di landing page
    $feedbackRating5 = \App\Models\Rating::with('user', 'lapak')
        ->where('rating', 5)
        ->whereNotNull('feedback')
        ->orderBy('created_at', 'desc')
        ->limit(20)
        ->get();
    
    return view('landpage', compact('menuPopuler', 'lapaks', 'feedbackRating5'));
});



// Login Pembeli
Route::get('/login/pembeli', [AuthController::class, 'showLoginPembeli'])->name('login.pembeli');
Route::post('/login/pembeli', [AuthController::class, 'loginPembeli']);
// Register Pembeli
Route::get('/register/pembeli', [AuthController::class, 'showRegisterPembeli'])->name('register.pembeli');
Route::post('/register/pembeli', [AuthController::class, 'registerPembeli']);
// Lupa Password Pembeli
Route::get('/password/reset', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/password/email', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [AuthController::class, 'resetPassword'])->name('password.update');

// Login Penjual
Route::get('/login/penjual', [AuthController::class, 'showLoginPenjual'])->name('login.penjual');
Route::post('/login/penjual', [AuthController::class, 'loginPenjual']);


// Login Admin
Route::get('/login/admin', [AuthController::class, 'showLoginAdmin'])->name('login.admin');
Route::post('/login/admin', [AuthController::class, 'loginAdmin']);
Route::get('/admin/login', [AuthController::class, 'showLoginAdmin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'loginAdmin']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout', [AuthController::class, 'logout']); // Tambahan untuk GET method

// Google OAuth
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('google.callback');

// Dashboard Pembeli (Protected)
Route::get('/home', function () {
    $lapaks = \App\Models\Lapak::all();
    return view('home', compact('lapaks'));
})->middleware(\App\Http\Middleware\PembeliAuth::class)->name('dashboard.pembeli');

// Pembeli routes (protected by PembeliAuth middleware)
Route::prefix('pembeli')->name('pembeli.')->middleware(\App\Http\Middleware\PembeliAuth::class)->group(function () {
    Route::get('lapak', [App\Http\Controllers\PembeliController::class, 'selectLapak'])->name('lapak.select');
    Route::get('lapak/{id}', [App\Http\Controllers\PembeliController::class, 'showLapak'])->name('lapak.show');
    Route::get('riwayat', [App\Http\Controllers\PembeliController::class, 'riwayatPesanan'])->name('riwayat');
    Route::post('order', [App\Http\Controllers\PembeliController::class, 'storeOrder'])->name('order.store');
    Route::get('order/{id}', [App\Http\Controllers\PembeliController::class, 'showOrder'])->name('order.show');
    Route::post('order/{id}/bukti', [App\Http\Controllers\PembeliController::class, 'uploadProof'])->name('order.uploadProof');
    Route::post('order/{id}/confirm', [App\Http\Controllers\PembeliController::class, 'confirmReceived'])->name('order.confirmReceived');
    Route::post('order/{id}/rating', [App\Http\Controllers\PembeliController::class, 'storeRating'])->name('order.rating');
    
    // Chat routes
    Route::get('chat', [App\Http\Controllers\Pembeli\ChatController::class, 'index'])->name('chat.index');
    Route::get('chat/{lapakId}', [App\Http\Controllers\Pembeli\ChatController::class, 'show'])->name('chat.show');
    Route::post('chat/{lapakId}', [App\Http\Controllers\Pembeli\ChatController::class, 'store'])->name('chat.store');
    Route::get('chat/{lapakId}/messages', [App\Http\Controllers\Pembeli\ChatController::class, 'getNewMessages'])->name('chat.getNewMessages');
    
    // Notification routes
    Route::get('notifications', [App\Http\Controllers\Pembeli\NotificationController::class, 'index'])->name('notifications.index');
    Route::get('notifications/get', [App\Http\Controllers\Pembeli\NotificationController::class, 'getNotifications'])->name('notifications.getNotifications');
    Route::post('notifications/{id}/read', [App\Http\Controllers\Pembeli\NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::post('notifications/read-all', [App\Http\Controllers\Pembeli\NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    
    // Profile routes
    Route::get('profile/edit', [App\Http\Controllers\Pembeli\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [App\Http\Controllers\Pembeli\ProfileController::class, 'update'])->name('profile.update');
});

// Dashboard Penjual (Protected) - Redirect to new route
Route::get('/penjual/dashboard', function () {
    return redirect()->route('penjual.dashboard');
})->middleware(\App\Http\Middleware\PenjualAuth::class)->name('dashboard.penjual');

// Dashboard Admin (Protected)
Route::get('/admin/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])
    ->middleware(\App\Http\Middleware\AdminAuth::class)
    ->name('admin.dashboard');
Route::get('/admin/search', [App\Http\Controllers\Admin\DashboardController::class, 'search'])
    ->middleware(\App\Http\Middleware\AdminAuth::class)
    ->name('admin.search');

// Penjual routes (protected by PenjualAuth middleware)
Route::prefix('penjual')->name('penjual.')->middleware(\App\Http\Middleware\PenjualAuth::class)->group(function () {
    Route::get('dashboard', [App\Http\Controllers\Penjual\DashboardController::class, 'index'])->name('dashboard');
    // Penjual menu management
    Route::get('menus', [App\Http\Controllers\Penjual\MenuController::class, 'index'])->name('menus.index');
    Route::get('menus/create', [App\Http\Controllers\Penjual\MenuController::class, 'create'])->name('menus.create');
    Route::post('menus', [App\Http\Controllers\Penjual\MenuController::class, 'store'])->name('menus.store');
    Route::get('menus/{id}/edit', [App\Http\Controllers\Penjual\MenuController::class, 'edit'])->name('menus.edit');
    Route::put('menus/{id}', [App\Http\Controllers\Penjual\MenuController::class, 'update'])->name('menus.update');
    Route::delete('menus/{id}', [App\Http\Controllers\Penjual\MenuController::class, 'destroy'])->name('menus.destroy');

    // Penjual transaksi (read-only + update status)
    Route::get('transaksi', [App\Http\Controllers\Penjual\TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('transaksi/{id}', [App\Http\Controllers\Penjual\TransaksiController::class, 'show'])->name('transaksi.show');
    Route::post('transaksi/{id}/status', [App\Http\Controllers\Penjual\TransaksiController::class, 'updateStatus'])->name('transaksi.updateStatus');

    // Penjual keuangan
    Route::get('keuangan', [App\Http\Controllers\Penjual\KeuanganController::class, 'index'])->name('keuangan.index');
    Route::get('keuangan/create', [App\Http\Controllers\Penjual\KeuanganController::class, 'create'])->name('keuangan.create');
    Route::post('keuangan', [App\Http\Controllers\Penjual\KeuanganController::class, 'store'])->name('keuangan.store');
    Route::get('keuangan/{id}/edit', [App\Http\Controllers\Penjual\KeuanganController::class, 'edit'])->name('keuangan.edit');
    Route::put('keuangan/{id}', [App\Http\Controllers\Penjual\KeuanganController::class, 'update'])->name('keuangan.update');
    Route::delete('keuangan/{id}', [App\Http\Controllers\Penjual\KeuanganController::class, 'destroy'])->name('keuangan.destroy');

    // Penjual laporan
    Route::get('laporan/harian', [App\Http\Controllers\Penjual\LaporanController::class, 'harian'])->name('laporan.harian');
    Route::get('laporan/bulanan', [App\Http\Controllers\Penjual\LaporanController::class, 'bulanan'])->name('laporan.bulanan');

    // Penjual feedback
    Route::get('feedback', [App\Http\Controllers\Penjual\FeedbackController::class, 'index'])->name('feedback.index');

    // Penjual edit lapak (only their own)
    Route::get('lapak/edit', [App\Http\Controllers\Penjual\LapakController::class, 'edit'])->name('lapak.edit');
    Route::put('lapak', [App\Http\Controllers\Penjual\LapakController::class, 'update'])->name('lapak.update');

    // Chat routes
    Route::get('chat', [App\Http\Controllers\Penjual\ChatController::class, 'index'])->name('chat.index');
    Route::get('chat/{userId}', [App\Http\Controllers\Penjual\ChatController::class, 'show'])->name('chat.show');
    Route::post('chat/{userId}', [App\Http\Controllers\Penjual\ChatController::class, 'store'])->name('chat.store');
    Route::get('chat/{userId}/messages', [App\Http\Controllers\Penjual\ChatController::class, 'getNewMessages'])->name('chat.getNewMessages');

    // Notification routes
    Route::get('notifications', [App\Http\Controllers\Penjual\NotificationController::class, 'index'])->name('notifications.index');
    Route::get('notifications/get', [App\Http\Controllers\Penjual\NotificationController::class, 'getNotifications'])->name('notifications.getNotifications');
    Route::post('notifications/{id}/read', [App\Http\Controllers\Penjual\NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::post('notifications/read-all', [App\Http\Controllers\Penjual\NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
});

// Admin routes group (protected by session role check)
// Protect admin routes with AdminAuth middleware class
Route::prefix('admin')->name('admin.')->middleware(\App\Http\Middleware\AdminAuth::class)->group(function () {

    // Resource-like routes for admin panel
    Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [App\Http\Controllers\Admin\UserController::class, 'create'])->name('users.create');
    Route::post('/users', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');

    Route::resource('menus', App\Http\Controllers\Admin\MenuController::class, ['names' => [
        'index' => 'menus.index', 'create' => 'menus.create', 'store' => 'menus.store', 'edit' => 'menus.edit', 'update' => 'menus.update', 'destroy' => 'menus.destroy'
    ]])->parameters(['menus' => 'id']);

    Route::resource('lapaks', App\Http\Controllers\Admin\LapakController::class, ['names' => [
        'index' => 'lapaks.index', 'create' => 'lapaks.create', 'store' => 'lapaks.store', 'edit' => 'lapaks.edit', 'update' => 'lapaks.update', 'destroy' => 'lapaks.destroy'
    ]])->parameters(['lapaks' => 'id']);

    Route::resource('keuangan', App\Http\Controllers\Admin\KeuanganController::class, ['names' => [
        'index' => 'keuangan.index', 'create' => 'keuangan.create', 'store' => 'keuangan.store', 'edit' => 'keuangan.edit', 'update' => 'keuangan.update', 'destroy' => 'keuangan.destroy'
    ]])->parameters(['keuangan' => 'id']);

    // Transaksi: read-only listing and show
    Route::get('transaksi', [App\Http\Controllers\Admin\TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('transaksi/{id}', [App\Http\Controllers\Admin\TransaksiController::class, 'show'])->name('transaksi.show');
    Route::post('transaksi/{id}/status', [App\Http\Controllers\Admin\TransaksiController::class, 'updateStatus'])->name('transaksi.updateStatus');


});
