<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaksi;
use App\Models\Menu;
use App\Models\Rating;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $penjualId = session('penjual_id');
        $penjual = \App\Models\Penjual::findOrFail($penjualId);
        
        if (!$penjual->lapak_id) {
            return redirect()->route('penjual.lapak.edit')->with([
                'key' => 'error',
                'value' => 'Anda belum memiliki lapak. Silakan buat lapak terlebih dahulu.'
            ]);
        }
        
        $lapakId = $penjual->lapak_id;
        $lapak = \App\Models\Lapak::find($lapakId);

        // Pesanan Hari Ini
        $pesananHariIni = Transaksi::where('lapak_id', $lapakId)
            ->whereDate('waktu_transaksi', today())
            ->count();
        
        // Pesanan Kemarin (untuk perhitungan persentase)
        $pesananKemarin = Transaksi::where('lapak_id', $lapakId)
            ->whereDate('waktu_transaksi', today()->subDay())
            ->count();
        
        $persentasePesanan = $pesananKemarin > 0 
            ? round((($pesananHariIni - $pesananKemarin) / $pesananKemarin) * 100, 0)
            : ($pesananHariIni > 0 ? 100 : 0);
        
        $pesananDiproses = Transaksi::where('lapak_id', $lapakId)
            ->whereDate('waktu_transaksi', today())
            ->whereIn('status_transaksi', ['diproses', 'sedang_dibuat'])
            ->count();

        // Pendapatan Hari Ini
        $pendapatanHariIni = Transaksi::where('lapak_id', $lapakId)
            ->whereDate('waktu_transaksi', today())
            ->where('status_transaksi', 'selesai')
            ->sum('total_harga');
        
        // Pendapatan Kemarin (untuk perhitungan persentase)
        $pendapatanKemarin = Transaksi::where('lapak_id', $lapakId)
            ->whereDate('waktu_transaksi', today()->subDay())
            ->where('status_transaksi', 'selesai')
            ->sum('total_harga');
        
        $persentasePendapatan = $pendapatanKemarin > 0 
            ? round((($pendapatanHariIni - $pendapatanKemarin) / $pendapatanKemarin) * 100, 0)
            : ($pendapatanHariIni > 0 ? 100 : 0);
        
        $pendapatanKemarinFormatted = $pendapatanKemarin > 1000 
            ? 'Rp ' . number_format($pendapatanKemarin / 1000, 0, ',', '.') . 'K'
            : 'Rp ' . number_format($pendapatanKemarin, 0, ',', '.');
        
        $pendapatanFormatted = $pendapatanHariIni > 1000 
            ? 'Rp ' . number_format($pendapatanHariIni / 1000, 0, ',', '.') . 'K'
            : 'Rp ' . number_format($pendapatanHariIni, 0, ',', '.');

        // Total Menu
        $totalMenu = Menu::where('lapak_id', $lapakId)->count();
        
        // Menu Aktif (stok > 0)
        $menuAktif = Menu::where('lapak_id', $lapakId)
            ->where('stok', '>', 0)
            ->count();
        
        // Menu terlaris minggu ini (untuk subtitle) - hitung jumlah menu yang terjual
        $menuTerlarisMingguData = DB::table('menus')
            ->leftJoin('transaksis', function($join) use ($lapakId) {
                $join->on('menus.menu_id', '=', 'transaksis.menu_id')
                     ->where('transaksis.lapak_id', '=', $lapakId)
                     ->where('transaksis.status_transaksi', '=', 'selesai')
                     ->whereBetween('transaksis.waktu_transaksi', [now()->startOfWeek(), now()->endOfWeek()]);
            })
            ->select('menus.menu_id', DB::raw('COALESCE(SUM(transaksis.jumlah), 0) as total_terjual'))
            ->where('menus.lapak_id', $lapakId)
            ->groupBy('menus.menu_id')
            ->having('total_terjual', '>', 0)
            ->orderBy('total_terjual', 'desc')
            ->limit(3)
            ->get();
        
        $menuTerlarisMinggu = $menuTerlarisMingguData->count();

        // Rating - hitung dari tabel ratings
        $ratings = Rating::where('lapak_id', $lapakId)->get();
        $totalUlasan = $ratings->count();
        
        if ($totalUlasan > 0) {
            $rating = round($ratings->avg('rating'), 1);
        } else {
            $rating = 0;
        }
        
        // Feedback terbaru (5 terakhir)
        $feedbackTerbaru = Rating::with('user')
            ->where('lapak_id', $lapakId)
            ->whereNotNull('feedback')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Pesanan Terbaru (5 terakhir)
        $pesananTerbaru = Transaksi::with(['menu', 'user'])
            ->where('lapak_id', $lapakId)
            ->orderBy('waktu_transaksi', 'desc')
            ->limit(5)
            ->get();

        // Menu Terlaris (4 teratas)
        $menuTerlarisData = DB::table('menus')
            ->leftJoin('transaksis', function($join) use ($lapakId) {
                $join->on('menus.menu_id', '=', 'transaksis.menu_id')
                     ->where('transaksis.lapak_id', '=', $lapakId)
                     ->where('transaksis.status_transaksi', '=', 'selesai');
            })
            ->select('menus.menu_id', 
                     DB::raw('COALESCE(SUM(transaksis.jumlah), 0) as total_terjual'))
            ->where('menus.lapak_id', $lapakId)
            ->groupBy('menus.menu_id')
            ->orderBy('total_terjual', 'desc')
            ->limit(4)
            ->get();
        
        $menuTerlaris = collect();
        foreach ($menuTerlarisData as $data) {
            $menu = Menu::find($data->menu_id);
            if ($menu) {
                $menu->total_terjual = $data->total_terjual ?? 0;
                $menuTerlaris->push($menu);
            }
        }
        
        // Fallback: ambil menu terbaru jika tidak ada transaksi
        if ($menuTerlaris->isEmpty()) {
            $menuTerlaris = Menu::where('lapak_id', $lapakId)->limit(4)->get()->map(function($menu) {
                $menu->total_terjual = 0;
                return $menu;
            });
        }

        return view('penjual.dashboard', compact(
            'lapak',
            'pesananHariIni',
            'pesananDiproses',
            'persentasePesanan',
            'pendapatanFormatted',
            'pendapatanKemarinFormatted',
            'persentasePendapatan',
            'totalMenu',
            'menuAktif',
            'menuTerlarisMinggu',
            'rating',
            'totalUlasan',
            'pesananTerbaru',
            'menuTerlaris',
            'feedbackTerbaru'
        ));
    }
}

