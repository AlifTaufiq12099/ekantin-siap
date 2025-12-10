    @extends('layouts.admin')

    @section('title', 'Users')

    @section('content')
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Daftar Users</h1>
        <p class="text-gray-600">Kelola data pengguna sistem</p>
    </div>

    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
            <div class="flex-1 max-w-md">
                <form action="{{ route('admin.users.index') }}" method="GET" class="flex items-center space-x-2">
                    <div class="relative flex-1">
                        <input 
                            type="text" 
                            name="q"
                            value="{{ $query ?? '' }}"
                            placeholder="Cari user..." 
                            class="w-full px-4 py-2 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none"
                        >
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>
                    <button 
                        type="submit"
                        class="px-4 py-2 bg-gradient-to-r from-purple-500 to-indigo-600 text-white rounded-lg hover:shadow-lg transition font-medium"
                    >
                        Cari
                    </button>
                    @if(isset($query) && $query)
                    <a href="{{ route('admin.users.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                        Reset
                    </a>
                    @endif
                </form>
            </div>
            <a href="{{ route('admin.users.create') }}" class="bg-gradient-to-r from-purple-500 to-indigo-600 text-white px-4 py-2 rounded-lg hover:shadow-lg transition font-medium whitespace-nowrap">
                + Tambah User
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">ID</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Role</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Nama</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Email</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Aksi</th>

                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $u)
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $u->id }}</td>
                        <td class="px-4 py-3 text-sm text-purple-700 font-semibold">{{ $u->role }}</td>
                        <td class="px-4 py-3 text-sm font-medium text-gray-800">{{ $u->nama }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $u->email }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.users.edit', $u->id) }}" class="px-3 py-1 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 transition text-sm font-medium">
                                    Edit
                                </a>
                                <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="px-3 py-1 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition text-sm font-medium">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center text-gray-500">
                            Belum ada user terdaftar
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
        <div class="mt-6">
            {{ $users->links() }}
        </div>
        @endif
    </div>
    @endsection
