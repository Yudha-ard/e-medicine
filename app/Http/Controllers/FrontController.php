<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class FrontController extends Controller
{

    public function index() {
        return view('frontend.pages.index');
    }
    public function about() {
        return view('frontend.pages.about');
    }
    public function contact() {
        return view('frontend.pages.contact');
    }
}
