@extends('layouts.admin')

@section('title', 'Keuangan')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">Data Keuangan</h1>
    <p class="text-gray-600">Kelola data keuangan kantin</p>
</div>

<div class="bg-white rounded-xl shadow-md p-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-semibold text-gray-800">Riwayat Keuangan</h2>
        <a href="{{ route('admin.keuangan.create') }}" class="bg-gradient-to-r from-purple-500 to-indigo-600 text-white px-4 py-2 rounded-lg hover:shadow-lg transition font-medium">
            + Tambah Data
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-200">
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">ID</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Tanggal</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Jenis</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Jumlah</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Lapak</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $i)
                <tr class="border-b border-gray-100 hover:bg-gray-50">
                    <td class="px-4 py-3 text-sm text-gray-600">{{ $i->keuangan_id }}</td>
                    <td class="px-4 py-3 text-sm text-gray-600">{{ \Carbon\Carbon::parse($i->tanggal)->format('d/m/Y') }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 text-xs rounded-full {{ $i->jenis_transaksi == 'masuk' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                            {{ ucfirst($i->jenis_transaksi) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-sm font-medium {{ $i->jenis_transaksi == 'masuk' ? 'text-green-600' : 'text-red-600' }}">
                        {{ $i->jenis_transaksi == 'masuk' ? '+' : '-' }}Rp {{ number_format($i->jumlah_uang, 0, ',', '.') }}
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-600">{{ optional($i->lapak)->nama_lapak ?? '-' }}</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('admin.keuangan.edit', $i->keuangan_id) }}" class="px-3 py-1 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 transition text-sm font-medium">
                                Edit
                            </a>
                            <form action="{{ route('admin.keuangan.destroy', $i->keuangan_id) }}" method="POST" style="display:inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data keuangan ini?')">
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
                    <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                        Belum ada data keuangan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($items->hasPages())
    <div class="mt-6">
        {{ $items->links() }}
    </div>
    @endif
</div>
@endsection
