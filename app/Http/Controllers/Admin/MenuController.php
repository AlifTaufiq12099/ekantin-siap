<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use App\Models\Menu;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('q', '');
        
        $menus = Menu::with('lapak')
            ->when($query, function($q) use ($query) {
                $q->where('nama_menu', 'like', '%' . $query . '%')
                  ->orWhere('deskripsi', 'like', '%' . $query . '%')
                  ->orWhere('kategori', 'like', '%' . $query . '%')
                  ->orWhereHas('lapak', function($lapakQuery) use ($query) {
                      $lapakQuery->where('nama_lapak', 'like', '%' . $query . '%');
                  });
            })
            ->orderBy('menu_id','desc')
            ->paginate(20);
        
        $menus->appends(['q' => $query]);
        
        return view('admin.menus.index', compact('menus', 'query'));
    }

    public function create()
    {
        return view('admin.menus.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_menu'=>'required|string',
            'deskripsi'=>'nullable|string',
            'harga'=>'required|numeric',
            'kategori'=>'nullable|string',
            'stok'=>'nullable|integer',
            'lapak_id'=>'nullable|integer',
            'image' => 'nullable|image|max:4096'
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time().'_'.preg_replace('/[^A-Za-z0-9\-\.]/','_', $file->getClientOriginalName());

            // optimize and save main image
            $img = Image::make($file->getRealPath());
            $img->orientate();
            $img->resize(1200, null, function ($constraint) { $constraint->aspectRatio(); $constraint->upsize(); });
            $path = 'menus/'.$filename;
            Storage::disk('public')->put($path, (string) $img->encode('jpg', 85));

            // create thumbnail
            $thumb = $img->resize(300, null, function ($constraint) { $constraint->aspectRatio(); $constraint->upsize(); });
            $thumbPath = 'menus/thumb_'.$filename;
            Storage::disk('public')->put($thumbPath, (string) $thumb->encode('jpg', 80));

            $data['image'] = $path;
        }

        Menu::create($data);
        return redirect()->route('admin.menus.index')->with('success','Menu dibuat');
    }

    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        return view('admin.menus.edit', compact('menu'));
    }

    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);
        $data = $request->validate([
            'nama_menu'=>'required|string',
            'deskripsi'=>'nullable|string',
            'harga'=>'required|numeric',
            'kategori'=>'nullable|string',
            'stok'=>'nullable|integer',
            'lapak_id'=>'nullable|integer',
            'image' => 'nullable|image|max:4096'
        ]);

        if ($request->hasFile('image')) {
            // delete old images
            if (!empty($menu->image) && Storage::disk('public')->exists($menu->image)) {
                Storage::disk('public')->delete($menu->image);
            }
            $oldThumb = 'menus/thumb_'.basename($menu->image ?? '');
            if (!empty($menu->image) && Storage::disk('public')->exists($oldThumb)) {
                Storage::disk('public')->delete($oldThumb);
            }

            $file = $request->file('image');
            $filename = time().'_'.preg_replace('/[^A-Za-z0-9\-\.]/','_', $file->getClientOriginalName());

            $img = Image::make($file->getRealPath());
            $img->orientate();
            $img->resize(1200, null, function ($constraint) { $constraint->aspectRatio(); $constraint->upsize(); });
            $path = 'menus/'.$filename;
            Storage::disk('public')->put($path, (string) $img->encode('jpg', 85));

            $thumb = $img->resize(300, null, function ($constraint) { $constraint->aspectRatio(); $constraint->upsize(); });
            $thumbPath = 'menus/thumb_'.$filename;
            Storage::disk('public')->put($thumbPath, (string) $thumb->encode('jpg', 80));

            $data['image'] = $path;
        }

        $menu->update($data);
        return redirect()->route('admin.menus.index')->with('success','Menu diupdate');
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();
        return redirect()->route('admin.menus.index')->with('success','Menu dihapus');
    }
}
