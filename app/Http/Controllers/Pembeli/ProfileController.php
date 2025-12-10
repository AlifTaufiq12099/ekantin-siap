<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        $userId = session('user_id');
        $user = User::findOrFail($userId);

        return view('pembeli.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $userId = session('user_id');
        $user = User::findOrFail($userId);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $userId,
            'password' => 'nullable|string|min:4|confirmed',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle foto profil upload
        if ($request->hasFile('foto_profil')) {
            // Hapus foto lama jika ada
            if ($user->foto_profil) {
                Storage::disk('public')->delete($user->foto_profil);
            }
            
            $file = $request->file('foto_profil');
            $path = $file->store('user_profiles', 'public');
            $data['foto_profil'] = $path;
        }

        // Update password jika diisi
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        // Remove password_confirmation from data
        unset($data['password_confirmation']);

        $user->update($data);

        return redirect()->route('pembeli.lapak.select')->with([
            'key' => 'success',
            'value' => 'Profil berhasil diperbarui'
        ]);
    }
}
