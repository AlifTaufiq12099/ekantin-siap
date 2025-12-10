<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'admin_id';
    protected $fillable = ['nama','username','password','no_hp','email','alamat'];
    public $timestamps = true;

    protected $hidden = ['password'];

    // If you don't use email as the login field, set the username property name
    protected $username = 'username';
}
