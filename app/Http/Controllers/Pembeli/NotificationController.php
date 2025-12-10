<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $userId = session('user_id');
        $notifications = Notification::where('user_type', 'pembeli')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('pembeli.notifications.index', compact('notifications'));
    }

    public function getNotifications()
    {
        $userId = session('user_id');
        $notifications = Notification::where('user_type', 'pembeli')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function($notification) {
                return [
                    'id' => $notification->notification_id,
                    'title' => $notification->title,
                    'message' => $notification->message,
                    'link' => $notification->link,
                    'is_read' => $notification->is_read,
                    'created_at' => $notification->created_at->setTimezone('Asia/Jakarta')->format('d M Y H:i')
                ];
            });

        $unreadCount = Notification::where('user_type', 'pembeli')
            ->where('user_id', $userId)
            ->where(function($q) {
                $q->where('is_read', false)->orWhereNull('read_at');
            })
            ->count();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount
        ]);
    }

    public function markAsRead($id)
    {
        $userId = session('user_id');
        $notification = Notification::where('notification_id', $id)
            ->where('user_type', 'pembeli')
            ->where('user_id', $userId)
            ->firstOrFail();

        $notification->update(['read_at' => now(), 'is_read' => true]);

        return back()->with(['key' => 'success', 'value' => 'Notifikasi ditandai sudah dibaca']);
    }

    public function markAllAsRead()
    {
        $userId = session('user_id');
        Notification::where('user_type', 'pembeli')
            ->where('user_id', $userId)
            ->where(function($q) {
                $q->where('is_read', false)->orWhereNull('read_at');
            })
            ->update(['read_at' => now(), 'is_read' => true]);

        return back()->with(['key' => 'success', 'value' => 'Semua notifikasi ditandai sudah dibaca']);
    }
}
