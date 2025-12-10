<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $primaryKey = 'transaksi_id';
    protected $fillable = ['user_id','menu_id','lapak_id','waktu_transaksi','jumlah','total_harga','metode_pembayaran','status_transaksi','bukti_pembayaran'];

    protected $casts = [
        'waktu_transaksi' => 'datetime',
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id', 'menu_id');
    }

    public function lapak()
    {
        return $this->belongsTo(Lapak::class, 'lapak_id', 'lapak_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }
}
