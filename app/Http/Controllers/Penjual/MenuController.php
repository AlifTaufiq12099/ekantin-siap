<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Menu;
use App\Models\Penjual;

class MenuController extends Controller
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
        
        $menus = Menu::where('lapak_id', $penjual->lapak_id)->orderBy('menu_id','desc')->paginate(20);
        return view('penjual.menus.index', compact('menus'));
    }

    public function create()
    {
        return view('penjual.menus.create');
    }

    public function store(Request $request)
    {
        $penjualId = session('penjual_id');
        $penjual = Penjual::findOrFail($penjualId);
        
        if (!$penjual->lapak_id) {
            return back()->with([
                'key' => 'error',
                'value' => 'Anda belum memiliki lapak. Silakan buat lapak terlebih dahulu.'
            ])->withInput();
        }
        
        $data = $request->validate([
            'nama_menu'=>'required|string',
            'deskripsi'=>'nullable|string',
            'harga'=>'required|numeric',
            'kategori'=>'nullable|string',
            'stok'=>'nullable|integer',
            'image' => 'nullable|image|max:2048'
        ]);

        $data['lapak_id'] = $penjual->lapak_id;
        // handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('menus', 'public');
            $data['image'] = $path;
        }

        Menu::create($data);
        return redirect()->route('penjual.menus.index')->with('success','Menu dibuat');
    }

    public function edit($id)
    {
        $penjualId = session('penjual_id');
        $penjual = Penjual::findOrFail($penjualId);
        
        if (!$penjual->lapak_id) {
            return redirect()->route('penjual.lapak.edit')->with([
                'key' => 'error',
                'value' => 'Anda belum memiliki lapak. Silakan buat lapak terlebih dahulu.'
            ]);
        }
        
        $menu = Menu::where('lapak_id', $penjual->lapak_id)->where('menu_id', $id)->firstOrFail();
        return view('penjual.menus.edit', compact('menu'));
    }

    public function update(Request $request, $id)
    {
        $penjualId = session('penjual_id');
        $penjual = Penjual::findOrFail($penjualId);
        
        if (!$penjual->lapak_id) {
            return back()->with([
                'key' => 'error',
                'value' => 'Anda belum memiliki lapak. Silakan buat lapak terlebih dahulu.'
            ])->withInput();
        }
        
        $menu = Menu::where('lapak_id', $penjual->lapak_id)->where('menu_id', $id)->firstOrFail();
        $data = $request->validate([
            'nama_menu'=>'required|string',
            'deskripsi'=>'nullable|string',
            'harga'=>'required|numeric',
            'kategori'=>'nullable|string',
            'stok'=>'nullable|integer',
            'image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            // delete old image if exists
            if (!empty($menu->image) && Storage::disk('public')->exists($menu->image)) {
                Storage::disk('public')->delete($menu->image);
            }
            $path = $request->file('image')->store('menus', 'public');
            $data['image'] = $path;
        }

        $menu->update($data);
        return redirect()->route('penjual.menus.index')->with('success','Menu diupdate');
    }

    public function destroy($id)
    {
        $penjualId = session('penjual_id');
        $penjual = Penjual::findOrFail($penjualId);
        
        if (!$penjual->lapak_id) {
            return back()->with([
                'key' => 'error',
                'value' => 'Anda belum memiliki lapak. Silakan buat lapak terlebih dahulu.'
            ]);
        }
        
        $menu = Menu::where('lapak_id', $penjual->lapak_id)->where('menu_id', $id)->firstOrFail();
        $menu->delete();
        return redirect()->route('penjual.menus.index')->with('success','Menu dihapus');
    }
}
