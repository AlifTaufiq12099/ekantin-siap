<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Menu;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Total Pesanan
        $totalPesanan = Transaksi::count();

        // Pendapatan (format: Rp Xjt)
        $totalPendapatan = Transaksi::where('status_transaksi', 'selesai')->sum('total_harga');
        $pendapatanFormatted = $totalPendapatan > 1000000 
            ? 'Rp ' . number_format($totalPendapatan / 1000, 1, ',', '.') . ' K'
            : 'Rp ' . number_format($totalPendapatan, 0, ',', '.');

        // Menu Aktif
        $menuAktif = Menu::where('stok', '>', 0)->count();

        // Total User
        $totalUser = User::count();

        // Pesanan Terbaru (5 terakhir)
        $pesananTerbaru = Transaksi::with(['menu', 'user'])
            ->orderBy('waktu_transaksi', 'desc')
            ->limit(5)
            ->get();

        // Menu Terlaris (5 teratas berdasarkan jumlah terjual)
        $menuTerlarisData = DB::table('menus')
            ->leftJoin('transaksis', function($join) {
                $join->on('menus.menu_id', '=', 'transaksis.menu_id')
                     ->where('transaksis.status_transaksi', '=', 'selesai');
            })
            ->select('menus.menu_id', 
                     DB::raw('COALESCE(SUM(transaksis.jumlah), 0) as total_terjual'), 
                     DB::raw('COALESCE(SUM(transaksis.total_harga), 0) as total_pendapatan'))
            ->groupBy('menus.menu_id')
            ->orderBy('total_terjual', 'desc')
            ->limit(5)
            ->get();
        
        $menuTerlaris = collect();
        foreach ($menuTerlarisData as $data) {
            $menu = Menu::find($data->menu_id);
            if ($menu) {
                $menu->total_terjual = $data->total_terjual ?? 0;
                $menu->total_pendapatan = $data->total_pendapatan ?? 0;
                $menuTerlaris->push($menu);
            }
        }
        
        // Fallback: ambil menu terbaru jika tidak ada transaksi
        if ($menuTerlaris->isEmpty()) {
            $menuTerlaris = Menu::limit(5)->get()->map(function($menu) {
                $menu->total_terjual = 0;
                $menu->total_pendapatan = 0;
                return $menu;
            });
        }

        return view('admin.dashboard', compact(
            'totalPesanan',
            'pendapatanFormatted',
            'menuAktif',
            'totalUser',
            'pesananTerbaru',
            'menuTerlaris'
        ));
    }

    public function search(Request $request)
    {
        $query = $request->get('q', '');
        
        if (empty($query)) {
            return redirect()->route('admin.dashboard');
        }

        $results = [
            'menus' => collect(),
            'transaksis' => collect(),
            'users' => collect(),
            'lapaks' => collect(),
        ];

        // Search Menu
        $results['menus'] = Menu::where('nama_menu', 'like', '%' . $query . '%')
            ->orWhere('deskripsi', 'like', '%' . $query . '%')
            ->orWhere('kategori', 'like', '%' . $query . '%')
            ->with('lapak')
            ->limit(10)
            ->get();

        // Search Transaksi
        $results['transaksis'] = Transaksi::with(['menu', 'user', 'lapak'])
            ->where(function($q) use ($query) {
                $q->where('transaksi_id', 'like', '%' . $query . '%')
                  ->orWhereHas('menu', function($menuQuery) use ($query) {
                      $menuQuery->where('nama_menu', 'like', '%' . $query . '%');
                  })
                  ->orWhereHas('user', function($userQuery) use ($query) {
                      $userQuery->where('name', 'like', '%' . $query . '%')
                                ->orWhere('email', 'like', '%' . $query . '%');
                  });
            })
            ->orderBy('waktu_transaksi', 'desc')
            ->limit(10)
            ->get();

        // Search User
        $results['users'] = User::where('name', 'like', '%' . $query . '%')
            ->orWhere('email', 'like', '%' . $query . '%')
            ->limit(10)
            ->get();

        // Search Lapak
        $results['lapaks'] = \App\Models\Lapak::where('nama_lapak', 'like', '%' . $query . '%')
            ->orWhere('pemilik', 'like', '%' . $query . '%')
            ->orWhere('no_hp_pemilik', 'like', '%' . $query . '%')
            ->limit(10)
            ->get();

        $totalResults = $results['menus']->count() + $results['transaksis']->count() + $results['users']->count() + $results['lapaks']->count();

        return view('admin.search', compact('query', 'results', 'totalResults'));
    }
}
