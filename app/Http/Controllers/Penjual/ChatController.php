<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use App\Models\Lapak;
use App\Models\Penjual;
use App\Models\Notification;

class ChatController extends Controller
{
    public function index()
    {
        $penjualId = session('penjual_id');
        $penjual = Penjual::findOrFail($penjualId);
        
        if (!$penjual->lapak_id) {
            return redirect()->route('penjual.lapak.edit')->with([
                'key' => 'error',
                'value' => 'Anda belum memiliki lapak. Silakan buat lapak terlebih dahulu.'
            ]);
        }
        
        $lapakId = $penjual->lapak_id;

        // Get all users who have sent messages to this penjual's lapak
        $usersWithChat = User::whereHas('sentMessages', function($query) use ($lapakId) {
            $query->where('lapak_id', $lapakId)
                  ->where('receiver_type', 'penjual');
        })
        ->orWhereHas('receivedMessages', function($query) use ($lapakId) {
            $query->where('lapak_id', $lapakId)
                  ->where('sender_type', 'penjual');
        })
        ->with(['sentMessages' => function($query) use ($lapakId) {
            $query->where('lapak_id', $lapakId)->latest()->limit(1);
        }, 'receivedMessages' => function($query) use ($lapakId) {
            $query->where('lapak_id', $lapakId)->latest()->limit(1);
        }])
        ->get()
        ->map(function($user) use ($lapakId, $penjualId) {
            // Get last message
            $lastMessage = Message::where('lapak_id', $lapakId)
                ->where(function($q) use ($user, $penjualId) {
                    $q->where(function($q2) use ($user, $penjualId) {
                        $q2->where('sender_id', $user->id)
                           ->where('sender_type', 'pembeli')
                           ->where('receiver_id', $penjualId)
                           ->where('receiver_type', 'penjual');
                    })->orWhere(function($q2) use ($user, $penjualId) {
                        $q2->where('sender_id', $penjualId)
                           ->where('sender_type', 'penjual')
                           ->where('receiver_id', $user->id)
                           ->where('receiver_type', 'pembeli');
                    });
                })
                ->latest()
                ->first();

            // Get unread count
            $unreadCount = Message::where('lapak_id', $lapakId)
                ->where('sender_id', $user->id)
                ->where('sender_type', 'pembeli')
                ->where('receiver_id', $penjualId)
                ->where('receiver_type', 'penjual')
                ->whereNull('read_at')
                ->count();

            $user->last_message = $lastMessage;
            $user->unread_count = $unreadCount;
            return $user;
        })
        ->sortByDesc(function($user) {
            return $user->last_message ? $user->last_message->created_at : now()->subYears(100);
        })
        ->values();

        return view('penjual.chat.index', compact('usersWithChat'));
    }

    public function show($userId)
    {
        $penjualId = session('penjual_id');
        $penjual = Penjual::findOrFail($penjualId);
        
        if (!$penjual->lapak_id) {
            return redirect()->route('penjual.lapak.edit')->with([
                'key' => 'error',
                'value' => 'Anda belum memiliki lapak. Silakan buat lapak terlebih dahulu.'
            ]);
        }
        
        $lapakId = $penjual->lapak_id;
        $user = User::findOrFail($userId);

        // Get all messages between this penjual and user for this lapak
        $messages = Message::where('lapak_id', $lapakId)
            ->where(function($q) use ($user, $penjualId) {
                $q->where(function($q2) use ($user, $penjualId) {
                    $q2->where('sender_id', $user->id)
                       ->where('sender_type', 'pembeli')
                       ->where('receiver_id', $penjualId)
                       ->where('receiver_type', 'penjual');
                })->orWhere(function($q2) use ($user, $penjualId) {
                    $q2->where('sender_id', $penjualId)
                       ->where('sender_type', 'penjual')
                       ->where('receiver_id', $user->id)
                       ->where('receiver_type', 'pembeli');
                });
            })
            ->orderBy('message_id', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark messages as read
        Message::where('lapak_id', $lapakId)
            ->where('sender_id', $user->id)
            ->where('sender_type', 'pembeli')
            ->where('receiver_id', $penjualId)
            ->where('receiver_type', 'penjual')
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return view('penjual.chat.show', compact('user', 'messages'));
    }

    public function store(Request $request, $userId)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        $penjualId = session('penjual_id');
        $penjual = Penjual::findOrFail($penjualId);
        
        if (!$penjual->lapak_id) {
            return response()->json([
                'success' => false,
                'error' => 'Anda belum memiliki lapak. Silakan buat lapak terlebih dahulu.'
            ], 400);
        }
        
        $lapakId = $penjual->lapak_id;
        $user = User::findOrFail($userId);

        $message = Message::create([
            'sender_id' => $penjualId,
            'sender_type' => 'penjual',
            'receiver_id' => $user->id,
            'receiver_type' => 'pembeli',
            'lapak_id' => $lapakId,
            'message' => $request->message
        ]);

        // Create notification for buyer
        Notification::createNotification(
            'pembeli',
            $user->id,
            'chat',
            'Pesan Baru dari ' . $penjual->nama_penjual,
            $request->message,
            route('pembeli.chat.show', $lapakId)
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

    public function getNewMessages($userId)
    {
        $penjualId = session('penjual_id');
        $penjual = Penjual::findOrFail($penjualId);
        
        if (!$penjual->lapak_id) {
            return response()->json(['messages' => []]);
        }
        
        $lapakId = $penjual->lapak_id;
        $lastMessageId = request('last_message_id', 0);

        $messages = Message::where('lapak_id', $lapakId)
            ->where('message_id', '>', $lastMessageId)
            ->where(function($q) use ($userId, $penjualId) {
                $q->where(function($q2) use ($userId, $penjualId) {
                    $q2->where('sender_id', $userId)
                       ->where('sender_type', 'pembeli')
                       ->where('receiver_id', $penjualId)
                       ->where('receiver_type', 'penjual');
                })->orWhere(function($q2) use ($userId, $penjualId) {
                    $q2->where('sender_id', $penjualId)
                       ->where('sender_type', 'penjual')
                       ->where('receiver_id', $userId)
                       ->where('receiver_type', 'pembeli');
                });
            })
            ->orderBy('message_id', 'asc')
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function($msg) use ($penjualId) {
                return [
                    'id' => $msg->message_id,
                    'message' => $msg->message,
                    'is_me' => $msg->sender_type === 'penjual' && $msg->sender_id == $penjualId,
                    'created_at' => $msg->created_at->setTimezone('Asia/Jakarta')->format('H:i')
                ];
            });

        return response()->json(['messages' => $messages]);
    }
}
