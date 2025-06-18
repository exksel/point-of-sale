<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        return view('landing.home');
    }

    public function aboutus()
    {
        return view('landing.aboutus');
    }
}
