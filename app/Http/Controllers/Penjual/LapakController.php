<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lapak;
use App\Models\LapakLog;
use Illuminate\Support\Facades\Storage;
use App\Models\Penjual;

class LapakController extends Controller
{
    public function edit()
    {
        $penjualId = session('penjual_id');
        $penjual = Penjual::findOrFail($penjualId);
        
        // if penjual has a lapak_id, try to load it; otherwise prepare empty lapak for creation
        $lapak = null;
        if ($penjual->lapak_id) {
            $lapak = Lapak::find($penjual->lapak_id);
        }

        return view('penjual.lapaks.edit', compact('lapak'));
    }

    public function update(Request $request)
    {
        $penjualId = session('penjual_id');
        $penjual = Penjual::findOrFail($penjualId);
        
        $lapak = null;
        if ($penjual->lapak_id) {
            $lapak = Lapak::find($penjual->lapak_id);
        }

        $data = $request->validate([
            'nama_lapak' => 'required|string',
            'pemilik' => 'nullable|string',
            'no_hp_pemilik' => 'nullable|string',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle foto profil upload
        if ($request->hasFile('foto_profil')) {
            // Hapus foto lama jika ada
            if ($lapak && $lapak->foto_profil) {
                Storage::disk('public')->delete($lapak->foto_profil);
            }
            
            $file = $request->file('foto_profil');
            $path = $file->store('lapak_profiles', 'public');
            $data['foto_profil'] = $path;
        }

        // If lapak doesn't exist yet, create it, otherwise update and log changes
        if (! $lapak) {
            $lapak = Lapak::create([
                'nama_lapak' => $data['nama_lapak'],
                'pemilik' => $data['pemilik'] ?? $penjual->nama_penjual,
                'no_hp_pemilik' => $data['no_hp_pemilik'] ?? null,
                'foto_profil' => $data['foto_profil'] ?? null,
            ]);

            // link lapak to penjual
            $penjual->lapak_id = $lapak->lapak_id;
            $penjual->save();

            LapakLog::create([
                'lapak_id' => $lapak->lapak_id,
                'changed_by' => $penjual->penjual_id,
                'changed_by_role' => 'penjual',
                'old_data' => null,
                'new_data' => $data,
            ]);

            return redirect()->route('penjual.dashboard')->with('success', 'Lapak dibuat dan ditautkan ke akun Anda');
        }

        // Record old and new for log
        $old = [
            'nama_lapak' => $lapak->nama_lapak,
            'pemilik' => $lapak->pemilik,
            'no_hp_pemilik' => $lapak->no_hp_pemilik,
            'foto_profil' => $lapak->foto_profil,
        ];

        // Update lapak (hanya update foto_profil jika ada file baru)
        $updateData = [
            'nama_lapak' => $data['nama_lapak'],
            'pemilik' => $data['pemilik'] ?? $lapak->pemilik,
            'no_hp_pemilik' => $data['no_hp_pemilik'] ?? $lapak->no_hp_pemilik,
        ];
        
        if (isset($data['foto_profil'])) {
            $updateData['foto_profil'] = $data['foto_profil'];
        }
        
        $lapak->update($updateData);

        $new = [
            'nama_lapak' => $lapak->nama_lapak,
            'pemilik' => $lapak->pemilik,
            'no_hp_pemilik' => $lapak->no_hp_pemilik,
            'foto_profil' => $lapak->foto_profil,
        ];

        LapakLog::create([
            'lapak_id' => $lapak->lapak_id,
            'changed_by' => $penjual->penjual_id,
            'changed_by_role' => 'penjual',
            'old_data' => $old,
            'new_data' => $new,
        ]);

        return redirect()->route('penjual.dashboard')->with('success', 'Lapak diperbarui');
    }
}
