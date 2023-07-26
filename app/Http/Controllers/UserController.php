<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Apotek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
    public function index() {
        
        $users = User::orderby('id', 'ASC')->paginate(10);

        return view('backend.pages.admin.user.index', compact('users'));
    }

    public function show($id)
    {
    
        try {
            $users = User::findOrFail($id);
            return view('backend.pages.admin.user.view', compact('users'));
        } catch (ModelNotFoundException $e) {
            Alert::error('gagal', 'User tidak ditemukan !');
            return back();
        }

    }
    public function edit($id)
    {
        try {
            $users = User::findOrFail($id);
            $apoteks = Apotek::all();
            return view('backend.pages.admin.user.edit', compact(['users','apoteks']));
        } catch (ModelNotFoundException $e) {
            Alert::error('gagal', 'User tidak ditemukan !');
            return back();
        }
    }
    public function create()
    {
        $users = User::All();
        $apoteks = Apotek::all();
        return view('backend.pages.admin.user.add', compact(['users','apoteks']));
    }
    public function update(Request $request, $id)
    {
        $messages = [
            'required' => 'Isi :attribute harus diisi.',
            'email' => 'Isi :attribute dengan format email yang valid.',
            'numeric' => 'Isi :attribute dengan format angka.',
            'string' => 'Isi :attribute dengan format string.',
            'min' => 'Isi :attribute minimal :min karakter.',
            'max' => 'Isi :attribute maksimal :max karakter.',
        ];

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string',
            'img_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'role' => 'required|string',
            'status' => 'required|string',
            'apotek_id' => 'nullable',
            'address' => 'required|string|min:10|max:100',
            'phone' => 'required|numeric|min:1000000000',
        ], $messages);

        $users = User::findOrFail($id);

        if ($request->hasFile('img_profile')) {
            $image = $request->file('img_profile');
            $imageName = uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images/user', $imageName);
            $oldImg = $users->img_profile;
            $users->img_profile = $imageName;

            if (!empty($oldImg)) {
                    Storage::disk('public')->delete('images/user/' . $oldImg);
            }
        }

        $users->name = $request->name;
        $users->email = $request->email;
        $users->role = $request->role;
        $users->status = $request->status;
        $users->address = $request->address;
        $users->phone = $request->phone;
        $users->apotek_id = $request->apotek_id;

        if ($request->password !== $users->password) {
            $users->password = Hash::make($request->password);
        }

        $users->save();

        Alert::success('sukses', 'Sukses Update Data User !');
        return redirect()->route('admin.user');

    }

    public function store(Request $request)
    {
        $messages = [
            'required' => 'Isi :attribute harus diisi.',
            'email' => 'Isi :attribute dengan format email yang valid.',
            'numeric' => 'Isi :attribute dengan format angka.',
            'string' => 'Isi :attribute dengan format string.',
            'min' => 'Isi :attribute minimal :min karakter.',
            'max' => 'Isi :attribute maksimal :max karakter.',
        ];
    
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string',
            'img_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'role' => 'required|string',
            'status' => 'required|string',
            'apotek_id' => 'nullable',
            'address' => 'required|string|min:10|max:100',
            'phone' => 'required|numeric|min:1000000000',
        ], $messages);
        
        if(isset($request->email) && !empty($request->email))
        {
            $email = $request->email; 
        }

        $fileName = null;

        if ($request->hasFile('img_profile')) {
            $image = $request->file('img_profile');
            $extension = $image->getClientOriginalExtension();
            $imageName = uniqid() . '_' . time() . '.' . $extension;
            $imagePath = 'images/user/' . $imageName;
            Storage::disk('public')->putFileAs('images/user', $image, $imageName);
            $fileName = pathinfo($imagePath, PATHINFO_BASENAME);
        }

        $dataUser = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => $request->input('role'),
            'status' => $request->input('status'),
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
            'apotek_id' => $request->input('apotek_id'),
            'img_profile' => $fileName,
        ]);

        if ($dataUser) {
            Alert::success('sukses', 'Sukses Tambah Data User !');
            return redirect()->route('admin.user');
        }

        Alert::error('gagal', 'Gagal Tambah Data User !');
        return redirect()->route('admin.user.create');
    }
    public function destroy($id) {

        try {
            $users = User::findOrFail($id);
            if($users->delete()){
                Alert::success('sukses', 'Sukses Hapus Data User !');
                return redirect()->route('admin.user');
            } else {
                Alert::error('gagal', 'Gagal Hapus Data User !');
                return redirect()->route('admin.user');
            }
        } catch (ModelNotFoundException $e) {
            Alert::error('gagal', 'User tidak ditemukan !');
            return back();
        }
        
    }
}
