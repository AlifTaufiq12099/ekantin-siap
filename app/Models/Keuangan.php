<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keuangan extends Model
{
    use HasFactory;

    protected $primaryKey = 'keuangan_id';
    protected $fillable = ['lapak_id','tanggal','jenis_transaksi','jumlah_uang','keterangan'];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function lapak()
    {
        return $this->belongsTo(Lapak::class, 'lapak_id', 'lapak_id');
    }
}
