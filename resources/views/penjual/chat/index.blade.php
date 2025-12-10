@extends('layouts.penjual')

@section('title', 'Chat')
@section('page-title', 'Chat')
@section('page-subtitle', 'Pesan dengan pembeli')

@section('content')
    @if(session('key') === 'success')
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-4">
            {{ session('value') }}
        </div>
    @endif

    @if(session('key') === 'error')
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-4">
            {{ session('value') }}
        </div>
    @endif

    <h2 class="text-2xl font-bold text-gray-800 mb-6">Daftar Chat</h2>

    @if($usersWithChat->count() > 0)
        <div class="space-y-3">
            @foreach($usersWithChat as $user)
                <a href="{{ route('penjual.chat.show', $user->id) }}"
                    class="block bg-white rounded-xl shadow-md hover:shadow-lg transition p-4 border-l-4 border-orange-400">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4 flex-1">
                            <div
                                class="w-14 h-14 bg-gradient-to-r from-orange-500 to-pink-500 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                                @if($user->foto_profil)
                                    <img src="{{ asset('storage/' . $user->foto_profil) }}" alt="{{ $user->name }}"
                                        class="w-12 h-12 rounded-full object-cover border-2 border-orange-200">
                                @else
                                    <div
                                        class="w-12 h-12 bg-gradient-to-br from-orange-400 to-pink-500 rounded-full flex items-center justify-center border-2 border-orange-200">
                                        <span class="text-xl text-white">👤</span>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-bold text-gray-800 text-lg">{{ $user->name }}</h3>
                                @if($user->last_message)
                                    <p class="text-sm text-gray-600 truncate mt-1">
                                        {{ $user->last_message->message }}
                                    </p>
                                    <p class="text-xs text-gray-400 mt-1">
                                        {{ $user->last_message->created_at->setTimezone('Asia/Jakarta')->diffForHumans() }}
                                    </p>
                                @else
                                    <p class="text-sm text-gray-400 italic">Belum ada pesan</p>
                                @endif
                            </div>
                        </div>
                        @if($user->unread_count > 0)
                            <div class="ml-4">
                                <span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                                    {{ $user->unread_count }}
                                </span>
                            </div>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-xl shadow-md p-12 text-center">
            <div class="text-6xl mb-4">💬</div>
            <p class="text-lg text-gray-500 mb-2">Belum ada chat</p>
            <p class="text-sm text-gray-400">Chat akan muncul di sini setelah pembeli mengirim pesan</p>
        </div>
    @endif
@endsection