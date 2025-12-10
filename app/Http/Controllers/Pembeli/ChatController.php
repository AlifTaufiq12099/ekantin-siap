<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Lapak;
use App\Models\Penjual;
use App\Models\Notification;

class ChatController extends Controller
{
    public function index()
    {
        $userId = session('user_id');

        // Get all lapaks that have messages with this user
        $lapaksWithChat = Lapak::whereHas('messages', function($query) use ($userId) {
            $query->where(function($q) use ($userId) {
                $q->where('sender_id', $userId)
                  ->where('sender_type', 'pembeli');
            })->orWhere(function($q) use ($userId) {
                $q->where('receiver_id', $userId)
                  ->where('receiver_type', 'pembeli');
            });
        })
        ->with(['penjual'])
        ->get()
        ->map(function($lapak) use ($userId) {
            // Get last message
            $lastMessage = Message::where('lapak_id', $lapak->lapak_id)
                ->where(function($q) use ($userId) {
                    $q->where('sender_id', $userId)
                      ->where('sender_type', 'pembeli')
                      ->orWhere('receiver_id', $userId)
                      ->where('receiver_type', 'pembeli');
                })
                ->latest()
                ->first();

            // Get unread count
            $unreadCount = Message::where('lapak_id', $lapak->lapak_id)
                ->where('sender_type', 'penjual')
                ->where('receiver_id', $userId)
                ->where('receiver_type', 'pembeli')
                ->whereNull('read_at')
                ->count();

            $lapak->last_message = $lastMessage;
            $lapak->unread_count = $unreadCount;
            return $lapak;
        })
        ->sortByDesc(function($lapak) {
            return $lapak->last_message ? $lapak->last_message->created_at : now()->subYears(100);
        })
        ->values();

        return view('pembeli.chat.index', compact('lapaksWithChat'));
    }

    public function show($lapakId)
    {
        $userId = session('user_id');
        $lapak = Lapak::findOrFail($lapakId);
        $penjual = Penjual::where('lapak_id', $lapakId)->firstOrFail();

        // Get all messages between this user and penjual for this lapak
        $messages = Message::where('lapak_id', $lapakId)
            ->where(function($q) use ($userId, $penjual) {
                $q->where(function($q2) use ($userId, $penjual) {
                    $q2->where('sender_id', $userId)
                       ->where('sender_type', 'pembeli')
                       ->where('receiver_id', $penjual->penjual_id)
                       ->where('receiver_type', 'penjual');
                })->orWhere(function($q2) use ($userId, $penjual) {
                    $q2->where('sender_id', $penjual->penjual_id)
                       ->where('sender_type', 'penjual')
                       ->where('receiver_id', $userId)
                       ->where('receiver_type', 'pembeli');
                });
            })
            ->orderBy('message_id', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark messages as read
        Message::where('lapak_id', $lapakId)
            ->where('sender_type', 'penjual')
            ->where('receiver_id', $userId)
            ->where('receiver_type', 'pembeli')
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return view('pembeli.chat.show', compact('lapak', 'messages'));
    }

    public function store(Request $request, $lapakId)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        $userId = session('user_id');
        $lapak = Lapak::findOrFail($lapakId);
        $penjual = Penjual::where('lapak_id', $lapakId)->firstOrFail();

        $message = Message::create([
            'sender_id' => $userId,
            'sender_type' => 'pembeli',
            'receiver_id' => $penjual->penjual_id,
            'receiver_type' => 'penjual',
            'lapak_id' => $lapakId,
            'message' => $request->message
        ]);

        // Create notification for seller
        Notification::createNotification(
            'penjual',
            $penjual->penjual_id,
            'chat',
            'Pesan Baru dari ' . \App\Models\User::find($userId)->name,
            $request->message,
            route('penjual.chat.show', $userId)
        );

        // Always return JSON for AJAX requests
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true, 
                'message' => [
                    'message_id' => $message->message_id,
                    'message' => $message->message,
                    'created_at' => $message->created_at->setTimezone('Asia/Jakarta')->format('H:i')
                ]
            ]);
        }

        return back()->with(['key' => 'success', 'value' => 'Pesan berhasil dikirim']);
    }

    public function getNewMessages($lapakId)
    {
        $userId = session('user_id');
        $penjual = Penjual::where('lapak_id', $lapakId)->firstOrFail();
        $lastMessageId = request('last_message_id', 0);

        $messages = Message::where('lapak_id', $lapakId)
            ->where('message_id', '>', $lastMessageId)
            ->where(function($q) use ($userId, $penjual) {
                $q->where(function($q2) use ($userId, $penjual) {
                    $q2->where('sender_id', $userId)
                       ->where('sender_type', 'pembeli')
                       ->where('receiver_id', $penjual->penjual_id)
                       ->where('receiver_type', 'penjual');
                })->orWhere(function($q2) use ($userId, $penjual) {
                    $q2->where('sender_id', $penjual->penjual_id)
                       ->where('sender_type', 'penjual')
                       ->where('receiver_id', $userId)
                       ->where('receiver_type', 'pembeli');
                });
            })
            ->orderBy('message_id', 'asc')
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function($msg) use ($userId) {
                return [
                    'id' => $msg->message_id,
                    'message' => $msg->message,
                    'is_me' => $msg->sender_type === 'pembeli' && $msg->sender_id == $userId,
                    'created_at' => $msg->created_at->setTimezone('Asia/Jakarta')->format('H:i')
                ];
            });

        return response()->json(['messages' => $messages]);
    }
}
