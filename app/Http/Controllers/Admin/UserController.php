<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Lapak;
use App\Models\Penjual;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('q', '');
        
        // ambil user dari tabel users
        $usersQuery = \DB::table('users')
            ->select(
                'id',
                'name as nama',
                'email',
                \DB::raw('"User" as role'),
                'created_at'
            );

        // ambil penjual dari tabel penjuals
        $penjualsQuery = \DB::table('penjuals')
            ->select(
                'penjual_id as id',
                'nama_penjual as nama',
                'email',
                \DB::raw('"Penjual" as role'),
                'created_at'
            );

        // Jika ada query, filter dulu sebelum union
        if ($query) {
            $usersQuery->where(function($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                  ->orWhere('email', 'like', '%' . $query . '%');
            });
            
            $penjualsQuery->where(function($q) use ($query) {
                $q->where('nama_penjual', 'like', '%' . $query . '%')
                  ->orWhere('email', 'like', '%' . $query . '%');
            });
        }

        // gabungkan dua tabel
        $all = $usersQuery->union($penjualsQuery);

        // bungkus jadi subquery lalu paginate
        $final = \DB::table(\DB::raw("({$all->toSql()}) as combined"))
            ->mergeBindings($all)
            ->orderBy('id', 'desc')
            ->paginate(20);
        
        $final->appends(['q' => $query]);

        return view('admin.users.index', ['users' => $final, 'query' => $query]);
    }


    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        // base validation for user
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'password' => 'nullable|string|min:4',
            'is_penjual' => 'nullable|boolean'
        ]);

        $isPenjual = $request->has('is_penjual') && $request->is_penjual;

        if ($isPenjual) {
            // additional validation for penjual + lapak
            $request->validate([
                'email' => 'required|email|unique:penjuals,email|unique:users,email',
                'password' => 'required|string|min:4',
                'nama_lapak' => 'required|string',
                'pemilik' => 'nullable|string',
                'no_hp_pemilik' => 'nullable|string'
            ]);

            // create lapak first
            $lapak = Lapak::create([
                'nama_lapak' => $request->nama_lapak,
                'pemilik' => $request->pemilik ?? $request->nama,
                'no_hp_pemilik' => $request->no_hp_pemilik ?? null,
            ]);

            // create penjual account
            $penjual = Penjual::create([
                'nama_penjual' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'no_hp' => $request->no_hp_pemilik ?? null,
                'lapak_id' => $lapak->lapak_id,
            ]);

            // also create a users entry so admin user list shows the penjual
            $user = new User();
            $user->name = $request->nama;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            return redirect()->route('admin.users.index')->with('success', 'Penjual dan Lapak berhasil dibuat');
        }

        // create normal user
        $user = new User();
        $user->name = $data['nama'];
        $user->email = $data['email'] ?? null;
        if (!empty($data['password']))
            $user->password = Hash::make($data['password']);
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dibuat');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'password' => 'nullable|string|min:4',
        ]);

        $user->name = $data['nama'];
        $user->email = $data['email'] ?? null;
        if (!empty($data['password']))
            $user->password = Hash::make($data['password']);
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diupdate');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User dihapus');
    }
}
