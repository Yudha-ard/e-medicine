<?php

namespace App\Http\Controllers;

use App\Models\Apotek;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ApotekController extends Controller
{
   public function index() {
    
     $apoteks = Apotek::orderby('id', 'ASC')->paginate(10);
     
     if (Auth::user()->role === 'customer') {
        $orders = Transaksi::where('user_id', Auth::user()->id)->pluck('apotek_id')->toArray();
        return view('backend.pages.customer.apotek.index', compact(['apoteks','orders']));
     } else {
        return view('backend.pages.admin.apotek.index', compact('apoteks'));
     }
  }

  public function show($id)
  {
      try {
          $apoteks = Apotek::findOrFail($id);
          if(Auth::user()->role === 'customer') {
             $orders = Transaksi::where('user_id', Auth::user()->id)->where('apotek_id', $apoteks->id)->exists();
             return view('backend.pages.customer.apotek.view', compact(['apoteks','orders']));
          }
          return view('backend.pages.admin.apotek.view', compact('apoteks'));
      } catch (ModelNotFoundException $e) {
          Alert::error('gagal', 'Apotek tidak ditemukan !');
          return back();
      }

  }
  public function edit($id)
  {
      try {
          $apoteks = Apotek::findOrFail($id);
          return view('backend.pages.admin.apotek.edit', compact('apoteks'));
      } catch (ModelNotFoundException $e) {
          Alert::error('gagal', 'Apotek tidak ditemukan !');
          return back();
      }
  }
  public function create()
  {
      return view('backend.pages.admin.apotek.add');
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
         'address' => 'required|string|min:10|max:100',
         'phone' => 'required|numeric|min:1000000000',
         'status' => 'required|string',
      ], $messages);

      $dataApotek = Apotek::create([
          'name' => $request->input('name'),
          'address' => $request->input('address'),
          'phone' => $request->input('phone'),
          'status' => $request->input('status'),
      ]);

      if ($dataApotek) {
          Alert::success('sukses', 'Sukses Tambah Data Apotek !');
          return redirect()->route('admin.apotek');
      }

      Alert::error('gagal', 'Gagal Tambah Data Apotek !');
      return redirect()->route('admin.apotek.create');
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
         'address' => 'required|string|min:10|max:100',
         'phone' => 'required|numeric|min:1000000000',
         'status' => 'required|string',
      ], $messages);

      $apoteks = Apotek::findOrFail($id);

      $apoteks->name = $request->name;
      $apoteks->address = $request->address;
      $apoteks->phone = $request->phone;
      $apoteks->status = $request->status;

      $apoteks->save();

      Alert::success('sukses', 'Sukses Update Data Apotek !');
      return redirect()->route('admin.apotek');

  }
  public function destroy($id) {

      try {
          $apoteks = Apotek::findOrFail($id);
          if($apoteks->delete()){
              Alert::success('sukses', 'Sukses Hapus Data Apotek !');
              return redirect()->route('admin.apotek');
          } else {
              Alert::error('gagal', 'Gagal Hapus Data Apotek !');
              return redirect()->route('admin.apotek');
          }
      } catch (ModelNotFoundException $e) {
          Alert::error('gagal', 'Apotek tidak ditemukan !');
          return back();
      }
      
  }

}
