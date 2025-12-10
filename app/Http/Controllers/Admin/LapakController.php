<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lapak;
use App\Models\LapakLog;
use Illuminate\Support\Facades\Auth;

class LapakController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('q', '');
        
        $lapaks = Lapak::when($query, function($q) use ($query) {
                $q->where('nama_lapak', 'like', '%' . $query . '%')
                  ->orWhere('pemilik', 'like', '%' . $query . '%')
                  ->orWhere('no_hp_pemilik', 'like', '%' . $query . '%');
            })
            ->orderBy('lapak_id','desc')
            ->paginate(20);
        
        $lapaks->appends(['q' => $query]);
        
        return view('admin.lapaks.index', compact('lapaks', 'query'));
    }

    public function create()
    {
        return view('admin.lapaks.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_lapak'=>'required|string',
            'pemilik'=>'nullable|string',
            'no_hp_pemilik'=>'nullable|string'
        ]);

        Lapak::create($data);
        return redirect()->route('admin.lapaks.index')->with('success','Lapak dibuat');
    }

    public function edit($id)
    {
        $lapak = Lapak::findOrFail($id);
        return view('admin.lapaks.edit', compact('lapak'));
    }

    public function update(Request $request, $id)
    {
        $lapak = Lapak::findOrFail($id);
        $data = $request->validate([
            'nama_lapak'=>'required|string',
            'pemilik'=>'nullable|string',
            'no_hp_pemilik'=>'nullable|string'
        ]);

        // record old data
        $old = [
            'nama_lapak' => $lapak->nama_lapak,
            'pemilik' => $lapak->pemilik,
            'no_hp_pemilik' => $lapak->no_hp_pemilik,
        ];

        $lapak->update($data);

        $new = [
            'nama_lapak' => $lapak->nama_lapak,
            'pemilik' => $lapak->pemilik,
            'no_hp_pemilik' => $lapak->no_hp_pemilik,
        ];

        // who made the change (prefer authenticated admin)
        $admin = Auth::guard('admin')->user();
        $changedBy = $admin ? $admin->admin_id : session('user_id');

        LapakLog::create([
            'lapak_id' => $lapak->lapak_id,
            'changed_by' => $changedBy,
            'changed_by_role' => 'admin',
            'old_data' => $old,
            'new_data' => $new,
        ]);

        return redirect()->route('admin.lapaks.index')->with('success','Lapak diupdate');
    }

    public function destroy($id)
    {
        $lapak = Lapak::findOrFail($id);
        $lapak->delete();
        return redirect()->route('admin.lapaks.index')->with('success','Lapak dihapus');
    }
}
