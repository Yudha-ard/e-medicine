<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo;
    protected function redirectTo()
    {
        $role = auth()->user()->role;

        $dashboard = '';
        switch ($role) {
            case 'administrator':
                $dashboard = '/admin/dashboard';
                break;
            case 'kurir':
                $dashboard = '/kurir/dashboard';
                break;
            case 'customer':
                $dashboard = '/user/dashboard';
                break;
            case 'apoteker':
                $dashboard = '/apotek/dashboard';
                break;
            default:
                $dashboard = '/';
        }

        Alert::success('Success', 'Login Sukses !');
        return $dashboard;
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

}
