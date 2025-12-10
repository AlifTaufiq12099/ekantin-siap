<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Menu;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('q', '');
        
        $transaksis = Transaksi::with(['user','menu','lapak'])
            ->when($query, function($q) use ($query) {
                $q->where('transaksi_id', 'like', '%' . $query . '%')
                  ->orWhereHas('menu', function($menuQuery) use ($query) {
                      $menuQuery->where('nama_menu', 'like', '%' . $query . '%');
                  })
                  ->orWhereHas('user', function($userQuery) use ($query) {
                      $userQuery->where('name', 'like', '%' . $query . '%')
                                ->orWhere('email', 'like', '%' . $query . '%');
                  })
                  ->orWhereHas('lapak', function($lapakQuery) use ($query) {
                      $lapakQuery->where('nama_lapak', 'like', '%' . $query . '%');
                  })
                  ->orWhere('status_transaksi', 'like', '%' . $query . '%');
            })
            ->orderBy('transaksi_id','desc')
            ->paginate(30);
        
        $transaksis->appends(['q' => $query]);
        
        return view('admin.transaksi.index', compact('transaksis', 'query'));
    }

    public function show($id)
    {
        $transaksi = Transaksi::with(['user','menu','lapak'])->findOrFail($id);
        return view('admin.transaksi.show', compact('transaksi'));
    }

    public function updateStatus(Request $request, $id)
    {
        $transaksi = Transaksi::with('menu')->findOrFail($id);
        $data = $request->validate(['status_transaksi' => 'required|in:diproses,selesai,dibatalkan,menunggu_konfirmasi']);
        
        $oldStatus = $transaksi->status_transaksi;
        $newStatus = $data['status_transaksi'];
        
        // Jika status berubah menjadi dibatalkan, kembalikan stok
        if ($newStatus === 'dibatalkan' && $oldStatus !== 'dibatalkan') {
            $menu = Menu::find($transaksi->menu_id);
            if ($menu) {
                $menu->stok += $transaksi->jumlah;
                $menu->save();
            }
        }
        // Jika status berubah dari dibatalkan ke status lain, kurangi stok lagi
        elseif ($oldStatus === 'dibatalkan' && $newStatus !== 'dibatalkan') {
            $menu = Menu::find($transaksi->menu_id);
            if ($menu && $menu->stok >= $transaksi->jumlah) {
                $menu->stok -= $transaksi->jumlah;
                $menu->save();
            }
        }
        
        $transaksi->status_transaksi = $newStatus;
        $transaksi->save();
        return redirect()->back()->with('success','Status transaksi diperbarui oleh admin');
    }
}
