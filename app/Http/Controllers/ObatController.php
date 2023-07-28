<?php

namespace App\Http\Controllers;

use App\Models\KategoriObat;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ObatController extends Controller
{
    public function index() {
        
        $user = Auth::user();
        if ($user->apotek_id) {
            $obats = Obat::where('apotek_id', $user->apotek_id)->orderBy('id', 'ASC')->paginate(10);
        } else {
            $obats = collect();
        }

        return view('backend.pages.apoteker.obat.index', compact('obats'));
    }

    public function show($id)
    {
    
        try {
            $obats = Obat::findOrFail($id);
            return view('backend.pages.apoteker.obat.view', compact('obats'));
        } catch (ModelNotFoundException $e) {
            Alert::error('gagal', 'Obat tidak ditemukan !');
            return back();
        }

    }
    public function edit($id)
    {
        try {
            $kategoris = KategoriObat::all();
            $obats = Obat::findOrFail($id);
            return view('backend.pages.apoteker.obat.edit', compact(['obats','kategoris']));
        } catch (ModelNotFoundException $e) {
            Alert::error('gagal', 'Obat tidak ditemukan !');
            return back();
        }
    }
    public function create()
    {
        $kategoris = KategoriObat::all();
        return view('backend.pages.apoteker.obat.add', compact('kategoris'));
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
            'stock' => 'required',
            'harga' => 'required',
            'diskon' => 'nullable',
            'kategori_id' => 'required',
            'apotek_id' => 'required',
            'status' => 'required|string',
            'img_obat' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'deskripsi' => 'required|string|min:10|max:1000',
        ], $messages);
        
        $fileName = null;

        if ($request->hasFile('img_obat')) {
            $image = $request->file('img_obat');
            $extension = $image->getClientOriginalExtension();
            $imageName = uniqid() . '_' . time() . '.' . $extension;
            $imagePath = 'images/obat/' . $imageName;
            Storage::disk('public')->putFileAs('images/obat', $image, $imageName);
            $fileName = pathinfo($imagePath, PATHINFO_BASENAME);
        }

        $dataObat = Obat::create([
            'name' => $request->input('name'),
            'stock' => $request->input('stock'),
            'harga' => $request->input('harga'),
            'diskon' => $request->input('diskon'),
            'kategori_id' => $request->input('kategori_id'),
            'apotek_id' => $request->input('apotek_id'),
            'status' => $request->input('status'),
            'deskripsi' => $request->input('deskripsi'),
            'img_obat' => $fileName,
        ]);

        if ($dataObat) {
            Alert::success('sukses', 'Sukses Tambah Data Obat !');
            return redirect()->route('apoteker.obat');
        }

        Alert::error('gagal', 'Gagal Tambah Data Obat !');
        return redirect()->route('apoteker.obat.create');
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
            'stock' => 'required',
            'harga' => 'required',
            'diskon' => 'nullable',
            'kategori_id' => 'required',
            'apotek_id' => 'required',
            'status' => 'required|string',
            'img_obat' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'deskripsi' => 'required|string|min:10|max:1000',
        ], $messages);

        $obats = Obat::findOrFail($id);

        if ($request->hasFile('img_obat')) {
            $image = $request->file('img_obat');
            $imageName = uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images/obat', $imageName);
            $oldImg = $obats->img_obat;
            $obats->img_obat = $imageName;

            if (!empty($oldImg)) {
                Storage::disk('public')->delete('images/obat/' . $oldImg);
            }
        }

        $obats->name = $request->name;
        $obats->stock = $request->stock;
        $obats->harga = $request->harga;
        $obats->diskon = $request->diskon;
        $obats->kategori_id = $request->kategori_id;
        $obats->apotek_id = $request->apotek_id;
        $obats->status = $request->status;
        $obats->deskripsi = $request->deskripsi;

        $obats->save();

        Alert::success('sukses', 'Sukses Update Data Obat !');
        return redirect()->route('apoteker.obat');

    }
    public function destroy($id) {

        try {
            $obats = Obat::findOrFail($id);
            if($obats->delete()){
                Alert::success('sukses', 'Sukses Hapus Data Obat !');
                return redirect()->route('apoteker.obat');
            } else {
                Alert::error('gagal', 'Gagal Hapus Data Obat !');
                return redirect()->route('apoteker.obat');
            }
        } catch (ModelNotFoundException $e) {
            Alert::error('gagal', 'Obat tidak ditemukan !');
            return back();
        }
        
    }
}
