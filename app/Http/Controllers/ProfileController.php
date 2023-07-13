<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
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

        if (!$users && !$users->role == 0) {
        
            return redirect()->route('customer.profile');
        
        } elseif (!$users && !$users->role == 1) {

            return redirect()->route('admin.profile');
            
        } elseif (!$users && !$users->role == 2) {

            return redirect()->route('apoteker.profile');
            
        } elseif (!$users && !$users->role == 3) {

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
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'img_profile' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], $messages);

        $users = User::find(Auth::user()->id);

        if (!$users) {
            if ($users->is_admin == 0) {
                return redirect()->route('user.profile');
            } elseif ($users->is_admin == 1) {
                return redirect()->route('admin.profile');
            }
        }

        if ($request->hasFile('img_profile')) {
            $image = $request->file('img_profile');
            $extension = $image->getClientOriginalExtension();
            $imageName = uniqid() . '_' . time() . '.' . $extension;
            $imagePath = 'images/user/' . $imageName;
            $image->storeAs('public/'. $imagePath);
            $fileName = $imageName;
        }

        $Pass = $users->password;
        $PassNew = $request->password;

        $users->name = $request->name;
        $users->email = $request->email;

        if ($PassNew !== $Pass) {
            $users->password = Hash::make($PassNew);
        }
        
        $oldImg = $users->img_profile;
        $users->img_profile = $imageName;

        $fileName = pathinfo($imageName, PATHINFO_BASENAME);
        $users->img_profile = $fileName;

        $users->save();

        if (!empty($oldImg)) {
            Storage::disk('public')->delete('images/user/' . $oldImg);
        }

        if ($users->is_admin == 0) {
            Alert::success('sukses', 'Sukses Update Data Profile !');
            return redirect()->route('user.profile');
        } elseif ($users->is_admin == 1) {
            Alert::success('sukses', 'Sukses Update Data Profile!');
            return redirect()->route('admin.profile');
        }
    }

}
