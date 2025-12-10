<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $primaryKey = 'notification_id';
    protected $fillable = [
        'user_type', 'user_id', 'type', 'title', 'message', 'link', 'read_at', 'is_read'
    ];

    protected $casts = [
        'read_at' => 'datetime',
        'is_read' => 'boolean',
    ];

    public function user()
    {
        if ($this->user_type === 'pembeli') {
            return $this->belongsTo(User::class, 'user_id', 'id');
        }
        return $this->belongsTo(Penjual::class, 'user_id', 'penjual_id');
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false)->orWhereNull('read_at');
    }

    public function scopeForUser($query, $role, $id)
    {
        return $query->where('user_type', $role)->where('user_id', $id);
    }


    public static function createNotification($role, $recipientId, $type, $title, $message, $link = null)
    {
        return self::create([
            'user_type' => $role,
            'user_id' => $recipientId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'link' => $link,
            'is_read' => false,
        ]);
    }
}
