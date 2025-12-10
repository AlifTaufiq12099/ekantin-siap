<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $primaryKey = 'message_id';
    protected $fillable = [
        'sender_id', 'sender_type', 'receiver_id', 'receiver_type', 'lapak_id', 'message', 'read_at'
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    public function lapak()
    {
        return $this->belongsTo(Lapak::class, 'lapak_id', 'lapak_id');
    }

    public function sender()
    {
        if ($this->sender_type === 'pembeli') {
            return $this->belongsTo(User::class, 'sender_id', 'id');
        }
        return $this->belongsTo(Penjual::class, 'sender_id', 'penjual_id');
    }

    public function receiver()
    {
        if ($this->receiver_type === 'pembeli') {
            return $this->belongsTo(User::class, 'receiver_id', 'id');
        }
        return $this->belongsTo(Penjual::class, 'receiver_id', 'penjual_id');
    }
}
