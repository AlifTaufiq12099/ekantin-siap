<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Menu;
use App\Models\Penjual;

class TransaksiController extends Controller
{
    public function index()
    {
        $penjualId = session('penjual_id');
        $penjual = Penjual::findOrFail($penjualId);
        
        if (!$penjual->lapak_id) {
            return redirect()->route('penjual.lapak.edit')->with([
                'key' => 'error',
                'value' => 'Anda belum memiliki lapak. Silakan buat lapak terlebih dahulu.'
            ]);
        }
        
        $transaksis = Transaksi::with(['user','menu'])->where('lapak_id', $penjual->lapak_id)->orderBy('transaksi_id','desc')->paginate(30);
        return view('penjual.transaksi.index', compact('transaksis'));
    }

    public function show($id)
    {
        $penjualId = session('penjual_id');
        $penjual = Penjual::findOrFail($penjualId);
        
        if (!$penjual->lapak_id) {
            return redirect()->route('penjual.lapak.edit')->with([
                'key' => 'error',
                'value' => 'Anda belum memiliki lapak. Silakan buat lapak terlebih dahulu.'
            ]);
        }
        
        $t = Transaksi::with(['user','menu'])->where('lapak_id', $penjual->lapak_id)->where('transaksi_id', $id)->firstOrFail();
        return view('penjual.transaksi.show', compact('t'));
    }

    public function updateStatus(Request $request, $id)
    {
        $penjualId = session('penjual_id');
        $penjual = Penjual::findOrFail($penjualId);
        
        if (!$penjual->lapak_id) {
            return back()->with([
                'key' => 'error',
                'value' => 'Anda belum memiliki lapak. Silakan buat lapak terlebih dahulu.'
            ]);
        }
        
        $t = Transaksi::with('menu')->where('lapak_id', $penjual->lapak_id)->where('transaksi_id', $id)->firstOrFail();
        // allow new statuses including 'sedang_dibuat' and 'menunggu_konfirmasi'
        $data = $request->validate(['status_transaksi'=>'required|in:diproses,selesai,dibatalkan,menunggu_konfirmasi,sedang_dibuat,siap']);
        
        $oldStatus = $t->status_transaksi;
        $newStatus = $data['status_transaksi'];
        
        // Jika status berubah menjadi dibatalkan, kembalikan stok
        if ($newStatus === 'dibatalkan' && $oldStatus !== 'dibatalkan') {
            $menu = Menu::find($t->menu_id);
            if ($menu) {
                $menu->stok += $t->jumlah;
                $menu->save();
            }
        }
        // Jika status berubah dari dibatalkan ke status lain, kurangi stok lagi
        elseif ($oldStatus === 'dibatalkan' && $newStatus !== 'dibatalkan') {
            $menu = Menu::find($t->menu_id);
            if ($menu && $menu->stok >= $t->jumlah) {
                $menu->stok -= $t->jumlah;
                $menu->save();
            }
        }
        
        $t->status_transaksi = $newStatus;
        $t->save();
        return redirect()->back()->with('success','Status transaksi diperbarui menjadi: ' . $t->status_transaksi);
    }
}
