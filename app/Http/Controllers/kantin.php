<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class kantin extends Controller
{
    public function index() : View
    {
        $data['nama_kantin'] = 'Kantin D-pipe';
        $data['menu'] = [
            ['nama' => 'Nasi Gila', 'gambar' => '/image/resepnasigila.png'],
            ['nama' => 'Mie Jawa', 'gambar' => '/image/miejawa.jpeg'],

        ];
        $data['jam_buka'] = '07:00';
        $data['jam_tutup'] = '15:00';
        $now = date('H:i');
        $data['status_kantin'] = ($now >= $data['jam_buka'] && $now <= $data['jam_tutup']) ? 'Buka' : 'Tutup';
        $data['info_promo'] = ($data['status_kantin'] == 'Buka') ? 'Promo: Diskon 10% untuk pembelian di atas Rp20.000!' : 'Tidak ada promo saat ini.';
        $data['tujuan_kantin'] = 'Menyediakan makanan sehat dan terjangkau untuk semua.';
        $data['minuman'] = [
            ['nama' => 'Es Teh', 'gambar' => '/image/es-teh.jpg'],
            ['nama' => 'es Jeruk', 'gambar' => '/image/es-jeruk.jpeg'],
        ];

        return view('kantin', $data);
    }
}
