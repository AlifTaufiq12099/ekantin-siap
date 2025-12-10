<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Keuangan;
use App\Models\Penjual;
use App\Models\Transaksi;

class KeuanganController extends Controller
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
        
        $lapakId = $penjual->lapak_id;
        
        // Total pendapatan dari semua pesanan dengan status 'selesai' dari awal sampai akhir
        $totalPendapatan = Transaksi::where('lapak_id', $lapakId)
            ->where('status_transaksi', 'selesai')
            ->sum('total_harga');
        
        // Total transaksi selesai
        $totalTransaksiSelesai = Transaksi::where('lapak_id', $lapakId)
            ->where('status_transaksi', 'selesai')
            ->count();
        
        // List pesanan yang selesai
        $pesananSelesai = Transaksi::with(['user', 'menu'])
            ->where('lapak_id', $lapakId)
            ->where('status_transaksi', 'selesai')
            ->orderBy('waktu_transaksi', 'desc')
            ->paginate(20);
        
        return view('penjual.keuangan.index', compact('pesananSelesai', 'totalPendapatan', 'totalTransaksiSelesai'));
    }

    public function create()
    {
        return view('penjual.keuangan.create');
    }

    public function store(Request $request)
    {
        $penjualId = session('penjual_id');
        $penjual = Penjual::findOrFail($penjualId);
        
        if (!$penjual->lapak_id) {
            return back()->with([
                'key' => 'error',
                'value' => 'Anda belum memiliki lapak. Silakan buat lapak terlebih dahulu.'
            ])->withInput();
        }
        
        $data = $request->validate([
            'tanggal'=>'nullable|date',
            'jenis_transaksi'=>'nullable|string',
            'jumlah_uang'=>'required|numeric',
            'keterangan'=>'nullable|string'
        ]);

        $data['lapak_id'] = $penjual->lapak_id;
        Keuangan::create($data);
        return redirect()->route('penjual.keuangan.index')->with('success','Data keuangan dibuat');
    }

    public function edit($id)
    {
        $penjualId = session('penjual_id');
        $penjual = Penjual::findOrFail($penjualId);
        
        if (!$penjual->lapak_id) {
            return redirect()->route('penjual.lapak.edit')->with([
                'key' => 'error',
                'value' => 'Anda belum memiliki lapak. Silakan buat lapak terlebih dahulu.'
            ]);
        }
        
        $item = Keuangan::where('lapak_id', $penjual->lapak_id)->where('keuangan_id', $id)->firstOrFail();
        return view('penjual.keuangan.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $penjualId = session('penjual_id');
        $penjual = Penjual::findOrFail($penjualId);
        
        if (!$penjual->lapak_id) {
            return back()->with([
                'key' => 'error',
                'value' => 'Anda belum memiliki lapak. Silakan buat lapak terlebih dahulu.'
            ])->withInput();
        }
        
        $item = Keuangan::where('lapak_id', $penjual->lapak_id)->where('keuangan_id', $id)->firstOrFail();
        $data = $request->validate([
            'tanggal'=>'nullable|date',
            'jenis_transaksi'=>'nullable|string',
            'jumlah_uang'=>'required|numeric',
            'keterangan'=>'nullable|string'
        ]);

        $item->update($data);
        return redirect()->route('penjual.keuangan.index')->with('success','Data keuangan diupdate');
    }

    public function destroy($id)
    {
        $penjualId = session('penjual_id');
        $penjual = Penjual::findOrFail($penjualId);
        
        if (!$penjual->lapak_id) {
            return back()->with([
                'key' => 'error',
                'value' => 'Anda belum memiliki lapak. Silakan buat lapak terlebih dahulu.'
            ]);
        }
        
        $item = Keuangan::where('lapak_id', $penjual->lapak_id)->where('keuangan_id', $id)->firstOrFail();
        $item->delete();
        return redirect()->route('penjual.keuangan.index')->with('success','Data keuangan dihapus');
    }
}
