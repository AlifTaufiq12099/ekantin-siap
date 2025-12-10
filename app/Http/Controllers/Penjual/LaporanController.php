<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Keuangan;
use App\Models\Penjual;

class LaporanController extends Controller
{
    public function harian()
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

        // Data transaksi hari ini
        $transaksiHari = Transaksi::with(['user','menu'])
            ->where('lapak_id', $lapakId)
            ->whereDate('waktu_transaksi', today())
            ->orderBy('transaksi_id','desc')
            ->get();

        // Data keuangan hari ini
        $keuanganHari = Keuangan::where('lapak_id', $lapakId)
            ->whereDate('tanggal', today())
            ->orderBy('keuangan_id','desc')
            ->get();

        // Ringkasan
        $totalTransaksiHari = $transaksiHari->count();
        $totalPenjualanHari = $transaksiHari->sum('total_harga');
        $totalKeuanganMasuk = $keuanganHari->where('jenis_transaksi', 'Pemasukan')->sum('jumlah_uang');
        $totalKeuanganKeluar = $keuanganHari->where('jenis_transaksi', 'Pengeluaran')->sum('jumlah_uang');

        return view('penjual.laporan.harian', compact('transaksiHari','keuanganHari','totalTransaksiHari','totalPenjualanHari','totalKeuanganMasuk','totalKeuanganKeluar'));
    }

    public function bulanan(Request $request)
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

        $bulan = $request->query('bulan', now()->format('Y-m'));
        [$tahun, $bln] = explode('-', $bulan);

        // Data transaksi bulan ini
        $transaksiBulan = Transaksi::with(['user','menu'])
            ->where('lapak_id', $lapakId)
            ->whereYear('waktu_transaksi', $tahun)
            ->whereMonth('waktu_transaksi', $bln)
            ->orderBy('transaksi_id','desc')
            ->get();

        // Data keuangan bulan ini
        $keuanganBulan = Keuangan::where('lapak_id', $lapakId)
            ->whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bln)
            ->orderBy('keuangan_id','desc')
            ->get();

        // Ringkasan
        $totalTransaksiBulan = $transaksiBulan->count();
        $totalPenjualanBulan = $transaksiBulan->sum('total_harga');
        $totalKeuanganMasukBulan = $keuanganBulan->where('jenis_transaksi', 'Pemasukan')->sum('jumlah_uang');
        $totalKeuanganKeluarBulan = $keuanganBulan->where('jenis_transaksi', 'Pengeluaran')->sum('jumlah_uang');

        return view('penjual.laporan.bulanan', compact('transaksiBulan','keuanganBulan','bulan','totalTransaksiBulan','totalPenjualanBulan','totalKeuanganMasukBulan','totalKeuanganKeluarBulan'));
    }
}
