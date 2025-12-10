<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Penjual extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'penjual_id';
    protected $fillable = ['nama_penjual','email','password','no_hp','lapak_id'];
    protected $hidden = ['password'];
}
