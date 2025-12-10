<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $penjualId = session('penjual_id');
        $notifications = Notification::where('user_type', 'penjual')
            ->where('user_id', $penjualId)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('penjual.notifications.index', compact('notifications'));
    }

    public function getNotifications()
    {
        $penjualId = session('penjual_id');
        $notifications = Notification::where('user_type', 'penjual')
            ->where('user_id', $penjualId)
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

        $unreadCount = Notification::where('user_type', 'penjual')
            ->where('user_id', $penjualId)
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
        $penjualId = session('penjual_id');
        $notification = Notification::where('notification_id', $id)
            ->where('user_type', 'penjual')
            ->where('user_id', $penjualId)
            ->firstOrFail();

        $notification->update(['read_at' => now(), 'is_read' => true]);

        return back()->with(['key' => 'success', 'value' => 'Notifikasi ditandai sudah dibaca']);
    }

    public function markAllAsRead()
    {
        $penjualId = session('penjual_id');
        Notification::where('user_type', 'penjual')
            ->where('user_id', $penjualId)
            ->where(function($q) {
                $q->where('is_read', false)->orWhereNull('read_at');
            })
            ->update(['read_at' => now(), 'is_read' => true]);

        return back()->with(['key' => 'success', 'value' => 'Semua notifikasi ditandai sudah dibaca']);
    }
}
