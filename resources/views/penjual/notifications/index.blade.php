@extends('layouts.penjual')

@section('title', 'Notifikasi')
@section('page-title', 'Notifikasi')
@section('page-subtitle', 'Semua notifikasi sistem')

@section('content')
<div class="bg-white rounded-xl shadow-lg p-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Semua Notifikasi</h2>
        @if($notifications->count() > 0)
            <form action="{{ route('penjual.notifications.markAllAsRead') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                    Tandai Semua Sudah Dibaca
                </button>
            </form>
        @endif
    </div>

    @if($notifications->count() > 0)
        <div class="space-y-3">
            @foreach($notifications as $notification)
                <div class="p-4 rounded-lg border {{ $notification->is_read ? 'bg-white border-gray-200' : 'bg-blue-50 border-blue-200' }} hover:shadow-md transition">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            @if($notification->link)
                                <a href="{{ $notification->link }}" class="block">
                            @endif
                            <h3 class="font-semibold text-gray-800 text-lg">{{ $notification->title }}</h3>
                            <p class="text-sm text-gray-600 mt-1">{{ $notification->message }}</p>
                            <p class="text-xs text-gray-400 mt-2">{{ $notification->created_at->setTimezone('Asia/Jakarta')->format('d M Y H:i') }}</p>
                            @if($notification->link)
                                </a>
                            @endif
                        </div>
                        <div class="flex items-center space-x-2 ml-4">
                            @if(!$notification->is_read)
                                <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                            @endif
                            @if(!$notification->is_read)
                                <form action="{{ route('penjual.notifications.markAsRead', $notification->notification_id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-xs text-blue-600 hover:text-blue-800">
                                        Tandai Dibaca
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($notifications->hasPages())
        <div class="mt-6">
            {{ $notifications->links() }}
        </div>
        @endif
    @else
        <div class="text-center py-12">
            <div class="text-6xl mb-4">🔔</div>
            <p class="text-lg text-gray-500 mb-2">Tidak ada notifikasi</p>
            <p class="text-sm text-gray-400">Notifikasi akan muncul di sini</p>
        </div>
    @endif
</div>
@endsection

