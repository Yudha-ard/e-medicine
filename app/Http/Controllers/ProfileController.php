<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
class ProfileController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');    
    }
    public function index()
    {
        $users = Auth::user();

        return view('backend.pages.profile.index', compact('users'));
    }
    public function edit()
    {
        $users = Auth::user();

        if (!$users && $users->role === 'customer') {
        
            return redirect()->route('customer.profile');
        
        } elseif (!$users && $users->role === 'administrator') {

            return redirect()->route('admin.profile');
            
        } elseif (!$users && $users->role === 'apoteker') {

            return redirect()->route('apoteker.profile');
            
        } elseif (!$users && $users->role === 'kurir') {

            return redirect()->route('kurir.profile');
            
        }
        
        return view('backend.pages.profile.edit', compact('users'));
    }
    
    public function update(Request $request)
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
            'address' => 'required|string|min:10|max:100',
            'phone' => 'required|numeric|min:1000000000',
        ], $messages);

        $users = User::find(Auth::user()->id);

        if (!$users && $users->role === 'customer') {
        
            return redirect()->route('customer.profile');
        
        } elseif (!$users && $users->role === 'administrator') {

            return redirect()->route('admin.profile');
            
        } elseif (!$users && $users->role === 'apoteker') {

            return redirect()->route('apoteker.profile');
            
        } elseif (!$users && $users->role === 'kurir') {

            return redirect()->route('kurir.profile');
            
        }

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

        $Pass = $users->password;
        $PassNew = $request->password;

        $users->name = $request->name;
        $users->email = $request->email;

        if ($PassNew !== $Pass) {
            $users->password = Hash::make($PassNew);
        }

        $users->address = $request->address;
        $users->phone = $request->phone;

        $users->save();

        if ($users && $users->role === 'customer') {
            Alert::success('sukses', 'Sukses Update Data Profile !');
            return redirect()->route('customer.profile');
        
        } elseif ($users && $users->role === 'administrator') {
            Alert::success('sukses', 'Sukses Update Data Profile !');
            return redirect()->route('admin.profile');
            
        } elseif ($users && $users->role === 'apoteker') {
            Alert::success('sukses', 'Sukses Update Data Profile !');
            return redirect()->route('apoteker.profile');
            
        } elseif ($users && $users->role === 'kurir') {
            Alert::success('sukses', 'Sukses Update Data Profile !');
            return redirect()->route('kurir.profile');
            
        }
    }

}
