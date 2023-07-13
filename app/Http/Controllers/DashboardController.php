<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function customer()
    {
        return view('backend.pages.customer.index');
    }

    public function admin()
    {
        return view('backend.pages.admin.index');
    }

    public function apoteker()
    {
        return view('backend.pages.apoteker.index');
    }

    public function kurir()
    {
        return view('backend.pages.kurir.index');
    }
}
