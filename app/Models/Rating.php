<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $primaryKey = 'rating_id';
    protected $fillable = ['transaksi_id', 'user_id', 'lapak_id', 'rating', 'feedback'];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id', 'transaksi_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function lapak()
    {
        return $this->belongsTo(Lapak::class, 'lapak_id', 'lapak_id');
    }
}
