<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Keuangan;

class KeuanganController extends Controller
{
    public function index()
    {
        $items = Keuangan::with('lapak')->orderBy('keuangan_id','desc')->paginate(20);
        return view('admin.keuangan.index', compact('items'));
    }

    public function create()
    {
        return view('admin.keuangan.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'lapak_id'=>'nullable|integer',
            'tanggal'=>'nullable|date',
            'jenis_transaksi'=>'nullable|string',
            'jumlah_uang'=>'required|numeric',
            'keterangan'=>'nullable|string'
        ]);

        Keuangan::create($data);
        return redirect()->route('admin.keuangan.index')->with('success','Data keuangan dibuat');
    }

    public function edit($id)
    {
        $item = Keuangan::findOrFail($id);
        return view('admin.keuangan.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = Keuangan::findOrFail($id);
        $data = $request->validate([
            'lapak_id'=>'nullable|integer',
            'tanggal'=>'nullable|date',
            'jenis_transaksi'=>'nullable|string',
            'jumlah_uang'=>'required|numeric',
            'keterangan'=>'nullable|string'
        ]);

        $item->update($data);
        return redirect()->route('admin.keuangan.index')->with('success','Data keuangan diupdate');
    }

    public function destroy($id)
    {
        $item = Keuangan::findOrFail($id);
        $item->delete();
        return redirect()->route('admin.keuangan.index')->with('success','Data keuangan dihapus');
    }
}
