<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $primaryKey = 'menu_id';
    protected $fillable = ['nama_menu','deskripsi','harga','kategori','stok','lapak_id','image'];

    public function lapak()
    {
        return $this->belongsTo(Lapak::class, 'lapak_id', 'lapak_id');
    }
}
