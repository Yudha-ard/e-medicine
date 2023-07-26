<?php

namespace App\Http\Controllers;

use App\Models\KategoriObat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class KategoriObatController extends Controller
{
    public function index() {
        
        $kategoris = KategoriObat::orderby('id', 'ASC')->paginate(10);

        return view('backend.pages.apoteker.kategori.index', compact('kategoris'));
    }

    public function show($id)
    {
    
        try {
            $kategoris = KategoriObat::findOrFail($id);
            return view('backend.pages.apoteker.kategori.view', compact('kategoris'));
        } catch (ModelNotFoundException $e) {
            Alert::error('gagal', 'Kategori tidak ditemukan !');
            return back();
        }

    }
    public function edit($id)
    {
        try {
            $kategoris = KategoriObat::findOrFail($id);
            return view('backend.pages.apoteker.kategori.edit', compact('kategoris'));
        } catch (ModelNotFoundException $e) {
            Alert::error('gagal', 'Kategori tidak ditemukan !');
            return back();
        }
    }
    public function create()
    {
        return view('backend.pages.apoteker.kategori.add');
    }
    public function store(Request $request)
    {
        $messages = [
            'required' => 'Isi :attribute harus diisi.',
            'string' => 'Isi :attribute dengan format string.',
            'min' => 'Isi :attribute minimal :min karakter.',
            'max' => 'Isi :attribute maksimal :max karakter.',
        ];
    
        $request->validate([
            'name' => 'required|string',
            'img_kategori' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'deskripsi' => 'required|string|min:10|max:1000',
        ], $messages);
        
        $fileName = null;

        if ($request->hasFile('img_kategori')) {
            $image = $request->file('img_kategori');
            $extension = $image->getClientOriginalExtension();
            $imageName = uniqid() . '_' . time() . '.' . $extension;
            $imagePath = 'images/kategori/' . $imageName;
            Storage::disk('public')->putFileAs('images/kategori', $image, $imageName);
            $fileName = pathinfo($imagePath, PATHINFO_BASENAME);
        }

        $dataKategori = KategoriObat::create([
            'name' => $request->input('name'),
            'deskripsi' => $request->input('deskripsi'),
            'img_kategori' => $fileName,
        ]);

        if ($dataKategori) {
            Alert::success('sukses', 'Sukses Tambah Data Kategori !');
            return redirect()->route('apoteker.kategori');
        }

        Alert::error('gagal', 'Gagal Tambah Data Kategori !');
        return redirect()->route('apoteker.kategori.create');
    }
    public function update(Request $request, $id)
    {
        $messages = [
            'required' => 'Isi :attribute harus diisi.',
            'string' => 'Isi :attribute dengan format string.',
            'min' => 'Isi :attribute minimal :min karakter.',
            'max' => 'Isi :attribute maksimal :max karakter.',
        ];
    
        $request->validate([
            'name' => 'required|string',
            'img_kategori' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'deskripsi' => 'required|string|min:10|max:1000',
        ], $messages);

        $kategoris = KategoriObat::findOrFail($id);

        if ($request->hasFile('img_kategori')) {
            $image = $request->file('img_kategori');
            $imageName = uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images/kategori', $imageName);
            $oldImg = $kategoris->img_kategori;
            $kategoris->img_kategori = $imageName;

            if (!empty($oldImg)) {
                Storage::disk('public')->delete('images/kategori/' . $oldImg);
            }
        }

        $kategoris->name = $request->name;
        $kategoris->deskripsi = $request->deskripsi;

        $kategoris->save();

        Alert::success('sukses', 'Sukses Update Data Kategori !');
        return redirect()->route('apoteker.kategori');

    }
    public function destroy($id) {

        try {
            $kategoris = KategoriObat::findOrFail($id);
            if($kategoris->delete()){
                Alert::success('sukses', 'Sukses Hapus Data Kategori !');
                return redirect()->route('apoteker.kategori');
            } else {
                Alert::error('gagal', 'Gagal Hapus Data Kategori !');
                return redirect()->route('apoteker.kategori');
            }
        } catch (ModelNotFoundException $e) {
            Alert::error('gagal', 'Kategori tidak ditemukan !');
            return back();
        }
        
    }
}
